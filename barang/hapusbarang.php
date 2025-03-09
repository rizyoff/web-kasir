<?php

include_once("../config/config.php");

// Pastikan $connection sudah didefinisikan dan digunakan
if (!isset($connection)) {
    die("Koneksi ke database gagal!");
}

// Ambil ID dari URL
$id = $_GET['id'];

// Mulai transaksi
$connection->begin_transaction();

try {
    // // Hapus data dari tabel detail_transaksi
    // $deleteDetails = "DELETE FROM detail_transaksi WHERE id_barang = '$id'";
    // $connection->query($deleteDetails);

    // Hapus data dari tabel db_kasirbarang
    $deleteBarang = "DELETE FROM db_kasirbarang WHERE id = '$id'";
    $connection->query($deleteBarang);

    // Commit transaksi
    $connection->commit();

    header("Location: index.php");
} catch (mysqli_sql_exception $e) {
    // Rollback jika ada kesalahan
    $connection->rollback();
    echo "DATA GAGAL DIHAPUS: " . $e->getMessage();
}


