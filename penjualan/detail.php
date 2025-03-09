<?php
include '../config/config.php';

$kd_transaksi = $_GET['kd'];

if (isset($_POST['add_detail'])) {
    // var_dump($_POST);

    $barcode = $_POST['barcode'];
    $query_brg = $mysqli->query("SELECT * FROM db_kasirbarang WHERE Barcode = '$barcode'");
    $barang = $query_brg->fetch_assoc();
    $barang_id = $barang["id"] ?? null;

    // Cek apakah barang sudah ada di detail_transaksi
    $query_detail = $mysqli->query("SELECT * FROM detail_transaksi WHERE id_barang = '$barang_id' AND kd_penjualan = '$kd_transaksi'");

    if ($query_detail && $query_detail->num_rows > 0) {
        // Jika ada barang dengan id dan kd_transaksi yang sama, update jumlah
        $cur_detail = $query_detail->fetch_assoc();
        $jumlah_added = $cur_detail['jmlh'] + 1;

        // Update jumlah di detail_transaksi
        $query = $mysqli->query("UPDATE detail_transaksi SET jmlh = '$jumlah_added' WHERE id_barang = '$barang_id' AND kd_penjualan = '$kd_transaksi'");

        if (!$query) {
            echo "Error: " . $mysqli->error;
        }
    } else {
        // Jika tidak ada, insert data baru
        if ($barang_id) {
            $query = $mysqli->query("INSERT INTO detail_transaksi (id_barang, kd_penjualan, jmlh) VALUES ('$barang_id', '$kd_transaksi', '1')");
        }

        // if (!$query) {
        //     echo "Error: " . $mysqli->error;
        // }
    }
}


?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SMK Tunas Harapan Pati | Penjualan</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../asset/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../asset/bower_components/Ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../asset/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../asset/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../asset/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="../index.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>TH</b>PT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>SMK</b>Tunas Harapan Pati</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../asset/dist/img/avatar5.png" class="user-image" alt="User Image">
                                <span class="hidden-xs">Muhammad Rizky</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="../asset/dist/img/avatar5.png" class="img-circle" alt="User Image">

                                    <p>
                                        Muhammad Rizky - Web Programmer
                                        <small>Nomor Absen 37</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="../asset/dist/img/avatar5.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>Muhammad Rizky</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">Menu</li>
                    <!-- <li><a href="siswa.php"><i class="fa fa-book"></i> <span>Data Siswa</span></a></li>
        <li><a href="kelas.php"><i class="fa fa-book"></i> <span>Data Kelas</span></a></li> -->
                    <li><a href="../barang/index.php"><i class="fa fa-book"></i> <span>Data Barang</span></a></li>
                    <li><a href="datapenjualan.php"><i class="fa fa-book"></i> <span>Data Penjualan</span></a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Form Detail Barang
                    <small>SMK Tunas Harapan Pati</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-Penjualan"></i> Penjualan</a></li>
                </ol>
            </section>

            
            <!-- Main content -->
            <section class="content">
                <div>
                    <strong>
                        <h1>Toko Bu Anis</h1>
                    </strong>
                </div>
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Identitas</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <h3 style="margin: 1em;">Kode Transaksi : <?= $_GET['kd'] ?></h3>
                            </div>
                            <div class="col-xs-6 text-right">
                                <h3 style="margin: 1em;">Nama Pembeli : <?= $_GET['nama'] ?></h3>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- </div> -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daftar Barang</h3>
                    </div>
                

                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="18%" class="text-center">Nama Barang</th>
                                    <th width="15%" class="text-center">Harga</th>
                                    <th width="5%" class="text-center">Jumlah</th>
                                    <th width="25%" class="text-center">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query dengan JOIN antara tabel detail_transaksi dan barang
                                $result = mysqli_query($mysqli, "
                                    SELECT detail_transaksi.*, db_kasirbarang.nm_barang AS nm_barang, db_kasirbarang.harga_jual 
                                    FROM detail_transaksi
                                    JOIN db_kasirbarang ON detail_transaksi.id_barang = db_kasirbarang.id
                                    WHERE detail_transaksi.kd_penjualan = '$kd_transaksi'
                                    ORDER BY detail_transaksi.id DESC
                                ");

                                while ($data = mysqli_fetch_array($result)) {
                                ?>
                                <tr class="text-center">
                                    <td><?php echo $data['nm_barang']; ?></td>
                                    <!-- Menampilkan nama barang dari tabel barang -->
                                    <td><?php echo rupiah($data['harga_jual']); ?></td>
                                    <!-- Menampilkan harga jual dari tabel barang -->

                                    <!-- Kolom jumlah yang bisa diedit dengan double click -->
                                    <td ondblclick="editJumlah(this, <?= $data['id']; ?>)">
                                        <span><?php echo $data['jmlh']; ?></span>
                                        <input type="number" class="edit-input" value="<?php echo $data['jmlh']; ?>"
                                            onblur="saveJumlah(this, <?= $data['id']; ?>)" style="display:none;">
                                    </td>

                                    <td><?php echo rupiah($data['jmlh'] * $data['harga_jual']); ?></td>
                                    <!-- Contoh perhitungan -->
                                </tr>
                                <?php } ?>
                            </tbody>
                            
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center">Total Belanja</th>
                                    <th class="text-center" id="jmlhBarang">0</th>
                                    <th class="text-center" id="totalBayar">Rp 0</th>
                                </tr>
                            </thead>


                            <tfoot>
                                <?php
                                // Query dengan JOIN antara tabel detail_transaksi dan barang
                                $result = mysqli_query($mysqli, "
                                    SELECT uang_bayar, kembalian FROM penjualan
                                    WHERE kd_transaksi = '$kd_transaksi'
                                    ORDER BY kd_transaksi DESC
                                ");
                                while ($data = mysqli_fetch_array($result)) {
                                ?>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center">Uang Pembeli</th>
                                    <th class="text-center">
                                    <input type="text" name="uang" id="uang" class="form-control" value="<?php echo rupiah($data['uang_bayar'])?>" placeholder="Masukkan jumlah uang pembeli" oninput="formatUang(this)" readonly>
                                    </th>
                                </tr>

                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center">Kembalian</th>
                                    <th class="text-center">
                                    <input type="text" name="kembalian" id="kembalian" class="form-control" value="<?php echo rupiah($data['kembalian'])?>" placeholder="Kembalian" readonly>
                                    </th>
                                </tr>
                                <?php } ?>
                               

                                <tr>
                                    <td colspan="5">
                                    <form action="datapenjualan.php" method="POST"
                                        style="display: flex;  justify-content: flex-start; padding: 20px 45px 0 20px;">
                                        <button type="submit" name="back" class="btn btn-warning">Kembali</button>
                                    </form>
                                    </td>
                                    <td colspan="5">
                                    <form method="POST"
                                        style="display: flex;  justify-content: flex-end; padding: 20px 45px 0 20px;">
                                        <button type="submit" name="print" class="btn btn-success" onclick="handlePrint()">Print</button>
                                    </form>
                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>


                <!-- /.box-body -->
        </div>
        <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.13
        </div>
        <strong>Copyright &copy; 2024-2025 <a href="#">Toko Bu Anis</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->

    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="../asset/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../asset/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../asset/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../asset/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../asset/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../asset/dist/js/demo.js"></script>
    <!-- page script -->
    <script>
    $(function() {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    })

    function updateTotals() {
    let totalJumlah = 0;
    let totalBayar = 0;

    // Loop melalui setiap baris tabel yang berisi data barang
    document.querySelectorAll('tbody tr').forEach(function(row) {
        // Ambil jumlah barang dari kolom jumlah
        let jumlah = parseInt(row.querySelector('td:nth-child(3) span').textContent) || 0;
        // Ambil harga barang dari kolom harga
        let harga = parseInt(row.querySelector('td:nth-child(2)').textContent.replace(/[^0-9]/g, '')) || 0;
        // Hitung sub total
        let subTotal = jumlah * harga;

        // Tambahkan jumlah barang ke total jumlah barang
        totalJumlah += jumlah;
        // Tambahkan sub total ke total bayar
        totalBayar += subTotal;
    });

    // Tampilkan total jumlah barang
    document.getElementById('jmlhBarang').textContent = totalJumlah;
    // Tampilkan total bayar dengan format rupiah
    document.getElementById('totalBayar').textContent = formatRupiah(totalBayar);
    document.getElementById('totalBayarHidden').value = totalBayar; // Total bayar dalam format angka untuk perhitungan
}

function formatUang(input) {
    // Hapus karakter selain angka
    let angka = input.value.replace(/[^,\d]/g, '').toString();

    // Format angka menjadi rupiah
    input.value = formatRupiah(parseFloat(angka));

    // Update kembalian saat input berubah
    updateKembalian();
}

function formatRupiah(angka) {
    let rupiah = '';
    let angkarev = angka.toString().split('').reverse().join('');
    for (let i = 0; i < angkarev.length; i++) {
        if (i % 3 === 0) rupiah += angkarev.substr(i, 3) + '.';
    }
    return 'Rp ' + rupiah.split('', rupiah.length - 1).reverse().join('');
}


// Fungsi untuk menghitung dan menampilkan kembalian
function updateKembalian() {
    // Ambil total bayar yang sudah di-convert ke angka dari hidden input atau dari teks yang dihapus format rupiah-nya
    const totalBayar = parseFloat(document.getElementById('totalBayar').textContent.replace(/[^0-9]/g, '')) || 0;
    const uangPembeli = parseFloat(document.getElementById('uang').value.replace(/[^0-9]/g, '')) || 0; // Uang dari input

    // Hitung kembalian
    const kembalian = uangPembeli - totalBayar;

    // Tampilkan kembalian di input kembalian dalam format rupiah
    document.getElementById('kembalian').value = formatRupiah(kembalian >= 0 ? kembalian : 0);
    document.getElementById('kembalian_hidden').value = kembalian;
}


// Panggil fungsi updateTotals saat halaman dimuat
window.onload = function() {
    updateTotals();
}

// Fungsi untuk menyimpan uang bayar ke input hidden saat menyimpan transaksi
function updateHiddenUangBayar() {
    const uangPembeli = parseFloat(document.getElementById('uang').value.replace(/[^0-9]/g, '')) || 0;
    document.getElementById('uang_bayar_hidden').value = uangPembeli;
}

// Panggil fungsi ini sebelum form disubmit
document.querySelector('form[action="prosestransaksi.php"]').onsubmit = updateHiddenUangBayar;

function handlePrint() {
        window.print();
    }



    </script>
</body>

</html>