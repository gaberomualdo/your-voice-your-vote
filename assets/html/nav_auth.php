<!-- navbar of the site for pages that require sign in -->

<nav>
    <!-- logo -->
    <?php include "logo.php" ?>

    <!-- submit, search, and logout (logout is removed for now) -->
    <ul>
        <!--<button class="log_out">Log Out</button>-->
        
        <!-- search bar is only displayed in logged-in homepage -->
        <?php if($pagefile == "home") { echo '<input type="text" class="search" placeholder="Search Proposals..." spellcheck="false">'; } ?>
        <button class="submit" onclick="window.open('submit.php', '_self');">Submit a Proposal</button>
    </ul>
</nav>