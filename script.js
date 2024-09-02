const toggleCheckbox = document.getElementById('toggleCheckbox');
const body = document.body;

toggleCheckbox.addEventListener('change', function() {
    body.classList.toggle('dark-mode');

    const isDarkMode = body.classList.contains('dark-mode');
    localStorage.setItem('dark-mode', isDarkMode);


});

document.addEventListener('DOMContentLoaded', function() {
    const isDarkMode = localStorage.getItem('dark-mode');

if (isDarkMode === 'true') {
    body.classList.add('dark-mode');

    toggleCheckbox.checked = true;
}
});
