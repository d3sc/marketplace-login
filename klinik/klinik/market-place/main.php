<?php

error_reporting(0);

session_start();

include('../koneksi.php');

// op akan digunakan untuk menangkap variable yang ada di dalam url 
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == "delete") {
    $id = $_GET['id'];
    $sql1 = "delete from $tabel_barang where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = 'gagal melakukan hapus data';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Place</title>

    <!-- My CSS -->
    <link rel="stylesheet" href="../style/market-place.css">

    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- My Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- My Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500&display=swap" rel="stylesheet">

</head>

<body>
    <main>
        <div class="back">
            <a href="../index.php"><i class='bx bx-left-arrow-alt'></i></a>
        </div>
        <div class="container">
            <h1 class="mb-4">Market Place</h1>
            <div class="card-body">
                <table class="table" border="1" style="border-color: #D2D2D2;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Harga Barang</th>
                            <th scope="col">Stock Barang</th>
                        </tr>
                    <tbody>
                        <?php
                        //* Proses Read Data

                        $sql2   = "select * from $tabel_barang order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urutan = 1;

                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $nama_barang = $r2['nama_barang'];
                            $harga_barang = $r2['harga_barang'];
                            $stock_barang = $r2['stock_barang'];
                        ?>
                            <tr>

                                <th scope="row"><?php echo $urutan++ ?></th>
                                <td scope="row"><?php echo $nama_barang ?></td>
                                <td scope="row">Rp. <?php echo $harga_barang ?></td>
                                <td scope="row"><?php echo $stock_barang ?></td>

                                <?php if ($_SESSION['session_username'] == "admin") { ?>
                                    <td scope="row">
                                        <a href="tambah-barang.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning btn-sm">Edit</button></a>
                                        <a href="main.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('anda yakin?');"><button type="button" class="btn btn-danger btn-sm">Delete</button></a>
                                        <a href="detail.php?op=detail&id=<?php echo $id ?>"><button type="button" class="btn btn-primary btn-sm">Detail</button></a>
                                    </td>
                            </tr>
                        <?php } else { ?>

                            <td scope="row">
                                <a href="detail.php?op=detail&id=<?php echo $id ?>"><button type="button" class="btn btn-primary btn-sm">Detail</button></a>
                            </td>

                    <?php }
                            } ?>
                    </tbody>
                    </thead>
                </table>
                <?php if ($_SESSION['session_username'] == "admin") { ?>
                    <div class="tambah" style="text-align: end;">

                        <a href="tambah-barang.php" style="text-decoration: none; color: #fff;"><button type="button" class="btn btn-success">tambah</button></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
</body>

</html>