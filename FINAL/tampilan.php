<?php
$conn = mysqli_connect('localhost', 'root', '', 'asri_library');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'petugas') {
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
    <link rel="stylesheet" type="text/css" href="admin/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="admin/css/active.css">
    <link rel="stylesheet" type="text/css" href="tampilan.css">



    <title>Buat Akun Petugas</title>
    <style>
        body {
            background-image: url(admin/gambar/gambar.png);
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


        .logo-container img {
            width: 400px;
            height: auto;
            margin-top: 140px;
 
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

 


    <div class="container">
        <div class="bagian-kiri">
            <div class="text-kiri">
            </div>
        </div>


        <div class="bagian-kanan" style="background-color: #dfceed;">

            <button class="logo-container" style="background-color: #dfceed; border: none;">
                <a href="index.php" class="btn" style="font-size: 30px;  ">
                    <img src="admin/gambar/logo.png">
                </a>
            </button>



        </div>

    </div>
</body>

</html>