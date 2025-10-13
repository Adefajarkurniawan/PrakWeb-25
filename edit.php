<?php
// FILE: edit.php
// Berfungsi untuk menerima data dari form edit di index.php dan meng-update-nya di database.

session_start();
require_once 'koneksi.php';

// Keamanan: Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Pastikan request adalah metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil semua data dari form, TERMASUK ID
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    
    // Validasi sederhana: pastikan semua field (termasuk ID) tidak kosong
    if (!empty($id) && !empty($nim) && !empty($nama) && !empty($jurusan)) {
        
        // Menyiapkan query UPDATE yang aman dengan PREPARED STATEMENT
        // Query ini akan mengubah data nim, nama, dan jurusan
        // PADA BARIS (WHERE) dengan id yang cocok.
        $sql = "UPDATE mahasiswa SET nim = ?, nama = ?, jurusan = ? WHERE id = ?";
        
        $stmt = mysqli_prepare($koneksi, $sql);
        
        // Mengikat variabel ke placeholder. "sssi" berarti string, string, string, integer.
        mysqli_stmt_bind_param($stmt, "sssi", $nim, $nama, $jurusan, $id);
        
        // Mengeksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, redirect kembali ke halaman index.php
            header("Location: index.php");
            exit();
        } else {
            // Jika gagal, tampilkan pesan error
            echo "Error: Gagal meng-update data. " . mysqli_error($koneksi);
        }
        
        // Menutup statement
        mysqli_stmt_close($stmt);
        
    } else {
        // Jika ada field yang kosong
        echo "Error: Semua field harus diisi.";
    }
    
    // Menutup koneksi database
    mysqli_close($koneksi);

} else {
    // Jika file ini diakses langsung, alihkan ke halaman utama
    header("Location: index.php");
    exit();
}
?>