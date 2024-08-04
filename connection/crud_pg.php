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
$tableName = 'gangguan_frekuensi';

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
                    'no_surat_tugas', 'tanggal_tugas', 'pihak_pelapor',
                    'pihak_pengganggu', 'latitude', 'frekuensi_terukur',
                    'longitude', 'alamat', 'tanggal_penanganan_gangguan',
                    'tindakan', 'sumber_gangguan', 'keterangan'
                ];

                $filteredData = [];
                foreach ($columns as $column) {
                    if (isset($_POST[$column])) {
                        $filteredData[$column] = $_POST[$column];
                    }
                }

                $model->createData($tableName, $filteredData);
                header('Location: ../layout-penanganan-gangguan.php');
                exit(); // Tambahkan exit setelah header location

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
                    'no_surat_tugas', 'tanggal_tugas', 'pihak_pelapor',
                    'pihak_pengganggu', 'frekuensi_terukur', 'latitude',
                    'longitude', 'alamat', 'sumber_gangguan', 'tindakan',
                    'keterangan', 'tanggal_penanganan_gangguan'
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
                            'no_surat_tugas', 'tanggal_tugas', 'pihak_pelapor', 'pihak_pengganggu',
                            'frekuensi_terukur', 'latitude', 'longitude', 'alamat',
                            'sumber_gangguan', 'tindakan', 'keterangan', 'tanggal_penanganan_gangguan'
                        ];
                        $dateColumns = [1, 11]; // Kolom tanggal dalam file Excel
                        
                        $insertedRows = $model->importData($filePath, $tableName, $columns, $dateColumns);
                        $result = ['success' => true, 'message' => "Sudah Berhasil Menambahkan $insertedRows baris."];
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

        case 'get_chart_data':
            try {
                $pieData = $model->fetchChartData($tableName, 'sumber_gangguan, COUNT(*) as jumlah', 'sumber_gangguan');
                $barData = $model->fetchChartData($tableName, 'pihak_pelapor, COUNT(*) as jumlah', 'pihak_pelapor');
                $barData2 = $model->fetchChartData($tableName, 'frekuensi_terukur, COUNT(*) as jumlah', 'frekuensi_terukur');

                $result = [
                    'success' => true,
                    'pie' => $pieData,
                    'bar' => $barData,
                    'bar2' => $barData2
                ];
            } catch (Exception $e) {
                $result = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
            break;

        case 'get_summary_counts':
            $stmtClosed = $pdo->prepare("SELECT COUNT(*) as closed_count FROM gangguan_frekuensi WHERE LOWER(keterangan) LIKE '%closed%'");
            $stmtClosed->execute();
            $closedCount = $stmtClosed->fetch(PDO::FETCH_ASSOC)['closed_count'];

            $stmtProcessed = $pdo->prepare("SELECT COUNT(*) as processed_count FROM gangguan_frekuensi WHERE LOWER(keterangan) NOT LIKE '%closed%'");
            $stmtProcessed->execute();
            $processedCount = $stmtProcessed->fetch(PDO::FETCH_ASSOC)['processed_count'];

            $result = [
                'success' => true,
                'closed_count' => $closedCount,
                'processed_count' => $processedCount
            ];
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
