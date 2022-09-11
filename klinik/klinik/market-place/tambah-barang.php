<?php

// Menjalankan session
session_start();

// Cek koneksi
include('../koneksi.php');

// Atur var
$nama_barang = "";
$harga_barang = "";
$stock_barang = "";
$err = "";
$sukses = "";

// op akan digunakan untuk menangkap variable yang ada di dalam url 
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from $tabel_barang where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    // Jika data id tidak ditemukan / tidak ada.
    $nama_barang = $r1['nama_barang'];
    if ($nama_barang == '') {
        $err = 'Data Tidak Ditemukan!';
    } else {
        $harga_barang = $r1['harga_barang'];
        $stock_barang = $r1['stock_barang'];
    }
}

if (isset($_POST['submit'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga_barang = $_POST['harga_barang'];
    $stock_barang = $_POST['stock_barang'];

    if ($nama_barang and $harga_barang and $stock_barang) {
        $q = mysqli_query($koneksi, "SELECT * FROM $tabel_barang WHERE nama_barang='$nama_barang'");
        $cek = mysqli_num_rows($q);

        if ($op == 'edit') {
            // echo $cek;
            if ($q1) {
                $sql1   = "update $tabel_barang set nama_barang = '$nama_barang', harga_barang='$harga_barang', stock_barang='$stock_barang' where id = '$id'";
                $q1     = mysqli_query($koneksi, $sql1);
                $sukses = "Data berhasil di update!";
                header('refresh:2;url=main.php');
            } else {
                $err = "Data gagal di update!";
            }
        } else {
            if ($cek == 0) {
                // Memasukkan data kedalam database menggunakan sql
                $sql1   = "insert into $tabel_barang(nama_barang, harga_barang, stock_barang) values ('$nama_barang', '$harga_barang', '$stock_barang')";
                $q1 = mysqli_query($koneksi, $sql1);
                $sukses     = "Berhasil memasukkan data!";
            }

            // sebaliknya
            else {
                $error      = 'Gagal memasukkan data!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah barang</title>

    <!-- My CSS -->
    <link rel="stylesheet" href="../style/tambah-barang.css">

    <!-- Bootsrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- My Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- My Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <div class="back">
            <a href="main.php"><i class='bx bx-left-arrow-alt'></i></a>
        </div>
        <form class="main-form" action="" method="post">
            <?php
            // Melalukan pengecekan, jika variable error ada isinya maka akan memunculkan alert danger
            if ($err) {
            ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $err ?>
                </div>
            <?php
                // header("refresh:2;url=main.php");
            }
            ?>
            <?php
            // Jika variable sukses ada isinya maka akan memunculkan alert success. 
            if ($sukses) {
            ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
            <?php
                header("refresh:2;url=main.php");
            }
            ?>
            <h1 class="mb-4"><?php if ($op == "edit") {
                                    echo "Edit Barang";
                                } else {
                                    echo "Tambah Barang";
                                } ?></h1>
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang :</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $nama_barang ?>">
            </div>
            <div class="mb-3">
                <label for="harga_barang" class="form-label">Harga Barang :</label>
                <input type="number" class="form-control" id="harga_barang" name="harga_barang" value="<?php echo $harga_barang ?>">
            </div>
            <div class="mb-3">
                <label for="stock_barang" class="form-label">Stock Barang :</label>
                <input type="number" class="form-control" id="stock_barang" name="stock_barang" value="<?php echo $stock_barang ?>">
            </div>

            <button type="submit" class="btn btn-success" name="submit" id="submit">Submit</button>
        </form>
    </main>
</body>
<!-- <script src="../js/rupiah.js"></script> -->

</html>