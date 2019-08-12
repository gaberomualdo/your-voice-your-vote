// this is the JavaScript file only used in the submit.php file

// display animations when page is loaded
window.addEventListener("load", () => {
    // header animation
    document.querySelector("body > div.container > div.block:first-child > div.top_area > h1.header").classList.add("animation_shown");

    // description and form animation (in) goes after header animation is done (can be checked with last word transition time)
    const headerTransitionTimeMilliseconds = parseInt(document.querySelector("body > div.container > div.block:first-child > div.top_area > h1.header > span.word_container:last-child > span.word_animated").style.transitionDelay.split("s")[0]) + 0.6;

    setTimeout(() => {
        // animate (in) description and form
        document.querySelector("body > div.container > div.block:first-child > div.top_area > h1.header ~ div.description").style.opacity = "1";
        document.querySelector("body > div.container > div.block:first-child > div.top_area > h1.header ~ div.description").classList.add("fadeIn");
    }, headerTransitionTimeMilliseconds * 1000);
});