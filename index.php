<!-- define preset PHP variables -->
<?php $pagefile = "index"; $pagetitle = "Home"; ?>

<!DOCTYPE html>
<html lang="en">
    <!-- include HEAD tag -->
    <?php include "assets/html/head.php" ?>
    <body>
        <!-- include navbar -->
        <?php include "assets/html/nav.php" ?>

        <!-- site content and container DIV -->
        <div class="container">
            <div class="col">
                <!-- landing page (left side) with catchy header, text, and login button -->
                <h1 class="catchy_header">Bring real change to your school.</h1>
                <p class=""><?php include "assets/txt/site_title.txt"; ?> is a platform for students to voice their concerns and suggest solutions to the issues faced by the student body. This platform allows students to make their voices heard, to pitch in on innovative ideas, and bring about lasting change to ASL.</p>
                <!-- note that this login button simply triggers the other login button -->
                <button class="login_alias">Sign in with Google</button>
            </div>
            <div class="col">
                
            </div>
        </div>

        <!-- include footer -->
        <?php include "assets/html/footer.php" ?>

        <!-- include scripts -->
        <?php include "assets/html/scripts.php" ?>
    </body>
</html>