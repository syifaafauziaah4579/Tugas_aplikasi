
<?php
include "config.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $kegiatan = $_POST['kegiatan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    $foto = "";

    // Upload foto jika dipilih
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $folder = "uploads/";

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $tmp = $_FILES['foto']['tmp_name'];
        $namaAsli = basename($_FILES['foto']['name']);
        $ekstensi = strtolower(pathinfo($namaAsli, PATHINFO_EXTENSION));
        $formatDiizinkan = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($ekstensi, $formatDiizinkan, true)) {
            die("Format foto harus JPG, JPEG, PNG, GIF, atau WEBP.");
        }

        if (getimagesize($tmp) === false) {
            die("File yang dipilih bukan gambar yang valid.");
        }

        $namaFoto = bin2hex(random_bytes(8)) . "." . $ekstensi;
        $tujuan = $folder . $namaFoto;

        if (move_uploaded_file($tmp, $tujuan)) {
            $foto = $namaFoto;
        } else {
            die("Foto gagal diunggah.");
        }
    } elseif (
        isset($_FILES['foto']) &&
        $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE
    ) {
        die("Upload foto gagal. Periksa ukuran file.");
    }

    // Query SQL: simpan data ke tabel kegiatan
    $sql = "INSERT INTO kegiatan
            (nama, kelas, kegiatan, tanggal, deskripsi, foto)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Query gagal: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $nama,
        $kelas,
        $kegiatan,
        $tanggal,
        $deskripsi,
        $foto
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit;
    } else {
        die("Data gagal disimpan: " . mysqli_stmt_error($stmt));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kegiatan Adiwiyata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Form Kegiatan Adiwiyata</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Siswa</label><br>
        <input type="text" name="nama" required>
        <br><br>

        <label>Kelas</label><br>
        <input type="text" name="kelas" required>
        <br><br>

        <label>Kegiatan</label><br>
        <input type="text" name="kegiatan" required>
        <br><br>

        <label>Tanggal</label><br>
        <input type="date" name="tanggal" required>
        <br><br>

        <label>Deskripsi Kegiatan</label><br>
        <textarea name="deskripsi" rows="4"></textarea>
        <br><br>

        <label>Foto Kegiatan</label><br>
        <input type="file" name="foto"
               accept=".jpg,.jpeg,.png,.gif,.webp">
        <br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Kembali</a>

    </form>

</body>
</html>
