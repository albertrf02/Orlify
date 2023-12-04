import $ from "jquery";

function adminPages() {
    $(document).ready(function () {
        $("#pagina-users").show();
        $("#pagina-classes").hide();
    });

    $(document).ready(function () {
        $("#users").click(function (e) {
            e.preventDefault();
            $(".pagina").hide();
            $("#pagina-users").show();
        });
    });

    $(document).ready(function () {
        $("#classes").click(function (e) {
            e.preventDefault();
            $(".pagina").hide();
            $("#pagina-classes").show();
            window.history.pushState(null, null, '/admin');
        });
    });
}

    
    function recoverPages() {
        $(document).ready(function () {
            $("#recover").click(function (e) {
                e.preventDefault();
                $("#pagina-recover").hide();
                $("#pagina-missatge").show();
            });
        });

    }






export { adminPages };
export { recoverPages };