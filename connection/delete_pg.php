<?php
// Koneksi ke database
include 'koneksi-sfr.php'; // Sesuaikan dengan file koneksi Anda

$response = array('success' => false, 'message' => 'Data gagal dihapus.');

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query untuk menghapus data
    $query = "DELETE FROM gangguan_frekuensi WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Data berhasil dihapus.';
    }
    $stmt->close();
}

echo json_encode($response);
?>
