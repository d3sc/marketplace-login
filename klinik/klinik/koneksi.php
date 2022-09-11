<?php

$host_db = "localhost";
$user_db = "root";
$pass_db = "";
$nama_db = "klinik";
$koneksi = mysqli_connect($host_db, $user_db, $pass_db, $nama_db);

if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}

$tabel_user = "user";
$tabel_barang = "barang";
