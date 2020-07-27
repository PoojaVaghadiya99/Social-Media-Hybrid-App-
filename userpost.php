<?php
    include("config/connection.php");
    $db = new Database();
    include('object/user.php');
    $user = new User($db);
    include('object/post.php');
    $post = new Post($db);

    // Get UserID By User EmailID 
    $userid=$user->finduserid($_SESSION['email']);
    $a=$post->findpost($userid);
?>

<center>
    <table>
        <div class="row container m-0 p-0">
        
            <?php
            $c=mysqli_num_rows($a);
            if ($c > 0) 
            {
                while($row = mysqli_fetch_assoc($a)) 
                {
                    ?>
                            <div class="col-lg-4 col-md-4 col-4 m-0 padding">
                                <img src="<?php echo $row['post_img']; ?>" class="img-fluid m-0 p-0"/>
                            </div>    
                            
                    <?php
                }
            }
            ?>   
            </div> 
        </table>
</center>

