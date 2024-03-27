<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'koneksi-sfr.php'; // Asumsi nama file koneksi adalah koneksi-pg.php

$id = $_POST['id'] ?? '';
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

$frekuensi_pattern = '/^\d+(\.\d+)?(\s*-\s*\d+(\.\d+)?)?$/';

// Memeriksa apakah format frekuensi sesuai
if (!preg_match($frekuensi_pattern, $frekuensi_terukur)) {
    echo json_encode(['success' => false, 'message' => 'Format frekuensi tidak sesuai. Format yang diizinkan: 000.000 atau 000.000 - 000.000']);
    exit;
}

// Menambahkan " MHz" secara otomatis jika belum disertakan
if (!strpos($frekuensi_terukur, 'MHz')) {
    $frekuensi_terukur .= ' MHz';
}

// Persiapkan statement SQL untuk update data
$stmt = $conn->prepare("UPDATE gangguan_frekuensi SET no_surat_tugas = ?, tanggal_tugas = ?, pihak_pelapor = ?, pihak_pengganggu = ?, frekuensi_terukur = ?, latitude = ?, longitude = ?, alamat = ?, sumber_gangguan = ?, tindakan = ?, keterangan = ?, tanggal_penanganan_gangguan = ? WHERE id = ?");

// Bind parameter ke statement
$stmt->bind_param("ssssddssssssi", $no_surat_tugas, $tanggal_tugas, $pihak_pelapor, $pihak_pengganggu, $frekuensi_terukur, $latitude, $longitude, $alamat, $sumber_gangguan, $tindakan, $keterangan, $tanggal_penanganan_gangguan, $id);

// Eksekusi statement
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Record updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => "Error updating record: " . $stmt->error]);
}

// Tutup statement dan koneksi database
$stmt->close();
$conn->close();
?>
