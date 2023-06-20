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
    <script src="js/alert.js"></script>
    <!--Alert CSS-->
    <link rel="stylesheet" href="css/alert.css">

    <!--AJAX-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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
        border-top: 1px dashed #dddddd;
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

        <h2>Welcome - <?php echo $fullname; ?></h2>

        <!-- Upload Button Trigger Modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Upload
        </button>

        <!--Logout Button-->
        <a href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a>

        <!-- Modal Form-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <textarea class="form-control" name="content" rows="5"></textarea>
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

        <!--Search-->
        <div class="input-group mb-3 mt-3">
            <input type="text" class="form-control" placeholder="Search in conversation" aria-label="search-subject"
                aria-describedby="search-subject">
            <button class="btn btn-primary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
        </div>

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
		$query = mysqli_query($conn,"SELECT *,UNIX_TIMESTAMP() - date_created AS TimeSpent from post LEFT JOIN user on user.user_id = post.user_id order by post_id DESC");
		while($post_row=mysqli_fetch_array($query)){
		    $id = $post_row['post_id'];	
		    $upid = $post_row['user_id'];	
		    $posted_by = $post_row['firstname']." ".$post_row['lastname'];
	    ?>

        <?php				
		    $days = floor($post_row['TimeSpent'] / (60 * 60 * 24));
			$remainder = $post_row['TimeSpent'] % (60 * 60 * 24);
			$hours = floor($remainder / (60 * 60));
			$remainder = $remainder % (60 * 60);
			$minutes = floor($remainder / 60);
			$seconds = $remainder % 60;
			if($days > 0)
			echo date('F d, Y - H:i:sa', $post_row['date_created']);
			elseif($days == 0 && $hours == 0 && $minutes == 0)
			echo "A few seconds ago";		
			elseif($days == 0 && $hours == 0)
			echo $minutes.' minutes ago';
		?>

        </p>

        <!-- Post Content -->
        <div class="card mx-5">
            <!-- Delete Post -->
            <div class="row">
                <div class="col-2 m-3 float-right">
                    <a style="text-decoration:none;" href="#"><button class="btn btn-warning"><i
                                class="bi bi-pencil-square"></i></button></a>
                    <a style="text-decoration:none;" href="deletepost.php<?php echo '?id='.$id; ?>"><button
                            class="btn btn-danger"><i class="bi bi-trash"></i></button></a>
                </div>
            </div>

            <div class="card-body m-5">

                <!-- Content of the post -->
                <h2 class="card-title text-center mb-5"><?php echo $post_row['section_title']; ?></h2>
                <span class="badge rounded-pill text-bg-primary">Priority</span>
                <span class="badge rounded-pill text-bg-danger">Not Priority</span>
                <span class="badge rounded-pill text-bg-success">Resolved</span>
                <p class="card-title fw-bold">Posted by:
                    <?php echo $post_row['firstname'] . " " . $post_row['lastname']; ?></p>
                <p class="card-text"><small class="text-body-secondary"><?php echo $post_row['date_created']; ?></small>
                </p>
                <p class="card-text"><?php echo $post_row['content']; ?></p>
                <img src="images/<?php echo $post_row['picture']; ?>" class="card-img-bottom img-thumbnail" alt="..."
                    target="_blank">
                <h2 class="card-title mt-3">Summary</h2>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus doloremque
                    autem quo repellat ducimus porro est itaque! Tempore blanditiis perspiciatis iste in asperiores non
                    odio cupiditate porro error, deserunt enim doloribus ad quidem nostrum tenetur molestiae minima,
                    quasi et natus nesciunt. Delectus excepturi laudantium quas ducimus reiciendis sequi in laboriosam.
                </p>
            </div>
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


        <!-- Comments Section -->
        <div id="comments" class="card p-5 media mx-5">
            <h2 for="commentForm" class="form-label">Comments</h2>
            <!--Comment-->
            <div class="card mt-2">
                <div class="row">
                    <?php
                        $sql = "SELECT * FROM comment LIMIT 10";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <!-- Image of the commenter -->
                    <img class="rounded-circle col-1 m-3" src="https://bootdey.com/img/Content/avatar/avatar1.png"
                        alt="" />
                    <!--Name of the commenter-->
                    <h4 class="media-heading col-10 mt-3"><?php echo $row['user_id']; ?></h4>
                    <!--Comment of the commenter-->
                    <p class="col-12 mx-3">
                        <?php echo $row['content']; ?>
                    </p>

                    <!--Timestamp when did this comment-->
                    <ul class="list-unstyled list-inline media-detail pull-left mx-3">
                        <li><?php echo $row['date_posted']; ?></li>
                    </ul>
                    <?php
                            }
                        }else{
                            echo "There are no comments!";
                        }
                    ?>

                </div>
            </div>

            <!-- View more comments button -->
            <button type="button" class="btn btn-outline-primary mt-4" id="viewMoreComments">View more comments</button>

        </div>

        <!--JS Bootstrap CDN-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>


        <script>
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
                        window.location = 'home.php';
                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });
        });

        //Show more comments
        // $(document).ready(function {
        //     var commentCount = 10;
        //     $("#viewMoreComments").click(function() {
        //         commentCount = commentCount + 5;
        //         $("#comments").load("load-comments.php", {
        //             commentNewCount: commentCount
        //         });
        //     });
        // })
        </script>
</body>

</html>