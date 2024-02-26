<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/active.css">
    <link rel="stylesheet" type="text/css" href="css/buat-akun-pengurus.css">



    <title>Buat Akun Petugas</title>
    <style>
        body {
            background-image: url(gambar/gambar.png);
            background-repeat: no-repeat;

        }

        .submit:hover {
            color: white;
            width: 32%;
            margin-left: 34%;

        }


        .bagian-kanan {
            width: 50%;
            background-color: #D9D9D9;
            height: 500px;
            margin-left: 60px;
        }

        .form-container {
            margin-top: 100px;
         

        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            font-size: 14px;
            margin-left: 20px;
            border-radius: 20px;
        }

        .logo-container img {
            height: 110px;
            width: 125px;
            padding: 0px;
            margin-left: 130px;
            margin-bottom: 40px;
            margin-top: 0px;
        }

        .logo-container {
            display: flex;


        }

        .logo-container h1 {
            font-size: 35px;
            margin-left: 0px;
            margin-top: 40px;
            font-family: 'Aclonica', sans-serif;
        }

        input[type="submit"] {
            padding: 7px;
            background-color: rgb(101, 72, 107);
            color: #fff;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            vertical-align: center;
            width: 280px;
            height: 45;
            margin-left: 150px;
            font-size: 20px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: black;
            width: 280px;
            height: 45px;
            padding: 10px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            vertical-align: center;
            margin-left: 150px;
            font-size: 25px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin-top: 10px;

        }
    </style>
</head>

<body style="background-color:#dfceed;">

    <nav class="navbar-atas">
        <div class="logo">
            <img src="gambar/logo.png ">
            <p>Asri Library</p>
        </div>
    </nav>
    <nav class="navbar-bawah">
        <button class="home" style="background-color:rgb(126, 80, 136); margin-top: 10px;">
            <a href="home.php" class="btn" style="font-size: 30px;  ">
                <img src="gambar/kembali.png" style="width: 70px;">
            </a>
        </button>
    </nav>


    <div class="container">
        <div class="bagian-kiri">
            <div class="text-kiri">
            </div>
        </div>


        <div class="bagian-kanan" style="background-color: #dfceed;">

            <div class="logo-container">
                <img src="gambar/logo.png">
                <h1>Daftar</h1>
            </div>


            <form method="post" action="backend/daftarkan-pengurus.php">

                <input type="text" name="nama-lengkap" placeholder="Nama Lengkap" required>

                <input type="text" name="alamat" placeholder="Alamat" required>

                <input type="text" name="nama-pengguna" placeholder="Nama Pengguna" required>

                <input type="text" name="email" placeholder="Email" required>

                <input type="password" name="kata-sandi" placeholder="Kata Sandi" required>

                <input type="submit" class="submit" value="Daftar">


            </form>
        </div>

    </div>
</body>

</html>