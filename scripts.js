window.onload = function() {
    if(window.location.pathname === '/index.php') {
        const login = document.getElementById('login-button');
        login.style.background = 'teal';
        login.style.color = 'white';
    }
    else {
        document.getElementById('login-button').style.background = 'white';
        document.getElementById('login-button').style.color = 'teal';
    }
    
    if(window.location.pathname === '/register.php') {
        const signup = document.getElementById('signup-button');
        signup.style.background = 'teal';
        signup.style.color = 'white';
    }
}

const preventSubmit = (e) => {
    e.preventDefault();
    return false;
}