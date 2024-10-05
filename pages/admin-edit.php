<?php
$page_title = "Admin Edit";
$id = isset($_GET["songid"]) ? (int)$_GET["songid"] : NULL;
$detail = null;
$tags = [];
$sort_param = $_GET["sort"] ?? NULL;



if ($id) {
    $queryResult = exec_sql_query($db, "SELECT * FROM songs WHERE id = :id;", array(":id" => $id));
    $details = $queryResult->fetchAll();

    if (!empty($details)) {
        $detail = $details[0];
        $tag_result = exec_sql_query($db, "SELECT tags.name FROM tags
            JOIN song_tags ON song_tags.tag_id = tags.id
            WHERE song_tags.song_id = :id", array(':id' => $id));

        if ($tag_result) {
            $tags = $tag_result->fetchAll();
        }
    }
}

define("MAX_FILE_SIZE", 1000000);

if (is_user_logged_in()) {
if (isset($_POST["update_song"])) {
    $form_valid = true;

    $form_values = [
        'song_name' => trim($_POST['song_name']),
        'artist' => trim($_POST['artist']),
        'album' => trim($_POST['album']),
        'release_date' => $_POST['release_date'],
        'genre' => trim($_POST['genre']),
        'languages' => trim($_POST['languages']),
        'file_path' => trim($_POST['file_path']),
        'file_type' => trim($_POST['file_type']),

    ];



    if ($form_valid) {

        $upload = $_FILES["image-file"];
        if ($upload["error"] == UPLOAD_ERR_OK) {
            $upload_file_name = basename($upload["name"]);
            $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png'];

            if (in_array($upload_file_ext, $allowed_types)) {
                $upload_storage_path = "public/uploads/songs/" . $id . "." . $upload_file_ext;
                if (move_uploaded_file($upload['tmp_name'], $upload_storage_path)) {
                    $form_values['file_path'] = $upload_storage_path;
                    $form_values['file_type'] = $upload_file_ext;
                } else {
                    $form_valid = false;
                }
            } else {
                echo 'Invalid file type. Please upload an image file (jpg, jpeg, png).';
                $form_valid = false;
            }
        }


        if ($form_valid) {
            $update_query = "UPDATE songs SET song_name = :song_name, artist = :artist, album = :album,
                release_date = :release_date, genre = :genre, languages = :languages, file_path = :file_path, file_type = :file_type
                WHERE id = :id";
            $params = $form_values + [':id' => $id];
            $update_result = exec_sql_query($db, $update_query, $params);
            if ($update_result) {
                echo "Song updated successfully.";
            } else {
                echo "Error updating song.";
            }
        }
    } else {
        echo "Validation failed. Please check your inputs.";
    }
}
}

?>
<!-- Source: (original work) Troy Corbitt -->
<!-- Source: kyle harms-->

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
        <h2><?php echo $page_title; ?></h2>
        <div class="flex-container">

            <?php if ($detail === NULL) : ?>
                <div class="no-record-found">
                    <p>Song record changed/unknown (<?php echo htmlspecialchars($id); ?>).</p>
                    <h2>Return to the <a href="/adminview">songs list</a>.</h2>
                </div>
            <?php else : ?>
                <form id="update_song" action="/adminedit?songid=<?php echo htmlspecialchars($id); ?>" method="post" enctype="multipart/form-data">


                    <input type="hidden" name="song_id" value="<?php echo htmlspecialchars($detail['id']); ?>">

                    <div class="label-input">
                        <label for="song_name">Song Name:</label>
                        <input type="text" id="song_name" name="song_name" value="<?php echo htmlspecialchars($detail['song_name']); ?>" required>
                    </div>

                    <div class="label-input">
                        <label for="artist">Rank:</label>
                        <input type="text" id="rank" name="rank" value="<?php echo htmlspecialchars($detail['ranking']); ?>" required>
                    </div>

                    <div class="label-input">
                        <label for="rank">Artist:</label>
                        <input type="text" id="artist" name="artist" value="<?php echo htmlspecialchars($detail['artist']); ?>" required>
                    </div>

                    <div class="label-input">
                        <label for="album">Album:</label>
                        <input type="text" id="album" name="album" value="<?php echo htmlspecialchars($detail['album']); ?>" required>
                    </div>

                    <div class="label-input">
                        <label for="release_date">Release Date:</label>
                        <input type="date" id="release_date" name="release_date" value="<?php echo htmlspecialchars($detail['release_date']); ?>" required>
                    </div>

                    <div class="label-input">
                        <label for="genre">Genre:</label>
                        <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($detail['genre']); ?>" required>
                    </div>

                    <div class="label-input">
                        <label for="languages">Languages:</label>
                        <input type="text" id="languages" name="languages" value="<?php echo htmlspecialchars($detail['languages']); ?>" required>
                    </div>


                    <div class="label-input">
                        <label for="tags">Tags:</label>
                        <div id="tags">
                            <?php foreach ($tags as $tag) : ?>
                                <span class="tag"><?php echo htmlspecialchars($tag['name']); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>


                    <?php if (is_user_logged_in()) { ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">

                    <?php if ($upload_feedback["too_large"]) { ?>
                        <p class="feedback">Sorry, the file failed to upload because it was too big. Please select a file that&apos;s no larger than 1MB.</p>
                    <?php } ?>

                    <?php if ($upload_feedback["general_error"]) { ?>
                        <p class="feedback">Sorry, something went wrong. Please select an JPG/JPEG/PNG file to upload.</p>
                    <?php } ?>

                    <div class="label-input">
                        <label for="upload-file">Image File:</label>
                        <input id="upload-file" type="file" name="image-file" accept="image/png, image/jpeg, image/jpg">
                    </div>

                    <div class="label-input">
                        <label for="upload-source" class="optional">Source URL:</label>
                        <input id="upload-source" type="url" name="source" placeholder="URL where found. (optional)">
                    </div>


                    <picture>
                        <img src="<?php echo "/public/uploads/songs/" . htmlspecialchars($detail['id']) . '.' . htmlspecialchars($detail['file_type']); ?>" alt="<?php echo htmlspecialchars($detail['song_name']); ?>">
                    </picture>

                    <div class="align-right">
                        <button type="submit" name="update_song" class="update-song-btn">Update Song</button>

                    </div>
                </form>
                <?php } ?>
            <?php endif; ?>
    </main>

<?php } ?>

<?php if (!is_user_logged_in()) { ?>
    </header>
    <h2 class="color">Sign In</h2>

    <?php echo login_form('/adminview', $session_messages); ?>


<?php } ?>

<?php include "includes/footer.php"; ?>
</body>

</html>
<!-- Source: (original work) Troy Corbitt -->
