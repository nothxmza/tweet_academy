const nameInput = document.getElementById('name');
const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const monthSelect = document.getElementById('month-select');
const daySelect = document.getElementById('day-select');
const yearSelect = document.getElementById('year-select');
const passwordInput = document.getElementById('password');
const submitButton = document.querySelector('input[type="submit"]');

const daybox = document.getElementsByClassName('select-container');

nameInput.addEventListener('input', validateForm);
usernameInput.addEventListener('input', validateForm);
emailInput.addEventListener('input', validateForm);
monthSelect.addEventListener('input', validateForm);
daySelect.addEventListener('input', validateForm);
yearSelect.addEventListener('input', validateForm);
passwordInput.addEventListener('input', validateForm);

function validateForm() {
    if (nameInput.value != "" && usernameInput.value != "" && emailInput.value != "" && monthSelect.value != "none" && daySelect.value != "none" && yearSelect.value != "none" && passwordInput.value != "") {
        
        let date = new Date();
        let monthSelectValue = monthSelect.value;
        let daySelectValue = daySelect.value;
        if ( daySelectValue.charAt(0) == '0' ) {
            daySelectValue = daySelectValue.slice(-1);
        }
        if ( monthSelectValue.charAt(0) == '0' ) {
            monthSelectValue = monthSelectValue.slice(-1);
        }

        if (yearSelect.value > date.getFullYear() - 13) {
            submitButton.disabled = true;
            daybox[0].style.border = "1px solid rgb(255, 0, 0)";
            daybox[1].style.border = "1px solid rgb(255, 0, 0)";
            daybox[2].style.border = "1px solid rgb(255, 0, 0)";
        } else if (yearSelect.value == date.getFullYear() - 13) {
            if (monthSelectValue > date.getMonth() + 1) {
                submitButton.disabled = true;
                daybox[0].style.border = "1px solid rgb(255, 0, 0)";
                daybox[1].style.border = "1px solid rgb(255, 0, 0)";
                daybox[2].style.border = "1px solid rgb(255, 0, 0)";
            } else if (monthSelectValue == date.getMonth() + 1) {
                if (daySelect.value > date.getDate()) {
                    submitButton.disabled = true;
                    daybox[0].style.border = "1px solid rgb(255, 0, 0)";
                    daybox[1].style.border = "1px solid rgb(255, 0, 0)";
                    daybox[2].style.border = "1px solid rgb(255, 0, 0)";
                } else {
                    submitButton.disabled = false;
                    daybox[0].style.border = "1px solid #ccc";
                    daybox[1].style.border = "1px solid #ccc";
                    daybox[2].style.border = "1px solid #ccc";
                    daybox[0].style.borderRadius = "2px";
                    daybox[1].style.borderRadius = "2px";
                    daybox[2].style.borderRadius = "2px";
                }
            } else {
                submitButton.disabled = false;
                daybox[0].style.border = "1px solid #ccc";
                daybox[1].style.border = "1px solid #ccc";
                daybox[2].style.border = "1px solid #ccc";
                daybox[0].style.borderRadius = "2px";
                daybox[1].style.borderRadius = "2px";
                daybox[2].style.borderRadius = "2px";
            }
        } else {
            submitButton.disabled = false;
            daybox[0].style.border = "1px solid #ccc";
            daybox[1].style.border = "1px solid #ccc";
            daybox[2].style.border = "1px solid #ccc";
            daybox[0].style.borderRadius = "2px";
            daybox[1].style.borderRadius = "2px";
            daybox[2].style.borderRadius = "2px";
        }
    } else {
        submitButton.disabled = true;  
    }
}