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
                    <h1>Submit a Proposal</h1>
                    <p><strong>Some guidelines for writing a clear and effective proposal:</strong></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <p><strong>A Brief Explanation of the Proposal Submission Process:</strong></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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