// Dark mode toggle for login/register nav
window.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('darkmode-toggle');
    if (!toggle) return;
    toggle.addEventListener('click', () => {
        const html = document.documentElement;
        const isDark = html.classList.toggle('dark');
        localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
        // Change icons
        document.getElementById('icon-moon').classList.toggle('hidden', isDark);
        document.getElementById('icon-sun').classList.toggle('hidden', !isDark);
    });
    // Set correct icon on load
    const isDark = document.documentElement.classList.contains('dark');
    document.getElementById('icon-moon').classList.toggle('hidden', isDark);
    document.getElementById('icon-sun').classList.toggle('hidden', !isDark);
});
