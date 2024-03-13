<?php
include 'koneksi-sfr.php';

// Aktifkan laporan error
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Mendapatkan data dari form
$nama_pengguna = $_POST['NAMA_PENGGUNA'];
$frekuensi = $_POST['FREKUENSI_MHz']; // Asumsi input adalah format yang valid untuk double
$dinas = $_POST['DINAS'];
$subservice = $_POST['SUBSERVICE'];
$lokasi = $_POST['LOKASI'];
$provinsi = $_POST['PROVINSI'];
$kab_kota = $_POST['KAB_KOTA'];
$jenis_pelanggaran = $_POST['JENIS_PELANGGARAN'];
$tindakan = $_POST['TINDAKAN'];
$status = $_POST['STATUS'];
$tgl_operasi_stasiun = $_POST['TGL_OPERASI_STASIUN'];
$no_isr_setelah_penindakan = $_POST['NO_ISR_SETELAH_PENINDAKAN'];
$no_surat_penindakan = $_POST['NO_SURAT_PENINDAKAN'];
$tanggal_tindakan = $_POST['TANGGAL_TINDAKAN'];
$keterangan = $_POST['KETERANGAN'];

// Query dengan backticks untuk nama kolom yang tidak standar
$query = "INSERT INTO penertiban_sfr (`NAMA PENGGUNA`, `FREKUENSI(MHz)`, `DINAS`, `SUBSERVICE`, `LOKASI`, `PROVINSI`, `KAB/KOTA`, `JENIS PELANGGARAN`, `TINDAKAN`, `STATUS`, `TGL OPERASI STASIUN`, `NO ISR SETELAH PENINDAKAN`, `NO SURAT PENINDAKAN`, `TANGGAL TINDAKAN`, `KETERANGAN`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);

// Periksa jika $stmt adalah false yang menandakan kesalahan pada prepare statement
if ($stmt === false) {
    throw new Exception('Prepare statement failed: ' . $conn->error);
}

// Binding parameter
$stmt->bind_param("sdsssssssssssss", 
    $nama_pengguna, 
    $frekuensi, 
    $dinas, 
    $subservice, 
    $lokasi, 
    $provinsi, 
    $kab_kota, 
    $jenis_pelanggaran, 
    $tindakan, 
    $status, 
    $tgl_operasi_stasiun, 
    $no_isr_setelah_penindakan, 
    $no_surat_penindakan, 
    $tanggal_tindakan, 
    $keterangan);

// Menjalankan statement
if($stmt->execute()) {
    echo "Data berhasil disimpan";
    header('Location: ../layout-table-SFR-modified.php'); 
    exit(); 
} else {
    echo "Error: " . $stmt->error;
}


// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
