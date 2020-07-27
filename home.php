<?php

    include("config/connection.php");
    $db = new Database();
    include('object/user.php');
    $user = new User($db);
    include('object/post.php');
    $post = new Post($db);
    include('object/report.php');
    $report = new Report($db);
    include('object/like.php');
    include("header.php");

    // Get UserID By User EmailID 
    $userid=$user->finduserid($_SESSION['email']);

    $result=$post->getalluserpost();

    if($result)
    {
        $c=mysqli_num_rows($result);
        if ($c > 0) 
        {
            // User Following List
            $all=$report->findfollowingid($userid);
            array_push($all,$userid);
              
            $postid=$post->userpost($all);
            // print_r($postid);
                        
            foreach($postid as $postid)
            {
                // echo $post;
                $loadpost=$post->loadpost($postid,$userid);
                // print_r($loadpost);
                while($row = mysqli_fetch_assoc($loadpost)) 
                {
                    $mydate=$row['created'];
                    $datetime=$user->dateDiff($mydate);
                                
?>
                    <div class="container-flunet mb-1 mr-0 ml-0 postbox">
                        <div class="row mr-0 ml-0 justify-content-md-center">
                            <div class="col col-lg-7 col-md-12 col-12 border-all mr-0 ml-0">
                                
                                <div class="post-title_ mt-1">
                                    <?php
                                    // Find Profile Photo
                                    $photo=$user->profilephoto($row["userid"]);
                                    if($photo == "") 
                                    { 
                                    ?>
                                        <img src="./src/img/c.png" class="post-avatar float-left m-2">
                                
                                        <?php } else { ?>
                                
                                        <img src="<?php echo $photo; ?>" class="post-avatar float-left m-2">
                                
                                    <?php } ?>
                                    
                                    <span class="username"><?php echo $user->findusername($row["userid"]); ?></span>
                                    
                                    <i class="fa fa-ellipsis-v float-right a mr-3 mt-3" aria-hidden="true"></i>
                                </div>
                                
                                <div class="post-img">                
                                    <?php 
                                        $checkfiletype = $post->checkfiletype($row['post_img']); 
                                        if($checkfiletype == "image")
                                        {
                                            ?>
                                            <img src="<?php echo $row['post_img']; ?>" width="100%" height="100%">
                                            <?php
                                        }
                                        else if($checkfiletype == "video")
                                        {
                                            ?>
                                            <video width="100%" height="100%" controls autoplay>
                                                <source src="<?php echo $row['post_img']; ?>">
                                            </video>
                                            <?php
                                        }
                                        else if($checkfiletype == "audio")
                                        {
                                            ?>
                                            <?php
                                        }
                                        else 
                                        {
                                            ?>
                                            <iframe src="<?php echo $row['post_img']; ?>" width="100%" height="100%" style="border:none;"></iframe>
                                            <?php
                                        }
                                    ?>
                                 </div>
                            
                                <div class="post-description-icon m-2">
                                    
                                    <i <?php if (userLiked($row['id'])): ?>
                                        class="fa fa-thumbs-up like-btn a"
                                        <?php else: ?>
                                        class="fa fa-thumbs-o-up like-btn a"
                                        <?php endif ?>
                                        data-id="<?php echo $row['id'] ?>">
                                    </i>
                                  
                                    <span class="likes"><?php echo getLikes($row['id']); ?></span>
                                   
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <!-- if user dislikes post, style button differently -->
                                    <i <?php if (userDisliked($row['id'])): ?>
                                        class="fa fa-thumbs-down dislike-btn a"
                                        <?php else: ?>
                                        class="fa fa-thumbs-o-down dislike-btn a"
                                        <?php endif ?>
                                        data-id="<?php echo $row['id'] ?>">
                                    </i>
                                        
                                    <span class="dislikes"><?php echo getDislikes($row['id']); ?></span>
                                                
                                    <!-- Save -->
                                    <i <?php if (userSaved($row['id'])): ?>
                                        class="fa fa-bookmark save-btn float-right a"
                                        <?php else: ?>
                                        class="fa fa-bookmark-o save-btn float-right a"
                                        <?php endif ?>
                                        data-id="<?php echo $row['id'] ?>">
                                    </i>
                                
                                </div>
                                      
                                <!-- Date -->
                                <div class="ml-3"><?php echo $datetime; ?></div>

                            </div>
                        </div>
                    </div>
                <?php        
                }
            }
        }
    }
?>

<script>

$(document).ready(function(){

// if the user clicks on the like button ...
$('.like-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.hasClass('fa-thumbs-o-up')) {
  	action = 'like';
  } else if($clicked_btn.hasClass('fa-thumbs-up')){
  	action = 'unlike';
  }
  $.ajax({
  	url: 'Home.php',
  	type: 'post',
  	data: {
  		'action': action,
  		'post_id': post_id
  	},
  	success: function(data){
  		res = JSON.parse(data);
  		if (action == "like") {
  			$clicked_btn.removeClass('fa-thumbs-o-up');
  			$clicked_btn.addClass('fa-thumbs-up');
  		} else if(action == "unlike") {
  			$clicked_btn.removeClass('fa-thumbs-up');
  			$clicked_btn.addClass('fa-thumbs-o-up');
  		}
  		// display the number of likes and dislikes
  		$clicked_btn.siblings('span.likes').text(res.likes);
  		$clicked_btn.siblings('span.dislikes').text(res.dislikes);

  		// change button styling of the other button if user is reacting the second time to post
  		$clicked_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
  	}
  });		

});

// if the user clicks on the dislike button ...
$('.dislike-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.hasClass('fa-thumbs-o-down')) {
  	action = 'dislike';
  } else if($clicked_btn.hasClass('fa-thumbs-down')){
  	action = 'undislike';
  }
  $.ajax({
  	url: 'Home.php',
  	type: 'post',
  	data: {
  		'action': action,
  		'post_id': post_id
  	},
  	success: function(data){
  		res = JSON.parse(data);
  		if (action == "dislike") {
  			$clicked_btn.removeClass('fa-thumbs-o-down');
  			$clicked_btn.addClass('fa-thumbs-down');
  		} else if(action == "undislike") {
  			$clicked_btn.removeClass('fa-thumbs-down');
  			$clicked_btn.addClass('fa-thumbs-o-down');
  		}
  		// display the number of likes and dislikes
  		$clicked_btn.siblings('span.likes').text(res.likes);
  		$clicked_btn.siblings('span.dislikes').text(res.dislikes);
  		
  		// change button styling of the other button if user is reacting the second time to post
  		$clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
  	}
  });	

});

// Save

$('.save-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.hasClass('fa-bookmark-o')) {
  	action = 'save';
  } else if($clicked_btn.hasClass('fa-bookmark')){
  	action = 'unsave';
  }
  $.ajax({
  	url: 'Home.php',
  	type: 'post',
  	data: {
  		'action': action,
  		'post_id': post_id
  	},
  	success: function(data){
  		res = JSON.parse(data);
  		if (action == "save") {
  			$clicked_btn.removeClass('fa-bookmark-o');
  			$clicked_btn.addClass('fa-bookmark');
  		} else if(action == "unsave") {
  			$clicked_btn.removeClass('fa-bookmark');
  			$clicked_btn.addClass('fa-bookmark-o');
  		}
  		// display the number of saves and dissaves
  		$clicked_btn.siblings('span.saves').text(res.saves);
  		$clicked_btn.siblings('span.dissaves').text(res.dissaves);

  		// change button styling of the other button if user is reacting the second time to post
  		$clicked_btn.siblings('i.fa-bookmark').removeClass('fa-bookmark').addClass('fa-bookmark-o');
  	}
  });		

});


});
</script>

<?php include("footer.php"); ?>