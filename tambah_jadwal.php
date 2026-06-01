<?php
require_once "fungsi.php";

$hasil = tampilListKaryawan();
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
    <form id="formK" action="algo.php" method="POST">
        <div class="peraturan-container">
            <h3>📋 Peraturan Penjadwalan (Constraints)</h3>
            <ul>
                <li><strong>Jumlah Karyawan:</strong> Karyawan yang dipilih harus antara 8 sampai 15 orang.</li>
                <li><strong>Karyawan Laki-laki:</strong> Minimal harus ada 2 karyawan laki-laki yang ikut dalam jadwal.</li>
                <li><strong>Tidak Boleh Ganda:</strong> Satu karyawan hanya boleh muncul satu kali dalam daftar pilihan.</li>
                <li><strong>Jumlah Karyawan Harus Cukup:</strong> Karyawan yang dipilih harus cukup untuk mengisi semua shift dan tetap memiliki kesempatan libur. Sebagai aturan aman, jumlah karyawan harus sekitar 20% lebih banyak dari kebutuhan minimum.
                    <br><small><em>Contoh: Jika ada 3 shift dan setiap shift membutuhkan 3 orang, maka dibutuhkan minimal 11 karyawan.</em></small>
                </li>
                <li><strong>Istirahat Setelah Shift Malam:</strong> Karyawan yang bekerja pada shift malam hari ini tidak boleh langsung bekerja pada shift pagi keesokan harinya.</li>
                <li><strong>Batas Maksimal Hari Kerja:</strong> Karyawan hanya boleh bekerja maksimal 6 hari berturut-turut. Setelah itu wajib mendapatkan 1 hari libur.</li>
                <li><strong>Tanggal Tidak boleh sama:</strong> Tanggal yang sudah ada di jadwal tidak boleh sama dengan rentan tanggal tersebut </li>
            </ul>
        </div>
        <div class="double">
            <div>
                <p>Jumlah Shift</p>
                <select name="jumlah_shift" id="jumlah_shift">
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div>
                <p>Jumlah Karyawan Per Shift</p>
                <select name="jumlah_karyawan" id="jumlah_karyawan">
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div>
                <p>Pilih Tanggal Mulai</p>
                <input type="date" name="tanggal_awal" min="<?php echo date('Y-m-d') ?>" required>
            </div>
            <div>
                <p>Tanggal Berakhir</p>
                <input type="date" name="tanggal_akhir">
            </div>
        </div>
        <p>List Karyawan</p>
        <div id="container">
            <div class="nama_karyawan">
                <select name="list_karyawan[]">
                    <?php foreach ($hasil as $h): ?>
                        <option
                            value="<?php echo $h['id_karyawan'] ?>"
                            data-kelamin="<?php echo $h['kelamin'] ?>">
                            <?php echo $h['nama_karyawan'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="jenis_kelamin" value="<?php echo $hasil[0]['kelamin'] ?>" disabled>
                <button type="button" class="hapus">-</button>
            </div>
        </div>
        <button id="tambah" type="button">Tambah Karyawan</button>
        <div>
            <a href="list_jadwal.php">Kembali</a>
            <input type="submit" value="submit" name="submit" id="submit">
        </div>
    </form>
    <script>
        const tombolTambah = document.getElementById("tambah");
        const container = document.getElementById("container");
        const formK = document.getElementById("formK")

        container.addEventListener("change", function(input) {
            if (input.target.matches("select[name='list_karyawan[]']")) {
                const select = input.target;
                const option = select.options[select.selectedIndex];
                const kelamin = option.dataset.kelamin;
                const jenis_kelamin = select.parentElement.querySelector("input[name='jenis_kelamin']");
                jenis_kelamin.value = kelamin;
            }
        });

        container.addEventListener("click", function(input) {
            if (input.target.classList.contains("hapus")) {
                const totalField = document.querySelectorAll(".nama_karyawan");
                if (totalField.length == 1) {
                    return false
                } else {
                    input.target.parentElement.remove();
                    return true
                }
            }
        })

        tombolTambah.addEventListener("click", function() {
            const optionKaryawan = `
                <?php foreach ($hasil as $h): ?>
                    <option 
                        value="<?php echo $h['id_karyawan'] ?>"
                        data-kelamin="<?php echo $h['kelamin'] ?>">
                        <?php echo $h['nama_karyawan'] ?>
                    </option>
                <?php endforeach; ?>
            `;
            const div = document.createElement("div");
            div.classList.add("nama_karyawan");
            div.innerHTML = `
                <select name="list_karyawan[]">
                    ${optionKaryawan}
                </select>
                <input type="text" name="jenis_kelamin" value="<?php echo $hasil[0]['kelamin'] ?>" disabled>
                <button type="button" class="hapus">-</button>
            `;
            container.appendChild(div);
        })

        const tanggalAwal = document.querySelector("input[name='tanggal_awal']");
        const tanggalAkhir = document.querySelector("input[name='tanggal_akhir']");
        tanggalAwal.addEventListener("change", function() {
            let minTanggal = new Date(this.value);
            minTanggal.setDate(minTanggal.getDate() + 6);
            const tahun = minTanggal.getFullYear();
            const bulan = String(minTanggal.getMonth() + 1).padStart(2, "0");
            const hari = String(minTanggal.getDate()).padStart(2, "0");
            const tanggalMin = `${tahun}-${bulan}-${hari}`;
            tanggalAkhir.min = tanggalMin;

            // otomatis isi jika kosong atau lebih kecil dari min
            if (
                !tanggalAkhir.value ||
                tanggalAkhir.value < tanggalMin
            ) {
                tanggalAkhir.value = tanggalMin;
            }
        });

        formK.addEventListener("submit", function(input) {
            const list_karyawan = document.querySelectorAll(".nama_karyawan")
            let valid_list = false
            if ((list_karyawan.length >= 8) && (list_karyawan.length <= 15)) {
                valid_list = true
            }

            const jumlah_shift = parseInt(document.getElementById("jumlah_shift").value);
            const jumlah_karyawan_per_shift = parseInt(document.getElementById("jumlah_karyawan").value);
            const kebutuhan_harian = jumlah_shift * jumlah_karyawan_per_shift;
            const min_karyawan_sehat = Math.ceil(kebutuhan_harian * 1.2);

            let valid_sehat = true;
            if (list_karyawan.length < min_karyawan_sehat) {
                valid_sehat = false;
            }

            const karyawan = document.querySelectorAll("select[name='list_karyawan[]']")
            let valid_kelamin = true
            let jumlah = 0
            karyawan.forEach(i => {
                const aksesOpsi = i.options[i.selectedIndex]
                const kelamin = aksesOpsi.dataset.kelamin
                if (kelamin == "L") {
                    jumlah++;
                }
            });
            if (jumlah < 2) {
                valid_kelamin = false
            }

            let valid_unik = true
            let list = []
            karyawan.forEach(i => {
                if (list.includes(i.value)) {
                    valid_unik = false
                }
                list.push(i.value)
            });

            if (!(valid_list && valid_sehat && valid_kelamin && valid_unik)) {
                let pesan_kelamin = "";
                let pesan_unik = "";
                let pesan_minimal = "";
                let pesan_sehat = "";
                if (!valid_kelamin) {
                    pesan_kelamin = "- Minimal ada 2 laki - laki\n"
                }
                if (!valid_unik) {
                    pesan_unik = "- Tidak boleh ada karyawan duplikat\n"
                }
                if (!valid_list) {
                    pesan_minimal = "- Jumlah karyawan 8 - 15\n"
                }
                if (!valid_sehat) {
                    pesan_sehat = `- Jumlah karyawan terpilih (${list_karyawan.length} orang) kurang dari batas minimum libur sehat (${min_karyawan_sehat} orang) untuk ${jumlah_shift} shift dengan ${jumlah_karyawan_per_shift} karyawan per shift agar terhindar dari kerja rodi tanpa libur.\n`
                }
                alert(
                    `Gagal mengirim form:\n\n` +
                    `${pesan_kelamin}` +
                    `${pesan_unik}` +
                    `${pesan_minimal}` +
                    `${pesan_sehat}`
                )
                input.preventDefault()
            }
        })
    </script>
</body>

</html>