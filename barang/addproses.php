<?php
  include_once("../config/config.php");
	// Check If form submitted, insert form data into users table.
		$barcode    = $_POST['Barcode'];
		$nm_barang  = $_POST['nm_barang'];
		$keterangan = $_POST['keterangan'];
    $stok       = $_POST['stock'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
		
				
		// Insert user data into table
		$result = mysqli_query($mysqli, "INSERT INTO db_kasirbarang(
    Barcode,   
    nm_barang, 
    keterangan,
    stock,      
    harga_beli,
    harga_jual) VALUES(
    '$barcode',   
    '$nm_barang',
    '$keterangan',
    '$stok',      
    '$harga_beli',
    '$harga_jual')");
		
        if ($result) {
            $_SESSION['info'] = [
              'status' => 'success',
              'message' => 'Berhasil menambah data'
            ];
            header('Location: ./index.php');
        } else {
            $_SESSION['info'] = [
              'status' => 'failed',
              'message' => mysqli_error($connection)
            ];
            header('Location: ./addbarang.php');
        }

	?>