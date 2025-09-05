const passwordInput = document.getElementById("password");
const confirmPasswordInput = document.getElementById("confirm");
const generateButton = document.getElementById("generate-password");

function generatePassword() {
    const length = parseInt(prompt('Enter password Length (Default: 12)')) || 12;
    const useUppercase = confirm('Include Uppercase letters ?');
    const useNumbers = confirm('Include Numbers?');
    const useSpecilaChars = confirm('Include special characters?');
    let chars = 'abcdefghijklmnopqrstuvwxyz';
    if (useUppercase) chars += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (useNumbers) chars += '0123456789';
    if (useSpecilaChars) chars += '!@#$%^&*()_`|}{[]:;?><,./-=';
    let password = "";
    for (let i = 0; i < length; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    passwordInput.value = password;
    confirmPasswordInput.value = password;
}
generateButton.addEventListener('click', generatePassword);
passwordInput.addEventListener('focus', generatePassword);
