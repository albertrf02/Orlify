/**
 * Function that handles the cookie notification.
 */
function cookie() {
    /**
     * Listens for the 'DOMContentLoaded' event
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Gets the cookie notification element
        var cookieNotification = document.getElementById('cookie-notification');
        // If the cookie notification element exists
        if (cookieNotification) {
            // Removes the 'translate-y-full' class from the cookie notification element
            cookieNotification.classList.remove('translate-y-full');
        }

        // Gets the accept cookies element
        var acceptCookies = document.getElementById('accept-cookies');
        // If the accept cookies element exists
        if (acceptCookies) {
            // Adds a click event listener to the accept cookies element
            acceptCookies.addEventListener('click', function() {
                // If the cookie notification element exists
                if (cookieNotification) {
                    // Adds the 'translate-y-full' class to the cookie notification element
                    cookieNotification.classList.add('translate-y-full');
                }
            });
        }
    });
}

// Exports the cookie function
export { cookie };
