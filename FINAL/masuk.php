<?php
require("config.php");

class UserAuthentication {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function loginUser($username_email, $password) {
        $query = mysqli_query($this->conn, "SELECT * FROM user WHERE username='$username_email' OR email='$username_email'");

        if (mysqli_num_rows($query) == 1) {
            $user_data = mysqli_fetch_assoc($query);

            if (password_verify($password, $user_data['password'])) {
                $this->startSession($user_data);
            } else {
                $this->redirectWithMessage('masuk.html', 'Incorrect password');
            }
        } else {
            $this->redirectWithMessage('masuk.html', 'Invalid username or email');
        }
    }

    private function startSession($user_data) {
        session_start();
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['role'] = $user_data['role'];

        $this->redirectToRoleSpecificPage($user_data['role']);
    }

    private function redirectToRoleSpecificPage($role) {
        $basePath = '';
        if ($role == 'admin') {
            $basePath = 'admin/home.php';
        } elseif ($role == 'petugas') {
            $basePath = 'petugas/home.php';
        } else {
            $basePath = 'peminjam/home.php';
        }

        header("Location: $basePath");
        exit();
    }

    private function redirectWithMessage($url, $message) {
        echo "<script>alert('$message'); window.location.href='$url';</script>";
        exit();
    }
}

// Usage
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];

    $userAuth = new UserAuthentication($conn);
    $userAuth->loginUser($username_email, $password);
}
?>
