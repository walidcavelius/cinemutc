document.addEventListener('htmx:configRequest', (event) => {
    event.detail.headers['X-CSRF-Token'] = 'your-csrf-token-here';
});