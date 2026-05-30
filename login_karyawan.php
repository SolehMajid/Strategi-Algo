<?php 
    require_once "fungsi.php";

    $msg = "";
    $display = "";
    if(!empty($_POST['submit'])) {
        validasiKaryawan(htmlspecialchars($_POST['kode']), $msg, $display);
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
    <form action="" method="post">
        <p class="tengah">Masukkan Kode Unik</p>
        <div class="tengah">
            <input type="text" name="kode" value="">
        </div>
        <div class="tengah">
            <a class="kembali" href="index.html">Kembali</a>
            <input type="submit" value="submit" name="submit">
        </div>
    </form>
</body>
</html>