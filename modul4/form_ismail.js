const form = document.getElementById('myForm');
form.addEventListener('submit', (event) => {
    event.preventDefault();

    const namaLengkap = document.getElementById('namaLengkap').value;
    const nim = document.getElementById('nim').value;
    const email = document.getElementById('email').value;
    const pesan = document.getElementById('pesan').value;

    let isValid = true;

    if (namaLengkap.trim() === '') {
        document.getElementById('namaLengkapError').textContent = 'Nama lengkap tidak boleh kosong';
        isValid = false;
    } else if (!/^[a-zA-Z\s]+$/.test(namaLengkap)) {
        document.getElementById('namaLengkapError').textContent = 'Nama lengkap hanya boleh berisi huruf';
        isValid = false;
    } else if (namaLengkap.length < 3) {
        document.getElementById('namaLengkapError').textContent = 'Nama lengkap minimal 3 huruf';
        isValid = false;
    } else {
        document.getElementById('namaLengkapError').textContent = '';
    }

    if (nim.trim() === '') {
        document.getElementById('nimError').textContent = 'NIM tidak boleh kosong';
        isValid = false;
    } else if (!/^\d+$/.test(nim)) {
        document.getElementById('nimError').textContent = 'NIM hanya boleh berisi angka';
        isValid = false;
    } else if (nim.length < 12) {
        document.getElementById('nimError').textContent = 'NIM minimal 12 angka';
        isValid = false;
    } else {
        document.getElementById('nimError').textContent = '';
    }

    if (email.trim() === '') {
        document.getElementById('emailError').textContent = 'Email tidak boleh kosong';
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(email)) {
        document.getElementById('emailError').textContent = 'Format email tidak valid';
        isValid = false;
    } else {
        document.getElementById('emailError').textContent = '';
    }

    if (pesan.length > 200) {
        document.getElementById('pesanError').textContent = 'Pesan tidak boleh lebih dari 200 karakter';
        isValid = false;
    } else {
        document.getElementById('pesanError').textContent = '';
    }

    if (isValid) {
        alert('Form Berhasil di-Submit');
        window.location.href = 'modul2/home.html';
    }
});