// document.querySelector('form').addEventListener('submit', function (event) {
//     var username = document.getElementById('username').value;
//     var password = document.getElementById('password').value;
//     var confirm_password = document.getElementById('confirm_password').value;

//     if (username === '' || password === '' || confirm_password === '') {
//         alert('Mohon isi semua form!');
//         event.preventDefault();
//     } else if (password !== confirm_password) {
//         alert('Password dan konfirmasi password tidak cocok!');
//         event.preventDefault();
//     }
// });


document.querySelector('form').addEventListener('submit', async function (event) {
    event.preventDefault();  // Prevent the default form submission

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const errorMessage = document.getElementById("errorMessage");

    // Validasi form
    if (username === '' || password === '' || confirmPassword === '') {
        alert('Mohon isi semua form!');
        return;
    }

    if (password !== confirmPassword) {
        alert('Password dan konfirmasi password tidak cocok!');
        return;
    }

    try {
        // Kirim data registrasi ke backend
        // const response = await fetch("http://localhost/TODOLIST_API/Backend/API/register.php", {
        const response = await fetch("http://localhost/TODOLIST_API/Backend/API/regis.php", {

            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ username, password, confirm_password: confirmPassword }),
        });

        const result = await response.json();

        if (response.ok) {
            // Jika registrasi berhasil, tampilkan pesan dan arahkan ke halaman login
            alert(result.message);
            window.location.href = "login.html";
        } else {
            // Tampilkan pesan error jika ada
            errorMessage.style.display = "block";
            errorMessage.textContent = result.error;
        }
    } catch (error) {
        console.error("Error:", error);
        errorMessage.style.display = "block";
        errorMessage.textContent = "Terjadi kesalahan. Silakan coba lagi.";
    }
});
