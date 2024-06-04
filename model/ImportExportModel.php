<?php
require '/Applications/XAMPP/xamppfiles/htdocs/dtest/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as SharedDate;

class ImportExportModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function importData($tableName, $filePath, $fileType, $headerMapping, $forceImport = false) {
        $importErrors = [];
        $importSuccess = [];
        try {
            if ($fileType === 'csv') {
                $file = fopen($filePath, 'r');
                $headers = fgetcsv($file);
                $mappedHeaders = $this->mapHeaders($headers, $headerMapping);
                while ($row = fgetcsv($file)) {
                    $data = $this->prepareData($row, $mappedHeaders);
                    if ($this->validateData($data)) {
                        $this->insertOrUpdateData($tableName, $data, $forceImport);
                        $importSuccess[] = $data['no_surat_tugas'];
                    } else {
                        $importErrors[] = "Invalid data found in row: " . json_encode($row);
                        error_log("Invalid data: " . json_encode($data));
                    }
                }
                fclose($file);
            } elseif ($fileType === 'xlsx' || $fileType === 'xls') {
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $headers = $worksheet->toArray()[0];
                $mappedHeaders = $this->mapHeaders($headers, $headerMapping);
                foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                    if ($rowIndex == 1) continue; // Skip header row
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                    $rowData = [];
                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();
                    }
                    $data = $this->prepareData($rowData, $mappedHeaders);
                    if ($this->validateData($data)) {
                        $this->insertOrUpdateData($tableName, $data, $forceImport);
                        $importSuccess[] = $data['no_surat_tugas'];
                    } else {
                        $importErrors[] = "Invalid data found in row: " . json_encode($rowData);
                        error_log("Invalid data: " . json_encode($data));
                    }
                }
            } else {
                throw new Exception('Unsupported file type');
            }
            if (!empty($importErrors)) {
                return "Import completed with errors: " . implode("; ", $importErrors);
            }
            return "Import successful: " . implode(", ", $importSuccess);
        } catch (Exception $e) {
            error_log('Import error: ' . $e->getMessage());
            return "Import failed: " . $e->getMessage();
        }
    }

    private function mapHeaders($headers, $headerMapping) {
        $mappedHeaders = [];
        foreach ($headers as $header) {
            if (isset($headerMapping[$header])) {
                $mappedHeaders[] = $headerMapping[$header];
            } else {
                $mappedHeaders[] = null;
            }
        }
        return $mappedHeaders;
    }

    private function prepareData($row, $mappedHeaders) {
        $data = [];
        foreach ($row as $index => $value) {
            if ($mappedHeaders[$index] !== null) {
                $data[$mappedHeaders[$index]] = $value;
            }
        }
        return $this->convertDataFormats($data);
    }

    private function convertDataFormats($data) {
        // Convert date formats
        if (isset($data['tanggal_tugas']) && !empty($data['tanggal_tugas'])) {
            $data['tanggal_tugas'] = date('Y-m-d', strtotime($data['tanggal_tugas']));
        }
        if (isset($data['tanggal_penanganan_gangguan']) && !empty($data['tanggal_penanganan_gangguan'])) {
            $data['tanggal_penanganan_gangguan'] = date('Y-m-d', strtotime($data['tanggal_penanganan_gangguan']));
        }
        return $data;
    }

    private function validateData($data) {
        $requiredFields = ['no_surat_tugas', 'pihak_pelapor', 'frekuensi_terukur', 'latitude', 'longitude', 'alamat'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                error_log("Validation error: Missing required field '$field' in data: " . json_encode($data));
                return false;
            }
            if (strlen($data[$field]) > 255 && $field != 'latitude' && $field != 'longitude') {
                error_log("Validation error: '$field' exceeds length limit in data: " . json_encode($data));
                return false;
            }
        }

        // Validasi latitude dan longitude
        if (strlen($data['latitude']) > 20 || strlen($data['longitude']) > 20) {
            error_log("Validation error: 'latitude' or 'longitude' exceeds length limit in data: " . json_encode($data));
            return false;
        }

        return true;
    }

    private function insertOrUpdateData($tableName, $data, $forceImport) {
        $sql = "SELECT COUNT(*) FROM $tableName WHERE no_surat_tugas = :no_surat_tugas";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['no_surat_tugas' => $data['no_surat_tugas']]);
        if ($stmt->fetchColumn() > 0) {
            if ($forceImport) {
                $this->updateData($tableName, $data['no_surat_tugas'], $data);
                echo "Duplicate found and updated for No Surat Tugas " . $data['no_surat_tugas'] . "<br>";
            } else {
                echo "Duplicate found for No Surat Tugas " . $data['no_surat_tugas'] . "<br>";
            }
        } else {
            $this->createData($tableName, $data);
        }
    }

    private function createData($tableName, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
    }

    private function updateData($tableName, $id, $data) {
        $setClause = implode(", ", array_map(function($key) {
            return "$key = ?";
        }, array_keys($data)));
        $sql = "UPDATE $tableName SET $setClause WHERE no_surat_tugas = ?";
        $stmt = $this->pdo->prepare($sql);
        $values = array_values($data);
        $values[] = $id;
        $stmt->execute($values);
    }

    public function exportData($tableName) {
        $stmt = $this->pdo->prepare("SELECT * FROM $tableName");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(array_keys($data[0]), null, 'A1');
        $sheet->fromArray($data, null, 'A2');
        $writer = new Xlsx($spreadsheet);
        $fileName = "$tableName.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        $writer->save("php://output");
        exit;
    }
}
