
<?php
include "config.php";

// Memeriksa apakah ID tersedia di URL
if (!isset($_GET['id'])) {
    die("ID kegiatan tidak ditemukan.");
}

$id = (int) $_GET['id'];

// Mengambil data kegiatan berdasarkan ID
$query = mysqli_query(
    $conn,
    "SELECT * FROM kegiatan WHERE id = $id"
);

if (!$query || mysqli_num_rows($query) == 0) {
    die("Data kegiatan tidak ditemukan.");
}

$data = mysqli_fetch_assoc($query);

// Proses update data
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $kegiatan = $_POST['kegiatan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    $sql = "UPDATE kegiatan SET
                nama = ?,
                kelas = ?,
                kegiatan = ?,
                tanggal = ?,
                deskripsi = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Query gagal: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssssi",
        $nama,
        $kelas,
        $kegiatan,
        $tanggal,
        $deskripsi,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit;
    } else {
        die("Data gagal diperbarui: " . mysqli_stmt_error($stmt));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan Adiwiyata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Edit Kegiatan Adiwiyata</h2>

    <form method="POST">

        <label>Nama Siswa</label><br>
        <input
            type="text"
            name="nama"
            value="<?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            required
        >
        <br><br>

        <label>Kelas</label><br>
        <input
            type="text"
            name="kelas"
            value="<?= htmlspecialchars($data['kelas'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            required
        >
        <br><br>

        <label>Kegiatan</label><br>
        <input
            type="text"
            name="kegiatan"
            value="<?= htmlspecialchars($data['kegiatan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            required
        >
        <br><br>

        <label>Tanggal</label><br>
        <input
            type="date"
            name="tanggal"
            value="<?= htmlspecialchars($data['tanggal'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            required
        >
        <br><br>

        <label>Deskripsi</label><br>
        <textarea name="deskripsi" rows="4"><?= htmlspecialchars($data['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        <br><br>

        <button type="submit" name="update">Simpan Perubahan</button>
        <a href="index.php">Kembali</a>

    </form>

</body>
</html>
