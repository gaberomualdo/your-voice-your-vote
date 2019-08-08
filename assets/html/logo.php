<!-- HTML for logo with icon & text -->

<!-- logo links to public homepage for public pages, but logged-in homepage for logged-in pages. -->
<a class="logo" href="<?php if($pagefile == "index") { echo "index"; } else { echo "home"; } ?>.php">
    <?php include "assets/img/logo.svg" ?>
    <h3><?php include "assets/txt/site_title.txt" ?></h3>
</a>