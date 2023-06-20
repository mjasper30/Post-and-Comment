<?php
    require 'includes/dbconn.php';

    $commentNewCount = $_POST['commentNewCount'];
    
    $sql = "SELECT * FROM comment LIMIT $commentNewCount";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
?>
<!-- Image of the commenter -->
<img class="rounded-circle col-1 m-3" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />
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