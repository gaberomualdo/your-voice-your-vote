<!-- define preset PHP variables -->
<?php $pagefile = "home"; $pagetitle = "Home"; ?>

<!DOCTYPE html>
<html lang="en">
    <!-- include HEAD tag -->
    <?php include "assets/html/head.php" ?>
    <body>
        <!-- include navbar -->
        <?php include "assets/html/nav_auth.php" ?>

        <!-- site content and container DIV -->
        <div class="container openProposalsTabShown">
            <!-- two tabs — open proposals, and completed proposals -->
            
            <!-- tab buttons -->
            <ul class="tabButtons">
                <li class="openProposalsButton">Open Proposals</li>
                <li class="completedProposalsButton">Completed Proposals</li>
            </ul>

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
        <script src="assets/html/proposal_block.js"></script>
    </body>
</html>