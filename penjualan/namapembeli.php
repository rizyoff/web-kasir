<?php
session_start();
include_once("../config/config.php");

// Fungsi untuk mendapatkan kode transaksi terbaru
function getNextKodeTransaksi($connection) {
    $sql = "SELECT kode_transaksi FROM kode_transaksi ORDER BY id DESC LIMIT 1";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastKode = $row['kode_transaksi'];
        $nextNumber = intval(substr($lastKode, 1)) + 1;
        return 'A' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    } else {
        return 'A00001';
    }
}

// Fungsi untuk menambahkan kode transaksi baru ke database
function insertKodeTransaksi($connection, $kodeTransaksi) {
    $sql = "INSERT INTO kode_transaksi (kode_transaksi) VALUES (?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $kodeTransaksi);
    $stmt->execute();
    $stmt->close();
}

// Ambil kode transaksi terbaru
$kodeTransaksi = getNextKodeTransaksi($connection);

// Simpan kode transaksi baru ke database setelah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit'])) {
    $kdTransaksi = $kodeTransaksi;

    // Insert kode transaksi baru
    insertKodeTransaksi($connection, $kdTransaksi);

    // Menambahkan barang ke session 'items'
    $_SESSION['items'][] = array(
        'nama_barang' => $_POST['NamaBarang'],
        'harga' => $_POST['Harga'],
        'jumlah' => $_POST['Jumlah'],
        'subtotal' => $_POST['Harga'] * $_POST['Jumlah']
    );

    // Redirect setelah POST untuk mencegah pengulangan data saat refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} elseif (isset($_POST['clear'])) {
    // Hapus semua item dari session
    unset($_SESSION['items']);
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

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Buat Transaksi Baru
                    <small>SMK Tunas Harapan Pati</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i>Buat Transaksi</a></li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form <?= isset($_GET['edit']) ? "Update" : "Input"  ?> Data Barang
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form action="prosestransaksi.php" method="POST" name="form1">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Pembeli</label>
                                        <input required type="text" name="nama_pembeli" class="form-control"
                                            id="nama_pembeli" placeholder="Masukkan nama pembeli" required autofocus>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer text-right">
                                    <button type="submit" name="add_transaksi" class="btn btn-primary">Simpan</button>
                                </div>

                            </form>
                        </div>

                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>

        </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.13
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
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




    </script>
</body>

</html>