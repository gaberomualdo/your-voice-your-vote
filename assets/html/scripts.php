<!-- this include file imports all necessary scripts for the page -->

<!-- import firebase for authentication and database -->
<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-auth.js"></script>
<!-- only import firebase database for logged-in pages (to save load times for public homepage) -->
<?php
if($pagefile != "index"){
    echo '<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-database.js"></script>';
}
?>

<!-- include variable for firebase config by including JSON file -->
<?php
echo "<script>const firebaseConfigObject = ";
include "assets/json/firebase_config.json";
echo ";</script>";
?>

<!-- main script -->
<script src="assets/js/script.js"></script>

<!-- if logged-in, show logged-in script -->
<?php
if($pagefile != "index") {
    echo '<script src="assets/js/logged_in.js"></script>';
}
?>

<!-- if page is home.php, put necessary icons into JS variables -->
<?php
if($pagefile == "home") {
    // like
    echo "<script>const getLikeSVG = () => { return '";
    include "assets/img/like.svg";
    echo "' }; </script>";

    // dislike
    echo "<script>const getDislikeSVG = () => { return '";
    include "assets/img/dislike.svg";
    echo "' }; </script>";

    // clock
    echo "<script>const getClockSVG = () => { return '";
    include "assets/img/clock.svg";
    echo "' }; </script>";
}
?>

<!-- if page is submit.php, put those necessary icons into JS variables -->
<?php
if($pagefile == "submit") {
    // anonymous user profile picture
    echo "<script>const getAnonymousUserPNG = () => { return '";
    include "assets/img/anonymous_user_icon.txt";
    echo "' }; </script>";
}
?>

<!-- page-specific script -->
<script src="assets/js/pages/<?php echo $pagefile ?>.js"></script>