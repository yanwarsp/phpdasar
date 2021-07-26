<?php 
session_start();
if ( !isset($_SESSION["login"]) ) {
		header("Location: login.php");
		exit;
} 


require 'functions.php';

// paginatioon
//konfigurasi
$jumlahDataPerHal = 2;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHal = ceil($jumlahData / $jumlahDataPerHal);
$halAktif = ( isset($_GET["page"]) ) ? $_GET["page"] : 1;
$awalData = ( $jumlahDataPerHal * $halAktif) - $jumlahDataPerHal;


$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHal");

// tombol cari diklik
if ( isset($_POST["cari"]) ) {
	$mahasiswa = cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman Admin</title>
</head>
<body>


 <a href="logout.php">Log Out</a>
 <h1>Daftar Mahasiswa</h1>

 <a href="tambah.php">Tambah Data Mahasiswa</a>
 <br><br>

<form action="" method="post">
	<input type="text" name="keyword" size="35" autofocus placeholder="Masukan pencarian" autocomplete="off">
	<button type="submit" name="cari">Cari</button>
</form>
<br>

<!-- navigasi -->
<?php if ($halAktif > 1) : ?>
<a href="?page=<?= $halAktif - 1; ?>">&laquo;</a>
<?php endif; ?>


<?php  for( $i=1; $i <= $jumlahHal; $i++) : ?>
	<?php if( $i == $halAktif ) : ?>
		<a href="?page=<?= $i; ?>" style="font-weight: bold; color: red;"><?= $i; ?></a>
	<?php else : ?>
		<a href="?page=<?= $i; ?>"><?= $i; ?></a>
	<?php endif; ?>
<?php endfor; ?>

<?php if ($halAktif < $jumlahHal) : ?>
<a href="?page=<?= $halAktif + 1; ?>">&raquo;</a>
<?php endif; ?>


<br>
<table border="1" cellpadding="10" cellspacing="0">
	
	<tr>
		<th>No.</th>
		<th>Aksi</th>
		<th>NIM</th>
		<th>Nama</th>
		<th>Email</th>
		<th>Jurusan</th>
		<th>Gambar</th>
	</tr>
<?php  $i = 1; ?>
<?php foreach ($mahasiswa as $row) : ?>
	<tr>
		<td><?= $i; ?></td>
		<td>
			<a href="ubah.php?id=<?= $row["id"]; ?>">ubah</a>
			<a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('anda yakin ingin menghapus data ini?');">hapus</a>
		</td>
		<td><?= $row["nim"]; ?></td>
		<td><?= $row["nama"]; ?></td>
		<td><?= $row["email"]; ?></td>
		<td><?= $row["jurusan"]; ?></td>
		<td><img src="img/<?= $row["gambar"]; ?>"></td>
	</tr>
	<?php $i++; ?>
<?php endforeach; ?>

</table>

</body>
</html>