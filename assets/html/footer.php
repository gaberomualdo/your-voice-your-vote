<!-- footer of the site -->

<!-- add "no_links" class if page is index.php (because footer links are not present in index.php) -->
<footer <?php if($pagefile == "index") { echo 'class="no_links"'; } ?>>
    <!-- line for footer separator -->
    <hr>

    <!-- credits -->
    <p class="credits">Built by <?php include "assets/txt/site_author.txt" ?> (ASL Student)</p>
    
    <!-- links (includes privacy policy, and logout button) -->
    <!-- only show links if logged-in -->
    <?php
    if($pagefile != "index"){
        echo '
        <ul class="links">
            <a href="assets/txt/privacy_policy.txt" target="_blank">Privacy Policy</a>
            <a class="logout">Sign Out</a>
        </ul>';
    }
    ?>
</footer>