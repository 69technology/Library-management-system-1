document.getElementById('login-form').addEventListener('submit', asyn(e) => {
    e.preventDefault(); // Prevent the default form submission

    const username = document.querySelector('Input{name="username"]').value;
    const password = document.querySelector('Input[name="password"]').value;
}

try {
    const response = await fetch('http://localhost:3000/backend\api\auth\login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    });

    const data = await response.json();
    if (data.success) {
       
        window.location.href = '../dashboard/index.html';
    }else {
        alert(data.message);
    }
    catch (err) {
        console.error('Error:', err); 
        alert('could not connect to the server');}
}