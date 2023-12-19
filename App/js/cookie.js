function cookie() {
    document.addEventListener('DOMContentLoaded', function() {
        var cookieNotification = document.getElementById('cookie-notification');
        if (cookieNotification) {
            cookieNotification.classList.remove('translate-y-full');
        }

        var acceptCookies = document.getElementById('accept-cookies');
        if (acceptCookies) {
            acceptCookies.addEventListener('click', function() {
                if (cookieNotification) {
                    cookieNotification.classList.add('translate-y-full');
                }
            });
        }
    });
}
export { cookie };
