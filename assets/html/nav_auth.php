<!-- navbar of the site for pages that require sign in -->

<nav>
    <!-- logo -->
    <?php include "logo.php" ?>

    <!-- submit, search, and logout (logout is removed for now) -->
    <ul>
        <!-- search bar is only displayed in logged-in homepage -->
        <?php if($pagefile == "home") { echo '<input type="text" class="search" placeholder="Search Proposals..." spellcheck="false">'; } ?>
        <button class="submit" onclick="window.open('submit.php', '_self');">Submit a Proposal</button>
        <!--<button class="log_out">Log Out</button>-->

        <!-- profile image button, which triggers the profile buttons box open -->
        <button class="profileimage_btn"></button>
        <ul class="profile_btns">
            <li class="welcome">
            <span class="welcome_language_text"><?php
            (function() {
                // language possibilities, different ways of saying "Hello" in various languages
                $welcomeMessagePossibilities = [
                    [
                        "text"         => "&#20320;&#22909;",
                        "languageText" => "in Mandarin"
                    ],
                    [
                        "text"         => "Hola",
                        "languageText" => "in Spanish"
                    ],
                    [
                        "text"         => "Oi",
                        "languageText" => "in Portuguese"
                    ],
                    [
                        "text"         => "&#1047;&#1076;&#1088;&#1072;&#1074;&#1089;&#1090;&#1074;&#1091;&#1081;&#1090;&#1077;",
                        "languageText" => "in Russian"
                    ],
                    [
                        "text"         => "&#12371;&#12435;&#12395;&#12385;&#12399;",
                        "languageText" => "in Japanese"
                    ],
                    [
                        "text"         => "Hallo",
                        "languageText" => "in German"
                    ],
                    [
                        "text"         => "&#50668;&#48372;&#49464;&#50836;",
                        "languageText" => "in Korean"
                    ],
                    [
                        "text"         => "Bonjour",
                        "languageText" => "in French"
                    ],
                    [
                        "text"         => "Merhaba",
                        "languageText" => "in Turkish"
                    ],
                    [
                        "text"         => "&#3626;&#3623;&#3633;&#3626;&#3604;&#3637;",
                        "languageText" => "in Thai"
                    ],
                    [
                        "text"         => "&#915;&#949;&#953;&#940; &#963;&#959;&#965;",
                        "languageText" => "in Greek"
                    ],
                    [
                        "text"         => "Hej",
                        "languageText" => "in Swedish"
                    ],
                    [
                        "text"         => "Wagwan",
                        "languageText" => "like a roadman"
                    ]
                ];

                // show welcome message in random language
                $chosenWelcomeMessage = $welcomeMessagePossibilities[array_rand($welcomeMessagePossibilities)];
                echo $chosenWelcomeMessage["text"] . ",";

                // end welcome language text area
                echo "</span>";

                // email area
                echo "<span class='display_name'></span>";

                // language footnote
                echo "<span class='language'>";

                echo "You just learned how to say hello " . $chosenWelcomeMessage["languageText"] . ".";

                echo '</span>';
            })();
            ?>
            </li>
            <li class="button logout_btn">
                Sign Out
            </li>
        </ul>
    </ul>
</nav>