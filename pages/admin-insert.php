<?php
$page_title = "Songs Catalog";

$tag_query = "SELECT * FROM tags ORDER BY name ASC;";
$tags_result = exec_sql_query($db, $tag_query);
$tags = $tags_result->fetchAll();

$form_values = array(
    'song_name' => '',
    'artist' => '',
    'album' => '',
    'release_date' => '',
    'genre' => '',
    'languages' => '',
    'tag1' => '',
    'tag2' => '',
    'tag3' => '',
);

$sticky_values = array(
    'song_name' => '',
    'artist' => '',
    'album' => '',
    'release_date' => '',
    'genre' => '',
    'languages' => '',
    'tag1' => '',
    'tag2' => '',
    'tag3' => '',
);

$feedback_class = array(
    "song_name" => "hidden",
    "artist" => "hidden",
    "tag_duplicate" => "hidden"
);

$show_confirmation_message = false;
$tag_warning_message = false;

define("MAX_FILE_SIZE", 1000000);

if (is_user_logged_in()) {
$upload_feedback = array(
    "general_error" => false,
    "too_large" => false
);

$upload_file_name = NULL;
$upload_file_ext = NULL;

if (isset($_POST["add_song"])) {
    $form_valid = true;

    $form_values["song_name"] = trim($_POST["song_name"]);
    $form_values["artist"] = (int)($_POST["artist"]);
    $form_values["album"] = ($_POST["album"] == "" ? NULL : (int)$_POST["album"]);
    $form_values["release_date"] = ($_POST["release_date"] == "" ? NULL : $_POST["release_date"]);
    $form_values["genre"] = ($_POST["genre"] == "" ? NULL : $_POST["genre"]);
    $form_values["languages"] = ($_POST["languages"] == "" ? NULL : $_POST["languages"]);
    $form_values["tag1"] = ($_POST["tag1"] == "" ? NULL : (int)$_POST["tag1"]);
    $form_values["tag2"] = ($_POST["tag2"] == "" ? NULL : (int)$_POST["tag2"]);
    $form_values["tag3"] = ($_POST["tag3"] == "" ? NULL : (int)$_POST["tag3"]);

    if (!$form_values["song_name"]) {
        $form_valid = false;
        $feedback_class["song_name"] = "";
    }

    if (!$form_values["artist"]) {
        $form_valid = false;
        $feedback_class["artist"] = "";
    }

    $sel_tags = array($form_values['tag1'], $form_values['tag2'], $form_values['tag3']);
    $sel_tags = array_filter($sel_tags);
    if (count($sel_tags) !== count(array_unique($sel_tags))) {
        $form_valid = false;
        $feedback_class["tag_duplicate"] = "";
        $tag_warning_message = true;
    }

    $upload = $_FILES["songFile"];
    if ($upload["error"] == UPLOAD_ERR_OK) {
        $upload_file_name = basename($upload["name"]);

        $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));

        $allowed_types = ['jpg', 'jpeg', 'png'];
        if (!in_array($upload_file_ext, $allowed_types)) {
            $form_valid = false;
            $upload_feedback["general_error"] = true;
        }
    } else if (($upload["error"] == UPLOAD_ERR_INI_SIZE) || ($upload["error"] == UPLOAD_ERR_FORM_SIZE)) {
        $form_valid = false;
        $upload_feedback["too_large"] = true;
    } else {
        $form_valid = false;
        $upload_feedback["general_error"] = true;
    }

    if ($form_valid) {
        $highest_rank_query = "SELECT MAX(ranking) AS max_ranking FROM songs;";
        $highest_rank_result = exec_sql_query($db, $highest_rank_query);
        $highest_rank_row = $highest_rank_result->fetch(PDO::FETCH_ASSOC);
        $curr_highest_rank = $highest_rank_row['max_ranking'] ?? 0;
        $new_ranking = $curr_highest_rank + 1;

        $query = "INSERT INTO songs (ranking, song_name, artist, album, release_date, genre, languages, file_path, file_type)
        VALUES (:ranking, :song_name, :artist, :album, :release_date, :genre, :languages, :file_path, :file_type);";
        $params = [
            ':ranking' => $new_ranking,
            ':song_name' => $form_values["song_name"],
            ':artist' => $form_values["artist"],
            ':album' => $form_values["album"],
            ':release_date' => $form_values["release_date"],
            ':genre' => $form_values["genre"],
            ':languages' => $form_values["languages"],
            ":file_path" => $upload_file_name,
            ":file_type" => $upload_file_ext
        ];
        $result = exec_sql_query($db, $query, $params);

        if ($result) {
            $song_id = $db->lastInsertId();
            $record_id = $song_id;

            foreach (array_unique($sel_tags) as $tag_id) {
                $tag_query = "INSERT INTO song_tags (song_id, tag_id) VALUES (:song_id, :tag_id)";
                exec_sql_query($db, $tag_query, [':song_id' => $song_id, ':tag_id' => $tag_id]);
            }

            $upload_storage_path = "public/uploads/songs/" . $record_id . "." . $upload_file_ext;

            if (move_uploaded_file($upload["tmp_name"], $upload_storage_path) == false) {
                error_log("Failed to permanently store the uploaded file on the file server. Please check that the server folder exists.");
            }

            $show_confirmation_message = true;
        }
    } else {
        $sticky_values = $form_values;
    }
}
}
$records = exec_sql_query($db, "SELECT * FROM songs;")->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">

<header>
    <?php include "includes/keyvalue.php"; ?>
    <?php include "includes/meta.php"; ?>
    <?php include "includes/header.php"; ?>

    <?php if (is_user_logged_in()) { ?>
        <!-- <a href="/adminview" class="admin-link">Admin View Page</a> -->
        <!-- <a href="<?php echo logout_url(); ?>" class="logout-link">Log Out</a> -->

</header>



<body>
    <main class="song-management">
        <h1>Add New Song</h1>

        <section class="insert-page">

            <?php if ($show_confirmation_message) { ?>
                <section class="confirmation feedback">
                    <p><strong>The new song has been successfully added</strong></p>
                </section>
            <?php } ?>


            <form id="add_song" action="/admininsert" method="post" enctype="multipart/form-data" novalidate>

                <label for="song_name" class="insert-label">Song Name<abbr>*</abbr>:</label>
                <div class="feedback <?php echo $feedback_class["song_name"]; ?>"><strong>Please enter a valid song name.</strong></div>
                <input type="text" id="song_name" class="insert-input" name="song_name" value="<?php echo htmlspecialchars($sticky_values["song_name"]); ?>" required>

                <label for="artist" class="insert-label">Artist<abbr>*</abbr>:</label>
                <div class="feedback <?php echo $feedback_class["artist"]; ?>"><strong>Please select an artist.</strong></div>
                <select id="artist" name="artist" class="insert-input">
                    <option value="">Select an artist</option>

                    <?php foreach (RATING_ARTISTS as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php echo (isset($sticky_values["artist"]) && $sticky_values["artist"] == $key) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($value); ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="album" class="insert-label">Album:</label>
                <select id="album" name="album" class="insert-input">
                    <option value="">Select an album</option>

                    <?php foreach (RATING_ALBUMS as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php echo (isset($sticky_values["album"]) && $sticky_values["album"] == $key) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($value); ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="release_date" class="insert-label">Release Date:</label>
                <input type="date" id="release_date" name="release_date" class="insert-input" value="<?php echo htmlspecialchars($sticky_values["release_date"]); ?>">

                <label for="genre" class="insert-label">Genre:</label>
                <input type="text" id="genre" name="genre" class="insert-input" value="<?php echo htmlspecialchars($sticky_values["genre"]); ?>">

                <label for="languages" class="insert-label">Languages:</label>
                <input type="text" id="languages" name="languages" class="insert-input" value="<?php echo htmlspecialchars($sticky_values["languages"]); ?>">

                <section class="add-tags">



                    <section class="add-each-tag">
                        <section class="add-tag">
                            <label for="tag1" class="insert-label">Tag:</label>
                            <select id="tag1" name="tag1" class="insert-input">
                                <option value="">Select a Tag</option>

                                <?php foreach ($tags as $tag) {
                                    $selected = ($sticky_values['tag1'] == $tag['id']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($tag['id']) . "' $selected>" . htmlspecialchars($tag['name']) . "</option>";
                                }
                                ?>
                            </select>
                        </section>

                        <section class="add-tag">
                            <label for="tag2" class="insert-label">Tag:</label>
                            <select id="tag2" name="tag2" class="insert-input">
                                <option value="">Select a Tag</option>

                                <?php foreach ($tags as $tag) {
                                    $selected = ($sticky_values['tag2'] == $tag['id']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($tag['id']) . "' $selected>" . htmlspecialchars($tag['name']) . "</option>";
                                }
                                ?>
                            </select>
                        </section>

                        <section class="add-tag">
                            <label for="tag3" class="insert-label">Tag:</label>
                            <select id="tag3" name="tag3" class="insert-input">
                                <option value="">Select a Tag</option>

                                <?php foreach ($tags as $tag) {
                                    $selected = ($sticky_values['tag3'] == $tag['id']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($tag['id']) . "' $selected>" . htmlspecialchars($tag['name']) . "</option>";
                                }
                                ?>
                            </select>
                        </section>
                    </section>
                    <div class="feedback <?php echo $feedback_class["tag_duplicate"]; ?>">
                        <?php if ($tag_warning_message) echo "<strong>Please select different tags for each option.</strong>"; ?>
                    </div>
                </section>

                <section>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">

                    <div>
                        <label for="upload-file" class="insert-label">Image File:</label>

                        <?php if ($upload_feedback["too_large"]) { ?>
                            <p class="feedback"><strong>Sorry, the file failed to upload because it was too big. Please select a file that&apos;s no larger than 1MB.</strong></p>
                        <?php } ?>

                        <?php if ($upload_feedback["general_error"]) { ?>
                            <p class="feedback"><strong>Sorry, something went wrong. Please select a JPG/JPEG/PNG file to upload.</strong></p>
                        <?php } ?>

                        <input id="upload-file" type="file" name="songFile" accept="image/png, image/jpeg, image/jpg" class="insert-input">
                    </div>
                </section>

                <button type="submit" name="add_song" class="align-right">Add Song</button>
            </form>
        </section>

    <?php } ?>

    <?php if (!is_user_logged_in()) { ?>
        </header>
        <h2 class="color">Sign In</h2>

        <?php echo login_form('/admininsert', $session_messages); ?>


    <?php } ?>
    </main>

</body>

</html>
<!-- Source: (original work) Xiaoxin Li -->
