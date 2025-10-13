<?php
// MEMULAI SESSION
session_start();

// ARRAY ASOSIATIF - Menyimpan credential user statis
// Array asosiatif adalah array yang menggunakan key berbentuk string
$users = [
    "admin" => [
        "username" => "admin",
        "password" => "admin123",
        "email" => "admin@admin.com",
        "role" => "Admin"
    ],
    "farrel" => [
        "username" => "farrel",
        "password" => "farrel123",
        "email" => "farrel@mahasiswa.com",
        "role" => "Mahasiswa"
    ],
    "ade" => [
        "username" => "ade",
        "password" => "ade123",
        "email" => "ade@dosen.com",
        "role" => "Dosen"
    ]
];

// Variabel untuk menyimpan pesan error
$error_message = "";

// SUPERGLOBAL $_SERVER dan $_POST
// Mengecek apakah form sudah disubmit dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // SUPERGLOBAL $_POST - Mengambil data dari form
    // htmlspecialchars() untuk mencegah XSS attack
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    
    // Validasi: Cek apakah username ada di array $users
    if (isset($users[$username])) {
        // Cek apakah password cocok dengan yang ada di array
        if ($users[$username]['password'] === $password) {
            // LOGIN BERHASIL
            // SUPERGLOBAL $_SESSION - Menyimpan data user ke session
            $_SESSION['username'] = $users[$username]['username'];
            $_SESSION['fullname'] = $users[$username]['fullname'];
            $_SESSION['email'] = $users[$username]['email'];
            $_SESSION['role'] = $users[$username]['role'];
            $_SESSION['login_time'] = date('Y-m-d H:i:s'); // Simpan waktu login
            
            // Redirect ke halaman index.php
            header("Location: index.php");
            exit(); // Hentikan eksekusi script
        } else {
            // Password salah
            $error_message = "Password salah!";
        }
    } else {
        // Username tidak ditemukan
        $error_message = "Username tidak ditemukan!";
    }
}

// Jika user sudah login, redirect ke index
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Mahasiswa</title>
    
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <button id="themeToggle" class="theme-toggle-btn">
        <span class="theme-icon"><i class="fas fa-moon"></i></span>
        <span class="theme-text">Dark Mode</span>
    </button>

    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-user-graduate"></i>
            <h1>Login Sistem</h1>
            <p>Sistem Manajemen Data Mahasiswa</p>
        </div>
        
        <?php
        // Menampilkan error message jika ada
        if (!empty($error_message)) {
            echo "<div class='error-message'>";
            echo "<i class='fas fa-exclamation-circle'></i> ";
            echo $error_message;
            echo "</div>";
        }
        ?>
        
        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user"></i> Username:
                </label>
                <input type="text" id="username" name="username" 
                       placeholder="Masukkan username" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password:
                </label>
                <input type="password" id="password" name="password" 
                       placeholder="Masukkan password" required>
            </div>
            
            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <!-- Info Credentials untuk Testing -->
        <div class="credentials-info">
            <h3><i class="fas fa-info-circle"></i> Credentials untuk Testing:</h3>
            <ul>
                <?php
                // LOOPING MELALUI ARRAY ASOSIATIF
                // Menampilkan semua user yang tersedia menggunakan foreach
                foreach ($users as $key => $user) {
                    echo "<li>";
                    echo "({$user['role']})<br>";
                    echo "Username: <code>{$user['username']}</code> | ";
                    echo "Password: <code>{$user['password']}</code>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
    
    <script src="script/script.js"></script>
</body>
</html>
