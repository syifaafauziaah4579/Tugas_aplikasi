<?php
include "config.php";

$id = $_GET['id'];

$sql ="DELETE FROM Kegiatan WHERE id='$id'";

mysqli_query($conn, $sql);

header("Location: index.php");
exit;
?>