<?php
require_once "fungsi.php";

if (empty($_SESSION['id_pembuat'])) {
    header("location: login_pembuat.php");
    exit;
}

if (isset($_POST['submit'])) {
    $jumlah_shift = intval($_POST['jumlah_shift']);
    $jumlah_karyawan_per_shift = intval($_POST['jumlah_karyawan']);
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $list_karyawan = $_POST['list_karyawan'];

    if (empty($list_karyawan) || !is_array($list_karyawan)) {
        echo "<script>alert('Harap pilih minimal 8 karyawan.'); window.history.back();</script>";
        exit;
    }

    $N = count($list_karyawan);
    $S = $jumlah_shift;
    $K = $jumlah_karyawan_per_shift;

    // 1. Validasi kecukupan jumlah karyawan untuk Libur Sehat (Opsi B: N >= ceil(S * K * 1.2))
    $kebutuhan_harian = $S * $K;
    $min_karyawan_sehat = ceil($kebutuhan_harian * 1.2);
    if ($N < $min_karyawan_sehat) {
        echo "<script>
            alert('Gagal! Jumlah karyawan terpilih ($N orang) kurang dari batas minimum libur sehat ($min_karyawan_sehat orang) untuk $S shift dengan $K karyawan per shift agar terhindar dari kerja rodi tanpa libur.\\n\\nHarap tambahkan minimal ' . ($min_karyawan_sehat - $N) . ' karyawan lagi.');
            window.history.back();
        </script>";
        exit;
    }


    $start = new DateTime($tanggal_awal);
    $end = new DateTime($tanggal_akhir);

    if ($start > $end) {
        echo "<script>alert('Tanggal berakhir tidak boleh sebelum tanggal awal.'); window.history.back();</script>";
        exit;
    }

    // Cek apakah sudah ada jadwal pada rentang tanggal tersebut
    $id_pembuat = $_SESSION['id_pembuat'];
    $stmt_cek_jadwal = $conn->prepare("
        SELECT 1 
        FROM detail_jadwal dj
        JOIN jadwal j ON dj.id_jadwal = j.id_jadwal
        WHERE dj.tanggal BETWEEN :tanggal_awal AND :tanggal_akhir
          AND j.id_pembuat = :id_pembuat
        LIMIT 1
    ");
    $stmt_cek_jadwal->execute([
        ':tanggal_awal' => $tanggal_awal,
        ':tanggal_akhir' => $tanggal_akhir,
        ':id_pembuat' => $id_pembuat
    ]);
    if ($stmt_cek_jadwal->fetch()) {
        echo "<script>
            alert('Gagal! Jadwal pada tanggal sekitar " . date('d-m-Y', strtotime($tanggal_awal)). " sudah ada.\\n\\nPeraturan: Tidak boleh ada jadwal yang bertabrakan pada rentang tanggal yang sama.');
            window.history.back();
        </script>";
        exit;
    }

    $dates = [];
    $current = clone $start;
    while ($current <= $end) {
        $dates[] = $current->format('Y-m-d');
        $current->modify('+1 day');
    }

    // 2. Inisialisasi struktur pelacak (Trackers) untuk Constraint Programming
    $poin_kerja = [];          // employee_id => total akumulasi hari kerja (Soft Constraint: Keadilan)
    $hari_kerja_beruntun = [];  // employee_id => jumlah hari kerja berurutan (Hard Constraint: Max 6 hari)
    $last_shift = [];           // employee_id => shift hari sebelumnya (Hard Constraint: Malam -> Pagi)

    $tanggal_kemarin = date('Y-m-d', strtotime($tanggal_awal . ' - 1 day'));

    foreach ($list_karyawan as $id) {
        $poin_kerja[$id] = 0;

        // Ambil shift kerja kemarin dari database untuk mendeteksi shift Malam dari penjadwalan sebelumnya
        $stmt_kemarin = $conn->prepare("
            SELECT shift_kerja 
            FROM detail_jadwal 
            WHERE id_karyawan = :id_karyawan AND tanggal = :tanggal_kemarin 
            ORDER BY id_detail_jadwal DESC 
            LIMIT 1
        ");
        $stmt_kemarin->execute([
            ':id_karyawan' => $id,
            ':tanggal_kemarin' => $tanggal_kemarin
        ]);
        $row_kemarin = $stmt_kemarin->fetch(PDO::FETCH_ASSOC);
        $last_shift[$id] = $row_kemarin ? $row_kemarin['shift_kerja'] : null;

        // Ambil jumlah hari kerja berturut-turut sebelum tanggal_awal
        $consecutive = 0;
        $check_date = $tanggal_kemarin;
        while (true) {
            $stmt_check = $conn->prepare("
                SELECT shift_kerja 
                FROM detail_jadwal 
                WHERE id_karyawan = :id_karyawan AND tanggal = :check_date 
                ORDER BY id_detail_jadwal DESC 
                LIMIT 1
            ");
            $stmt_check->execute([
                ':id_karyawan' => $id,
                ':check_date' => $check_date
            ]);
            $row_check = $stmt_check->fetch(PDO::FETCH_ASSOC);
            if ($row_check && $row_check['shift_kerja'] !== 'Libur') {
                $consecutive++;
                $check_date = date('Y-m-d', strtotime($check_date . ' - 1 day'));
            } else {
                break;
            }
        }
        $hari_kerja_beruntun[$id] = $consecutive;
    }


    // Daftar nama shift berdasarkan konfigurasi S
    $shifts_list = [];
    if ($S == 3) {
        $shifts_list = ['Pagi', 'Siang', 'Malam'];
    } else {
        $shifts_list = ['Pagi', 'Siang'];
    }

    $jadwal_hasil = []; // Menyimpan output final: [tanggal][employee_id] = shift_kerja

    // 3.Eksekusi Algoritma CP Sekuensial dengan Domain Reduction (Hari-demi-Hari)
    foreach ($dates as $date) {

        // A. PENYARINGAN DOMAIN (Domain Filtering) untuk setiap karyawan
        $domain = [];
        foreach ($list_karyawan as $id) {
            // Domain awal lengkap
            $emp_domain = array_merge($shifts_list, ['Libur']);

            // Batasan 1: Malam -> Pagi (Cegah kelelahan)
            // Jika kemarin mendapat shift Malam, hapus opsi Pagi dari domain hari ini
            if ($last_shift[$id] === 'Malam') {
                $emp_domain = array_diff($emp_domain, ['Pagi']);
            }

            // Batasan 2: Maksimal Kerja 6 Hari Berurutan
            // Jika sudah bekerja 6 hari berturut-turut, domain dipaksa hanya Libur
            if ($hari_kerja_beruntun[$id] >= 6) {
                $emp_domain = ['Libur'];
            }

            $domain[$id] = $emp_domain;
        }

        // B. PRIORITAS BERDASARKAN POIN KERJA (Soft Constraint Pemerataan)
        // Urutkan karyawan dari yang memiliki poin kerja terkecil ke terbesar
        uasort($poin_kerja, function ($a, $b) {
            return $a <=> $b;
        });
        $sorted_employee_ids = array_keys($poin_kerja);

        // Inisialisasi status penugasan karyawan hari ini
        $assigned_today = [];
        foreach ($list_karyawan as $id) {
            $assigned_today[$id] = null;
        }

        // C. PENUGASAN SHIFT AKTIF HARI INI
        foreach ($shifts_list as $shift) {
            $assigned_count = 0;

            // Cari K karyawan dengan poin kerja terkecil yang domainnya mendukung shift ini
            foreach ($sorted_employee_ids as $id) {
                if ($assigned_count >= $K) {
                    break; // Shift ini sudah terpenuhi kuotanya
                }

                // Jika belum ditugaskan hari ini dan shift tersebut ada di domainnya yang telah terfilter
                if ($assigned_today[$id] === null && in_array($shift, $domain[$id])) {
                    $assigned_today[$id] = $shift;
                    $assigned_count++;
                }
            }
        }

        // Karyawan sisa yang belum kebagian shift kerja otomatis mendapatkan shift "Libur"
        foreach ($list_karyawan as $id) {
            if ($assigned_today[$id] === null) {
                $assigned_today[$id] = 'Libur';
            }
        }

        // D. UPDATE TRACKER STATUS UNTUK HARI BERIKUTNYA
        foreach ($list_karyawan as $id) {
            $assigned_shift = $assigned_today[$id];
            $jadwal_hasil[$date][$id] = $assigned_shift;

            // Perbarui Poin Kerja & Kerja Beruntun
            if ($assigned_shift !== 'Libur') {
                $poin_kerja[$id]++;
                $hari_kerja_beruntun[$id]++;
            } else {
                $hari_kerja_beruntun[$id] = 0; // Reset ke 0 karena hari ini libur
            }

            // Perbarui riwayat shift kemarin
            $last_shift[$id] = $assigned_shift;
        }

        $day_idx++;
    }

    // 4. MENYIMPAN HASIL JADWAL KE DATABASE (DENGAN PDO TRANSACTION)
    try {
        $conn->beginTransaction();

        // A. Buat Header Jadwal baru
        // Format Nama Jadwal: Jadwal Shift (TanggalMulai - TanggalAkhir)
        $nama_jadwal = "Jadwal Shift (" . date('d M', strtotime($tanggal_awal)) . " - " . date('d M Y', strtotime($tanggal_akhir)) . ")";
        $id_pembuat = $_SESSION['id_pembuat'];

        $stmt_jadwal = $conn->prepare("INSERT INTO jadwal (id_pembuat, nama_jadwal) VALUES (:id_pembuat, :nama_jadwal)");
        $stmt_jadwal->execute([
            ':id_pembuat' => $id_pembuat,
            ':nama_jadwal' => $nama_jadwal
        ]);
        $id_jadwal = $conn->lastInsertId();

        // B. Buat Detail Jadwal untuk setiap hari dan setiap karyawan
        $stmt_delete_overlap = $conn->prepare("
            DELETE FROM detail_jadwal 
            WHERE id_karyawan = :id_karyawan AND tanggal = :tanggal
        ");

        $stmt_detail = $conn->prepare("
            INSERT INTO detail_jadwal 
            (id_jadwal, id_karyawan, tanggal, shift_kerja) 
            VALUES 
            (:id_jadwal, :id_karyawan, :tanggal, :shift_kerja)
        ");

        foreach ($jadwal_hasil as $date => $assignments) {
            foreach ($assignments as $id_karyawan => $shift) {
                // Hapus jika ada duplikat jadwal pada tanggal tersebut untuk karyawan ini
                $stmt_delete_overlap->execute([
                    ':id_karyawan' => $id_karyawan,
                    ':tanggal' => $date
                ]);

                $stmt_detail->execute([
                    ':id_jadwal' => $id_jadwal,
                    ':id_karyawan' => $id_karyawan,
                    ':tanggal' => $date,
                    ':shift_kerja' => $shift
                ]);
            }
        }

        $conn->commit();

        header("location: list_jadwal.php");
        exit;
    } catch (Exception $e) {
        $conn->rollBack();
        echo "<h3>Gagal Menyimpan Jadwal!</h3>";
        echo "Error:" . $e->getMessage();
        echo "<br><a href='tambah_jadwal.php'>Kembali ke Halaman Tambah Jadwal</a>";
    }
} else {
    header("location: tambah_jadwal.php");
    exit;
}
