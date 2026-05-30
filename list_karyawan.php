<?php 
    require_once "fungsi.php";

    $hasil = tampilListKaryawan();

    if(!empty($_POST['tambah'])) {
        tambahKaryawan(htmlspecialchars($_POST['nama_karyawan']), $_POST['jenis_kelamin']);
    }

    if(!empty($_GET['id'])) {
        hapusKaryawan(htmlspecialchars($_GET['id']));
    }

    if(!empty($_POST['ya'])) {
        updateKaryawan(htmlspecialchars($_POST['id_karyawan']), htmlspecialchars($_POST['nama_karyawan']), htmlspecialchars($_POST['jenis_kelamin']));
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
    <!-- modal homemade -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <i onclick="closeModal()" class="close">X</i>
            <h2>Edit Nama</h2>
            <form action="" method="POST">
                <input type="hidden" name="id_karyawan">
                <input type="text" name="nama_karyawan" value="" required>
                <select name="jenis_kelamin">
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
                <button type="submit" value="submit" name="ya">Ya</button>
            </form>
        </div>
    </div>
    <div class="sidebar">
        <span><?php echo $_SESSION['nama_pembuat']; ?></span>
        <a href="dashboard_pembuat.php">Home</a>
        <a href="list_jadwal.php">Jadwal</a>
        <a class="actives" href="list_karyawan.php">Karyawan</a>
        <a class="log" href="log.php">Log Out</a>
    </div>
    <div class="content">
        <br>
        <form action="" method="POST" class="form-tambah">
            <input type="text" name="nama_karyawan" placeholder="Nama Karyawan" required>
            <select name="jenis_kelamin">
                <option value="L">Laki - Laki</option>
                <option value="P">Perempuan</option>
            </select>
            <button type="submit" name="tambah" value="tambah">
                Tambah Karyawan
            </button>
        </form>
        <table>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($hasil as $h): ?>
                <tr>
                    <td>
                        <span>
                            <?php echo $h['kode_unik']; ?>
                        </span>
                    </td>
                    <td>
                        <span>
                            <?php echo $h['nama_karyawan']; ?>
                        </span>
                    </td>
                    <td>
                        <span>
                            <?php echo $h['kelamin'] ?>
                        </span>
                    </td>
                    <td>
                        <button onclick="openModal(
                            '<?php echo $h['id_karyawan']; ?>',
                            '<?php echo $h['nama_karyawan']; ?>',
                            '<?php echo $h['kelamin']; ?>'
                        )">Edit</button>
                        <a onclick="return confirm('Hapus karyawan <?php echo $h['nama_karyawan'] ?>?')" href="?id=<?php echo $h['id_karyawan'] ?>">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="javascript.js"></script>
</body>
</html>