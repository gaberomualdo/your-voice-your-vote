<?php
/* this program is a function to take in a phrase, and generate
the HTML for a "catchy header" which is an animated header that
requires a set of words to be formatted in a specific way, in
different elements */
function generateCatchyHeaderHTML($text_to_display) {
    // variable for generated HTML
    $generatedHTML = "";

    // text split into words
    $words_to_display = explode(" ", $text_to_display);

    // loop through words and add formatted HTML to generated HTML variable
    foreach ($words_to_display as $index => $word) {
        $generatedHTML .= '<span class="word_container"><span class="word_animated" style="transition-delay: ' . (0.2 + (0.1 * $index)) . 's;">' . $word . '</span></span> ';
    }

    // return generated HTML
    return $generatedHTML;
}
?>