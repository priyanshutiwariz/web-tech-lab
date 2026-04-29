function getStoredUser() {
    try {
        return JSON.parse(localStorage.getItem('priyanshuStoreUser')) || null;
    } catch {
        return null;
    }
}

function saveUser(user) {
    localStorage.setItem('priyanshuStoreUser', JSON.stringify(user));
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function showMessage(element, text, type) {
    element.textContent = text;
    element.className = `message ${type}`;
    element.style.display = 'block';
}

function hideMessage(element) {
    element.style.display = 'none';
}

function validateLogin() {
    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value.trim();
    const message = document.getElementById('loginMessage');
    const stored = getStoredUser();

    if (!email || !password) {
        showMessage(message, 'Please enter both email and password.', 'error');
        return false;
    }

    if (!isValidEmail(email)) {
        showMessage(message, 'Enter a valid email address.', 'error');
        return false;
    }

    if (!stored) {
        showMessage(message, 'No registered account found. Please register first.', 'error');
        return false;
    }

    if (email !== stored.email || password !== stored.password) {
        showMessage(message, 'Email or password does not match.', 'error');
        return false;
    }

    showMessage(message, 'Login successful! You can now proceed to checkout.', 'success');
    return false;
}

function validateRegister() {
    const name = document.getElementById('registerName').value.trim();
    const email = document.getElementById('registerEmail').value.trim();
    const password = document.getElementById('registerPassword').value.trim();
    const confirm = document.getElementById('registerConfirm').value.trim();
    const message = document.getElementById('registerMessage');

    if (!name || !email || !password || !confirm) {
        showMessage(message, 'All fields are required.', 'error');
        return false;
    }

    if (name.length < 3) {
        showMessage(message, 'Please enter your full name.', 'error');
        return false;
    }

    if (!isValidEmail(email)) {
        showMessage(message, 'Please enter a valid email address.', 'error');
        return false;
    }

    if (password.length < 8) {
        showMessage(message, 'Password must be at least 8 characters.', 'error');
        return false;
    }

    if (password !== confirm) {
        showMessage(message, 'Passwords do not match.', 'error');
        return false;
    }

    saveUser({ name, email, password });
    showMessage(message, 'Registration successful. Login with your new account.', 'success');
    document.getElementById('registerForm').reset();
    return false;
}
