# 📝 Dokumentasi Perubahan - Implementasi PHP

## 🎯 Ringkasan Perubahan

Project telah dikonversi dari HTML statis menjadi aplikasi PHP dinamis dengan sistem autentikasi dan manajemen session.

---

## 📁 File yang Dibuat/Dimodifikasi

### ✅ File Baru:
1. **login.php** - Halaman login dengan autentikasi
2. **logout.php** - Handler untuk logout
3. **index.php** - Dashboard (converted dari index.html)

### ❌ File yang Dihapus:
- **index.html** - Diganti dengan index.php

### 🔄 File yang Dimodifikasi:
- **style/style.css** - Ditambahkan styling baru untuk komponen PHP

---

## 🆕 Fitur yang Ditambahkan

### 1. **login.php** - Sistem Login

#### A. Array Asosiatif untuk User Credentials
```php
// === BAGIAN BARU: Array Asosiatif ===
$users = [
    "admin" => [
        "username" => "admin",
        "password" => "admin123",
        "fullname" => "Administrator",
        "email" => "admin@mahasiswa.com",
        "role" => "Admin"
    ],
    // ... dst
];
```

#### B. Superglobal yang Digunakan
- `$_SERVER["REQUEST_METHOD"]` - Mengecek metode HTTP (GET/POST)
- `$_POST['username']` - Mengambil data username dari form
- `$_POST['password']` - Mengambil data password dari form
- `$_SESSION` - Menyimpan data user setelah login berhasil

#### C. Session Management
```php
// === BAGIAN BARU: Menyimpan data ke session ===
$_SESSION['username'] = $users[$username]['username'];
$_SESSION['fullname'] = $users[$username]['fullname'];
$_SESSION['email'] = $users[$username]['email'];
$_SESSION['role'] = $users[$username]['role'];
```

#### D. Security Features
- `htmlspecialchars()` - Mencegah XSS attack
- `isset()` - Validasi data
- Password validation

#### E. Looping Array Asosiatif
```php
// === BAGIAN BARU: Menampilkan semua credentials untuk testing ===
foreach ($users as $key => $user) {
    echo "<li>";
    echo "<strong>{$user['fullname']}</strong> ({$user['role']})<br>";
    echo "Username: <code>{$user['username']}</code> | ";
    echo "Password: <code>{$user['password']}</code>";
    echo "</li>";
}
```

---

### 2. **index.php** - Dashboard dengan Session Check

#### A. Session Protection
```php
// === BAGIAN BARU: Mengecek apakah user sudah login ===
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
```

#### B. Mengakses Data Session
```php
// === BAGIAN BARU: Array asosiatif untuk info user ===
$userInfo = [
    "username" => $username,
    "fullname" => $fullname,
    "email" => $email,
    "role" => $role,
    "login_time" => isset($_SESSION['login_time']) ? $_SESSION['login_time'] : 'N/A'
];
```

#### C. Header dengan Buttons
```html
<!-- === BAGIAN BARU: Header Buttons Container === -->
<div class="header-buttons">
    <!-- Button Toggle Dark Mode -->
    <button id="themeToggle" class="theme-toggle-btn">
        <span class="theme-icon"><i class="fas fa-moon"></i></span>
        <span class="theme-text">Dark Mode</span>
    </button>
    
    <!-- === BAGIAN BARU: Logout Button === -->
    <a href="logout.php" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin logout?')">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
</div>
```

#### D. Session Info Display
```html
<!-- === BAGIAN BARU: Session Info Display === -->
<div class="session-info">
    <strong><i class="fas fa-info-circle"></i> Informasi Session:</strong><br>
    <?php
    // === BAGIAN BARU: LOOPING MELALUI ARRAY ASOSIATIF ===
    foreach ($userInfo as $key => $value) {
        echo "<span class='session-key'>";
        echo ucfirst(str_replace('_', ' ', $key));
        echo ":</span> <strong>" . htmlspecialchars($value) . "</strong><br>";
    }
    ?>
</div>
```

#### E. Footer dengan User Info
```html
<!-- === BAGIAN BARU: Logged in info === -->
<p class="logged-user">
    Logged in as: <strong><?php echo $username; ?></strong>
</p>
```

---

### 3. **logout.php** - Logout Handler

```php
// === BAGIAN BARU: File logout lengkap ===
session_start();
session_unset();    // Hapus semua variabel session
session_destroy();  // Hancurkan session
header("Location: login.php");
exit();
```

---

### 4. **style/style.css** - CSS Baru

#### A. Header Layout Baru
```css
/* === DIUBAH: Layout header dengan flexbox === */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 40px;
}

header h1 {
    flex: 1;
    text-align: left;
}
```

#### B. Header Buttons Container
```css
/* === BARU: Container untuk buttons di header === */
.header-buttons {
    display: flex;
    align-items: center;
    gap: 20px; /* jarak 20px antara logout dan dark mode button */
}
```

#### C. Theme Toggle Button (Modified)
```css
/* === DIUBAH: Hapus position absolute === */
.theme-toggle-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    /* ... */
}

.theme-toggle-btn:hover {
    transform: scale(1.05); /* tanpa translateY */
}
```

#### D. Logout Button Styling
```css
/* === BARU: LOGOUT BUTTON STYLING === */
.logout-btn {
    padding: 10px 20px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.logout-btn:hover {
    background-color: #c82333;
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
}

/* Dark Mode */
body.dark-theme .logout-btn {
    background-color: #ff6b6b;
}
```

#### E. Session Info Styling
```css
/* === BARU: SESSION INFO STYLING === */
.session-info {
    background-color: rgba(74, 144, 226, 0.1);
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 0.9rem;
}

.session-info .session-key {
    color: #555;
}

body.dark-theme .session-info {
    background-color: rgba(255, 215, 0, 0.1);
}
```

#### F. Footer Logged User Info
```css
/* === BARU: LOGGED USER INFO IN FOOTER === */
.logged-user {
    font-size: 0.85rem;
    color: #ccc;
}

.logged-user strong {
    color: #ffd700;
}
```

#### G. Responsive Design Updates
```css
/* === DIUBAH: Responsive untuk header baru === */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        gap: 15px;
    }
    
    header h1 {
        text-align: center;
    }
    
    .header-buttons {
        flex-direction: column;
        width: 100%;
        gap: 10px;
    }
    
    .theme-toggle-btn,
    .logout-btn {
        width: 100%;
        justify-content: center;
    }
}
```

---

## 🔐 Credentials untuk Testing

| Nama | Username | Password | Role |
|------|----------|----------|------|
| Administrator | `admin` | `admin123` | Admin |
| Farrel Kurniawan | `farrel` | `farrel123` | Dosen |
| John Doe | `john` | `john123` | Mahasiswa |

---

## 📚 Materi PHP yang Diterapkan

### ✅ 1. Sintaks Dasar PHP
- `<?php ?>` tags
- `echo` statement
- Comments

### ✅ 2. Variabel
- `$username`, `$password`, `$fullname`, dll
- Loosely typed

### ✅ 3. PHP dan HTML
- PHP embedded dalam HTML
- Template literal dengan `<?php echo ?>`

### ✅ 4. Array Asosiatif
- Array `$users` dengan nested array
- Array `$userInfo` untuk data session
- Akses nilai: `$users[$username]['fullname']`

### ✅ 5. Superglobal
- `$_SERVER["REQUEST_METHOD"]` - Cek metode HTTP
- `$_POST` - Ambil data form
- `$_SESSION` - Simpan/akses data session

### ✅ 6. Session Management
- `session_start()` - Memulai session
- `$_SESSION['key'] = value` - Menyimpan data
- `isset($_SESSION['key'])` - Cek session
- `session_unset()` - Hapus variabel
- `session_destroy()` - Hancurkan session

### ✅ 7. Looping Array Asosiatif
- `foreach ($array as $key => $value)` - Loop di login.php
- `foreach ($userInfo as $key => $value)` - Loop di index.php

### ✅ 8. Security
- `htmlspecialchars()` - Mencegah XSS
- `exit()` - Hentikan eksekusi
- Validasi input dengan `isset()`

### ✅ 9. Redirect
- `header("Location: url")` - Redirect ke halaman lain
- `exit()` - Hentikan script setelah redirect

---

## 🚀 Cara Menjalankan

1. Buka terminal di folder project
2. Jalankan PHP development server:
   ```bash
   php -S localhost:8000
   ```
3. Buka browser dan akses: `http://localhost:8000/login.php`
4. Login dengan salah satu credentials di atas
5. Akan redirect ke `index.php` (dashboard)

---

## 🎨 Perubahan UI/UX

### Layout Header:
- **Sebelum**: Judul di tengah, dark mode button di kanan atas (absolute position)
- **Sesudah**: Judul di kiri, dark mode + logout button di kanan (flexbox)

### Spacing:
- Gap 20px antara logout button dan dark mode button
- Responsive: Buttons stack vertikal di mobile

### Color Scheme:
- **Logout Button**: Merah (#dc3545) di light mode, merah terang (#ff6b6b) di dark mode
- **Session Info**: Biru transparan di light mode, kuning transparan di dark mode

---

## 📱 Responsive Design

- **Desktop (>768px)**: Header horizontal, buttons side by side
- **Mobile (≤768px)**: Header vertical, buttons stacked
- Semua buttons full width di mobile untuk kemudahan akses

---

## 🔒 Fitur Keamanan

1. ✅ Session-based authentication
2. ✅ Login required untuk akses dashboard
3. ✅ XSS protection dengan `htmlspecialchars()`
4. ✅ Logout confirmation
5. ✅ Auto redirect jika belum login

---

## 📌 Catatan

- File `index.html` telah dihapus, gunakan `index.php` sebagai entry point
- Semua styling dipisahkan ke `style/style.css` (tidak ada inline style di PHP)
- Dark mode tetap berfungsi dengan JavaScript yang sudah ada
- API integration (handleAPI.js) tetap berfungsi seperti sebelumnya

---

**Dibuat pada**: 2 Oktober 2025  
**Status**: ✅ Selesai dan Tested
