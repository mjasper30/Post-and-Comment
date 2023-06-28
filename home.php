<?php
require 'includes/dbconn.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Post And Comment System</title>
    <?php include('dbconn.php'); ?>
    <?php include('session.php'); ?>

    <!--CSS Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!--Icons Bootstrap CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--Styles for Comment Cards-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <!--Alert JS-->
    <!--<script src="js/alert.js"></script>-->

    <!--Alert CSS-->
    <link rel="stylesheet" href="css/alert.css">

    <!--AJAX-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        margin-top: 20px;
    }

    .content-item {
        padding: 30px 0;
        background-color: #ffffff;
    }

    .content-item.grey {
        background-color: #f0f0f0;
        padding: 50px 0;
        height: 100%;
    }

    .content-item h2 {
        font-weight: 700;
        font-size: 35px;
        line-height: 45px;
        text-transform: uppercase;
        margin: 20px 0;
    }

    .content-item h3 {
        font-weight: 400;
        font-size: 20px;
        color: #555555;
        margin: 10px 0 15px;
        padding: 0;
    }

    .content-headline {
        height: 1px;
        text-align: center;
        margin: 20px 0 70px;
    }

    .content-headline h2 {
        background-color: #ffffff;
        display: inline-block;
        margin: -20px auto 0;
        padding: 0 20px;
    }

    .grey .content-headline h2 {
        background-color: #f0f0f0;
    }

    .content-headline h3 {
        font-size: 14px;
        color: #aaaaaa;
        display: block;
    }

    #comments {
        box-shadow: 0 -1px 6px 1px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }

    #comments form {
        margin-bottom: 30px;
    }

    #comments .btn {
        margin-top: 7px;
    }

    #comments form fieldset {
        clear: both;
    }

    #comments form textarea {
        height: 100px;
    }

    #comments .media {
        /*border-top: 1px dashed #dddddd;*/
        padding: 20px 0;
        margin: 0;
    }

    #comments .media>.pull-left {
        margin-right: 20px;
    }

    #comments .media img {
        max-width: 100px;
    }

    #comments .media h4 {
        margin: 0 0 10px;
    }

    #comments .media h4 span {
        font-size: 14px;
        float: right;
        color: #999999;
    }

    #comments .media p {
        margin-bottom: 15px;
        text-align: justify;
    }

    #comments .media-detail {
        margin: 0;
    }

    #comments .media-detail li {
        color: #aaaaaa;
        font-size: 12px;
        padding-right: 10px;
        font-weight: 600;
    }

    #comments .media-detail a:hover {
        text-decoration: underline;
    }

    #comments .media-detail li:last-child {
        padding-right: 0;
    }

    #comments .media-detail li i {
        color: #666666;
        font-size: 15px;
        margin-right: 10px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Post and Comment System</h1>

        <!-- Upload Button Trigger Modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Upload
        </button>

        <!--Logout Button-->
        <a href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a>

        <!-- Upload Post Modal Form-->
        <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload a Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="uploadPost" method="POST">
                        <div class="modal-body">

                            <div id="errorMessage" class="alert alert-warning d-none"></div>

                            <div class="mb-3">
                                <label for="">Section Title</label>
                                <input type="text" name="section_title" class="form-control" value="" />
                            </div>
                            <div class="mb-3">
                                <label for="">Content of the post</label>
                                <textarea class="form-control" name="content" rows="3"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleCombobox">Select status</label>
                                <select name="post_status" class="form-control" id="exampleCombobox">
                                    <option value="">Choose an option</option>
                                    <?php
                                    $query = "SELECT id, status FROM `post_status`";
                                    $result = mysqli_query($conn, $query);

                                    // Check if the query was successful
                                    if (!$result) {
                                        die("Database query failed.");
                                    }

                                    $options = '';

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $status = $row['status'];
                                        $options .= "<option value=" . $status . ">$status</option>";
                                    }

                                    echo $options;
                                    ?>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Image</label>
                                <input type="file" name="image" class="form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary me-1">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal Form-->
        <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updatePost" method="POST">
                        <div class="modal-body">

                            <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                            <input type="hidden" name="post_id" id="post_id">
                            <!--List of status-->
                            <div class="form-group mb-3">
                                <label for="exampleCombobox">Select status</label>
                                <select name="post_status" id="post_status" class="form-control" id="exampleCombobox">
                                    <option value="">Choose Status</option>
                                    <?php
                                    $query = "SELECT id, status FROM `post_status`";
                                    $result = mysqli_query($conn, $query);

                                    // Check if the query was successful
                                    if (!$result) {
                                        die("Database query failed.");
                                    }

                                    $options = '';

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $status = $row['status'];
                                        $options .= "<option value=" . $status . ">$status</option>";
                                    }

                                    echo $options;
                                    ?>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Summary</label>
                                <textarea class="form-control" name="summary" id="summary" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary me-1">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Search-->
        <div class="input-group mb-3 mt-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search in conversation"
                aria-label="search-subject" aria-describedby="search-subject">
            <button class="btn btn-primary" id="searchButton" type="button" id="button-addon2"><i
                    class="bi bi-search"></i></button>
        </div>

        <!--<h1>Conversation Search</h1>-->
        <!--<input type="text" id="searchInput" placeholder="Enter keyword">-->
        <!--<button id="searchButton">Search</button>-->
        <!--<div id="searchResults"></div>-->

        <div id="searchResults"></div>

        <!--List of subjects-->
        <div class="btn-group mb-3">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                List of Subjects
            </button>
            <?php
            $query = "SELECT post_id, section_title FROM `post`";
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if (!$result) {
                die("Database query failed.");
            }

            $options = '';

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['post_id'];
                $section_title = $row['section_title'];
                $options .= "<li><a class='dropdown-item' href='#' value='$id'>$section_title</a></li>";
            }

            ?>

            <ul class="dropdown-menu">
                <?php echo $options; ?>
            </ul>
        </div>

        <!--Content of the Post-->

        <?php
        $query1 = mysqli_query($conn, "SELECT *,UNIX_TIMESTAMP() - date_created AS TimeSpent from post LEFT JOIN user on user.user_id = post.user_id ORDER BY post_id DESC");
        while ($post_row = mysqli_fetch_array($query1)) {
            $id = $post_row['post_id'];
            $upid = $post_row['user_id'];
            $posted_by = $post_row['firstname'] . " " . $post_row['lastname'];
        ?>

        <?php
            $days = floor($post_row['TimeSpent'] / (60 * 60 * 24));
            $remainder = $post_row['TimeSpent'] % (60 * 60 * 24);
            $hours = floor($remainder / (60 * 60));
            $remainder = $remainder % (60 * 60);
            $minutes = floor($remainder / 60);
            $seconds = $remainder % 60;
            if ($days > 0)
                echo date('F d, Y - H:i:sa', $post_row['date_created']);
            elseif ($days == 0 && $hours == 0 && $minutes == 0)
                echo "A few seconds ago";
            elseif ($days == 0 && $hours == 0)
                echo $minutes . ' minutes ago';
            ?>

        </p>

        <!-- Post Content -->
        <div class="card mx-5">

            <div class="row">
                <div class="col-2 m-3 float-right">

                    <!-- Edit Post Button -->
                    <button class="editPostBtn btn btn-warning" value="<?= $post_row['post_id']; ?>"
                        data-bs-toggle="modal" data-bs-target="#exampleModalEdit"><i
                            class="bi bi-pencil-square"></i></button>

                    <!-- Delete Post Button -->
                    <a style="text-decoration:none;" href="deletepost.php<?php echo '?id=' . $id; ?>"><button
                            class="btn btn-danger"><i class="bi bi-trash"></i></button></a>
                </div>
            </div>

            <div class="card-body m-5">

                <!-- Content of the post -->
                <h2 class="card-title text-center mb-5"><?php echo $post_row['section_title']; ?></h2>

                <?php
                    include('dbconn.php');

                    $query = "SELECT action FROM post WHERE post_id = $id";

                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $taskStatus = $row['action'];
                            $priorityStatus = '';

                            if ($taskStatus == 'Resolved') {
                                $priorityStatus = '<span class="badge rounded-pill text-bg-success">Resolved</span>';
                            } elseif ($taskStatus == 'Priority') {
                                $priorityStatus = '<span class="badge rounded-pill text-bg-primary">Priority</span>';
                            } elseif ($taskStatus == 'Not') {
                                $priorityStatus = '<span class="badge rounded-pill text-bg-danger">Not Priority</span>';
                            } else {
                                $priorityStatus = '';
                            }

                            $row['priority_status'] = $priorityStatus;
                            // You can output or further process the updated row here
                        }
                    } else {
                        echo "Error executing query: " . mysqli_error($conn);
                    }


                    ?>

                <div class="mb-2">
                    <?php echo $priorityStatus; ?>
                </div>
                <p class="card-title fw-bold">Posted by:
                    <?php echo $post_row['firstname'] . " " . $post_row['lastname']; ?></p>
                <?php
                    $dateTimeString = $post_row['date_created'];
                    $dateTime = new DateTime($dateTimeString);
                    $formattedDateTime = $dateTime->format('F d, Y g:i:s A');
                    ?>
                <p class="card-text"><small class="text-body-secondary"><?php echo $formattedDateTime; ?></small>
                </p>
                <p class="card-text"><?php echo $post_row['content']; ?></p>
                <img src="images/<?php echo $post_row['picture']; ?>" class="card-img-bottom img-thumbnail" alt="..."
                    target="_blank">
                <h2 class="card-title mt-3">Summary</h2>
                <p class="card-text"><?php echo $post_row['summary']; ?></p>
            </div>
        </div>

        <!-- Comments Section -->
        <div id="comments" class="card p-5 media mx-5 mt-3">
            <h2 for="commentForm" class="form-label">Comments</h2>
            <!--Comment-->
            <div class="row m-2">
                <?php
                    $sql = "SELECT * FROM comment INNER JOIN user ON user.user_id = comment.user_id WHERE comment.post_id = '$id' ORDER BY comment.date_posted DESC LIMIT 2;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="media">
                            <div class="row">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                    class="mr-3 col-1 rounded-circle" alt="Profile Picture">
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

            </div>


            <!-- View more comments button -->
            <button type="button" class="btn btn-outline-primary mt-4" id="viewMoreComments">View more comments</button>

        </div>

        <!-- Post a comment form -->
        <div class="card mx-5 mt-5" id="container">
            <form id="postThis" method="post">
                <div class="mb-3 m-5">
                    <h2 for="commentForm" class="form-label">Post a comment</h2>
                    <textarea name="comment_content" class="form-control" id="commentForm" rows="3" cols="11"
                        placeholder="Write a comment..." required></textarea>
                    <br>

                    <label for="imageComment">Image</label>
                    <input type="file" name="imageComment" class="form-control" id="imageComment" />
                    <br>

                    <button type="submit" name="comment" class="btn btn-primary mb-5"><i class="bi bi-send-fill"></i>
                        Post</button>
                </div>

                <input type="hidden" name="id" value="<?php echo $id; ?>">
            </form>
        </div>
        </br>

        <?php } ?>

        <!--JS Bootstrap CDN-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>


        <script>
        $(document).ready(function() {
            //Uploading a Post
            $(document).on('submit', '#uploadPost', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("upload_post", true);

                $.ajax({
                    type: "POST",
                    url: "code.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 422) {
                            $('#errorMessage').removeClass('d-none');
                            $('#errorMessage').text(res.message);
                        } else if (res.status == 200) {
                            $('#errorMessage').addClass('d-none');
                            $('#exampleModal').modal('hide');
                            $('#uploadPost')[0].reset();
                            window.location.href = "home.php";
                        } else if (res.status == 500) {
                            alert(res.message);
                        }
                    }
                });

            });

            //Get Post ID
            $(document).on('click', '.editPostBtn', function() {
                var post_id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "code.php?post_id=" + post_id,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 422) {
                            alert(res.message);
                        } else if (res.status == 200) {
                            $('#post_id').val(res.data.post_id);
                            $('#post_status').val(res.data.post_status);
                            $('#summary').val(res.data.summary);
                        }
                    }
                });
            });

            //Update Post
            $(document).on('submit', '#updatePost', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("update_post", true);

                $.ajax({
                    type: "POST",
                    url: "code.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 422) {
                            $('#errorMessageUpdate').removeClass('d-none');
                            $('#errorMessageUpdate').text(res.message);

                        } else if (res.status == 200) {

                            $('#errorMessageUpdate').addClass('d-none');

                            $('#exampleModalEdit').modal('hide');
                            $('#updatePost')[0].reset();
                            window.location.href = "home.php";

                        } else if (res.status == 500) {
                            alert(res.message);
                        }
                    }
                });

            });

            //Posting a Comment
            $(document).on('submit', '#postThis', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("post_this", true);

                $.ajax({
                    type: "POST",
                    url: "code.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 422) {
                            $('#errorMessage').removeClass('d-none');
                            $('#errorMessage').text(res.message);
                        } else if (res.status == 200) {
                            $('#errorMessage').addClass('d-none');
                            $('#exampleModal').modal('hide');
                            $('#uploadPost')[0].reset();
                            // window.location = 'home.php#comments';
                            window.location = 'home.php';
                        } else if (res.status == 500) {
                            alert(res.message);
                        }
                    }
                });
            });

            //AJAX for Searching
            $('#searchButton').click(function() {
                var keyword = $('#searchInput').val();
                $.ajax({
                    type: 'POST',
                    url: 'search.php',
                    data: {
                        keyword: keyword
                    },
                    success: function(response) {
                        $('#searchResults').html(response);
                    }
                });
            });

            //View more comments
            var commentCount = 2;
            $("#viewMoreComments").click(function() {
                commentCount = commentCount + 2;
                $("#comments").load("load-comments.php", {
                    commentNewCount: commentCount
                });
            });
        });
        </script>
</body>

</html>