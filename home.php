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
        <h1>Post and Comment System</h1>

        <h2>Welcome - <?php echo $fullname; ?></h2>

        <!-- Upload Button Trigger Modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Upload
        </button>

        <!--Logout Button-->
        <a href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a>

        <!-- Modal Form-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
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
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Menu item</a></li>
                <li><a class="dropdown-item" href="#">Menu item</a></li>
                <li><a class="dropdown-item" href="#">Menu item</a></li>
            </ul>
        </div>

        <!--Content of the Post-->

        <?php	
		$query = mysqli_query($conn,"SELECT *,UNIX_TIMESTAMP() - date_created AS TimeSpent from post LEFT JOIN user on user.user_id = post.user_id order by post_id DESC")or die(mysqli_error());
		while($post_row=mysqli_fetch_array($query)){
		    $id = $post_row['post_id'];	
		    $upid = $post_row['user_id'];	
		    $posted_by = $post_row['firstname']." ".$post_row['lastname'];
	?>
        <a style="text-decoration:none; float:right;" href="deletepost.php<?php echo '?id='.$id; ?>"><button
                class="btn btn-danger">Delete Post</button></a>
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

        <div class="card mx-5">
            <div class="card-body m-5">
                <h2 class="card-title text-center m-5">Subject: This is a subject title example</h2>
                <p class="card-title fw-bold">Posted by: Jasper Macaraeg <?php echo $posted_by; ?></p>
                <p class="card-text"><small class="text-body-secondary">June 15, 2023 at 3:14pm</small></p>
                <p class="card-text"><?php echo $post_row['content']; ?></p>
                <img src="images/screenshot2.jpg" class="card-img-bottom img-thumbnail" alt="..." target="_blank">
            </div>
        </div>



        <div id="container">
            <form method="post">
                <div class="mb-3 m-5">
                    <h2 for="commentForm" class="form-label">Post a comment</h2>
                    <textarea name="comment_content" class="form-control" id="commentForm" rows="3" cols="11"
                        placeholder="Write a comment..." required></textarea>
                    <br>

                    <label for="imageComment">Image</label>
                    <input type="file" name="image" class="form-control" id="imageComment" />
                    <br>

                    <button type="submit" name="comment" class="btn btn-primary"><i class="bi bi-send-fill"></i>
                        Send</button>
                </div>

                <input type="hidden" name="id" value="<?php echo $id; ?>">
            </form>

            </br>

            <?php 
								$comment_query = mysqli_query($conn,"SELECT * ,UNIX_TIMESTAMP() - date_posted AS TimeSpent FROM comment LEFT JOIN user on user.user_id = comment.user_id where post_id = '$id'") or die (mysqli_error());
								while ($comment_row=mysqli_fetch_array($comment_query)){
    								$comment_id = $comment_row['comment_id'];
    								$comment_by = $comment_row['firstname']." ".  $comment_row['lastname'];
							?>
            <br><?php echo $comment_by; ?> - <?php echo $comment_row['content']; ?>
            <br>
            <?php				
								$days = floor($comment_row['TimeSpent'] / (60 * 60 * 24));
								$remainder = $comment_row['TimeSpent'] % (60 * 60 * 24);
								$hours = floor($remainder / (60 * 60));
								$remainder = $remainder % (60 * 60);
								$minutes = floor($remainder / 60);
								$seconds = $remainder % 60;
								if($days > 0)
								echo date('F d, Y - H:i:sa', $comment_row['date_posted']);
								elseif($days == 0 && $hours == 0 && $minutes == 0)
								echo "A few seconds ago";		
								elseif($days == 0 && $hours == 0)
								echo $minutes.' minutes ago';
							?>
            <br>
            <?php
							}
							?>

            <?php 
					if ($u_id = $id){
					?>



            <?php }else{ ?>

            <?php
					} } ?>


            <?php
								if (isset($_POST['post'])){
								$post_content  = $_POST['post_content'];
								
								mysqli_query($conn,"insert into post (content,date_created,user_id) values ('$post_content','".strtotime(date("Y-m-d h:i:sa"))."','$user_id') ")or die(mysqli_error());
								header('location:home.php');
								}
							?>

            <?php
							
								if (isset($_POST['comment'])){
								$comment_content = $_POST['comment_content'];
								$post_id=$_POST['id'];
								
								mysqli_query($conn,"insert into comment (content,date_posted,user_id,post_id) values ('$comment_content','".strtotime(date("Y-m-d h:i:sa"))."','$user_id','$post_id')") or die (mysqli_error());
								header('location:home.php');
								}
							?>

            <!-- Comments -->
            <div class="media mx-5">
                <h2 for="commentForm" class="form-label">Comments</h2>
                <!--Picture of the user-->
                <img width="50px" height="50px" style="border-radius: 100px;"
                    src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />
                <div class="media-body">
                    <!--Name of the commenter-->
                    <h4 class="media-heading">John Doe</h4>
                    <!--Comment of the user-->
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem
                        ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>

                    <!--Timestamp when did this comment-->
                    <ul class="list-unstyled list-inline media-detail pull-left">
                        <li>May 27, 2015 at 3:14am</li>
                    </ul>
                </div>
            </div>
        </div>

        <!--JS Bootstrap CDN-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>

        <!--Uploading a Post-->
        <script>
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
        </script>
</body>

</html>