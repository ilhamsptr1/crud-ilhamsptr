<?php
include 'database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);


$query_select = "SELECT nama FROM produk WHERE id = '$id'";
$result = mysqli_query($conn, $query_select);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php?pesan=Produk tidak ditemukan&tipe=danger");
    exit();
}

$produk = mysqli_fetch_assoc($result);
$nama_produk = $produk['nama'];
mysqli_free_result($result);


$query_delete = "DELETE FROM produk WHERE id = '$id'";

if (mysqli_query($conn, $query_delete)) {
    $pesan = "Produk '{$nama_produk}' berhasil dihapus";
    $tipe_pesan = "success";
} else {
    $pesan = "Error: " . mysqli_error($conn);
    $tipe_pesan = "danger";
}

header("Location: index.php?pesan=" . urlencode($pesan) . "&tipe=" . $tipe_pesan);
exit();
?>