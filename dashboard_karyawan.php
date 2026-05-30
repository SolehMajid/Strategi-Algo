<?php 
    require_once "fungsi.php";

    $hasil = tampilJadwalKaryawan();
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
        <span><?php echo $_SESSION['nama_karyawan']; ?></span>
        <a class="actives" href="dashboard_karyawan.php">Home</a>
        <a href="list_jadwal_karyawan.php">Jadwal</a>
        <a class="log" href="log.php">Log Out</a>
    </div>
    <div class="content">
        <br>
        <div>
            <?php foreach($hasil as $h): ?>
                <div>
                    <h5><?php echo $h['nama_jadwal'] ?></h5>
                    <div>
                        <div class="list">
                            <span><?php echo $h['shift_kerja'] ?></span>
                            <span><?php echo $h['tanggal'] ?></span>
                        </div>
                    </div>    
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>