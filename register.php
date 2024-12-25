<?php
Session_start();
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Ambil data dari form
   $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $confirm_pass = $_POST['confirm_pass'];
   
   // Validasi password
   if ($password !== $confirm_password) {
       // Password tidak cocok
       header("Location: register.php?error=password_mismatch");
       exit();
   }
   
   try {
       // Cek apakah email sudah ada
       $stmt = $koneksi->prepare("SELECT user_id FROM users WHERE email = ?");
       $stmt->bind_param("s", $email);
       $stmt->execute();
       $result = $stmt->get_result();
       
       if ($result->num_rows > 0) {
           // emaile sudah ada
           header("Location: login copy.html");
           exit();
       }
       
       // Hash password
       $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
       
       // Insert user baru
       $stmt = $koneksi->prepare("INSERT INTO users (fullname, email, pass, created_at) VALUES (?, ?, ?, ?, NOW())");
       $stmt->bind_param("ssss", $fullname, $email, $hashed_pass);
       
       if ($stmt->execute()) {
           // Registrasi berhasil
           $_SESSION['register_success'] = true;
           header("Location: login copy.html?status=success");
           exit();
       } else {
           throw new Exception("Failed to register user");
       }
       
   } catch (Exception $e) {
       error_log($e->getMessage());
       header("Location: register.php");
       exit();
   }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Register - Mindful Journey</title>
   <link rel="stylesheet" href="css/register.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body class="login-page">
   <div class="login-container">
       <h1>REGISTER</h1>
       <form class="login-form" action="login.php" method="POST">
           <div class="form-group">
               <input type="text" id="fullname" name="fullname" placeholder="Masukkan nama lengkap" required />
           </div>
           <div class="form-group">
               <input type="text" id="username" name="username" placeholder="Masukkan email" required />
           </div>
           <div class="form-group">
               <input type="password" id="password" name="password" placeholder="Masukkan password" required />
           </div>
           <div class="form-group">
               <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password" required />
           </div>
           <div class="form-group checkbox">
               <input type="checkbox" id="remember" name="remember" required/>
               <label for="remember">Remember Me</label>
           </div>
           <button type="submit" class="login-btn">Register</button>
           <div class="register-link">
               <p>Sudah punya akun? <a href="login copy.php">Login disini</a></p>
           </div>
       </form>
   </div>
</body>
</html>