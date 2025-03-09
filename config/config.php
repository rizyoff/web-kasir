<!-- <?php
/**
 * using mysqli_connect for database connection
 */
 
$databaseHost = 'localhost';
$databaseName = 'db_sekolah';
$databaseUsername = 'root';
$databasePassword = '';
 
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
 
?> -->

<?php
// Konfigurasi database
$host = 'localhost'; // atau 127.0.0.1
$user = 'root';      // username database
$password = '';      // password database, kosong jika tidak ada
$database = 'db_sekolah'; // nama database yang digunakan

// Membuat koneksi ke database
$connection = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

function rupiah($val)
{
    return "Rp" . number_format($val, 0, ',', '.');
}
?>
