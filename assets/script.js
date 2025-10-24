
const toggle = document.getElementById('toggleDark');
const html = document.documentElement;

// Load saved theme on page load
const savedTheme = localStorage.getItem('theme');
if (savedTheme === 'dark') {
 html.classList.add('dark');
 toggle.checked = true; // reflect switch position
} else {
 html.classList.remove('dark');
 toggle.checked = false;
}

// Toggle dark mode on switch click
toggle.addEventListener('change', () => {
 html.classList.toggle('dark');
 const newTheme = html.classList.contains('dark') ? 'dark' : 'light';
 localStorage.setItem('theme', newTheme);
});
