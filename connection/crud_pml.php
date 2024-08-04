<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'koneksi.php';
require_once 'user.php';
require_once '../model/TableModel.php';
require '../vendor/autoload.php';

$database = new Database();
$pdo = $database->getConnection();
$model = new TableModel($pdo);

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : null);
$tableName = 'pemeriksaan_ml';

$result = ['success' => false, 'message' => 'Unknown error occurred'];

try {
    switch ($action) {
        case 'read':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = $pdo->prepare("SELECT * FROM $tableName WHERE ID_ML = :ID_ML");
                $stmt->bindParam(':ID_ML', $id, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $result = [
                    'success' => true,
                    'data' => $data
                ];
            } else {
                $data = $model->fetchData($tableName);
                $result = [
                    'success' => true,
                    'data' => $data
                ];
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
