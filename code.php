<?php
require 'includes/dbconn.php';

if(isset($_POST['upload_post']))
{
    $section_title = mysqli_real_escape_string($conn, $_POST['section_title']);
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

    $query = "INSERT INTO `post`(`section_title`, `content`, `picture`) VALUES ('$section_title','$content','$image')";
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
?>