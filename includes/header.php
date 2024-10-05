<nav id="menu">

  <ul>
    <?php if (!is_user_logged_in()) { ?>
      <li class="<?php echo $nav_home_class; ?>"><a href="/">Home</a></li>
      <li class="<?php echo $nav_home_class; ?>"><a href="/projects">Projects</a></li>
      <li class="<?php echo $nav_home_class; ?>"><a href="/publications">Publications</a></li>
      <li class="<?php echo $nav_home_class; ?>"><a href="/teaching">Teaching</a></li>
      <li class="<?php echo $nav_home_class; ?>"><a href="/talks">Talks</a></li>
      <li class="<?php echo $nav_home_class; ?>"><a href="/bio">Bio</a></li>
      <li class="<?php echo $nav_home_class; ?>"><a href="/news">In the news</a></li>
      <!-- <li class="<?php echo $nav_login_class; ?>"><a href="/login">Login</a></li> -->
    <?php } ?>
    <?php if (is_user_logged_in()) { ?>
      <li class="<?php echo $nav_home_class; ?>"><a href="/">Consumer View All</a></li>
      <li class="<?php echo $nav_adminview_class; ?>"><a href="/adminview">Admin View All</a></li>
      <li class="<?php echo $nav_admininsert_class; ?>"><a href="/admininsert">Insert Entry</a></li>
      <a href="<?php echo logout_url(); ?>" class="logout-link">Log Out</a>
    <?php } ?>

  </ul>
</nav>
 <!-- Source: (original work) Troy Corbitt -->
<!-- Source: (original work) Xiaoxin Li -->
