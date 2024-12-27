// document.addEventListener('DOMContentLoaded', function () {
//     var todolistItems = document.querySelectorAll('#todolist li');

//     todolistItems.forEach(function (item, index) {
//         setTimeout(function () {
//             item.style.animation = 'expand 0.8s ease-out';
//         }, index * 100);
//     });
// });


document.addEventListener('DOMContentLoaded', function () {
    var todolistItems = document.querySelectorAll('#todolist li');

    todolistItems.forEach(function (item, index) {
        setTimeout(function () {
            item.style.animation = 'expand 0.8s ease-out';
        }, index * 100);
    });

    // Panggil fetchTasks setelah DOM dimuat
    fetchTasks();
});

const todolist = document.getElementById('todolist');
const taskForm = document.getElementById('taskForm');
const taskInput = document.getElementById('taskInput');
const logoutButton = document.getElementById('logoutButton');

// Fetch tasks
async function fetchTasks() {
    const response = await fetch('http://localhost/TODOLIST_API/Backend/API/todolist.php');
    const tasks = await response.json();
    todolist.innerHTML = ''; // Clear the todolist before updating
    tasks.forEach(task => {
        const li = document.createElement('li');
        li.innerHTML = `
            ${task.task} <small>${task.timestamp}</small>
            <button onclick="updateTask(${task.id}, '1')"><i class="fa-solid fa-check"></i></button>
            <button onclick="deleteTask(${task.id})"><i class="fa-solid fa-trash"></i></button>
        `;
        todolist.appendChild(li);
    });

    // Apply animation to the new list items
    var todolistItems = document.querySelectorAll('#todolist li');
    todolistItems.forEach(function (item, index) {
        setTimeout(function () {
            item.style.animation = 'expand 0.8s ease-out';
        }, index * 100);
    });
}

// Add task
taskForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const task = taskInput.value;
    if (!task) return alert('Task cannot be empty');
    const response = await fetch('http://localhost/TODOLIST_API/Backend/API/todolist.php', {
        method: 'POST',
        body: new URLSearchParams({ task })
    });
    const result = await response.json();
    if (result.error) {
        alert(result.error);
    } else {
        fetchTasks(); // Fetch tasks after adding a new one
    }
    taskInput.value = '';
});

// Update task status
async function updateTask(id, status) {
    const response = await fetch('http://localhost/TODOLIST_API/Backend/API/todolist.php', {
        method: 'PUT',
        body: new URLSearchParams({ id, status })
    });
    const result = await response.json();
    if (result.error) {
        alert(result.error);
    } else {
        fetchTasks();
    }
}

// Delete task
async function deleteTask(id) {
    const response = await fetch('http://localhost/TODOLIST_API/Backend/API/todolist.php', {
        method: 'DELETE',
        body: new URLSearchParams({ id })
    });
    const result = await response.json();
    if (result.error) {
        alert(result.error);
    } else {
        fetchTasks();
    }
}

// Logout
logoutButton.addEventListener('click', async (e) => {
    e.preventDefault();

    try {
        const response = await fetch('http://localhost/TODOLIST_API/Backend/API/logout.php', {
            method: 'POST',
        });

        const result = await response.json();

        if (response.ok) {
            // Logout sukses, arahkan kembali ke halaman login
            window.location.href = 'login.html';
        } else {
            console.error(result.error);
            alert('Logout failed. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Something went wrong. Please try again later.');
    }
});
