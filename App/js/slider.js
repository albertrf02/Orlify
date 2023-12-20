import $ from "jquery";

function slider() {
    const sliderElement = $("#slider");
    const nextButton = $("#next");
    const prevButton = $("#prev");

    if (!sliderElement.length || !nextButton.length || !prevButton.length) {
        return;
    }

    let defaultTransform = 0;
    let cardWidth = calculateCardWidth();
    const cardsPerMove = calculateCardsPerMove();

    $(window).on("resize", function () {
        cardWidth = calculateCardWidth();
        updateSliderTransform();
    });

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

    function calculateCardsPerMove() {
        return Math.floor($(window).width() / cardWidth);
    }

    function goNext() {
        defaultTransform -= cardWidth * cardsPerMove;
        updateSliderTransform();
    }

    nextButton.on("click", goNext);

    function goPrev() {
        defaultTransform += cardWidth * cardsPerMove;
        updateSliderTransform();
    }

    prevButton.on("click", goPrev);

    function updateSliderTransform() {
        if (Math.abs(defaultTransform) >= sliderElement[0].scrollWidth) {
            defaultTransform = 0;
        }

        if (defaultTransform > 0) {
            defaultTransform = -sliderElement[0].scrollWidth + sliderElement.width();
        }

        sliderElement.css("transform", "translateX(" + defaultTransform + "px)");
    }
}

export { slider };
