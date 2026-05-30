<?php 
    require_once "fungsi.php";

    $hasil = listJadwal();
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
        <a href="dashboard_karyawan.php">Home</a>
        <a class="actives" href="list_jadwal_karyawan.php">Jadwal</a>
        <a class="log" href="log.php">Log Out</a>
    </div>
    <div class="content">
        <br>
        <div>
            <?php foreach($hasil as $h): ?>
                <div>
                    <div>
                        <div class="list">
                            <span><?php echo $h['nama_jadwal'] ?></span>
                            <a href="print_jadwal.php?id=<?php echo $h['id_jadwal'] ?>">Print Jadwal</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>