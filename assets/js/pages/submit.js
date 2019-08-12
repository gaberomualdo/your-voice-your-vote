// this is the JavaScript file only used in the submit.php file

// display animations when page is loaded
window.addEventListener("load", () => {
    // header animation
    document.querySelector("body > div.container > div.block:first-child > div.row:first-child > h1.header").classList.add("animation_shown");

    // description and form animation (in) goes after header animation is done (can be checked with last word transition time)
    const headerTransitionTimeMilliseconds = parseInt(document.querySelector("body > div.container > div.block:first-child > div.row:first-child > h1.header > span.word_container:last-child > span.word_animated").style.transitionDelay.split("s")[0]) + 0.625;

    setTimeout(() => {
        // animate (in) description and form
        document.querySelector("body > div.container > div.block:first-child > div.row:nth-child(2) > div.description").style.opacity = "1";
        document.querySelector("body > div.container > div.block:first-child > div.row:nth-child(2) > div.description").classList.add("fadeIn");

        document.querySelector("body > div.container > div.block:first-child > div.row:nth-child(2) > div.form").style.opacity = "1";
        document.querySelector("body > div.container > div.block:first-child > div.row:nth-child(2) > div.form").classList.add("fadeIn");
    }, headerTransitionTimeMilliseconds * 1000);
});

// submit button and form functionality
