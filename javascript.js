function openModal(id, nama, kelamin) {
    document.getElementById("modal").style.display = "block";
    document.querySelector("input[name='id_karyawan']").value = id
    document.querySelector("input[name='nama_karyawan']").value = nama
    document.querySelector("select[name='jenis_kelamin']").value = kelamin
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

const container = document.getElementById("container");
const formK = document.getElementById("formK")


function validateNama(input) {
    let nama = input.value.trim()
    if(/[\d]/.test(nama)) {
        input.value = nama.replace(/\d/g, "")
    } else if(/[^a-z\s]/i.test(nama)) {
        input.value = nama.replace(/[^a-z\s]/gi, "")
    } 
    return true
}

container.addEventListener("keyup", function(input) {
    if (input.target.classList.contains("input_nama")) {
        validateNama(input.target)
    }
})

formK.addEventListener("submit", function(input) {
    const input_nama = document.querySelectorAll(".input_nama")
    let valid_nama = true
    input_nama.forEach(i => {
        if(i.value.match(/[a-z]/gim).length < 3) {
            valid_nama = false
        }
    });
    
    const list_karyawan = document.querySelectorAll(".nama_karyawan")
    let valid_list = false
    if((list_karyawan.length >= 8) && (list_karyawan.length <= 15)) {
        valid_list = true
    }

    
    const jenis_kelamin = document.querySelectorAll("select[name='jenis_kelamin[]']")
    let valid_kelamin = true
    let jumlah = 0
    jenis_kelamin.forEach(i => {
        if(i.value == "L") {
            jumlah++;
        }
    });
    if(jumlah < 2) {
        valid_kelamin = false
    }

    if(!(valid_nama && valid_list && valid_kelamin)) {
        let pesan_nama = "";
        let pesan_kelamin = "";
        if(!valid_nama) {
            pesan_nama = "- Nama harus terdapat minimal 3 karakter"
        }
        if(!valid_kelamin) {
            pesan_kelamin = "- Minimal ada 2 laki - laki"
        }
        alert(
            `
            ${pesan_nama}
            ${pesan_kelamin}
            `
        )
        input.preventDefault()
    }
})

