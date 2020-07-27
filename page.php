<?php
    include("config/connection.php");
    $db = new Database();
    include('object/user.php');
    $user = new User($db);
    include("header.php");

    $id=$user->finduserid($_SESSION['email']);

    $values=array();
    if($stmt=$db->runBaseQuery("select * from follow_report where userid='".$id."'"))
    {
        while($r=$stmt->fetch_array(MYSQLI_ASSOC))
        {
            $values[]=$r['pageid'];
        }
    }
?>

<script>
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#user tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

<div class="container">

<div class="active-pink-4 mb-4">
  <input class="form-control" type="text" id="myInput" placeholder="Search" aria-label="Search">
</div>

<table class="table" id="user">
    
<?php
    if($stmt=$db->runBaseQuery("select * from user where id!=".$id))
    {
        while($r=$stmt->fetch_array(MYSQLI_ASSOC))
        {
?>
          <tr>
            <td>
            <?php if($r['img'] == "") { ?>
                <img src="./src/img/c.png" class="post-avatar">
            <?php } else { ?>
                <img src="<?php echo $r['img']; ?>" class="post-avatar">
            <?php } ?>
        
            </td>
        
            <td><?php echo $r['username'] ?></td>
        
            <?php
                if(in_array($r['id'],$values))
                {
            ?>
        
            <td>
                <a class="btn btn-info" href="index.php?action=follow_report&userid=<?php echo $id; ?>&pageid=<?php echo $r['id']; ?>&follow=<?php echo $r['follower']; ?>" onClick="return unsub();"><?php echo "UnFollow"; ?></a>
            </td>
        
            <?php } else { ?>
         
            <td>
                <a class="btn btn-info" href="index.php?action=follow_report&userid=<?php echo $id; ?>&pageid=<?php echo $r['id']; ?>" onClick="return sub();"><?php echo "Follow"; ?></a>
            </td>
         
            <?php
                  }
            ?>
          </tr>
        
        <?php
        }
      } 
    ?>
  </table>
</div>

<?php include("footer.php"); ?>