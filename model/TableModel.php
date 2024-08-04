<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '/Applications/XAMPP/xamppfiles/htdocs/dtest/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

// use PhpOffice\PhpSpreadsheet\IOFactory;

class TableModel { 
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fetchData($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetchData: " . $e->getMessage());
            throw new Exception("Error fetching data: " . $e->getMessage());
        }
    }

    public function fetchDataById($tableName, $id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetchDataById: " . $e->getMessage());
            throw new Exception("Error fetching data by ID: " . $e->getMessage());
        }
    }

    public function createData($tableName, $data) {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), '?'));

            $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            
            if ($stmt->execute(array_values($data))) {
                return ['success' => true, 'message' => 'Data berhasil ditambahkan.'];
            } else {
                throw new Exception('Gagal menambahkan data.');
            }
        } catch (PDOException $e) {
            error_log("Database error in createData: " . $e->getMessage());
            if ($e->getCode() == '23000') {
                return ['success' => false, 'message' => 'Data sudah ada dalam database.'];
            } else {
                return ['success' => false, 'message' => 'Terjadi kesalahan database saat menambahkan data.'];
            }
        }
    }

    public function updateData($tableName, $id, $data, $idColumn = 'id') {
        try {
            $setClause = implode(", ", array_map(function($key) {
                return "$key = ?";
            }, array_keys($data)));

            $sql = "UPDATE $tableName SET $setClause WHERE $idColumn = ?";
            $stmt = $this->pdo->prepare($sql);
            $values = array_values($data);
            $values[] = $id;
            
            if ($stmt->execute($values)) {
                return ['success' => true, 'message' => 'Data berhasil diupdate.'];
            } else {
                throw new Exception('Gagal mengupdate data.');
            }
        } catch (PDOException $e) {
            error_log("Database error in updateData: " . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan database saat mengupdate data.'];
        }
    }

    public function deleteData($tableName, $id, $idColumn = 'id') {
        try {
            $sql = "DELETE FROM $tableName WHERE $idColumn = ?";
            $stmt = $this->pdo->prepare($sql);
            
            if ($stmt->execute([$id])) {
                return ['success' => true, 'message' => 'Data berhasil dihapus.'];
            } else {
                throw new Exception('Gagal menghapus data.');
            }
        } catch (PDOException $e) {
            error_log("Database error in deleteData: " . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan database saat menghapus data.'];
        }
    }

    public function fetchChartData($tableName, $fields, $groupByField) {
        try {
            $stmt = $this->pdo->prepare("SELECT $fields FROM $tableName GROUP BY $groupByField");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetchChartData: " . $e->getMessage());
            throw new Exception("Error fetching data: " . $e->getMessage());
        }
    }

    public function exportData($tableName) {
        $stmt = $this->pdo->prepare("SELECT * FROM $tableName");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($data)) {
            throw new Exception("No data found to export.");
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(array_keys($data[0]), null, 'A1');
        $sheet->fromArray($data, null, 'A2');
        $writer = new XlsxWriter($spreadsheet);
        $fileName = "$tableName.xlsx";

        if (!headers_sent()) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            $writer->save("php://output");
            exit;
        } else {
            throw new Exception("Headers already sent, cannot export the file.");
        }
    }
    
     // Fungsi untuk mengonversi format tanggal
     private function convertDate($date) {
        return date('Y-m-d', strtotime($date));
    }
    
    // Fungsi untuk mengimpor data dari file Excel
    public function importData($filePath, $tableName, $columns, $dateColumns = []) {
        $reader = new XlsxReader();
        $spreadsheet = $reader->load($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // Membuat query insert yang dinamis berdasarkan tabel dan kolom
        $columnNames = implode(", ", $columns);
        $placeholders = implode(", ", array_fill(0, count($columns), "?"));
        $query = "INSERT INTO $tableName ($columnNames) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($query);

        if (!$stmt) {
            die("Error preparing statement: " . $this->pdo->errorInfo()[2]);
        }

        $insertedRows = 0;
        foreach ($sheetData as $index => $row) {
            if ($index === 0) continue; // Lewati header

            // Mengonversi tanggal jika ada
            foreach ($dateColumns as $colIndex) {
                if (isset($row[$colIndex])) {
                    $row[$colIndex] = $this->convertDate($row[$colIndex]);
                }
            }

            if ($stmt->execute($row)) {
                $insertedRows += $stmt->rowCount();
            } else {
                echo "Error inserting data: " . $stmt->errorInfo()[2] . "<br>";
            }
        }

        return $insertedRows;
    }
}
?>
