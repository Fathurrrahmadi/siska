<?php
include 'koneksi-sfr.php'; // Sertakan file koneksi database

// Penerimaan data dari formulir
$no_surat_tugas = $_POST['no_surat_tugas'] ?? '';
$tanggal_tugas = $_POST['tanggal_tugas'] ?? '';
$pihak_pelapor = $_POST['pihak_pelapor'] ?? '';
$pihak_pengganggu = $_POST['pihak_pengganggu'] ?? '';
$frekuensi_terukur = $_POST['frekuensi_terukur'] ?? '';
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$sumber_gangguan = $_POST['sumber_gangguan'] ?? '';
$tindakan = $_POST['tindakan'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';
$tanggal_penanganan_gangguan = $_POST['tanggal_penanganan_gangguan'] ?? '';

// Query SQL untuk menyisipkan data ke tabel gangguan_frekuensi
$query = "INSERT INTO gangguan_frekuensi (no_surat_tugas, tanggal_tugas, pihak_pelapor, pihak_pengganggu, frekuensi_terukur, latitude, longitude, alamat, sumber_gangguan, tindakan, keterangan, tanggal_penanganan_gangguan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Persiapan dan eksekusi query
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssssssss", $no_surat_tugas, $tanggal_tugas, $pihak_pelapor, $pihak_pengganggu, $frekuensi_terukur, $latitude, $longitude, $alamat, $sumber_gangguan, $tindakan, $keterangan, $tanggal_penanganan_gangguan);

if ($stmt->execute()) {
    echo "Data berhasil disimpan.";
    header('Location: ../layout-penanganan-gangguan.php'); 
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}



$stmt->close();
$conn->close();
?>
