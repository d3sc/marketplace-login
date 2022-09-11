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

if ($op == 'detail') {
    $id = $_GET['id'];
    $sql1 = "select * from $tabel_barang where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    // Jika data id tidak ditemukan / tidak ada maka akan masuk kedalam if.
    $nama_barang = $r1['nama_barang'];
    if ($nama_barang == '') {
        $err = 'Data Tidak Ditemukan!';
    } else {
        $harga_barang = $r1['harga_barang'];
        $stock_barang = $r1['stock_barang'];
    }
}

?>
<?php if ($op == 'beli') {
    $id = $_GET['id'];
    $sql1 = "select * from $tabel_barang where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    $nama_barang = $r1['nama_barang'];
    $harga_barang = $r1['harga_barang'];
    $stock_barang = $r1['stock_barang'];

    if ($_SESSION['session_username']) { ?>
        <?php
        if ($_COOKIE['jumlah_barang'] <= $stock_barang) {
            unset($_SESSION['jumlah_barang']);
            $_SESSION['jumlah_barang'] = $_COOKIE['jumlah_barang'];

            $cookie_name = "jumlah_barang";
            $cookie_value = "";
            $cookie_time = time() + (60 * 60);
            setcookie($cookie_name, $cookie_value, $cookie_time, "/");

            if ($_SESSION['jumlah_barang'] <= 0) { ?>

                <script>
                    alert("pembelian tidak bisa kurang dari 0!");
                </script>

                <?php
            } else {
                $total_harga = $harga_barang * $_SESSION['jumlah_barang'];
                if ($_SESSION['session_saldo'] < $total_harga) {
                ?>
                    <script>
                        alert('saldo tidak cukup!')
                    </script>
                <?php
                } else {

                    $_SESSION['session_saldo'] -= $total_harga;

                    $stock_barang -= $_SESSION['jumlah_barang'];
                    $saldo_sekarang = $_SESSION['session_saldo'];

                    $id_user = $_SESSION['session_id_user'];
                ?>
                    <script>
                        alert('Barang Sudah Dibeli!');
                    </script>
            <?php
                    $sql1   = "update $tabel_user set saldo='$saldo_sekarang' where id = '$id_user'";
                    $q1     = mysqli_query($koneksi, $sql1);
                    $sql1   = "update $tabel_barang set stock_barang='$stock_barang' where id = '$id'";
                    $q1     = mysqli_query($koneksi, $sql1);
                    // header('refresh:1;url=main.php');
                }
            }
        } else { ?>
            <script>
                alert('melebihi batas stock!')
            </script>
        <?php
        }
    } else { ?>
        <script>
            alert('daftar dlu tong!');
        </script>
<?php
        header('refresh:1;url=../sign/login.php');
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail</title>

    <!-- My CSS -->
    <link rel="stylesheet" href="../style/detail.css">

    <!-- Bootstrap 5 -->
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
            <div class="profile">
                <h5>saldo : Rp.<?php echo $_SESSION['session_saldo']; ?></h5>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-body" style="width: 100%;">
                <h5 class="card-title"><?php echo $nama_barang ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">harga : <?php echo $harga_barang ?></h6>
                <h6 class="card-subtitle mb-2 text-muted">stock : <?php echo $stock_barang ?></h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <form class="beli" method="post" action="">
                    <a href="detail.php?op=beli&id=<?php echo $id ?>" class="card-link" onclick="return confirm('anda yakin?');" id="link-btn"><button type="button" class="btn btn-success" name="submit" id="kirim">Beli</button></a>
                    <input type="number" name="jumlah" require id="jumlah">
                </form>
                <!-- <a href="#" class="card-link">Beli</a> -->
            </div>
        </div>
    </main>
</body>
<script>
    const btn = document.getElementById('kirim');

    btn.addEventListener('click', () => {
        const inputVal = document.getElementById('jumlah').value;
        let cookieName = "jumlah_barang";
        let waktu = new Date();
        waktu.setTime(waktu.getTime() + (1 * 24 * 60 * 60 * 1000));
        let expires = "expires=" + waktu.toUTCString();
        document.cookie = cookieName + "=" + inputVal + ";" + expires + ";path=/"
    })
</script>

<?php
if ($stock_barang <= 0) { ?>

    <script defer>
        const input = document.getElementById('jumlah');
        // const btn = document.getElementById('kirim');
        const link_btn = document.getElementById('link-btn');

        input.hidden = true;
        btn.hidden = true;
        link_btn.hidden = true;
    </script>

<?php
}
?>

</html>