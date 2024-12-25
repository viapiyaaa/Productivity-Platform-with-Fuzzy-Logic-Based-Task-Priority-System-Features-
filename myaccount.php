<?php
session_start();
include 'koneksi.php';

// Pastikan pengguna sudah login
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['user_id'];

try {
    // Ambil data pengguna dari database
    $sql = "SELECT fullname, email, phone FROM users WHERE user_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($fullname, $email, $phone);
    $stmt->fetch();
    $stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mindful Journey - Account</title>
    <link rel="stylesheet" href="css/myaccount.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <div class="logo">Mindful Journey</div>

        <div class="section">
          <div class="section-title">ACCOUNT</div>
          <a href="myaccount.html" class="menu-item">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="currentColor" />
            </svg>
            <span>My Account</span>
          </a>
          <a href="kalender.html" class="menu-item">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M19 4H18V2H16V4H8V2H6V4H5C3.89 4 3.01 4.9 3.01 6L3 20C3 21.1 3.89 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4ZM19 20H5V9H19V20Z" fill="currentColor" />
            </svg>
            <span>Calendar</span>
          </a>
          <a href="notifikasi.html" class="menu-item">
            <svg viewBox="0 0 24 24" fill="none">
              <path
                d="M12 22C13.1 22 14 21.1 14 20H10C10 21.1 10.9 22 12 22ZM18 16V11C18 7.93 16.37 5.36 13.5 4.68V4C13.5 3.17 12.83 2.5 12 2.5C11.17 2.5 10.5 3.17 10.5 4V4.68C7.64 5.36 6 7.92 6 11V16L4 18V19H20V18L18 16Z"
                fill="currentColor"
              />
            </svg>
            <span>Notifications</span>
          </a>
        </div>

        <div class="section">
          <div class="section-title">MINDFUL TASK</div>
          <a href="todo.html" class="menu-item">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z" fill="currentColor" />
            </svg>
            <span>To Do</span>
          </a>
          <a href="dailyhabits.html" class="menu-item">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M3 13H5V11H3V13ZM3 17H5V15H3V17ZM3 9H5V7H3V9ZM7 13H21V11H7V13ZM7 17H21V15H7V17ZM7 7V9H21V7H7Z" fill="currentColor" />
            </svg>
            <span>Daily Habits</span>
          </a>
          <a href="diary.html" class="menu-item">
            <svg viewBox="0 0 24 24" fill="none">
              <path
                d="M16 11C17.66 11 18.99 9.66 18.99 8C18.99 6.34 17.66 5 16 5C14.34 5 13 6.34 13 8C13 9.66 14.34 11 16 11ZM8 11C9.66 11 10.99 9.66 10.99 8C10.99 6.34 9.66 5 8 5C6.34 5 5 6.34 5 8C5 9.66 6.34 11 8 11ZM8 13C5.67 13 1 14.17 1 16.5V19H15V16.5C15 14.17 10.33 13 8 13ZM16 13C15.71 13 15.38 13.02 15.03 13.05C16.19 13.89 17 15.02 17 16.5V19H23V16.5C23 14.17 18.33 13 16 13Z"
                fill="currentColor"
              />
            </svg>
            <span>Diary</span>
          </a>
        </div>

        <div class="section">
          <div class="section-title">BILLINGS</div>
          <a href="billing.html" class="menu-item">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M20 4H4C2.89 4 2.01 4.89 2.01 6L2 18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V12H20V18ZM20 8H4V6H20V8Z" fill="currentColor" />
            </svg>
            <span>Billing & Invoices</span>
          </a>
          <a href="upgrade.html" class="menu-item">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1ZM12 11.99H19C18.47 16.11 15.72 19.78 12 20.93V12H5V6.3L12 3.19V11.99Z" fill="currentColor" />
            </svg>
            <span>Upgrade</span>
          </a>
        </div>
      </div>

      <div class="main-content">
        <div class="account-container">
            <h1 class="page-title">My Account</h1>
            <div class="profile-section">
                <div class="profile-header">
                    <div class="profile-avatar">MJ</div>
                    <div class="profile-info">
                        <h2>Welcome back, <?php echo htmlspecialchars($fullname); ?>!</h2>
                        <p>Manage your account settings and preferences</p>
                    </div>
                </div>

                <form>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" value="<?php echo htmlspecialchars($fullname); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="<?php echo htmlspecialchars($email); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" value="<?php echo htmlspecialchars($phone); ?>" />
                    </div>
                    <button type="submit" class="save-button">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
    </div>
  </body>
</html>



