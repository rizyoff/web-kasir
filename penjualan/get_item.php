<?php
include_once("../config/config.php");

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    // Mencegah SQL Injection
    $barcode = mysqli_real_escape_string($mysqli, $barcode);

    // Query untuk mengambil data barang berdasarkan barcode
    $query = "SELECT * FROM barang WHERE barcode = '$barcode'";
    $result = mysqli_query($mysqli, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Kembalikan data barang dalam format JSON
        echo json_encode([
            'success' => true,
            'nama' => $data['nama'],
            'harga' => $data['harga_jual']
        ]);
    } else {
        // Barang tidak ditemukan
        echo json_encode([
            'success' => false,
        ]);
    }
} else {
    // Tidak ada barcode yang dikirim
    echo json_encode([
        'success' => false
    ]);
}