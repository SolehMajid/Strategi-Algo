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
                    <?php foreach($hasil as $h): ?>
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

        container.addEventListener("change", function(input){
            if(input.target.matches("select[name='list_karyawan[]']")){
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
                <?php foreach($hasil as $h): ?>
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
            if((list_karyawan.length >= 8) && (list_karyawan.length <= 15)) {
                valid_list = true
            }

            const karyawan = document.querySelectorAll("select[name='list_karyawan[]']")
            let valid_kelamin = true
            let jumlah = 0
            karyawan.forEach(i => {
                const aksesOpsi = i.options[i.selectedIndex]
                const kelamin = aksesOpsi.dataset.kelamin
                if(kelamin == "L") {
                    jumlah++;
                }
            });
            if(jumlah < 2) {
                valid_kelamin = false
            }

            let valid_unik = true
            let list = []
            karyawan.forEach(i => {
                if(list.includes(i.value)) {
                    valid_unik = false
                }
                list.push(i.value)
            });

            if(!(valid_list && valid_kelamin && valid_unik)) {
                let pesan_kelamin = "";
                let pesan_unik = "";
                let pesan_minimal = "";
                if(!valid_kelamin) {
                    pesan_kelamin = "- Minimal ada 2 laki - laki"
                }
                if(!valid_unik) {
                    pesan_unik = "- Tidak boleh ada karyawan duplikat"
                }
                if(!valid_list) {
                    pesan_minimal = "- Jumlah karyawan 8 - 15"
                }
                alert(
                    `
                    ${pesan_kelamin}
                    ${pesan_unik}
                    ${pesan_minimal}
                    `
                )
                input.preventDefault()
            }
        })
    </script>
</body>
</html>