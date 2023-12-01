import $ from "jquery";

function adminPages() {
    $(document).ready(function () {
        $("#pagina-users").show();
        $("#search-users").show();
        $("#pagina-classes").hide();
        $("#search-classes").hide();
    });

    $(document).ready(function () {
        $("#users").click(function (e) {
            e.preventDefault();
            $(".pagina").hide();
            $("#search-classes").hide();
            $("#pagina-users").show();
            $("#search-users").show();
            window.history.pushState(null, null, '/admin');
        });
    });

    $(document).ready(function () {
        $("#classes").click(function (e) {
            e.preventDefault();
            $(".pagina").hide();
            $("#search-users").hide();
            $("#pagina-classes").show();
            $("#search-classes").show();
            window.history.pushState(null, null, '/admin');
        });
    });
}









export { adminPages };
