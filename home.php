<!-- define preset PHP variables -->
<?php $pagefile = "home"; $pagetitle = "Home"; ?>

<!DOCTYPE html>
<html lang="en">
    <!-- include HEAD tag -->
    <?php include "assets/html/head.php" ?>
    <body class="dark_mode">
        <!-- include navbar -->
        <?php include "assets/html/nav_auth.php" ?>

        <!-- site content and container DIV -->
        <div class="container openProposalsTabShown">
            <!-- two tabs — open proposals, and completed proposals -->
            
            <!-- tab buttons -->
            <ul class="tabButtons">
                <li class="openProposalsButton">Active Posts</li>
                <li class="completedProposalsButton">Archived Posts</li>
                <li class="searchResultsButton">Search Results</li>
            </ul>

            <!-- display loading icon while database is loading -->
            <div class="default_style_loading_container loading_container">
                <div class="default_style_loading_loader"></div>
            </div>

            <!-- tabs -->
            <div class="tabs">
                <div class="openProposalsTab">
                    
                </div>
                <div class="completedProposalsTab">
                    
                </div>
            </div>
        </div>

        <!-- include footer -->
        <?php include "assets/html/footer.php" ?>

        <!-- include scripts -->
        <?php include "assets/html/scripts.php" ?>

        <!-- import script to generate HTML for proposal block -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="assets/html/proposal_block.js"></script>
    </body>
</html>