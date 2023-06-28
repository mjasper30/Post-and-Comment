<?php
require 'includes/dbconn.php';
$commentNewCount = $_POST['commentNewCount'];

$sql = "SELECT * FROM comment INNER JOIN user ON user.user_id = comment.user_id ORDER BY comment.date_posted DESC LIMIT $commentNewCount;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
?>
    <h2 for="commentForm" class="form-label">Comments</h2>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="media">
                    <div class="row">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="mr-3 col-1 rounded-circle" alt="Profile Picture">
                        <h5 class="card-title mt-3 col-11">
                            <?php echo $row['firstname'] . " " . $row['lastname']; ?></h5>
                    </div>
                    <div class="media-body mt-3">
                        <p class="card-text"><?php echo $row['content']; ?></p>
                        <?php
                        if ($row['picture'] == NULL) {
                            echo "";
                        } else {
                        ?>
                            <a href="images/<?php echo $row['picture']; ?>" target="_blank">
                                <img class="mb-3" src="images/<?php echo $row['picture']; ?>" alt="Image Comment">
                            </a>
                        <?php
                        }
                        ?>

                        <div class="card-footer bg-white">
                            <!--Timestamp when did this comment-->
                            <?php
                            $dateTimeString = $row['date_posted'];
                            $dateTime = new DateTime($dateTimeString);
                            $formattedDateTime = $dateTime->format('F d, Y g:i:s A');
                            ?>
                            <small class="text-muted"><?php echo $formattedDateTime; ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} else {
    echo "There are no comments!";
}
mysqli_close($conn);
?>