<?php
// require_once 'koneksi.php';

// $database = new Database();
// $pdo = $database->getConnection(); 

// if (isset($_GET['action']) && $_GET['action'] == 'read') {
//     echo json_encode(readPg());
// } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     switch ($_POST['action']) {
//         case 'create':
//             echo createPg($_POST);
//             break;
//         case 'update':
//             echo updatePg($_POST['id'], $_POST);
//             break;
//         case 'delete':
//             echo deletePg($_POST['id']);
//             break;
//     }
// }


// function createPRfm($data){

// }

// function readPRfm(){
//     global $pdo;
//     $sql = "SELECT * FROM pengukuran_radio_fm";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute();
//     return $stmt->fetchAll();

// }
// function updatePRfm($id, $data){

// }
// function deletePRfm($id){

//     global $pdo;
//     $sql = "DELETE FROM gangguan_frekuensi WHERE ID=?";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute([$id]);
//     return $stmt->rowCount();
// }
?>