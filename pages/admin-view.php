<?php
$page_title = "Home";



$result = exec_sql_query($db, "SELECT
songs.id AS 'song_id',
songs.song_name AS 'song_name',
songs.artist AS 'artist',
songs.ranking AS 'ranking',
songs.album AS 'album',
songs.release_date AS 'release_date',
songs.genre AS 'genre',
songs.languages AS 'languages',
songs.file_type AS 'file_type'
FROM songs;");



$records = $result->fetchAll();


$page_title = "Update Song";
define("MAX_FILE_SIZE", 1000000);

if (is_user_logged_in()) {
    $tag_result = exec_sql_query($db, "SELECT id, name FROM tags ORDER BY name ASC;");
    if ($tag_result) {
        $allTags = $tag_result->fetchAll();
        echo "<div class='tags-list'>";
        foreach ($allTags as $tag) {
            $filter = "/adminview?" . http_build_query(['tag_filter' => $tag['id']]);
            echo '<a href="' . htmlspecialchars($filter) . '" class="con-filter-button">' . htmlspecialchars($tag['name']) . '</a> ';
        }
        echo "</div>";
    }



    $selectedTagFilter = isset($_GET['tag_filter']) ? (int)$_GET['tag_filter'] : NULL;

    if ($selectedTagFilter) {

        $filteredSongsQuery = exec_sql_query(
            $db,
            "SELECT songs.id AS 'song_id', songs.song_name AS 'song_name', songs.artist AS 'artist',
        songs.ranking AS 'ranking', songs.album AS 'album', songs.release_date AS 'release_date',
        songs.genre AS 'genre', songs.languages AS 'languages', songs.file_type AS 'file_type'
        FROM songs
        INNER JOIN song_tags ON songs.id = song_tags.song_id
        INNER JOIN tags ON song_tags.tag_id = tags.id
        WHERE song_tags.tag_id = :selectedTagFilter",
            array(':selectedTagFilter' => $selectedTagFilter)
        );

        $records = $filteredSongsQuery->fetchAll();
    }
}

$form_values = array_fill_keys(['song_name', 'artist', 'album', 'release_date', 'genre', 'languages', 'tag1', 'tag2', 'tag3'], '');
$feedback_class = array_fill_keys(['song_name', 'artist', 'tag_duplicate'], 'hidden');
$upload_feedback = ['general_error' => false, 'too_large' => false];




$song_id = $_GET['song_id'] ?? null;
if ($song_id) {

    $song_query = "SELECT * FROM songs WHERE id = :id";
    $song_result = exec_sql_query($db, $song_query, [':id' => $song_id]);
    $song = $song_result->fetchAll();
    if ($song) {
        $form_values = array_intersect_key($song, $form_values);
    }
}
if (isset($_POST['update_song'])) {
    $form_valid = true;


    $song_name = $_POST['song_name'] ?? '';
    $artist = $_POST['artist'] ?? '';
    $album = $_POST['album'] ?? '';
    $release_date = $_POST['release_date'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $languages = $_POST['languages'] ?? '';
    $tag1 = $_POST['tag1'] ?? '';
    $tag2 = $_POST['tag2'] ?? '';
    $tag3 = $_POST['tag3'] ?? '';


    if (empty($song_name)) {
        $form_valid = false;
        $feedback_class['song_name'] = '';
    }
    if (empty($artist)) {
        $form_valid = false;
        $feedback_class['artist'] = '';
    }
    if (empty($album)) {
        $form_valid = false;
        $feedback_class['album'] = '';
    }
    if (empty($release_date)) {
        $form_valid = false;
        $feedback_class['release_date'] = '';
    }
    if (empty($genre)) {
        $form_valid = false;
        $feedback_class['genre'] = '';
    }
    if (empty($languages)) {
        $form_valid = false;
        $feedback_class['languages'] = '';
    }


    if (isset($_FILES['songFile']) && $_FILES['songFile']['error'] === UPLOAD_ERR_OK) {
        $upload_file_name = basename($_FILES["songFile"]["name"]);
        $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png'];
        if (!in_array($upload_file_ext, $allowed_types)) {
            $form_valid = false;
            $upload_feedback["general_error"] = true;
        } else {
            $upload_storage_path = "public/uploads/songs/" . $song_id . "." . $upload_file_ext;
            if (!move_uploaded_file($_FILES['songFile']['tmp_name'], $upload_storage_path)) {
                $form_valid = false;
                error_log("Failed to permanently store the uploaded file on the file server.");
            }
        }
    }


    if ($form_valid) {
        $update_query = "UPDATE songs SET song_name = :song_name, artist = :artist, album = :album,
                         release_date = :release_date, genre = :genre, languages = :languages
                         WHERE id = :id";
        $params = [
            ':song_name' => $song_name,
            ':artist' => $artist,
            ':album' => $album,
            ':release_date' => $release_date,
            ':genre' => $genre,
            ':languages' => $languages,
            ':id' => $song_id
        ];
        $update_result = exec_sql_query($db, $update_query, $params);
        if ($update_result) {
            echo "Song updated successfully.";
        } else {
            echo "Error updating song.";
        }
    }
}









?>


<!-- Source: (original work) Troy Corbitt -->
<!-- Source: https://www.w3schools.com/php/func_array_fill_keys.asp -->


<!DOCTYPE html>
<html lang="en">
<header>
    <?php include "includes/keyvalue.php"; ?>
    <?php include "includes/meta.php"; ?>
    <?php include "includes/header.php"; ?>

    <?php if (is_user_logged_in()) { ?>
        <!-- <a href="/admininsert" class="admin-link">Admin Insert Page</a> -->
        <!-- <a href="<?php echo logout_url(); ?>" class="logout-link">Log Out</a> -->

</header>


<body>
    <main>


        </div>
        <h2>Songs Catalog</h2>
        <div class="parent-container">
            <div class="table-container">
                <table>
                    <tr>
                        <th>Song Name</th>
                        <th>Ranking</th>
                        <th>Artist</th>
                        <th>Album</th>
                        <th>Release Date</th>
                        <th>Genre</th>
                        <th>Language</th>
                        <th>Tags</th>
                        <th>Visuals</th>
                    </tr>
                    <!-- Source: (original work) Troy Corbitt -->
                    <?php
                    foreach ($records as $record) {
                        $songids = htmlspecialchars($record['song_id']);
                        $songName = htmlspecialchars($record['song_name']);
                        $Ranking = htmlspecialchars($record['ranking']);
                        $artists = htmlspecialchars(RATING_ARTISTS[$record['artist']]);
                        $albums = htmlspecialchars(RATING_ALBUMS[$record['album']]);
                        $releaseDate = htmlspecialchars($record['release_date']);
                        $genre = htmlspecialchars($record['genre']);
                        $language = htmlspecialchars($record['languages']);
                        $file_type = htmlspecialchars($record['file_type']);
                        // $tagNames = htmlspecialchars($record['tag_name']);

                        include "includes/phpecho.php";
                    }
                    ?>
                </table>

            </div>







    </main>
</body>

<?php } ?>

<?php if (!is_user_logged_in()) { ?>
    </header>

    <body>
        <h2 class="color">Sign In</h2>

        <p> <?php echo login_form('/adminview', $session_messages); ?> </p>
    </body>

<?php } ?>


</html>
<!-- Source: (original work) Troy Corbitt -->
