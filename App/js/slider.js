import $ from "jquery";

/**
 * Funció per gestionar el component del control deslitzant.
 */
function slider() {
    // Obté els elements DOM per al control deslitzant, el botó Següent i el botó Anterior
    const sliderElement = $("#slider");
    const nextButton = $("#next");
    const prevButton = $("#prev");

    // Verifica si tots els elements necessaris existeixen, si no, surt de la funció
    if (!sliderElement.length || !nextButton.length || !prevButton.length) {
        return;
    }

    // Inicialitza algunes variables
    let defaultTransform = 0;
    let cardWidth = calculateCardWidth();
    const cardsPerMove = calculateCardsPerMove();

    // Gestiona l'actualització de la mida de la finestra
    $(window).on("resize", function () {
        cardWidth = calculateCardWidth();
        updateSliderTransform();
    });

    /**
     * Calcula l'amplada de cada targeta en funció de la mida de la finestra.
     *
     * @return {number} - Amplada de la targeta.
     */
    function calculateCardWidth() {
        const desktopWidth = 768;
        const maxWidth = 1210;
        const minWidth = 392.5;
        const windowWidth = $(window).width();

        if (windowWidth >= desktopWidth) {
            return maxWidth;
        } else {
            return Math.min(minWidth, windowWidth);
        }
    }

    /**
     * Calcula la quantitat de targetes a moure per cada desplaçament.
     *
     * @return {number} - Quantitat de targetes a moure.
     */
    function calculateCardsPerMove() {
        return Math.floor($(window).width() / cardWidth);
    }

    /**
     * Desplaça el control deslitzant a la següent posició.
     */
    function goNext() {
        defaultTransform -= cardWidth * cardsPerMove;
        updateSliderTransform();
    }

    // Assigna l'esdeveniment de clic al botó Següent
    nextButton.on("click", goNext);

    /**
     * Desplaça el control deslitzant a la posició anterior.
     */
    function goPrev() {
        defaultTransform += cardWidth * cardsPerMove;
        updateSliderTransform();
    }

    // Assigna l'esdeveniment de clic al botó Anterior
    prevButton.on("click", goPrev);

    /**
     * Actualitza la transformació CSS per al control deslitzant.
     */
    function updateSliderTransform() {
        // Verifica si s'ha arribat al final del control deslitzant
        if (Math.abs(defaultTransform) >= sliderElement[0].scrollWidth) {
            defaultTransform = 0; // Torna a la posició inicial
        }

        // Verifica si s'ha arribat al principi del control deslitzant
        if (defaultTransform > 0) {
            defaultTransform = -sliderElement[0].scrollWidth + sliderElement.width();
        }

        // Aplica la transformació CSS per desplaçar el control deslitzant
        sliderElement.css("transform", "translateX(" + defaultTransform + "px)");
    }
}

export { slider };