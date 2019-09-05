<!DOCTYPE html>
<html lang="en">
    <!-- HEAD -->
    <head>
        <!-- META declarations -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <!-- page title -->
        <title>Submission Platform &bull; <?php
        // include site title after page title
        include "../assets/txt/site_title.txt";
        ?></title>

        <!-- favicons -->
        <link rel="apple-touch-icon" sizes="57x57" href="../assets/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="../assets/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="../assets/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="../assets/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="../assets/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="../assets/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="../assets/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="../assets/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="../assets/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="../manifest.json">
        <meta name="msapplication-TileColor" content="#DA1333">
        <meta name="msapplication-TileImage" content="../assets/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#DA1333">

        <!-- CSS -->
        <link rel="stylesheet" href="main.css">
    </head>

    <!-- BODY -->
    <body>
        <!-- site content and container DIV -->
        <div class="container not_logged_in">
            <!-- back to main site btn -->
            <a href="../" class="back_to_site"><?php include "back_arrow.svg"; ?> <p>Back to Homepage</p></a>

            <!-- header -->
            <h1 class="header">Submission Platform</h1>
            <!-- login area -->
            <div class="login_area">
                <input type="password" placeholder="Submission Platform Password...">
                <button>Go!</button>
            </div>

            <!-- logged-in area -->
            <div class="logged_in_area">
                <!-- input box to enter voting duration in days -->
                <div class="voting_duration_input">
                    <strong>Proposal Voting Duration: </strong>
                    <input type="number" value="7" min="0" max="365">
                    <p>days</p>
                </div>

                <!-- tabs with proposals to approve and active proposals -->
                <div class="tabs">
                    <div class="proposals_to_approve tab">
                        <h1 class="tab_header">Submission Platform</h1>
                    </div>
                    <div class="active_proposals tab">
                        <h1 class="tab_header">Active Proposals</h1>
                    </div>
                </div>
            </div>

            <!-- footer with copyright and site author name -->
            <footer>
                <p>&copy; <?php include "../assets/txt/site_author.txt"; ?> 2019&ndash;Present</p>
            </footer>
        </div>

        <!-- import firebase for authentication and database -->
        <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-database.js"></script>

        
        <script src="script.js.php"></script>
    </body>
</html>