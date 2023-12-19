function cookie() {
    window.onload = function() {
        document.getElementById('cookie-notification').classList.remove('translate-y-full');
    };
    
    document.getElementById('accept-cookies').addEventListener('click', function() {
        document.getElementById('cookie-notification').classList.add('translate-y-full');
    });

    }
export { cookie };
