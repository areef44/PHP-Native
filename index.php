<?php

require_once 'function.php';

$siswa = query("SELECT * FROM siswa ORDER BY id DESC");

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



    <a href="tambah.php">Tambah Data</a>

    <form action="" method="post">
        <input type="text" name="keyword" size="40px" autofocus placeholder="masukkan keyword pencarian" autocomplete="off">
        <button type="submit" name="cari">Cari!</button>
    </form>


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