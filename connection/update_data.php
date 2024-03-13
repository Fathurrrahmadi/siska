<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'koneksi-sfr.php';

$idsfr = $_POST['idsfr'] ?? ''; 
$nama_pengguna = $_POST['namaPengguna'] ?? ''; // Memperbaiki dari 'NAMA_PENGGUNA' menjadi 'namaPengguna'
$frekuensi = $_POST['frekuensi'] ?? 0;
$dinas = $_POST['dinas'] ?? '';
$subservice = $_POST['subservice'] ?? '';
$lokasi = $_POST['lokasi'] ?? '';
$provinsi = $_POST['provinsi'] ?? '';
$kab_kota = $_POST['kabKota'] ?? ''; // Memperbaiki dari 'KAB_KOTA' menjadi 'kabKota'
$jenis_pelanggaran = $_POST['jenisPelanggaran'] ?? ''; // Memperbaiki dari 'JENIS_PELANGGARAN' menjadi 'jenisPelanggaran'
$tindakan = $_POST['tindakan'] ?? '';
$status = $_POST['status'] ?? '';
$tgl_operasi_stasiun = $_POST['tglOperasiStasiun'] ?? ''; // Memperbaiki dari 'TGL_OPERASI_STASIUN' menjadi 'tglOperasiStasiun'
$no_isr_setelah_penindakan = $_POST['noISRSetelahPenindakan'] ?? ''; // Memperbaiki dari 'NO_ISR_SETELAH_PENINDAKAN' menjadi 'noISRSetelahPenindakan'
$no_surat_penindakan = $_POST['noSuratPenindakan'] ?? ''; // Memperbaiki dari 'NO_SURAT_PENINDAKAN' menjadi 'noSuratPenindakan'
$tanggal_tindakan = $_POST['tanggalTindakan'] ?? ''; // Memperbaiki dari 'TANGGAL_TINDAKAN' menjadi 'tanggalTindakan'
$keterangan = $_POST['keterangan'] ?? '';

$stmt = $conn->prepare("UPDATE penertiban_sfr SET `NAMA PENGGUNA` = ?, `FREKUENSI(MHz)` = ?, `DINAS` = ?, `SUBSERVICE` = ?, `LOKASI` = ?, `PROVINSI` = ?, `KAB/KOTA` = ?, `JENIS PELANGGARAN` = ?, `TINDAKAN` = ?, `STATUS` = ?, `TGL OPERASI STASIUN` = ?, `NO ISR SETELAH PENINDAKAN` = ?, `NO SURAT PENINDAKAN` = ?, `TANGGAL TINDAKAN` = ?, `KETERANGAN` = ? WHERE `idsfr` = ?");
$stmt->bind_param("sdsssssssssssssi", $nama_pengguna, $frekuensi, $dinas, $subservice, $lokasi, $provinsi, $kab_kota, $jenis_pelanggaran, $tindakan, $status, $tgl_operasi_stasiun, $no_isr_setelah_penindakan, $no_surat_penindakan, $tanggal_tindakan, $keterangan, $idsfr);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Record updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => "Error updating record: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
