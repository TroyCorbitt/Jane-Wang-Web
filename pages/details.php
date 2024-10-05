<?php
$page_title = "Details";

$song_id = $_GET['song_id'] ?? null;
$detail = null;
$tags = [];

if ($song_id) {
  $song_result = exec_sql_query(
    $db,
    "SELECT * FROM songs WHERE id = :song_id",
    array(':song_id' => $song_id)
  );

  $details = $song_result->fetchAll();

  $detail = $details[0];
  $tag_result = exec_sql_query(
    $db,
    "SELECT tags.name FROM tags
      JOIN song_tags ON song_tags.tag_id = tags.id
      WHERE song_tags.song_id = :song_id",
    array(':song_id' => $song_id)
  );

  if ($tag_result) {
    $tags = $tag_result->fetchAll();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include "includes/meta.php" ?>

<body>

  <?php include "includes/header.php" ?>

  <h1 class="con-detail-h1"><?php echo htmlspecialchars($detail['ranking']); ?> | <?php echo htmlspecialchars($detail['song_name']); ?></h1>

  <section class="con-pages">
    <aside class="con-detail-aside">
      <a href="/" class="con-filter-title"><strong>&#8678 Back</strong></a>
    </aside>

    <main class="con-details">
      <p>Artist: <?php echo htmlspecialchars($detail['artist']); ?></p>
      <p>Album: <?php echo htmlspecialchars($detail['album']); ?></p>
      <p>Release date: <?php echo htmlspecialchars($detail['release_date']); ?></p>
      <p>Genre: <?php echo htmlspecialchars($detail['genre']); ?></p>
      <p>Language: <?php echo htmlspecialchars($detail['languages']); ?></p>
      <p>Tags:
        <?php
        foreach ($tags as $tag) {
          echo '<span class="tag con-song-tags-button">' . htmlspecialchars($tag['name']) . '</span> ';
        }
        ?>
      </p>
    </main>


    <img class="con-detail-img" src="<?php echo "/public/uploads/songs/" . htmlspecialchars($detail['id']) . '.' . htmlspecialchars($detail['file_type']); ?>" alt="<?php echo htmlspecialchars($record['song_name']); ?>">

    <!-- <img class="con-detail-img" src="public/images/placeholder.jpg" alt="Placeholder"> -->

  </section>


</body>

</html>

<!-- Source: (original work) Xiaoxin Li -->
