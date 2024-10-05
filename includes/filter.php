<?php
$selectedTagFilter = isset($_GET['tag_filter']) ? (int)$_GET['tag_filter'] : NULL;

$tag_result = exec_sql_query(
    $db,
    "SELECT id, name FROM tags ORDER BY name ASC;"
);
if ($tag_result) {
    $allTags = $tag_result->fetchAll();
    echo "<div class='tags-list'>";
    foreach ($allTags as $tag) {
        $filter = "/adminedit?" . http_build_query(['tag_filter' => $tag['id']]);
        echo '<a href="' . htmlspecialchars($filter) . '" class="con-filter-button">' . htmlspecialchars($tag['name']) . '</a> ';
    }
    echo "</div>";
}




if ($selectedTagFilter) {
    $filteredSongsQuery = exec_sql_query(
        $db,
        "SELECT songs.* FROM songs
        JOIN song_tags ON songs.id = song_tags.song_id
        WHERE song_tags.tag_id = :selectedTagFilter;",
        array(':selectedTagFilter' => $selectedTagFilter)
    );
    if ($filteredSongsQuery) {
        $songsWithTag = $filteredSongsQuery->fetchAll();
        echo "<div class='songs-list'>";
        foreach ($songsWithTag as $songDetails) {
            echo "<h3>" . htmlspecialchars($songDetails['song_name']) . "</h3>";


            $associatedTagsQuery = exec_sql_query($db, "SELECT tags.id, tags.name FROM tags
                JOIN song_tags ON song_tags.tag_id = tags.id
                WHERE song_tags.song_id = :songId;",
                array(':songId' => $songDetails['id']));
            if ($associatedTagsQuery) {
                $tagsForCurrentSong = $associatedTagsQuery->fetchAll();
                foreach ($tagsForCurrentSong as $tagDetail) {
                    echo "<a href='?tag_filter=" . urlencode($tagDetail['id']) . "'>" . htmlspecialchars($tagDetail['name']) . "</a> ";
                }
            }
        }
        echo "</div>";
    }
}
?>

 <!-- Source: (original work) Troy Corbitt -->
  <!-- Source: w3 schools -->
