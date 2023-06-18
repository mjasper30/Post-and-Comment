<?php
    include('dbconn.php');
    include('session.php');
    if (isset($_POST['post'])){
        $content  = $_POST['content'];
        mysqli_query($conn,"insert into post (content,date_created,user_id) values ('$content','".strtotime(date("Y-m-d h:i:sa"))."','$user_id') ")or die(mysqli_error());
?>
    <script>
        window.location = 'home.php';
    </script>
<?php
    }
?>
