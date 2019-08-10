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
    // up arrow
    echo "<script>const getUpArrowSVG = () => { return '";
    include "assets/img/up_arrow.svg";
    echo "' }; </script>";

    // down arrow
    echo "<script>const getDownArrowSVG = () => { return '";
    include "assets/img/down_arrow.svg";
    echo "' }; </script>";
}
?>

<!-- page-specific script -->
<script src="assets/js/pages/<?php echo $pagefile ?>.js"></script>