<?php

require '/Applications/XAMPP/xamppfiles/htdocs/dtest/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExportModel {
    private $pdo;
    private $tableModel;
     public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->tableModel = new TableModel($pdo);
    }

    public function importData($tableName, $filePath, $fileType, $headerMapping, $forceImport = false) {
        $importErrors = [];
        $importSuccess = [];
        try {
            if ($fileType === 'csv') {
                $file = fopen($filePath, 'r');
                $headers = fgetcsv($file);
                $mappedHeaders = $this->mapHeaders($headers, $headerMapping);
                $dateFields = $this->detectDateFields($mappedHeaders);
                $textFields = $this->detectTextFields($mappedHeaders);
                while ($row = fgetcsv($file)) {
                    $data = $this->prepareData($row, $mappedHeaders);
                    $data = $this->convertDataFormats($data, $dateFields, $textFields);
                    $importSuccess[] = $data;
                }
                fclose($file);
            } elseif ($fileType === 'xlsx' || $fileType === 'xls') {
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $headers = $worksheet->toArray()[0];
                $mappedHeaders = $this->mapHeaders($headers, $headerMapping);
                $dateFields = $this->detectDateFields($mappedHeaders);
                $textFields = $this->detectTextFields($mappedHeaders);
                foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                    if ($rowIndex == 1) continue; // Skip header row
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                    $rowData = [];
                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();
                    }
                    $data = $this->prepareData($rowData, $mappedHeaders);
                    $data = $this->convertDataFormats($data, $dateFields, $textFields);
                    $importSuccess[] = $data;
                }
            } else {
                throw new Exception('Unsupported file type');
            }
            return [
                'success' => true,
                'data' => $importSuccess,
                'errors' => $importErrors
            ];
        } catch (Exception $e) {
            error_log('Import error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => "Import failed: " . $e->getMessage()
            ];
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
        return $data;
    }

    private function convertDataFormats($data, $dateFields, $textFields) {
        // Convert date formats
        foreach ($dateFields as $dateField) {
            if (isset($data[$dateField]) && !empty($data[$dateField])) {
                $data[$dateField] = date('Y-m-d', strtotime($data[$dateField]));
            }
        }
        // Ensure text fields are treated as text
        foreach ($textFields as $textField) {
            if (isset($data[$textField])) {
                $data[$textField] = (string)$data[$textField];
            }
        }
        return $data;
    }

    public function detectDateFields($mappedHeaders) {
        $dateFields = [];
        foreach ($mappedHeaders as $header) {
            if (strpos($header, 'tanggal') !== false) {
                $dateFields[] = $header;
            }
        }
        return $dateFields;
    }

    private function detectTextFields($mappedHeaders) {
        // Define which columns should be treated as text
        $textFields = ['no_surat_tugas', 'frekuensi_terukur', 'latitude', 'longitude'];
        $detectedTextFields = [];
        foreach ($mappedHeaders as $header) {
            if (in_array($header, $textFields)) {
                $detectedTextFields[] = $header;
            }
        }
        return $detectedTextFields;
    }

    public function insertOrUpdateData($tableName, $data, $uniqueKeys, $forceImport) {
        $whereClause = implode(" AND ", array_map(function($key) {
            return "$key = :$key";
        }, $uniqueKeys));
        
        $sql = "SELECT COUNT(*) FROM $tableName WHERE $whereClause";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_intersect_key($data, array_flip($uniqueKeys)));
        
        if ($stmt->fetchColumn() > 0) {
            if ($forceImport) {
                $this->tableModel->updateData($tableName, array_intersect_key($data, array_flip($uniqueKeys)), $data);
                echo "Duplicate found and updated for unique keys: " . json_encode(array_intersect_key($data, array_flip($uniqueKeys))) . "<br>";
            } else {
                echo "Duplicate found for unique keys: " . json_encode(array_intersect_key($data, array_flip($uniqueKeys))) . "<br>";
            }
        } else {
            $this->tableModel->createData($tableName, $data);
        }
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
