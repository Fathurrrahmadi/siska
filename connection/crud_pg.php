<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'koneksi.php';

require_once 'user.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/dtest/model/TableModel.php';
require '/Applications/XAMPP/xamppfiles/htdocs/dtest/vendor/autoload.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/dtest/model/ImportExportModel.php';



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$database = new Database();
$pdo = $database->getConnection();
$model = new TableModel($pdo);
$user = new User($pdo);
$importExportModel = new ImportExportModel($pdo); // Inisialisasi ImportExportModel


$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : null);
$tableName = 'gangguan_frekuensi';

$result = ['success' => false, 'message' => 'Unknown error occurred'];

if ($action !== null) {
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
                        'sumber_gangguan', 'keterangan'
                    ];

                    $filteredData = [];
                    foreach ($columns as $column) {
                        if (isset($_POST[$column])) {
                            $filteredData[$column] = $_POST[$column];
                        }
                    }

                    $result = $model->createData($tableName, $filteredData);
                } else {
                    $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk menambah data.'];
                }
            break;

            case 'update':
                if ($userRole == 'user' || $userRole == 'admin') {
                    $id = isset($_POST['id']) ? $_POST['id'] : null;
                    if ($id === null) {
                        throw new Exception('ID tidak ditemukan.');
                    }

                    $columns = [
                        'no_surat_tugas', 'tanggal_tugas', 'pihak_pelapor',
                        'pihak_pengganggu', 'latitude', 'frekuensi_terukur',
                        'longitude', 'alamat', 'tanggal_penanganan_gangguan',
                        'sumber_gangguan', 'keterangan'
                    ];

                    $filteredData = [];
                    foreach ($columns as $column) {
                        if (isset($_POST[$column])) {
                            $filteredData[$column] = $_POST[$column];
                        }
                    }

                    $result = $model->updateData($tableName, $id, $filteredData);
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

                    $result = $model->deleteData($tableName, $id);
                } else {
                    $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk menghapus data.'];
                }
            break;
            case 'read':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $stmt = $pdo->prepare("SELECT * FROM gangguan_frekuensi WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result = [
                        'success' => true,
                        'data' => $data,
                        'role' => $userRole // Menambahkan role ke dalam respons
                    ];
                } else {
                    $data = $model->fetchData($tableName);
                    $result = [
                        'success' => true,
                        'data' => $data,
                        'role' => $userRole // Menambahkan role ke dalam respons
                    ];
                }
                break;
                case 'import':
                    if ($userRole == 'admin' || $userRole == 'user') {
                        $fileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                        $filePath = $_FILES['file']['tmp_name'];
                
                        $headerMapping = [
                            'ST. NO' => 'no_surat_tugas',
                            'Nama pengguna' => 'pihak_pelapor',
                            'Frekuensi Terukur' => 'frekuensi_terukur',
                            'Lokasi sumber gangguan' => 'alamat',
                            'Sumber Gangguan' => 'sumber_gangguan',
                            'Keterangan' => 'keterangan'
                        ];
                
                        // Get force import option from the request
                        $forceImport = isset($_POST['force_import']) && $_POST['force_import'] === 'true';
                
                        $importExportModel = new ImportExportModel($pdo);
                        $message = $importExportModel->importData($tableName, $filePath, $fileType, $headerMapping, $forceImport);
                        $result = ['success' => true, 'message' => $message];
                    } else {
                        $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk mengimport data.'];
                    }
                    break;
                
                case 'export':
                    if ($userRole == 'admin' || $userRole == 'user') {
                        $importExportModel = new ImportExportModel($pdo);
                        $importExportModel->exportData($tableName);
                    } else {
                        $result = ['success' => false, 'message' => 'Anda tidak memiliki izin untuk mengekspor data.'];
                    }
                    break;
                case 'get_chart_data':
                    // Data untuk Pie Chart
                    $stmt = $pdo->prepare("SELECT sumber_gangguan, COUNT(*) as jumlah FROM gangguan_frekuensi GROUP BY sumber_gangguan");
                    $stmt->execute();
                    $pieData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    // Data untuk Bar Chart
                    $stmt = $pdo->prepare("SELECT pihak_pelapor, COUNT(*) as jumlah FROM gangguan_frekuensi GROUP BY pihak_pelapor");
                    $stmt->execute();
                    $barData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    $result = [
                        'success' => true,
                        'pie' => $pieData,
                        'bar' => $barData
                    ];
                break;

            default:
                throw new Exception('Aksi tidak dikenal.');
        }
    } catch (PDOException $e) {
        $result = ['success' => false, 'message' => 'Terjadi kesalahan database: ' . $e->getMessage()];
        error_log('Database error: ' . $e->getMessage());
    } catch (Exception $e) {
        $result = ['success' => false, 'message' => $e->getMessage()];
        error_log('General error: ' . $e->getMessage());
    }
}

header('Content-Type: application/json');
echo json_encode($result);
?>
