<?php
    include("config/connection.php");
    $db = new Database();
    include('object/user.php');
    $user = new User($db);
    include('object/report.php');
    $report = new Report($db);
    include('object/post.php');
    $post = new Post($db);

    $userid=$user->finduserid($_SESSION['email']);

    
    include("header.php");

    
    // Get UserID By User EmailID 
    $userid=$user->finduserid($_SESSION['email']);
    // Find User Following
    $following=$report->totalfollowing($userid);
    // Find User Follower
    $follower=$report->totalfollower($userid);
    // Find User Post
    $totalpost=$post->totalpost($userid);
    // Find Profile Photo
    $photo=$user->profilephoto($userid);

    
    // Print UserName and EmailID 
    $username=$user->getusername($_SESSION['email']); 
?>

<style>
</style>

<script>
function UserPost() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("data").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "userpost.php", true);
  xhttp.send();
}

function UserFollower() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("data").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "userfollower.php", true);
  xhttp.send();
}

function UserFollowing() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("data").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "userfollowing.php", true);
  xhttp.send();
}

function SavePost() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("data").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "savepost.php", true);
  xhttp.send();
}

function LikePost() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("data").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "likepost.php", true);
  xhttp.send();
}

</script>


<div class="container mt-3 t">

  <div class="row justify-content-md-center">

    <div class="col col-lg-2 col-md-2 col-12">
      <?php if($photo == "") { ?>
        <img src="./src/img/c.png" class="img-fluid avatar">
      <?php } else { ?>
        <img src="<?php echo $photo; ?>" class="img-fluid avatar">
      <?php } ?>
    </div>

    <br>

    <div class="col col-lg-5 col-md-5 col-12">
    
      <div class="row justify-content-md-center mt-3">
        <div class="col col-lg-12 col-md-12 col-12 t">
          <strong><?php echo $username; ?></strong>
        </div>
      </div>
      
      <br>
      
      <div class="row justify-content-md-center">

        <div class="col col-lg-4 col-md-4 col-4 t">
          <a href="#" class="text-secondary t" id="load" onclick="UserPost()">
            <h6 class="t">Post</h6>
            <h6 class='t'><?php echo $totalpost; ?></h6>
          </a>
          <hr width="80%" class="mt-0">
        </div>

        <div class="col col-lg-4 col-md-4 col-4 t mb-0">
          <a href="#content" class="text-secondary t" onclick="UserFollowing()">
            <h6 class="t">Following</h6>
            <h6 class='t'><?php echo $following; ?></h6>
          </a>
          <hr width="80%" class="mt-0">
        </div>

        <div class="col col-lg-4 col-md-4 col-4 t">
          <a href="#content" class="text-secondary t" onclick="UserFollower()">
            <h6 class="t">Follower</h6>
            <h6 class='t'><?php echo $follower; ?></h6>
          </a>
          <hr width="80%" class="mt-0">
        </div>
      </div>

     </div>
   </div>
</div>

  
<div class="mb-2 text-center mt-3">
  <i class="fa fa-bookmark mr-5 ml-5" aria-hidden="true" onclick="SavePost()"></i>&nbsp;&nbsp;&nbsp;
  <i class="fa fa-heart mr-5 ml-5" aria-hidden="true" onclick="LikePost()"></i>&nbsp;&nbsp;&nbsp;
</div>  

<div id="data" class="mt-3">
        <?php
          
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
</div>


<?php include("footer.php"); ?>

