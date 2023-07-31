// file validation.js
export function validateInputName(name) {
    if (name.length < 4) {
        return 'minimal 4 karakter';
    } else if (name.length > 14) {
        return 'maksimal 14 karakter';
    } else if (!/^[a-zA-Z\s]+$/.test(name.trim())) {
        return 'hanya karakter alphabet';
    } else {
        return '';
    }
}

export function validateInputUsername(username) {
    if (username.length < 3) {
        return 'minimal 3 karakter';
    } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
        return 'hanya karakter alfanumerik dan underscore';
    } else {
        return '';
    }
}

export function validateInputEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailRegex.test(email)) {
        return '';
    } else {
        return 'Format email tidak valid';
    }
}

export function validateInputPassword(password) {
    if (password.length < 5) {
        return 'minimal 5 karakter';
    } else if (password.length > 12) {
        return 'maksimal 12 karakter';
    } else if (!/^[a-zA-Z0-9]+$/.test(password)) {
        return 'hanya karakter alfanumerik';
    } else {
        return '';
    }
}
