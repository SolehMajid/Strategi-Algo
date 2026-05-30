<?php 
    require_once "fungsi.php";

    $hasil = printJadwal(htmlspecialchars($_GET['id']));

    $jadwal = [];
    foreach($hasil as $h) {
        $bulan = date('Y-m', strtotime($h['tanggal']));
        $minggu = date('W', strtotime($h['tanggal']));
        $hari = date('N', strtotime($h['tanggal']));

        $jadwal[$bulan][$minggu][$hari] = [
            'tanggal' => date('d', strtotime($h['tanggal'])),
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
    <div class="content">
        <br>
        <a class="tambah not" href="list_jadwal_karyawan.php">Kembali</a>
        <button class="tambah not" onclick="window.print()">Print Jadwal</button>
        <?php foreach($jadwal as $bulan => $minggu): ?>
            <h5 class="bulan"><?php echo date('M, Y', strtotime($bulan)) ?></h5>
            <table class="tab">
                <tr>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jum'at</th>
                    <th>Sabtu</th>
                    <th>Minggu</th>
                </tr>
                <?php foreach($minggu as $m): ?>
                    <tr>
                        <?php for($i = 1; $i <= 7; $i++): ?>
                            <?php if(!empty($m[$i])): ?>
                                <td class="<?php echo $m[$i]['shift_kerja'] ?>">
                                    <?php echo $m[$i]['tanggal']."/".$m[$i]['shift_kerja']  ?>
                                </td>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endforeach; ?>
    </div>
</body>
</html>