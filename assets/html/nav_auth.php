<!-- navbar of the site for pages that require sign in -->

<nav>
    <!-- logo -->
    <div class="logo">
        <?php include "assets/img/logo.svg" ?>
        <h1>
            <?php include "assets/txt/site_title.txt" ?>
        </h1>
    </div>

    <!-- submit, search, and logout -->
    <ul>
        <button class="log_out">Log Out</button>
        <button class="submit">Submit a Proposal</button>
        <input type="text" class="search" placeholder="Search All Proposals...">
    </ul>
</nav>