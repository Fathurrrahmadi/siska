<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'koneksi.php'; // Pastikan ini adalah file koneksi PDO yang benar

$database = new Database();
$pdo = $database->getConnection(); 

if (isset($_GET['action']) && $_GET['action'] == 'read') {
    echo json_encode(readSfr());
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['action']) {
        case 'create':
            echo createSfr($_POST);
            break;
        case 'update':
            echo updateSfr($_POST['idsfr'], $_POST);
            break;
        case 'delete':
            echo deleteSfr($_POST['idsfr']);
            break;
    }
}

function createSfr($data) {
    global $pdo;
    //gip lo ngentot buat nama column gajelas anjign
    // Pastikan nama-nama kolom di query SQL sesuai dengan nama kolom di database Anda
    $sql = "INSERT INTO penertiban_sfr (`NAMA PENGGUNA`, `FREKUENSI(MHZ)`, `DINAS`, `SUBSERVICE`, `LOKASI`, `PROVINSI`, `KAB/KOTA`, `JENIS PELANGGARAN`, `TINDAKAN`, `STATUS`, `TGL OPERASI STASIUN`, `NO ISR SETELAH PENINDAKAN`, `NO SURAT PENINDAKAN`, `TANGGAL TINDAKAN`, `KETERANGAN`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Menyiapkan prepared statement
    $stmt = $pdo->prepare($sql);

    // Bind parameter ke statement
    $stmt->execute([
        $data['NAMA_PENGGUNA'],
        $data['FREKUENSI_MHz'],
        $data['DINAS'],
        $data['SUBSERVICE'],
        $data['LOKASI'],
        $data['PROVINSI'],
        $data['KAB_KOTA'],
        $data['JENIS_PELANGGARAN'],
        $data['TINDAKAN'],
        $data['STATUS'],
        $data['TGL_OPERASI_STASIUN'],
        $data['NO_ISR_SETELAH_PENINDAKAN'],
        $data['NO_SURAT_PENINDAKAN'],
        $data['TANGGAL_TINDAKAN'],
        $data['KETERANGAN']
    ]);

    header('Location: ../layout-table-SFR-modified.php');  // Redirect ke halaman tabel
    exit(); 
    
}

function readSfr() {
    global $pdo;
    $sql = "SELECT * FROM penertiban_sfr";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}



function updateSfr($id, $data) {
    global $pdo;
    try {
        $sql = "UPDATE penertiban_sfr SET `NAMA PENGGUNA` = ?, `FREKUENSI(MHz)` = ?, `DINAS` = ?, `SUBSERVICE` = ?, `LOKASI` = ?, `PROVINSI` = ?, `KAB/KOTA` = ?, `JENIS PELANGGARAN` = ?, `TINDAKAN` = ?, `STATUS` = ?, `TGL OPERASI STASIUN` = ?, `NO ISR SETELAH PENINDAKAN` = ?, `NO SURAT PENINDAKAN` = ?, `TANGGAL TINDAKAN` = ?, `KETERANGAN` = ? WHERE `idsfr` = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['NAMA PENGGUNA'], $data['FREKUENSI(MHz)'], $data['DINAS'], $data['SUBSERVICE'],
            $data['LOKASI'], $data['PROVINSI'], $data['KAB/KOTA'], $data['JENIS PELANGGARAN'],
            $data['TINDAKAN'], $data['STATUS'], $data['TGL OPERASI STASIUN'], 
            $data['NO ISR SETELAH PENINDAKAN'],$data['NO SURAT PENINDAKAN'],
            $data['TANGGAL TINDAKAN'],$data['KETERANGAN'], $id
        ]);
        echo json_encode(['success' => true, 'message' => 'Update successful']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()]);
    }
}


function deleteSfr($id) {
    global $pdo;
    $sql = "DELETE FROM penertiban_sfr WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->rowCount();
}
?>
