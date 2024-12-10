// const passwordInput =document.getElementById("password");
// const confirmPasswordInput =document.getElementById("confirm");
// const generateButton =document.getElementById("generate-password");

// function generatePassword(){
//     const length = parseInt(prompt('Enter password Length (Default: 12)')) || 12;
//     const useUppercase = confirm('Include Uppercase letters ?');
//     const useNumbers = confirm('Include Numbers?');
//     const useSpecilaChars = confirm('Include special characters?');
//     let chars =+ 'abcdefghijklmnopqrstuvwxyz';
//     if(useUppercase) chars +='0123456789';
//     if(useSpecilaChars) chars += '!@#$%^&*()_`|}{[]:;?><,./-=';

//     let password = "";
//     for(let i=0; i<length; i++){
//         password += chars.charAt(math.floor(Math.random() * chars.length));
//         passwordInput.value = password;
//         confirmPasswordInput.value =password;
//     }
// }
// generateButton.addEventListener('click' generatePassword,);
// passwordInput.addEventListener('focus' generatePassword,);


document.getElementById('password').addEventListener('focus', function() {
    const suggestedPassword = generatePassword(12);
    const suggestionDiv = document.getElementById('suggestion');
    suggestionDiv.textContent = `Suggested Password: ${suggestedPassword}`;
    suggestionDiv.style.display = 'block';

    // Add click event to the suggestion
    suggestionDiv.onclick = function() {
        document.getElementById('password').value = suggestedPassword; 
        document.getElementById('confirm_password').value = suggestedPassword; // Set the same password in confirm field
        suggestionDiv.style.display = 'none'; // Hide suggestion after accepting
    };
});

function generatePassword(length) {
    const lowercase = 'abcdefghijklmnopqrstuvwxyz';
    const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const numbers = '0123456789';
    const symbols = '!@#$%^&*()';
    const allCharacters = lowercase + uppercase + numbers + symbols;

    let password = '';
    password += getRandomCharacter(lowercase); 
    password += getRandomCharacter(uppercase); 
    password += getRandomCharacter(numbers); 
    password += getRandomCharacter(symbols); 

    for (let i = 4; i < length; i++) {
        password += getRandomCharacter(allCharacters);
    }

    return shuffleString(password); 
}

function getRandomCharacter(characters) {
    const randomIndex = Math.floor(Math.random() * characters.length);
    return characters[randomIndex];
}

function shuffleString(string) {
    const array = string.split('');
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        // swap elements
        [array[i], array[j]] = [array[j], array[i]]; 
    }
    return array.join('');
}