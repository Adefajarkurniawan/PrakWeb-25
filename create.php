<?php
// FILE: create.php
// Berfungsi untuk menerima data dari form di index.php dan menyimpannya ke database.

// 1. MEMULAI SESSION & MENGHUBUNGKAN KE DATABASE
session_start();
require_once 'koneksi.php';

// 2. KEAMANAN: MEMASTIKAN HANYA USER YANG SUDAH LOGIN YANG BISA AKSES
// Jika tidak ada session 'username', berarti user belum login.
// Alihkan ke halaman login dan hentikan eksekusi script.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 3. MEMPROSES DATA SAAT FORM DI-SUBMIT
// Cek apakah data dikirim menggunakan metode POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 4. MENGAMBIL DATA DARI FORM
    // Ambil data dari superglobal $_POST.
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    
    // 5. VALIDASI SEDERHANA
    // Pastikan tidak ada field yang kosong.
    if (!empty($nim) && !empty($nama) && !empty($jurusan)) {
        
        // 6. MENYIAPKAN QUERY INSERT YANG AMAN (PREPARED STATEMENT)
        // Menggunakan placeholder (?) untuk mencegah SQL Injection.
        $sql = "INSERT INTO mahasiswa (nim, nama, jurusan) VALUES (?, ?, ?)";
        
        $stmt = mysqli_prepare($koneksi, $sql);
        
        // Mengikat variabel ke placeholder. "sss" berarti ketiga variabel adalah string.
        mysqli_stmt_bind_param($stmt, "sss", $nim, $nama, $jurusan);
        
        // 7. MENGEKSEKUSI QUERY
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, redirect kembali ke halaman index.php
            // Pengguna akan langsung melihat data baru yang ditambahkan.
            header("Location: index.php");
            exit();
        } else {
            // Jika gagal, tampilkan pesan error
            echo "Error: Gagal menyimpan data. " . mysqli_error($koneksi);
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
    // Jika file ini diakses langsung tanpa melalui metode POST,
    // alihkan kembali ke halaman utama.
    header("Location: index.php");
    exit();
}
?>