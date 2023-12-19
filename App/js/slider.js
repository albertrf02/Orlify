function slider() {
    let defaultTransform = 0;
    let cardWidth = calculateCardWidth();
    const cardsPerMove = calculateCardsPerMove();

    window.addEventListener("resize", function () {
        cardWidth = calculateCardWidth();
        updateSliderTransform();
    });

    function calculateCardWidth() {
        const desktopWidth = 768; // Adjust this value based on your breakpoint for desktop screens
        const maxWidth = 1210;
        const minWidth = 392.5; // Adjust this value based on your mobile width
        const windowWidth = window.innerWidth;

        // Choose the card width based on the window width
        if (windowWidth >= desktopWidth) {
            return maxWidth;
        } else {
            return Math.min(minWidth, windowWidth);
        }
    }

    function calculateCardsPerMove() {
        return Math.floor(window.innerWidth / cardWidth);
    }

    function goNext() {
        defaultTransform -= cardWidth * cardsPerMove;
        updateSliderTransform();
    }

    const next = document.getElementById("next");
    next.addEventListener("click", goNext);

    function goPrev() {
        defaultTransform += cardWidth * cardsPerMove;
        updateSliderTransform();
    }

    const prev = document.getElementById("prev");
    prev.addEventListener("click", goPrev);

    function updateSliderTransform() {
        var slider = document.getElementById("slider");

        if (Math.abs(defaultTransform) >= slider.scrollWidth) {
            defaultTransform = 0;
        }

        if (defaultTransform > 0) {
            defaultTransform = -slider.scrollWidth + slider.clientWidth;
        }

        slider.style.transform = "translateX(" + defaultTransform + "px)";
    }
}

export { slider };
