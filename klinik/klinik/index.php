<?php

// Menghilangkan warning
error_reporting(0);
// Menggunakan fungsi session_start() agar bisa menggunakan session
session_start();

// Atur koneksi ke database

include('koneksi.php');

// var
$username = "";
$storage = "";


// Jika cookie_username ada isinya, maka akan masuk kedalam if statement.
if (isset($_COOKIE['cookie_username'])) {
    // mengambil data dari cookie username
    // mengisi var dengan value dari cookie username dan password
    $cookie_username = $_COOKIE['cookie_username'];
    $cookie_password = $_COOKIE['cookie_password'];

    $sql1 = "SELECT * FROM $tabel_user WHERE username = '$cookie_username'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    // Jika var r1 dibagian password berisi var dari cookie_password, maka akan masuk kedalam if statement.
    if ($r1['password'] == $cookie_password) {
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_password'] = $cookie_password;
    }
}

if (isset($_COOKIE['cookie_username'])) {
    $username = $_COOKIE['cookie_username'];
}

if ($_COOKIE['cookie_username'] and $_SESSION['session_username']) {
    $storage = $_COOKIE['cookie_username'];
} else if ($_SESSION['session_username']) {
    $storage = $_SESSION['session_username'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>main page</title>
    <!-- My CSS -->
    <link rel="stylesheet" href="style/style.css" />

    <!-- my font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500&display=swap" rel="stylesheet" />
</head>

<body>
    <nav>
        <div class="logo">
            <h1>logo</h1>
        </div>
        <div class="links">
            <ul>
                <li><a href="#" class="link">Home</a></li>
                <li><a href="market-place/main.php" class="link">Market Place</a></li>
                <li><a href="#" class="link">Contact</a></li>
            </ul>
        </div>
        <div class="login">
            <a href="sign/login.php" class="login">log-in</a>
            <?php if ($storage) { ?>
                <style>
                    a.login {
                        display: none;
                    }
                </style>
                <a href="sign/logout.php" class="logout">log-out</a>
            <?php } ?>
        </div>
    </nav>
    <main>

        <?php if ($storage) { ?>
            <h1 class="text ml-4" style="color: #ddd;">Welcome <?php echo $storage ?></h1>
            <br>
            <h3 class="saldo">saldo anda : Rp.<?php echo $_SESSION['session_saldo']; ?></h3>
        <?php } ?>
    </main>
</body>

</html>