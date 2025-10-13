<?php
// FILE: delete.php
// Berfungsi untuk menerima ID dari URL, lalu menghapus data yang sesuai dari database.

session_start();
require_once 'koneksi.php';

// Keamanan: Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek apakah parameter 'id' ada di URL dan bukan kosong
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Ambil ID dari URL dan pastikan itu adalah integer untuk keamanan
    $id_to_delete = (int)$_GET['id'];
    
    // Menyiapkan query DELETE yang aman dengan PREPARED STATEMENT
    // Query ini akan menghapus baris dari tabel mahasiswa
    // DI MANA (WHERE) kolom 'id' cocok dengan ID yang diberikan.
    $sql = "DELETE FROM mahasiswa WHERE id = ?";
    
    $stmt = mysqli_prepare($koneksi, $sql);
    
    // Mengikat ID ke placeholder. "i" berarti tipenya adalah integer.
    mysqli_stmt_bind_param($stmt, "i", $id_to_delete);
    
    // Mengeksekusi query
    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil, redirect kembali ke halaman utama
        header("Location: index.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: Gagal menghapus data. " . mysqli_error($koneksi);
    }
    
    // Menutup statement
    mysqli_stmt_close($stmt);
    
} else {
    // Jika tidak ada ID di URL, kembalikan user ke halaman utama
    header("Location: index.php");
    exit();
}

// Menutup koneksi database
mysqli_close($koneksi);
?>