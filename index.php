<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once 'function.php';

//pagination postgress
//konfigurasi
$jumlahDataPerHalaman = 2;

//hitung total semua data
$jumlahData = count(query("SELECT * FROM siswa"));

//pembulatan keatas untuk pembuatan jumlah halaman
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

//versi biasa
// if (isset($_GET["halaman"])) {
//     //menangkap halaman dari URL
//     $halamanAktif  = $_GET["halaman"];
// } else {
//     //jadikan halaman index halaman url 1
//     $halamanAktif = 1;
// }

//versi ternary
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;

//mencari awal data menggunakan pagination
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;


$siswa = query("SELECT * FROM siswa LIMIT $jumlahDataPerHalaman OFFSET $awalData");



//tombol cari ditekan 
if (isset($_POST["cari"])) {
    $siswa = cari($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>

<body>

    <a href="logout.php">Log Out</a>

    <a href="tambah.php">Tambah Data</a>

    <br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40px" autofocus placeholder="masukkan keyword pencarian" autocomplete="off">
        <button type="submit" name="cari">Cari!</button>
    </form>


    <br><br>


    <!-- Arrow Navigation previous -->
    <?php if ($halamanAktif > 1) : ?>

        <a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>

    <?php endif; ?>


    <!-- Navigasi Pagination -->
    <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>

        <?php if ($i == $halamanAktif) : ?>

            <a href="?halaman=<?= $i; ?>" style="font-weight:bold; color:red"><?= $i; ?></a>

        <?php else : ?>

            <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>

        <?php endif; ?>

    <?php endfor; ?>


    <!-- Arrow Navigation next -->
    <?php if ($halamanAktif < $jumlahHalaman) : ?>

        <a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>

    <?php endif; ?>



    <h1>
        <table border="1">
            <tr>
                <td>No</td>
                <td>Nama</td>
                <td>Alamat</td>
                <td>Gambar</td>
                <td>Action</td>
            </tr>

            <?php
            $i = 1;
            foreach ($siswa as $value) {
            ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $value['nama']; ?></td>
                    <td><?= $value['alamat']; ?></td>
                    <td><img src="img/<?= $value['gambar']; ?>" alt="" width="50"></td>
                    <td>
                        <a href="edit.php?id=<?= $value['id']; ?>">Edit</a>
                        <a href="hapus.php?id=<?= $value['id']; ?>" onclick="return confirm('yakin?');">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>

        </table>

    </h1>
</body>

</html>