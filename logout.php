<?php
// FILE LOGOUT.PHP
// File ini berfungsi untuk menghancurkan session dan mengarahkan user kembali ke halaman login

// Memulai session
session_start();

// MENGHAPUS DATA DARI SESSION
// Menghapus semua variabel session
session_unset();

// MENGHANCURKAN SESSION
// Menghancurkan session sepenuhnya
session_destroy();

// Redirect ke halaman login dengan pesan
header("Location: login.php");
exit(); // Hentikan eksekusi script
?>
