<?php
require_once 'koneksi.php'; // Pastikan ini adalah file koneksi PDO yang benar

$database = new Database();
$pdo = $database->getConnection(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    // Error handling: No action specified
    exit('No action specified');
}

switch ($action) {
    case 'create':
        echo createPg($_POST);
        break;
    case 'update':
        echo updatePg($_POST['id'], $_POST);
        break;
    case 'delete':
        echo deletePg($_POST['id']);
        break;
    case 'read':
        echo json_encode(readPg());
        break;
    default:
        // Error handling: Unknown action
        exit('Unknown action');
}

function readPg() {
    global $pdo;
    $sql = "SELECT * FROM gangguan_frekuensi";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function createPg($data) {
    global $pdo;
    $sql = "INSERT INTO gangguan_frekuensi (no_surat_tugas, tanggal_tugas, pihak_pelapor, pihak_pengganggu, latitude, longitude, frekuensi_terukur, alamat, sumber_gangguan, tindakan, keterangan, tanggal_penanganan_gangguan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['no_surat_tugas'], $data['tanggal_tugas'], $data['pihak_pelapor'], $data['pihak_pengganggu'],
        $data['latitude'], $data['longitude'], $data['frekuensi_terukur'], $data['alamat'],
        $data['sumber_gangguan'], $data['tindakan'], $data['keterangan'], $data['tanggal_penanganan_gangguan']
    ]);
        header('Location: ../layout-penanganan-gangguan.php');  // Redirect ke halaman tabel
        exit(); 
 
    
}



function updatePg($id, $data) {
    global $pdo;
    $sql = "UPDATE gangguan_frekuensi SET no_surat_tugas=?, tanggal_tugas=?, pihak_pelapor=?, pihak_pengganggu=?, frekuensi_terukur=?, latitude=?, longitude=?, alamat=?, sumber_gangguan=?, tindakan=?, keterangan=?, tanggal_penanganan_gangguan=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([
        $data['no_surat_tugas'], $data['tanggal_tugas'], $data['pihak_pelapor'], $data['pihak_pengganggu'], $data['frekuensi_terukur'],
        $data['latitude'], $data['longitude'],  $data['alamat'], $data['sumber_gangguan'], $data['tindakan'], $data['keterangan'], $data['tanggal_penanganan_gangguan'],
        $id
    ])) {
        if ($stmt->rowCount() > 0) {
            return json_encode(['success' => true, 'message' => 'Data berhasil diupdate']);
        } else {
            // Tidak ada baris yang terpengaruh, kemungkinan ID tidak ditemukan
            return json_encode(['success' => false, 'message' => 'Tidak ada perubahan data atau ID tidak ditemukan.']);
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        return json_encode(['success' => false, 'message' => 'Gagal mengupdate data. Error: ' . $errorInfo[2]]);
    }
}


function deletePg($id) {
    global $pdo;
    $sql = "DELETE FROM gangguan_frekuensi WHERE id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$id])) {
        return json_encode(['success' => true, 'message' => 'Data berhasil dihapus']);
    } else {
        return json_encode(['success' => false, 'message' => 'Gagal menghapus data']);
    }
}
?>
