<!-- this include file imports all necessary scripts for the page -->

<!-- import firebase for authentication and database -->
<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-database.js"></script>

<!-- main script -->
<script src="assets/js/script.js"></script>

<!-- if logged-in, show logged-in script -->
<?php
if($pagefile != "index"){
    echo '<script src="assets/js/logged_in.js"></script>';
}
?>

<!-- page-specific script -->
<script src="assets/js/pages/<?php echo $pagefile ?>.js"></script>