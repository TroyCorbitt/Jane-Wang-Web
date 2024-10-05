<?php
$page_title = "Home";

$filter_param = $_GET["tag"] ?? NULL;

$sql_select_clause = "SELECT songs.id AS 'songs.song_id',
  songs.ranking AS 'songs.ranking',
  songs.song_name AS 'songs.song_name',
  songs.artist AS 'songs.artist',
  songs.file_type AS 'songs.file_type'
  FROM songs
  JOIN song_tags ON songs.id = song_tags.song_id
  JOIN tags ON song_tags.tag_id = tags.id";

$params = [];

if ($filter_param) {
  $sql_filter_clause = " WHERE tags.id = :tag_id";
  $params[':tag_id'] = $filter_param;
} else {
  $sql_filter_clause = "";
}

$sql_select_query = $sql_select_clause . $sql_filter_clause . " GROUP BY songs.id ORDER BY songs.ranking ASC;";
$result = exec_sql_query($db, $sql_select_query, $params);
$records = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<!-- <header> -->
<?php include "includes/keyvalue.php"; ?>
<?php include "includes/meta.php"; ?>
<?php include "includes/header.php"; ?>

<!-- <?php if (is_user_logged_in()) { ?> -->
  <!-- <a href="/adminview" class="admin-link">Admin View Page</a>
    <a href="/admininsert" class="admin-link">Admin Insert Page</a>
    <a href="<?php echo logout_url(); ?>" class="logout-link">Log Out</a>
<!-- <?php } ?>  -->


  </header>

  <body>

    <h1 class="Jane_header">Z. Jane Wang | Professor of Physics and Mechanical and Aerospace Engineering
    </h1>


  <div class="intro-text">
  <section class="intro-section">
  <div class="intro-image">
    <img src="images/Jane.jpeg" alt="Jane's Image">
    <p class="image-caption">Jane</p>
  </div>

  <div class="intro-text">
    <p class="intro-paragraph">Much of my work is driven by a desire to see and conceptualize the world around us.
       I strive to find sharp and intuitive answers to the inter-connected puzzles in complex living systems.</p>

    <p class="intro-paragraph">A long term scientific endeavor is to construct physical and mathematical methods and analyses 
      to understand complex biological behavior, informed by experiments. Our current work centers on investigating how the 
      physics of flight shapes the evolution of insects' neural control algorithms. The first is the analysis of flight of 
      genetically modified flies. This is in part motivated to test our recent prediction on fly's stability, and more generally, 
      to develop new methods for analyzing free flight with different neural feedback circuitries. The second is to analyze 
      passive flight to gain insight into efficient flight. The third is to build new behavioral experiments and analyses of 
      dragonfly's righting behavior so as to understand their sense of orientation in space, as a means to study the connection
       between the physics of flight and the evolved maneuvering strategies. Collectively, these works will shed light on the 
       design of nature's flyers and also offer new methods for abstracting key principles in animal locomotion through experiments
      together with suggestive, predictive, and explanatory models, ultimately contributing to our understanding of 'what is life?'.</p>
  </div>
</section>

  </div>

 
</section>

<section class="con-pages">
  <aside>
    <p class="con-filter-title"><strong>Filter by Tag</strong></p>
    <section class="con-filter">
      <?php
      $tag_result = exec_sql_query(
        $db,
        "SELECT id, name FROM tags ORDER BY name ASC;"
      );
      foreach ($tag_result->fetchAll() as $tag) {
        $page = "/?" . http_build_query(['tag' => $tag['id']]);
        echo '<a href="' . htmlspecialchars($page) . '" class="con-filter-button">' . htmlspecialchars($tag['name']) . '</a>';
      }
      ?>
    </section>
  </aside>

  <ul class="con-ul">
    <?php
    $chunks = array_chunk($records, 3);
    foreach ($chunks as $chunk) {
      include "includes/con-chunk.php";
    }
    ?>
  </ul>
</section>


  </body>

  <footer class="site-footer">
  jane dot wang at cornell.edu | (607) 255-5354 | 323 Thurston Hall | 517 Clark Hall
</footer>


</html>
<!-- Source: (original work) Xiaoxin Li -->
