<?php
require 'includes/dbconn.php';
include('session.php');

//Add Post
if(isset($_POST['upload_post']))
{
    $user_id=$_SESSION['id'];
    $section_title = mysqli_real_escape_string($conn, $_POST['section_title']);
    $post_status = mysqli_real_escape_string($conn, $_POST['post_status']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $img=$_FILES["image"]["name"];
    $extension = substr($img,strlen($img)-4,strlen($img));
    $allowed_extensions = array(".jpg","jpeg",".png",".gif");
    $img=md5($img).time().$extension;
    move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$img);
        
    $image = mysqli_real_escape_string($conn, $img);
    //$image = mysqli_real_escape_string($conn, "517dcc35f07ca8e52cfdd588ac861dc51670484801.jpg");

    if($section_title == NULL || $content == NULL || $image == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "INSERT INTO `post`(`user_id`, `section_title`, `content`, `action`, `picture`) VALUES ('$user_id','$section_title','$content','$post_status','$image')";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Post Created Successfully'
        ];
        echo json_encode($res);
        return false;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Post Not Created'
        ];
        echo json_encode($res);
        return false;
    }
}

//Add Comment
if(isset($_POST['post_this'])){
    $user_id=$_SESSION['id'];
    $comment_content = mysqli_real_escape_string($conn, $_POST['comment_content']);
    $post_id=$_POST['id'];
    $image = '';
    
    if($_FILES["imageComment"]["name"] == NULL){
        $image = NULL;
    }else{
        $img=$_FILES["imageComment"]["name"];
        $extension = substr($img,strlen($img)-4,strlen($img));
        $allowed_extensions = array(".jpg","jpeg",".png",".gif",".webp");
        $img=md5($img).time().$extension;
        move_uploaded_file($_FILES["imageComment"]["tmp_name"],"images/".$img);
        $image = mysqli_real_escape_string($conn, $img);
    }
    

    if($comment_content == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'You must comment something'
        ];
        echo json_encode($res);
        return false;
    }


    $query = "INSERT INTO `comment`(`user_id`, `post_id`, `content`, `picture`) VALUES ('$user_id','$post_id','$comment_content','$image')";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Comment Created Successfully'
        ];
        echo json_encode($res);
        return false;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Comment Not Created'
        ];
        echo json_encode($res);
        return false;
    }
}

// Get Edit Post
if(isset($_GET['post_id']))
{
    $post_id = mysqli_real_escape_string($conn, $_GET['post_id']);

    $query = "SELECT * FROM `post` WHERE post_id='$post_id'";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $post = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Post Edit Successfully',
            'data' => $post
        ];
        echo json_encode($res);
        return false;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Post Id Not Found'
        ];
        echo json_encode($res);
        return false;
    }
}

// Edit Post
if(isset($_POST['update_post']))
{
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);

    $action = mysqli_real_escape_string($conn, $_POST['post_status']);
    $summary = mysqli_real_escape_string($conn, $_POST['summary']);

    if($action == NULL || $summary == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'You must edit something'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE `post` SET action='$action', summary='$summary' WHERE post_id='$post_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Post Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Post Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}

?>