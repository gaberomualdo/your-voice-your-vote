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
                <!-- first row includes just the header -->
                <div class="row">
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
                </div>
                
                <!-- second row is split into two columns — the description, and the actual submission form -->
                <div class="row">
                    <!-- animated (in) description -->
                    <div class="col description animated" style="opacity: 0;">
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
                
                    <!-- submission form -->
                    <div class="col form animated" style="opacity: 0;">
                        <!-- title box -->
                        <input type="text" class="title" placeholder="Write a title..." spellcheck="false">
                        
                        <!-- description box -->
                        <textarea placeholder="Write a detailed description..." spellcheck="false"></textarea>
                        
                        <!-- submit button with "Submit Anonymously" checkbox -->
                        <div class="button_container">
                            <button>Submit Proposal for Approval</button>
                            <div class="submit_anon_checkbox">
                                <input type="checkbox" name="submit_anonymously_checkbox" id="submit_anonymously_checkbox">
                                <label for="submit_anonymously_checkbox"></label>
                                <p>Submit Anonymously</p>
                            </div>
                        </div>
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