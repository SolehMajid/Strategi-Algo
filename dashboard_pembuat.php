<?php 
    require_once "fungsi.php";

    $hasil = dashboardPembuat();
    
    // Grouping by nama_jadwal, then by tanggal
    $karyawan = [];
    foreach($hasil as $h) {
        $karyawan[$h['nama_jadwal']][$h['tanggal']][] = [
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
            <?php foreach ($karyawan as $nama_jadwal => $tanggal_list): ?>
                <div>
                    <h5><?php echo htmlspecialchars($nama_jadwal) ?></h5>
                    <hr>
                    <div>
                        <?php foreach($tanggal_list as $tgl => $shifts): ?>
                            <div>
                                <h5 class="tanggal-tgl"><?php echo date('d-m-Y', strtotime($tgl)) ?></h5>
                                <?php foreach($shifts as $isi): ?>
                                    <div class="list">
                                        <span><?php echo htmlspecialchars($isi['nama_karyawan']) ?></span>
                                        <span class="<?php echo $isi['shift_kerja'] == 'Libur' ? 'Libur' : '' ?>"><?php echo htmlspecialchars($isi['shift_kerja']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>