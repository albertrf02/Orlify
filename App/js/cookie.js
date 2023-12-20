/**
 * Gestiona la notificació de galetes (cookies) en una pàgina web.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function cookie() {
    document.addEventListener('DOMContentLoaded', function() {
        // Obté una referència a l'element de la notificació de galetes
        var cookieNotification = document.getElementById('cookie-notification');
        
        // Comprova si l'element de la notificació de galetes existeix
        if (cookieNotification) {
            // Elimina la classe 'translate-y-full' per mostrar la notificació
            cookieNotification.classList.remove('translate-y-full');
        }

        // Obté una referència a l'element de botó per acceptar les galetes
        var acceptCookies = document.getElementById('accept-cookies');
        
        // Comprova si l'element de botó per acceptar les galetes existeix
        if (acceptCookies) {
            // Afegix un esdeveniment de clic al botó per acceptar les galetes
            acceptCookies.addEventListener('click', function() {
                // Comprova si l'element de la notificació de galetes existeix
                if (cookieNotification) {
                    // Afegeix la classe 'translate-y-full' per amagar la notificació
                    cookieNotification.classList.add('translate-y-full');
                }
            });
        }
    });
}

export { cookie };