<?php

include 'koneksi-sfr.php';
 // Sertakan file koneksi database

$sql = "SELECT * FROM penertiban_sfr"; // Query untuk mengambil semua data
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // output data setiap baris
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['data' => $data]);
} else {
    echo json_encode(['data' => []]); // Kirim array kosong jika tidak ada data
}

$conn->close();
?>
