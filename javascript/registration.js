var eye = document.getElementById("pwd_eye");
var eye_repeat = document.getElementById("pwd_eye_repeat");
var password = document.getElementById("pwd");
var password_repeat = document.getElementById("pwdRepeat");
var signup_submit = document.getElementById("signup_submit");

eye.addEventListener('click', toggleEye);
eye_repeat.addEventListener('click', toggleEyeRepeat);

password.addEventListener('keyup', checkPasswordValidity);
password_repeat.addEventListener('keyup', checkPasswordRepeatValidity);

signup_submit.addEventListener('click', function (event) {
    if (password.value.length < 6 || password_repeat.value.length < 6) {
        event.preventDefault();
        return false;
    }
})

function toggleEye() {

    if (eye.classList.contains('active') ? eye.classList.remove('active') : eye.classList.add('active'));

    if (password.type === "password" ? password.type = "text" : password.type = "password");

}

function toggleEyeRepeat() {

    if (eye_repeat.classList.contains('active') ? eye_repeat.classList.remove('active') : eye_repeat.classList.add('active'));

    if (password_repeat.type === "password" ? password_repeat.type = "text" : password_repeat.type = "password");

}

function checkPasswordValidity() {
    var symbol = document.getElementById("pwd_validity");
    if (password.value.length < 6) {
        symbol.classList.remove('ready');
        symbol.classList.add('active');
        symbol.innerHTML = "✖";
    } else {
        symbol.classList.remove('active');
        symbol.classList.add('ready');
        symbol.innerHTML = "✔";
    }

}

function checkPasswordRepeatValidity() {
    var symbol = document.getElementById("pwd_validity_repeat");
    if (password_repeat.value.length < 6 || password_repeat.value !== password.value) {
        symbol.classList.remove('ready');
        symbol.classList.add('active');
        symbol.innerHTML = "✖";
    } else {
        symbol.classList.remove('active');
        symbol.classList.add('ready');
        symbol.innerHTML = "✔";
    }
}