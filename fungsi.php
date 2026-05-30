<?php 
    require_once "connection.php";
    session_start();

    function validasiPembuat($username, $password, &$msg, &$display) {
        global $conn;    

        $query = $conn->prepare(
            "SELECT password, id_pembuat, username 
            from pembuat_jadwal
            where username = :username"
        );
        $query->bindParam(":username", $username);
        $query->execute();
        $hasil = $query->fetch(PDO::FETCH_ASSOC);
        $stat = $hasil['password'];
        if(!empty($stat)) {
            if(password_verify($password, $stat)) {
                $msg = "";
                $display = "none";
                $_SESSION['id_pembuat'] = $hasil['id_pembuat'];
                $_SESSION['nama_pembuat'] = $hasil['username'];
                header("location: dashboard_pembuat.php");
            } else {
                $msg = "Username atau Password tidak cocok";
                $display = "block";
            }
        } else {
            $display = "block";
            $msg = "Username tidak ditemukan";
        }
    }

    function daftarPembuat($username, $password, &$msg, &$display) {
        global $conn;

        $query = $conn->prepare(
            "SELECT 1
            from pembuat_jadwal
            where username = :username"
        );
        $query->bindParam(":username", $username);
        $query->execute();
        $stat = $query->fetch(PDO::FETCH_ASSOC);
        if(!$stat) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $query = $conn->prepare(
                "INSERT into pembuat_jadwal
                (username, password)
                values 
                (:username, :password)"
            );
            $query->bindParam(":username", $username);
            $query->bindParam(":password", $hash);
            $query->execute();
            $msg = "";
            $display = "none";
            header('location: login_pembuat.php');
        } else {
            $display = "block";
            $msg = "Username sudah ada";
        }
    }

    function validasiKaryawan($kode, &$msg, &$display) {
        global $conn;

        $query = $conn->prepare(
            "SELECT id_karyawan, nama_karyawan
            from karyawan
            where kode_unik = :kode_unik"
        );
        $query->bindParam(":kode_unik", $kode);
        $query->execute();
        $hasil = $query->fetch(PDO::FETCH_ASSOC);
        if(!empty($hasil)) {
            $_SESSION['id_karyawan'] = $hasil['id_karyawan'];
            $_SESSION['nama_karyawan'] = $hasil['nama_karyawan'];
            $msg = "";
            $display = "none";
            header('location: dashboard_karyawan.php');
        } else {
            $msg = "Kode salah";
            $display = "block";
        }
    }

    function tampilJadwalPembuat() {
        global $conn;
        $id_pembuat = $_SESSION['id_pembuat'];

        $query = $conn->prepare(
            "SELECT j.id_jadwal, j.nama_jadwal, count(distinct dj.id_karyawan) jumlah_karyawan
            from jadwal j   
            left join detail_jadwal dj on dj.id_jadwal = j.id_jadwal
            where j.id_pembuat = :id_pembuat
            group by j.id_jadwal, j.nama_jadwal"
        );
        $query->bindParam(":id_pembuat", $id_pembuat);
        $query->execute();
        $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }

    function tampilListKaryawan() {
        global $conn;
        $id_pembuat = $_SESSION['id_pembuat'];

        $query = $conn->prepare(
            "SELECT k.id_karyawan, k.nama_karyawan, k.kode_unik, k.kelamin
            from karyawan k
            join pembuat_dan_karyawan pdk on pdk.id_karyawan = k.id_karyawan
            where pdk.id_pembuat = :id_pembuat"
        );
        $query->bindParam(":id_pembuat", $id_pembuat);
        $query->execute();
        $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }

    function tambahKaryawan($nama, $kelamin) {
        global $conn;
        $id_pembuat = $_SESSION['id_pembuat'];

        $query = $conn->prepare(
            "INSERT into karyawan
            (kode_unik, nama_karyawan, kelamin)
            values 
            (null, :nama_karyawan, :kelamin)"
        );
        $query->bindParam(":nama_karyawan", $nama);
        $query->bindParam(":kelamin", $kelamin);
        $query->execute();
        $id = $conn->lastInsertId();
        $query = $conn->prepare(
            "INSERT into pembuat_dan_karyawan
            (id_pembuat, id_karyawan)
            values
            (:id_pembuat, :id_karyawan)"
        );
        $query->bindParam(":id_pembuat", $id_pembuat);
        $query->bindParam(":id_karyawan", $id);
        $query->execute();
        $kode_unik = "KU".str_pad($id, 3, "0", STR_PAD_LEFT);
        $query = $conn->prepare(
            "UPDATE karyawan
            set kode_unik = :kode
            where id_karyawan = :id_karyawan"
        );
        $query->bindParam(":kode", $kode_unik);
        $query->bindParam(":id_karyawan", $id);
        $query->execute();
        header('location: list_karyawan.php');
        exit;
    }

    function hapusKaryawan($id) {
        global $conn;

        $query = $conn->prepare(
            "DELETE from detail_jadwal
            where id_karyawan = :id_karyawan"
        );
        $query->bindParam(":id_karyawan", $id);
        $query->execute();
        $query = $conn->prepare(
            "DELETE from pembuat_dan_karyawan
            where id_karyawan = :id_karyawan"
        );
        $query->bindParam(":id_karyawan", $id);
        $query->execute();
        $query = $conn->prepare(
            "DELETE from karyawan
            where id_karyawan = :id_karyawan"
        );
        $query->bindParam(":id_karyawan", $id);
        $query->execute();
        header('location: list_karyawan.php');
        exit;
    }

    function updateKaryawan($id, $nama, $kelamin) {
        global $conn;

        $query = $conn->prepare(
            "UPDATE karyawan
            set nama_karyawan = :nama, kelamin = :kelamin
            where id_karyawan = :id_karyawan"
        );
        $query->bindParam(":nama", $nama);
        $query->bindParam(":id_karyawan", $id);
        $query->bindParam(":kelamin", $kelamin);
        $query->execute();
        header('location: list_karyawan.php');
        exit;
    }

    function dashboardPembuat() {
        global $conn;    
        $id = $_SESSION['id_pembuat'];

        $query = $conn->prepare(
            "SELECT
                k.nama_karyawan,
                j.nama_jadwal,
                dj.shift_kerja
            from detail_jadwal dj
            join karyawan k
                on k.id_karyawan = dj.id_karyawan
            join jadwal j
                on j.id_jadwal = dj.id_jadwal
            where j.id_pembuat = :id_pembuat
            and dj.tanggal = current_date()
            order by nama_jadwal"
        );
        $query->bindParam(":id_pembuat", $id);
        $query->execute();
        $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }

    function tampilKaryawanPadaJadwal($id) {
        global $conn;

        $query = $conn->prepare(
            "SELECT tanggal, shift_kerja, id_karyawan
            from detail_jadwal
            where id_jadwal = :id_jadwal"
        );
        $query->bindParam(":id_jadwal", $id);
        $query->execute();
        $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }

    function hapusJadwal($id) {
        global $conn;

        $query = $conn->prepare(
            "DELETE FROM detail_jadwal
            where id_jadwal = :id_jadwal"
        );
        $query->bindParam(":id_jadwal", $id);
        $query->execute();
        $query = $conn->prepare(
            "DELETE FROM jadwal
            where id_jadwal = :id_jadwal"
        );
        $query->bindParam(":id_jadwal", $id);
        $query->execute();
        header('location: list_jadwal.php');
        exit;
    }

    function tampilJadwalKaryawan() {
        global $conn;

        $id = $_SESSION['id_karyawan'];
        $query = $conn->prepare(
            "SELECT j.nama_jadwal, dj.shift_kerja, dj.tanggal
            from detail_jadwal dj
            join jadwal j on j.id_jadwal = dj.id_jadwal
            where dj.id_karyawan = :id_karyawan and dj.tanggal = current_date()"
        );
        $query->bindParam(":id_karyawan", $id);
        $query->execute();
        $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }

    function listJadwal() {
        global $conn;

        $id = $_SESSION['id_karyawan'];
        $query = $conn->prepare(
            "SELECT distinct j.nama_jadwal, j.id_jadwal
            from detail_jadwal dj
            join jadwal j on j.id_jadwal = dj.id_jadwal
            where dj.id_karyawan = :id_karyawan"
        );
        $query->bindParam(":id_karyawan", $id);
        $query->execute();
        $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }
    
    function printJadwal($id_jadwal) {
        global $conn;

        $id = $_SESSION['id_karyawan'];
        $query = $conn->prepare(
            "SELECT tanggal, shift_kerja
            from detail_jadwal 
            where id_karyawan = :id_karyawan and id_jadwal = :id_jadwal
            order by tanggal;"
        );
        $query->bindParam(":id_jadwal", $id_jadwal);
        $query->bindParam(":id_karyawan", $id);
        $query->execute();
        $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }
?>