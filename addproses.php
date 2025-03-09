<?php
  include_once("config/config.php");
	// Check If form submitted, insert form data into users table.
		$nama = $_POST['nama'];
		$alamat = $_POST['alamat'];
		$nis = $_POST['nis'];
        $tgl_lahir = $_POST['tgl_lahir'];
		
				
		// Insert user data into table
		$result = mysqli_query($mysqli, "INSERT INTO siswa(nama,alamat,nis,tgl_lahir) VALUES('$nama','$alamat','$nis','$tgl_lahir')");
		
        if ($result) {
            $_SESSION['info'] = [
              'status' => 'success',
              'message' => 'Berhasil menambah data'
            ];
            header('Location: ./siswa.php');
        } else {
            $_SESSION['info'] = [
              'status' => 'failed',
              'message' => mysqli_error($connection)
            ];
            header('Location: ./addsiswa.php');
        }

	?>