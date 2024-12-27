// document.querySelector('form').addEventListener('submit', function (event) {
//     var username = document.getElementById('username').value;
//     var password = document.getElementById('password').value;

//     if (username === '' || password === '') {
//         alert('Mohon isi semua form!');
//         event.preventDefault();
//     }
// });

// document.querySelector('form').addEventListener('submit', async function (event) {
//     event.preventDefault(); // Mencegah form untuk submit otomatis

//     var username = document.getElementById('username').value;
//     var password = document.getElementById('password').value;
//     const errorMessage = document.getElementById("error-message");

//     // Validasi form: pastikan username dan password tidak kosong
//     if (username === '' || password === '') {
//         alert('Mohon isi semua form!');
//         return;
//     }

//     try {
//         // Kirim request login ke server
//         const response = await fetch("http://localhost/TODOLIST_API/Backend/API/login.php", {
//             method: "POST",
//             headers: { "Content-Type": "application/x-www-form-urlencoded" },
//             body: new URLSearchParams({ username, password }),
//         });

//         const result = await response.json();

//         if (response.ok) {
//             // Login sukses, arahkan ke halaman home
//             window.location.href = "home.html";
//         } else {
//             // Tampilkan pesan error jika login gagal
//             errorMessage.style.display = "block";
//             errorMessage.textContent = result.error;
//         }
//     } catch (error) {
//         // Tangani error jika ada masalah dalam melakukan request
//         console.error("Error:", error);
//         errorMessage.style.display = "block";
//         errorMessage.textContent = "Something went wrong. Please try again later.";
//     }
// });


document.querySelector('form').addEventListener('submit', async function (event) {
    event.preventDefault(); // Mencegah form untuk submit otomatis

    const username = document.getElementById('username').value.trim(); // Menghilangkan spasi di awal/akhir
    const password = document.getElementById('password').value.trim(); // Menghilangkan spasi di awal/akhir
    const errorMessage = document.getElementById("error-message");

    // Validasi form: pastikan username dan password tidak kosong
    if (username === '' || password === '') {
        alert('Mohon isi semua form!');
        return;
    }

    try {
        // Kirim request login ke server
        const response = await fetch("http://localhost/TODOLIST_API/Backend/API/login.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ username, password }),
        });

        const result = await response.json();

        if (response.ok) {
            // Login sukses, arahkan ke halaman home
            alert("Login berhasil! Anda akan diarahkan ke halaman utama.");
            window.location.href = "home.html";
        } else {
            // Tampilkan pesan error jika login gagal
            errorMessage.style.display = "block";
            errorMessage.textContent = result.error || "Login gagal. Silakan coba lagi.";
        }
    } catch (error) {
        // Tangani error jika ada masalah dalam melakukan request
        console.error("Error:", error);
        errorMessage.style.display = "block";
        errorMessage.textContent = "Terjadi kesalahan. Silakan coba lagi.";
    }
});

