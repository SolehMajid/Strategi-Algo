<?php 
    require_once "fungsi.php";

    $hasil = dashboardPembuat();
    
    $karyawan = [];
    foreach($hasil as $h) {
        $karyawan[$h['nama_jadwal']][] = [
            'nama_karyawan' => $h['nama_karyawan'],
            'shift_kerja' => $h['shift_kerja']
        ];
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
        <a class="actives" href="dashboard_pembuat.php">Home</a>
        <a href="list_jadwal.php">Jadwal</a>
        <a href="list_karyawan.php">Karyawan</a>
        <a class="log" href="log.php">Log Out</a>
    </div>
    <div class="content">
        <br>
        <div>
            <?php foreach ($karyawan as $k => $i): ?>
                <div>
                    <h5><?php echo $k ?></h5>
                    <hr>
                    <div>
                        <?php foreach($i as $isi): ?>
                            <div>
                                <span><?php echo $isi['nama_karyawan'] ?></span>
                                <span><?php echo $isi['shift_kerja'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>