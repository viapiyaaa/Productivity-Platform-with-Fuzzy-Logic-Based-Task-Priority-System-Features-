<?php
include "koneksi.php"; // Hubungkan dengan file koneksi database

session_start();

// Cek jika formulir dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $pass = $_POST['pass'];

    // Cek apakah email dan password cocok
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if ($result) { // Pastikan query berhasil
        if (mysqli_num_rows($result) > 0) {
            $users = mysqli_fetch_assoc($result); // Ubah dari $users ke $user

            // Verifikasi password
            if (password_verify($pass, $users['pass'])) { // Pastikan kolom 'password' sesuai dengan database
                // Simpan sesi pengguna
                $_SESSION['id_user'] = $users['id'];
                $_SESSION['user_email'] = $users['email'];

                // Redirect ke halaman lain (misalnya dashboard)
                header("Location: todo.php");
                exit;
            } else {
                echo "Password salah!";
            }
        } else {
            // echo "Email tidak ditemukan!"; // Aktifkan pesan kesalahan
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Jangan lupa untuk menutup koneksi jika sudah tidak dipakai
mysqli_close($koneksi);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Mindful Journey</title>
    <link rel="stylesheet" href="css/logincopy.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  </head>
  <body class="login-page">
    <div class="login-container">
      <h1>LOGIN</h1>
      <form class="login-form" action="todo.php" method="GET">
        <div class="form-group">
          <input type="text" id="email" name="email" placeholder="Masukkan email" required />
        </div>
        <div class="form-group">
          <input type="password" id="pass" name="pass" placeholder="Masukkan password" required />
        </div>
        <div class="form-group checkbox">
          <input type="checkbox" id="remember" name="remember" />
          <label for="remember">Remember Me</label>
        </div>
        <button type="submit" class="login-btn">Login</button>
        <div class="register-link">
          <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
        </div>
      </form>
    </div>
  </body>
</html>
