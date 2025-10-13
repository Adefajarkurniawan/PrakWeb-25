<?php
// MEMULAI SESSION
session_start();

// MENGECEK APAKAH USER SUDAH LOGIN
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// MENGHUBUNGKAN KE DATABASE
require_once 'koneksi.php';

// MENGAKSES DATA DARI SESSION
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];

$userInfo = [
    "username" => $username,
    "email" => $email,
    "role" => $role,
    "login_time" => isset($_SESSION['login_time']) ? $_SESSION['login_time'] : 'N/A'
];


$is_edit_mode = false; 
$data_to_edit = null;  
$action_url = 'create.php'; 
$button_text = 'Simpan Data'; 

// Cek apakah ada parameter 'edit_id' di URL (dikirim saat tombol edit diklik)
if (isset($_GET['edit_id'])) {
    $is_edit_mode = true;
    $action_url = 'edit.php'; 
    $button_text = 'Update Data'; 
    
    $id_to_edit = $_GET['edit_id'];
    
    $sql_edit = "SELECT * FROM mahasiswa WHERE id = ?";
    $stmt_edit = mysqli_prepare($koneksi, $sql_edit);
    mysqli_stmt_bind_param($stmt_edit, "i", $id_to_edit); 
    mysqli_stmt_execute($stmt_edit);
    $result_edit = mysqli_stmt_get_result($stmt_edit);
    
    if ($result_edit && mysqli_num_rows($result_edit) > 0) {
        $data_to_edit = mysqli_fetch_assoc($result_edit);
    }
    mysqli_stmt_close($stmt_edit);
}


$sql_mahasiswa = "SELECT id, nim, nama, jurusan FROM mahasiswa ORDER BY nama ASC";
$result_mahasiswa = mysqli_query($koneksi, $sql_mahasiswa);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Mahasiswa</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header>
        <h1 id="headerTitle">Dasbor Manajemen Mahasiswa</h1>
        <div class="header-buttons">
            <button id="themeToggle" class="theme-toggle-btn"><span class="theme-icon"><i class="fas fa-moon"></i></span><span class="theme-text">Dark Mode</span></button>
            <a href="logout.php" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin logout?')"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
    </header>

    <main>
        <div class="form-container">
            <h2><?php echo $is_edit_mode ? 'Edit Data Mahasiswa' : 'Tambah Data Mahasiswa'; ?></h2>
            
            <form id="mahasiswaForm" method="POST" action="<?php echo $action_url; ?>">
                
                <input type="hidden" name="id" value="<?php echo $is_edit_mode ? $data_to_edit['id'] : ''; ?>">

                <div class="form-group">
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" placeholder="Masukkan Nomor Induk Mahasiswa" required 
                           value="<?php echo $is_edit_mode ? htmlspecialchars($data_to_edit['nim']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required
                           value="<?php echo $is_edit_mode ? htmlspecialchars($data_to_edit['nama']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <input type="text" id="jurusan" name="jurusan" placeholder="Contoh: Teknik Informatika" required
                           value="<?php echo $is_edit_mode ? htmlspecialchars($data_to_edit['jurusan']) : ''; ?>">
                </div>

                <button type="submit"><?php echo $button_text; ?></button>
                <?php if ($is_edit_mode): ?>
                    <a href="index.php" class="cancel-btn">Batal Edit</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-container">
            <h2>Daftar Mahasiswa</h2>
            <div class="session-info">
                <strong><i class="fas fa-info-circle"></i> Informasi Session:</strong><br>
                <?php foreach ($userInfo as $key => $value) { echo "<span class='session-key'>" . ucfirst(str_replace('_', ' ', $key)) . ":</span> <strong>" . htmlspecialchars($value) . "</strong><br>"; } ?>
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
                    <?php
                    if ($result_mahasiswa && mysqli_num_rows($result_mahasiswa) > 0) {
                        while ($mahasiswa = mysqli_fetch_assoc($result_mahasiswa)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($mahasiswa['nim']) . "</td>";
                            echo "<td>" . htmlspecialchars($mahasiswa['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($mahasiswa['jurusan']) . "</td>";
                            echo "<td>";
                            // PERUBAHAN TOMBOL EDIT: Menjadi link <a> yang mengirim ID ke URL
                            echo '<a href="index.php?edit_id=' . $mahasiswa['id'] . '" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</a> ';
                            echo '<a href="delete.php?id=' . $mahasiswa['id'] . '" class="action-btn delete-btn" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini secara permanen?\')"><i class="fas fa-trash"></i> Hapus</a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo '<tr><td colspan="4" style="text-align: center;">Belum ada data mahasiswa.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 - Kelas Web Programming</p>
        <p id="modeStatus">Mode Saat Ini: Light Mode</p>
        <p class="logged-user">Logged in as: <strong><?php echo htmlspecialchars($username); ?></strong></p>
    </footer>

    <script src="script/script.js"></script>
</body>
</html>
<?php
// Menutup koneksi database di akhir file
mysqli_close($koneksi);
?>
