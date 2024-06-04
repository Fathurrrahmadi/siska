<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    public function fetchChartData($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetchChartData: " . $e->getMessage());
            throw new Exception("Error fetching data: " . $e->getMessage());
        }
    }
}
?>
