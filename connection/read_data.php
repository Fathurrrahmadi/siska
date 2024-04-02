<?php

include 'koneksi-sfr.php'; // Sertakan file koneksi database

$tabel = isset($_GET['tabel']) ? $_GET['tabel'] : ''; // Ambil nama tabel dari parameter GET

// List tabel yang diizinkan untuk mencegah SQL Injection
$tabelYangDiizinkan = ['penertiban_sfr', 'gangguan_frekuensi','pengukuran_radio_fm','users'];

if(in_array($tabel, $tabelYangDiizinkan)) {
    $sql = "SELECT * FROM $tabel"; // Query untuk mengambil semua data dari tabel yang ditentukan
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
} else {
    echo "Tabel tidak valid atau tidak ditemukan";
}

$conn->close();
?>
