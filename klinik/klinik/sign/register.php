<?php
// error_reporting(0);

// Atur koneksi ke database
include('../koneksi.php');

// Pengaturan variable
$err = "";
$success = "";
$username = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_verify = $_POST['password-verify'];

    if ($username && $password && $password_verify) {

        $sql1 = "SELECT * FROM $tabel_user WHERE username = '$username'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array($q1);

        $cek = mysqli_num_rows($q1);

        if ($password_verify != $password) {
            $err = "Password tidak sesuai!";
        } else {
            if ($cek == 0) {
                $password = md5($password);
                $sql1   = "insert into $tabel_user(username, password) values ('$username', '$password')";
                $q1 = mysqli_query($koneksi, $sql1);
                $success = "data berhasil dibuat!";
                header("location:login.php");
            } else {
                $err = "username sudah terdaftar!";
            }
        }
    } else {
        $err = "Masukkan kolom";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../style/register.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- my font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500&display=swap" rel="stylesheet" />

    <!-- My Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>

<body style="background-color: #343a40; width: 100%; height: 100vh; display: flex; justify-content: space-around; align-items: center;">

    <div class="border1"></div>
    <div class="back">
        <a href="login.php"><i class='bx bx-left-arrow-alt'></i></a>
    </div>
    <div class="side-text">
        <h1>Register Now!</h1>
    </div>
    <main>
        <div class="card" style="background-color: #323232; color: #edf0f1; border: none;">
            <div class="card-body">
                <h3 class="mb-4">Register</h3>
                <?php
                if ($err) { ?>

                    <div id="login-alert" class="alert alert-danger col-sm-12" role="alert">
                        <span><?php echo $err ?></span>
                    </div>

                <?php } ?>
                <?php
                if ($success) { ?>

                    <div id="login-alert" class="alert alert-success col-sm-12" role="alert">
                        <span><?php echo $success ?></span>
                    </div>

                <?php } ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="login-username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="login-password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (verify)</label>
                        <input type="password" class="form-control" id="login-password-verify" name="password-verify">
                    </div>
                    <button type="submit" class="btn btn-success mt-3" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>