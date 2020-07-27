<?php 

  include("config/connection.php");
  $db = new Database();

  include('object/user.php');
  include('object/report.php');
  include('object/post.php');
  include('object/like.php');

  $action=null;
	if(!empty($_GET["action"]))
	{
		$action=$_GET["action"];
  }
  
	switch($action)
	{
    case "follow_report":
      if(((null!=$_GET['userid']) AND (null!=$_GET['pageid'])) AND (null==$_GET['follow']))
      {
        $userid=$_GET['userid'];
        $pageid=$_GET['pageid'];
        $report = new Report($db);
        $report->addreport($userid,$pageid);
        header("Location: page.php");
      }
      else if(((null!=$_GET['userid']) and (null!=$_GET['pageid']) and (null!=$_GET['follow'])))
      {
        $userid=$_GET['userid'];
        $pageid=$_GET['pageid'];
        $report = new Report($db);
        $report->deletereport($userid,$pageid);
        header("Location: page.php");
      }
      else 
      {
        echo "Somthing Wents Wrong !!";    
      }
      break;
    default:
      break;
  }

  // Check User Login Or Not

  if(empty($_SESSION['email']))
  {
    header("Location: login.php");
  }

  if(isset($_SESSION['email']))
  {
     header("Location: home.php");
  }

  // Login

  if(isset($_POST['login']))
  {
    $email=$_POST['email'];
    $password=$_POST['pass'];
    $user = new User($db);
    $user->login($email,$password);
  }

  // Register

  if(isset($_POST['reg']))
  {
    $username=$_POST['user'];
    $email=$_POST['email'];
    $password=$_POST['pass'];
    $user = new User($db);

    $check=$user->CheckUserUnique($email);
    if($check == true)
    {
      $user->ragister($username,$email,$password);
    }
    else 
    {
      header("Location: register.php");
    }
  }

  // Logout

  if(isset($_GET['logout']))
  {
    $user = new User($db);
    $user->logout();
  }

  // Add Post
  
  if(isset($_POST["add_post"]))
	{
		$filename=$_FILES["img"]["name"];
		$tempname=$_FILES["img"]["tmp_name"];
		$folder="src/img/post/".$filename;
    move_uploaded_file($tempname,$folder);
    
    $title=$_POST['title'];
    $description=$_POST['description'];

    $post= new Post($db);
    $user =new User($db);
    $userid=$user->finduserid($_SESSION['email']);
    $view=0;
    $post->addpost($title,$description,$folder,$userid,$view);
  }

  // Change Password

  if(isset($_POST['change_password']))
  {
    $old=$_POST['oldpass'];
    $new=$_POST['newpass'];
    $id=$_POST['userid'];

    $user =new User($db);
    $user->changepassword($new,$id);
  }

  // Set Profile 

  if(isset($_POST['change_profile']))
  {
    $username=$_POST['username'];
    $gender=$_POST['inlineRadioOptions'];
    $id=$_POST['userid'];
    
    $user =new User($db);
    $user->changeuserinfo($username,$gender,$id);
    header("Location: setting.php");
  }

  // Set Profile 

  if(isset($_POST['change_profile_img']))
  {
    $filename=$_FILES["img"]["name"];
		$tempname=$_FILES["img"]["tmp_name"];
		$folder="src/img/profile/".$filename;
    move_uploaded_file($tempname,$folder);

    $id=$_POST['userid'];
    
    $user =new User($db);
    $user->changeuserprofile($folder,$id);
    header("Location: setting.php");
  }

  ?>
  