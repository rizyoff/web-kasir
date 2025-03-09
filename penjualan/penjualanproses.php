<?php
include_once("../config/config.php");

$date =date('Y-m-d');
$nama = $_POST['namaPembeli'];
$kd_Transaksi = $_POST['kdTransaksi'];

//insert data into table
$result = mysqli_query($mysqli, "INSERT INTO penjualan(tgl_transaksi, nm_pembeli, total_belanja, total_bayar) VALUES('$date','$nama','$kd_transaksi',0,0)");
$kode = mysqli_query($mysqli, "SELECT kd_transaksi from Penjualan ORDER BY kd_transaksi DESC LIMIT 1");
        $kode_result = mysqli_fetch_array($kode);

        if ($result) {
            $kd_transaksi = $kode_result['kd_transaksi'];
            $_SESSION['info'] = [
              'status' => 'success',
              'message' => 'Berhasil delete data'
            ];
            header('Location: ./index.php?kd='.$kd_transaksi.'&jml=0');
        } else {
            $_SESSION['info'] = [
              'status' => 'failed',
              'message' => mysqli_error($connection)
            ];
            header('Location: ./namapembeli.php');
        }