<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'koneksi.php';
require_once 'user.php';
require_once '../model/TableModel.php';
require '../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$database = new Database();
$pdo = $database->getConnection();
$model = new TableModel($pdo);
$user = new User($pdo);

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : null);
$tableName = 'penertiban_sfr';

$result = ['success' => false, 'message' => 'Unknown error occurred'];

try {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        throw new Exception('Anda harus login terlebih dahulu.');
    }

    $userRole = isset($_SESSION['role']) ? $_SESSION['role'] : null;

    switch ($action) {
        case 'create':
            if ($userRole == 'user' || $userRole == 'admin') {
                $columns = [
                    'nama_pengguna', 'frekuensi', 'dinas', 'subservice', 'lokasi',
                    'provinsi', 'kabkot', 'jenis_pelanggaran', 'tindakan', 'status',
                    'tgl_operasi_stasiun', 'no_isr_setelah_penindakan', 'no_surat_penindakan', 
                    'tgl_tindakan', 'keterangan'
                ];

                $filteredData = [];
                foreach ($columns as $column) {
                    if (isset($_POST[$column])) {
                        $filteredData[$column] = $_POST[$column];
                    }
                }

                $model->createData($tableName, $filteredData);
                header('Location: ../layout-table-SFR-modified.php');
                exit();

                $result = ['success' => true, 'message' => 'Data berhasil disimpan'];
            } else {
                $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk menambah data.'];
            }
            break;

        case 'update':
            if ($userRole == 'user' || $userRole == 'admin') {
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                if ($id === null) {
                    $result = ['success' => false, 'message' => 'ID tidak ditemukan.'];
                    break;
                }

                $columns = [
                    'nama_pengguna', 'frekuensi', 'dinas', 'subservice', 'lokasi',
                    'provinsi', 'kabkot', 'jenis_pelanggaran', 'tindakan', 'status',
                    'tgl_operasi_stasiun', 'no_isr_setelah_penindakan', 'no_surat_penindakan', 
                    'tgl_tindakan', 'keterangan'
                ];

                $filteredData = [];
                foreach ($columns as $column) {
                    if (isset($_POST[$column])) {
                        $filteredData[$column] = $_POST[$column];
                    }
                }

                try {
                    $result = $model->updateData($tableName, $id, $filteredData);
                } catch (Exception $e) {
                    $result = ['success' => false, 'message' => 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage()];
                }
            } else {
                $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk mengupdate data.'];
            }
            break;

        
        case 'delete':
            if ($userRole == 'admin') {
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                if ($id === null) {
                    throw new Exception('ID tidak ditemukan.');
                }

                $model->deleteData($tableName, $id);
                $result = ['success' => true, 'message' => 'Data berhasil dihapus.'];
            } else {
                $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk menghapus data.'];
            }
            break;

        case 'read':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = $pdo->prepare("SELECT * FROM $tableName WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $result = [
                    'success' => true,
                    'data' => $data,
                    'role' => $userRole
                ];
            } else {
                $data = $model->fetchData($tableName);
                $result = [
                    'success' => true,
                    'data' => $data,
                    'role' => $userRole
                ];
            }
            break;


        case 'import':
            if ($userRole == 'admin' || $userRole == 'user') {
                if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    $fileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $filePath = $_FILES['file']['tmp_name'];

                    try {
                        $columns = [
                            'nama_pengguna', 'frekuensi', 'dinas', 'subservice', 'lokasi',
                            'provinsi', 'kabkot', 'jenis_pelanggaran', 'tindakan', 'status',
                            'tgl_operasi_stasiun', 'no_isr_setelah_penindakan', 'no_surat_penindakan', 
                            'tgl_tindakan', 'keterangan'
                        ];
                        $dateColumns = [10, 13]; // Kolom tanggal dalam file Excel
                        
                        $insertedRows = $model->importData($filePath, $tableName, $columns, $dateColumns);
                        $result = ['success' => true, 'message' => "Successfully imported $insertedRows rows."];
                    } catch (Exception $e) {
                        $result = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
                    }
                } else {
                    $result = ['success' => false, 'message' => 'Error uploading file: ' . $_FILES['file']['error']];
                }
            } else {
                $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk mengimport data.'];
            }
            break;

        case 'export':
            if ($userRole == 'admin' || $userRole == 'user') {
                try {
                    $model->exportData($tableName);
                    exit();
                } catch (Exception $e) {
                    $result = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
                }
            } else {
                $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk mengekspor data.'];
            }
            break;

        default:
            throw new Exception('Aksi tidak dikenal.');
            break;
    }
} catch (PDOException $e) {
    $result = ['success' => false, 'message' => 'Terjadi kesalahan database: ' . $e->getMessage()];
    error_log('Database error: ' . $e->getMessage());
} catch (Exception $e) {
    $result = ['success' => false, 'message' => $e->getMessage()];
    error_log('General error: ' . $e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($result);
exit();
?>
