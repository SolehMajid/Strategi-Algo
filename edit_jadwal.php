<?php 
    require_once "fungsi.php";

    $test = tampilKaryawanPadaJadwal(htmlspecialchars($_GET['id']));
    $karyawan = tampilListKaryawan();

    $hasil = [];
    foreach($test as $h) {
        $hasil[$h['tanggal']][] = [
            'id_karyawan' => $h['id_karyawan'],
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
        <a href="dashboard_pembuat.php">Home</a>
        <a class="actives" href="list_jadwal.php">Jadwal</a>
        <a href="list_karyawan.php">Karyawan</a>
        <a class="log" href="log.php">Log Out</a>
    </div>
    <div class="content">
        <br>
        <a class='tambah' href="list_jadwal.php">Kembali</a>
        <div>
            <?php foreach($hasil as $t => $i): ?>
                <div>
                    <h5><?php echo $t ?></h5>
                    <div>
                        <?php foreach($i as $isi): ?>
                            <div>
                                <select name="id_karyawan" id="id_karyawan">
                                    <option value=""></option>
                                    <?php foreach($karyawan as $k): ?>
                                        <?php if($isi['id_karyawan'] == $k['id_karyawan']): ?>
                                            <option value="<?php echo $isi['id_karyawan'] ?>" selected><?php echo $k['nama_karyawan'] ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $k['id_karyawan'] ?>"><?php echo $k['nama_karyawan'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
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