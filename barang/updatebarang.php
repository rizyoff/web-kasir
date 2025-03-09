<?php

// Include koneksi database
include_once("../config/config.php");

// Get data dari form
$id          = $_POST['id'];
$barcode     = $_POST['Barcode'];
$nama_barang = $_POST['nm_barang'];
$keterangan  = $_POST['keterangan'];
$stok        = $_POST['stock'];
$harga_beli  = $_POST['harga_beli'];
$harga_jual  = $_POST['harga_jual'];

// Prepare statement untuk menghindari SQL injection
$query = "UPDATE db_kasirbarang SET 
            Barcode = ?, 
            nm_barang = ?, 
            keterangan = ?, 
            stock = ?, 
            harga_beli = ?, 
            harga_jual = ? 
          WHERE id = ?";

// Prepare statement
$stmt = $mysqli->prepare($query);

if ($stmt === false) {
    die('Prepare failed: ' . $mysqli->error);
}

// Bind parameters
$stmt->bind_param('sssiiii', $barcode, $nama_barang, $keterangan, $stok, $harga_beli, $harga_jual, $id);

// Execute statement
if ($stmt->execute()) {
    // Redirect ke halaman index.php
    header("Location: index.php");
} else {
    // Pesan error gagal update data
    echo "Data Gagal Diupdate: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$mysqli->close();

?>
