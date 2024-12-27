// document.querySelector('form').addEventListener('submit', function (event) {
//     var new_password = document.getElementById('new_password').value;

//     if (new_password === '') {
//         alert('New Password tidak boleh kosong!');
//         event.preventDefault();
//     }
// });


document.getElementById("resetForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const oldPassword = document.getElementById("old_password").value;
    const newPassword = document.getElementById("new_password").value;

    const errorMessage = document.getElementById("errorMessage");
    const successMessage = document.getElementById("successMessage");

    // Reset pesan error dan sukses
    errorMessage.style.display = "none";
    successMessage.style.display = "none";

    // Validasi input
    if (newPassword === '') {
        alert('New Password tidak boleh kosong!');
        return;
    }

    try {
        const response = await fetch("http://localhost/TODOLIST_API/Backend/API/reset.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ username, old_password: oldPassword, new_password: newPassword }),
        });

        const result = await response.json();

        if (response.ok) {
            successMessage.style.display = "block";
            successMessage.textContent = result.message;
            setTimeout(() => {
                window.location.href = "login.html";
            }, 2000); // Redirect setelah 2 detik
        } else {
            errorMessage.style.display = "block";
            errorMessage.textContent = result.error;
        }
    } catch (error) {
        console.error("Error:", error);
        errorMessage.style.display = "block";
        errorMessage.textContent = "Terjadi kesalahan. Silakan coba lagi.";
    }
});
