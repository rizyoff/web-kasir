<?php
include "../config/config.php";

if (isset($_POST['add_transaksi'])) {
    $nama_pembeli = $_POST['nama_pembeli'];


    $result = $mysqli->query("SELECT kd_transaksi FROM penjualan ORDER BY kd_transaksi DESC LIMIT 1");
    $res = $result->fetch_assoc();


    if ($res) {
        $kd_before = $res['kd_transaksi'];
        $kd_num_bef = (int) substr($kd_before, 3);
    } else {
        $kd_num_bef = 0;
    }

    $kd_num = $kd_num_bef + 1;

    $kd_transaksi = "TRN" . str_pad($kd_num, 4, "0", STR_PAD_LEFT);

    $query = $mysqli->query("INSERT INTO penjualan (kd_transaksi,nm_pembeli) VALUES ('$kd_transaksi', '$nama_pembeli') ");

    if ($query) {
        header("location:index.php?kd=$kd_transaksi&nama=$nama_pembeli");
    }
}


if (isset($_POST['save_trn'])) {
    // Ambil kode transaksi dari form input
    $kd = $_POST['kd'];
    $uang_bayar = $_POST['uang_bayar'];
    $uang_kembali = $_POST['kembalian'];

    // Dapatkan tanggal transaksi saat ini
    $now = new DateTime();
    $tgl_transaksi = $now->format('Y-m-d H:i:s');    // Format sesuai MySQL (Y-m-d)

    // Ambil detail transaksi berdasarkan kode penjualan
    $query_get_detail = $mysqli->query("SELECT * FROM detail_transaksi JOIN db_kasirbarang ON detail_transaksi.id_barang = db_kasirbarang.id WHERE kd_penjualan = '$kd'");
    
    // Fetch data hasil query
    $details = $query_get_detail->fetch_all(MYSQLI_ASSOC);

    // Inisialisasi variabel untuk menghitung total belanja dan total bayar
    $total_belanja = 0;
    $total_bayar = 0;

    // Looping untuk menghitung total belanja, total bayar, dan update stok barang
    foreach ($details as $detail) {
        $total_belanja += $detail['jmlh'];  // Menjumlahkan jumlah barang
        $total_bayar += $detail['jmlh'] * $detail['harga_jual']; // Menghitung total bayar dengan mengalikan jumlah dan harga

        // Ambil stok barang yang ada
        $stok_sekarang = $detail['stock'];  // Asumsikan kolom 'stok' ada di tabel db_kasirbarang

        // Hitung stok baru setelah dikurangi jumlah yang terjual
        $stok_baru = $stok_sekarang - $detail['jmlh'];

        // Update stok barang di tabel db_kasirbarang
        $id_barang = $detail['id_barang'];
        $query_update_stok = $mysqli->query("UPDATE db_kasirbarang SET stock = '$stok_baru' WHERE id = '$id_barang'");

        // Cek apakah update stok berhasil
        if (!$query_update_stok) {
            echo "Terjadi kesalahan saat mengupdate stok barang: " . $mysqli->error;
            exit; // Keluar jika gagal mengupdate stok
        }
    }

    $query_get_nama = $mysqli->query("SELECT nm_pembeli FROM penjualan WHERE kd_transaksi = '$kd'");
    $row = $query_get_nama->fetch_assoc();
    $nama = $row['nm_pembeli'];

    // Update tabel penjualan dengan data yang dihitung
    $query_put_trn = $mysqli->query("UPDATE penjualan SET tgl_transaksi = '$tgl_transaksi', total_belanja='$total_bayar', uang_bayar='$uang_bayar' WHERE kd_transaksi='$kd'");

    $query = $mysqli->query("UPDATE penjualan SET uang_bayar = '$uang_bayar', kembalian = '$uang_kembali' WHERE kd_transaksi = '$kd'");

    if ($query) {
        echo "Transaksi berhasil disimpan!";
    } else {
        echo "Error: " . $mysqli->error;
    }
        
    
    // Cek apakah query berhasil dijalankan
    if ($query_put_trn) {
        
        echo "Transaksi berhasil disimpan!";
        // Jika berhasil, arahkan ke halaman data penjualan
        header("Location: detail.php?kd=$kd&nama=$nama");
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Terjadi kesalahan saat menyimpan data transaksi: " . $mysqli->error;
    }
}

if (isset($_POST['print'])) {

}




// Memeriksa apakah formulir dikirimkan
if (isset($_POST['delete_det'])) {
    // Mendapatkan nilai ID dan KD dari form
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $kd = isset($_POST['kd']) ? $_POST['kd'] : null;
    $kdk = $_POST['kd'];
    $nama = $_POST['nama'];

    // Memastikan bahwa $id dan $kd tidak kosong
    if ($id && $kd) {
        // Menggunakan prepared statement untuk menghindari SQL injection
        $stmt = $mysqli->prepare("DELETE FROM detail_transaksi WHERE id = ?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // Jika penghapusan berhasil, arahkan kembali ke halaman sebelumnya
            header("Location: index.php?kd=$kdk&nama=$nama" . urlencode($kd));
            exit();
        } else {
            // Jika terjadi error saat eksekusi query
            echo "Error: " . $mysqli->error;
        }
    } else {
        echo "ID atau KD tidak valid.";
    }
}
if (isset($_POST['delete_det_data'])) {
    // Mendapatkan nilai ID dan KD dari form
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $kd = isset($_POST['kd']) ? $_POST['kd'] : null;
    $nama = $_POST['nama'];


    // Memastikan bahwa $id dan $kd tidak kosong
    if ($id && $kd) {
        // Menggunakan prepared statement untuk menghindari SQL injection
        $stmt = $mysqli->prepare("DELETE FROM detail_transaksi WHERE id = ?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // Jika penghapusan berhasil, arahkan kembali ke halaman sebelumnya
            header("Location: detailpenjualan.php?kd=" . urlencode($kd) . "&nama=$nama");
            exit();
        } else {
            // Jika terjadi error saat eksekusi query
            echo "Error: " . $mysqli->error;
        }
    } else {
        echo "ID atau KD tidak valid.";
    }
}
if (isset($_POST['delete_det'])) {
    // Mendapatkan nilai ID dan KD dari form
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $kd = isset($_POST['kd']) ? $_POST['kd'] : null;
    $nama = $_POST['nama'];


    // Memastikan bahwa $id dan $kd tidak kosong
    if ($id && $kd) {
        // Menggunakan prepared statement untuk menghindari SQL injection
        $stmt = $mysqli->prepare("DELETE FROM detail_transaksi WHERE id = ?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // Jika penghapusan berhasil, arahkan kembali ke halaman sebelumnya
            header("Location: index.php?kd=$kd&nama=$nama" . urlencode($kd) . "&nama=$nama");
            exit();
        } else {
            // Jika terjadi error saat eksekusi query
            echo "Error: " . $mysqli->error;
        }
    } else {
        echo "ID atau KD tidak valid.";
    }
}

if (isset($_POST['delete_trn'])) {
    // Mendapatkan nilai ID dan KD dari form
    $kd = $_POST['kd'];

    // Memastikan bahwa $id dan $kd tidak kosong
    if ($kd) {
        $query_det = $mysqli->query("DELETE FROM detail_transaksi WHERE kd_penjualan = '$kd'");
        $query = $mysqli->query("DELETE FROM penjualan WHERE kd_transaksi = '$kd'");
        header("location: datapenjualan.php");
    } else {
        echo "ID atau KD tidak valid.";
    }
}

if (isset($_POST['detail_trn'])) {
    // Mendapatkan nilai ID dan KD dari form
    $kd = $_POST['kd'];
    $nama = $_POST['nama'];

    // Memastikan bahwa $id dan $kd tidak kosong
    if ($kd) {
        header("location: detail.php?kd=$kd&nama=$nama");
    } else {
        echo "KD tidak valid.";
    }
}


if (isset($_POST['edit_jumlah'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jmlh'];

    // Query untuk mengupdate jumlah barang berdasarkan id_barang
    $query = $mysqli->query("UPDATE detail_transaksi SET jmlh='$jumlah' WHERE id_barang='$id_barang'");

    // Redirect kembali ke halaman transaksi setelah update berhasil
    if ($query) {
        // Mengambil parameter tambahan dari URL, jika tersedia
        $kd_transaksi = $_GET['kd'];
        $nama = isset($_GET['nama']) ? $_GET['nama'] : ''; // Cek jika 'nama' ada di URL

        // Menyiapkan URL untuk redirect
        $redirect_url = "index.php?kd=" . urlencode($kd_transaksi) . "&nama=" . urlencode($nama);
        header("Location: $redirect_url");
        exit();
    } else {
        echo "Gagal memperbarui jumlah.";
    }
}
