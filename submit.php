<!-- define preset PHP variables -->
<?php $pagefile = "submit"; $pagetitle = "Submit a Proposal"; ?>

<!DOCTYPE html>
<html lang="en">
    <!-- include HEAD tag -->
    <?php include "assets/html/head.php" ?>
    <body>
        <!-- include navbar -->
        <?php include "assets/html/nav_auth.php" ?>

        <!-- site content and container DIV -->
        <div class="container">
            <div class="block">
                <div class="top_area">
                    <!-- header has an animation on each word, so each word is separated (into <span> tags)
                    using PHP, as well as added transition duration for the effect -->
                    <h1 class="header">
                        <?php
                        (function(){
                            $text_to_display = "Submit a Proposal";
                            $words_to_display = explode(" ", $text_to_display);
                            foreach ($words_to_display as $index => $word) {
                                echo '<span class="word_container"><span class="word_animated" style="transition-delay: ', 0.2 + (0.1 * $index), 's;">', $word, '</span></span> ';
                            }
                        })();
                        ?>
                    </h1>

                    <!-- animated (in) description -->
                    <div class="description animated" style="opacity: 0;">
                        <p><strong>Some guidelines for writing a clear and effective proposal:</strong></p>
                        <ul>
                            <li>Lorem Ipsum</li>
                            <li>Lorem Ipsum</li>
                            <li>Lorem Ipsum</li>
                        </ul>
                        <p><strong>Things to Note About the Submission Process:</strong></p>
                        <ul>
                            <li>Lorem Ipsum</li>
                            <li>Lorem Ipsum</li>
                            <li>Lorem Ipsum</li>
                        </ul>
                    </div>
                </div>
                <div class="form">
                    <input type="text" class="title" placeholder="Write a title...">
                    <textarea placeholder="Write a detailed description..." rows="12"></textarea>
                    <div class="button_container">
                        <button>Submit Proposal for Approval</button>
                        <div class="submit_anon_checkbox"><input type="checkbox"><p>Submit Anonymously</p></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- include footer -->
        <?php include "assets/html/footer.php" ?>

        <!-- include scripts -->
        <?php include "assets/html/scripts.php" ?>
    </body>
</html>