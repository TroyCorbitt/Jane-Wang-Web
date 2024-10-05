<li class="con-li">
  <a href="/details?<?php echo http_build_query(['song_id' => $record['songs.song_id']]); ?>" class="con-song-link">

    <picture>
      <img src="<?php echo "/public/uploads/songs/" . htmlspecialchars($record['songs.song_id']) . '.' . htmlspecialchars($record['songs.file_type']); ?>" alt="<?php echo htmlspecialchars($record['songs.song_name']); ?>">
    </picture>

    <section class="con-song">
      <p><strong><?php echo htmlspecialchars($record['songs.ranking']); ?></strong></p>
      <p><?php echo htmlspecialchars($record['songs.song_name']); ?></p>
      <p><?php echo htmlspecialchars(RATING_ARTISTS[$record['songs.artist']]); ?></p>

      <section class="con-song-tags">
        <?php
        $tag_result = exec_sql_query(
          $db,
          "SELECT tags.name FROM tags
          INNER JOIN song_tags ON tags.id = song_tags.tag_id
          WHERE song_tags.song_id = :song_id",
          array(':song_id' => $record['songs.song_id'])
        );
        if ($tag_result) {
          $tags = $tag_result->fetchAll();
          if (count($tags) > 0) {
            foreach ($tags as $tag) {
              echo '<span class="con-song-tags-button">' . htmlspecialchars($tag['name']) . '</span>';
            }
          }
        }
        ?>
      </section>

      <button class="con-details-button">View All</button>
    </section>
  </a>
</li>
<!-- Source: (original work) Xiaoxin Li -->
