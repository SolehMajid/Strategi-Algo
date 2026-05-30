<?php 
    require_once "fungsi.php";

    $hasil = tampilJadwalPembuat();

    if(!empty($_GET['id'])) {
        hapusJadwal(htmlspecialchars($_GET['id']));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Strategi Algoritma</title>
</head>
<body>
    <div class="sidebar">
        <span><?php echo $_SESSION['nama_pembuat']; ?></span>
        <a href="dashboard_pembuat.php">Home</a>
        <a class="actives" href="list_jadwal.php">Jadwal</a>
        <a href="list_karyawan.php">Karyawan</a>
        <a class="log" href="log.php">Log Out</a>
    </div>
    <div class="content">
        <br>
        <a class='tambah' href="tambah_jadwal.php">Tambah Jadwal</a>
        <div>
            <?php foreach($hasil as $h): ?>
                <div>
                    <div>
                        <div class="list">
                            <span>
                                <?php echo $h['nama_jadwal']; ?>
                            </span>
                            <span>Jumlah Karyawan: 
                                <?php echo $h['jumlah_karyawan']; ?>
                            </span>
                            <a href="edit_jadwal.php?id=<?php echo $h['id_jadwal'] ?>">Edit</a>
                            <a onclick='return confirm(" Apakah anda ingin menghapus <?php echo $h["nama_jadwal"] ?>")' href="?id=<?php echo $h['id_jadwal'] ?>">Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>