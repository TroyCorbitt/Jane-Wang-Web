<?php
$tagnames = exec_sql_query(
  $db,
  "SELECT
*
FROM song_tags
INNER JOIN tags ON song_tags.tag_id = tags.id
WHERE song_id = :song_id ;",
  array(
    ':song_id' => $songids
  )
);
$tags = $tagnames->fetchAll();


?>
<tr>
  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link"><?php echo htmlspecialchars($songName); ?></a>
  </td>
  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link"><?php echo htmlspecialchars($Ranking); ?></a>
  </td>
  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link"><?php echo htmlspecialchars($artists); ?></a>
  </td>
  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link"><?php echo htmlspecialchars($albums); ?></a>
  </td>
  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link"><?php echo htmlspecialchars($releaseDate); ?></a>
  </td>
  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link"><?php echo htmlspecialchars($genre); ?></a>
  </td>
  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link"><?php echo htmlspecialchars($language); ?></a>
  </td>
  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link">
      <?php foreach ($tags as $tag) { ?>
        <?php echo htmlspecialchars($tag['name']); ?>

      <?php } ?>
    </a>
  </td>
  <td>

    <picture>
      <img src="<?php echo "/public/uploads/songs/" . htmlspecialchars($songids) . '.' . htmlspecialchars($file_type); ?>" alt="<?php echo htmlspecialchars($songName); ?>" class="images-admin">
    </picture>
  </td>



  <td>
    <a href="/adminedit?<?php echo http_build_query(array('songid' => $songids)); ?>" class="table-link">Edit</a>
  </td>
</tr>


<!-- Source: (original work) Troy Corbitt -->
