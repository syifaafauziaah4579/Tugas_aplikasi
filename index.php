<?php
include "config.php";

$sql = "SELECT * FROM kegiatan ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Kegiatan</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Data kegiatan Adiwiyata</h2>

    <a href="menambah.php">+Tambah kegiatan</a>
    <br><br>

    <table border="1" cellpandding="10">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Kegiatan</th>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>

    <?php
    $no = 1;
    
    while($row = mysqli_fetch_assoc($result)) {
    ?>

    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['kelas']; ?></td>
        <td><?= $row['kegiatan']; ?></td>
        <td><?= $row['tanggal']; ?></td>
        <td><?= $row['deskripsi']; ?></td>

        <td>
            <?php if (!empty($row['foto'])) { ?>

            <img src="uploads/<?= rawurlencode(basename($row['foto'])); ?>"
                 alt="Foto Kegiatan"
                 width="120">
            <?php } else { ?>

            Tidak ada foto

            <?php } ?>
        </td>
        <td>

        <a href="edit.php?id=<?= $row['id']; ?>">
            Edit
        </a>

        <a href="hapus.php?id=<?= $row['id']; ?>"
        onclick="return confirm('Yakin ingin menghapus data?')">
        Hapus
        </a>
        </td>
    </tr>
    <?php
    }
    ?>
    </table>
</body>
</html>