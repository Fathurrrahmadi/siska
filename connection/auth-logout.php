<?php
session_start();  // Mulai sesi

session_unset();  // Hapus semua variabel sesi
session_destroy();  // Hancurkan sesi

// Arahkan kembali ke halaman login
header("Location: ../auth-login.html");
exit;  // Pastikan tidak ada kode yang dieksekusi setelah pengalihan
?>
