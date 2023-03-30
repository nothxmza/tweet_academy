document.addEventListener('DOMContentLoaded', function () {
    var checkbox = document.getElementById('dark_mode');
    var select = document.getElementById('lang');
    var options = select.options;

    checkbox.addEventListener('change', function () {
        if (checkbox.checked) {
            // Set dark mode styles
            document.body.style.backgroundColor = 'black';
            document.body.style.color = '#2b4365';
            select.style.color = '#2b4365';
            for (var i = 0; i < options.length; i++) {
                options[i].style.color = '#2b4365';
                options[i].style.backgroundColor = 'black';
            }
            // Store preference in local storage
            localStorage.setItem('dark_mode', 'true');
        } else {
            // Set light mode styles
            document.body.style.backgroundColor = '#2b4365';
            document.body.style.color = 'black';
            select.style.color = 'black';
            for (var i = 0; i < options.length; i++) {
                options[i].style.color = 'black';
                options[i].style.backgroundColor = '#2b4365';
            }
            // Remove preference from local storage
            localStorage.removeItem('dark_mode');
        }
    });
});
