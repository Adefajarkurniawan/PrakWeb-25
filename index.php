<?php
// MEMULAI SESSION
// Session harus dimulai di awal file sebelum HTML apapun
session_start();

// MENGECEK APAKAH USER SUDAH LOGIN
// Menggunakan fungsi isset() untuk cek apakah variabel session 'username' sudah di-set
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: login.php");
    exit(); // Hentikan eksekusi script
}

// MENGAKSES DATA DARI SESSION
// Setelah lolos pengecekan, kita bisa akses data user dari session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];

// Array asosiatif untuk menyimpan informasi user session
$userInfo = [
    "username" => $username,
    "email" => $email,
    "role" => $role,
    "login_time" => isset($_SESSION['login_time']) ? $_SESSION['login_time'] : 'N/A'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Dasbor Mahasiswa</title>

    <link rel="stylesheet" href="style/style.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <header>
        <h1 id="headerTitle">Dasbor Manajemen Mahasiswa</h1>
        
        <!-- container yang ngewrap 2 button dibawah -->
        <div class="header-buttons">
            <!-- Button Toggle Dark Mode -->
            <button id="themeToggle" class="theme-toggle-btn">
                <span class="theme-icon"><i class="fas fa-moon"></i></span>
                <span class="theme-text">Dark Mode</span>
            </button>
            
            <!--  Logout Button === -->
            <a href="logout.php" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </header>

    <main>
        <div class="form-container">
            <h2>Manajemen Data Mahasiswa</h2>
            
            <form id="mahasiswaForm">
                
                <input type="hidden" id="mahasiswaId" name="id">

                <div class="form-group">
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" placeholder="Masukkan Nomor Induk Mahasiswa" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required>
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <input type="text" id="jurusan" name="jurusan" placeholder="Contoh: Teknik Informatika" required>
                </div>

                <button type="submit">Simpan Data</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Daftar Mahasiswa</h2>
            
            <!-- display session info-->
            <div class="session-info">
                <strong><i class="fas fa-info-circle"></i> Informasi Session:</strong><br>
                <?php
                foreach ($userInfo as $key => $value) {
                    echo "<span class='session-key'>";
                    echo ucfirst(str_replace('_', ' ', $key)); // Ubah key jadi readable
                    echo ":</span> <strong>" . htmlspecialchars($value) . "</strong><br>";
                }
                ?>
            </div>
            
            <table id="mahasiswaTable">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="mahasiswaTableBody">
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 - Kelas Web Programming</p>
        <p id="modeStatus">Mode Saat Ini: Light Mode</p>
        <!-- === BAGIAN BARU: Logged in info === -->
        <p class="logged-user">
            Logged in as: <strong><?php echo $username; ?></strong>
        </p>
    </footer>

    <script src="script/script.js"></script>
    <script src="script/handleAPI.js"></script>

</body>
</html>