<?php

// id,post_title,post_description,post_img,userid,created,modified

class Post
{ 
    private $conn;
    private $table_name = "post";
	
    public function __construct($db)
	{
		 $this->conn = $db;
    }
	
	function addpost($post_title,$post_description,$post_img,$userid,$view) 
	{
        $query = "INSERT INTO " . $this->table_name . " (post_title,post_description,post_img,userid,created,modified,view) VALUES (?,?,?,?,now(),now(),?)";
        $paramType = "sssii";
        $paramValue = array($post_title,$post_description,$post_img,$userid,$view);
        $this->conn->insert($query,$paramType,$paramValue);
    }
    
    function editpost($title,$content,$id) 
	{
        $query = "UPDATE " . $this->table_name . " SET news_title = ?,news_content = ?,modified = now() WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array($title,$content,$id);
        $this->conn->update($query, $paramType, $paramValue);
    }
	
	function deletepost($newsid) 
	{
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $paramType = "i";
        $paramValue = array($newsid);
        $this->conn->update($query, $paramType, $paramValue);
    }
	
	function getallpost() 
	{
    	$sql = "SELECT * FROM " . $this->table_name . " ORDER BY id";
        $result = $this->conn->runBaseQuery($sql);
       	return $result;
    }
	
	function getuserpost($userid) 
	{
        $query = "SELECT * FROM " . $this->table_name . " WHERE userid = ?";
        $paramType = "i";
        $paramValue = array($userid);
        $result = $this->conn->runquery($query, $paramType, $paramValue);
        return $result;
    }

    
    function findpost($userid)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE userid = ? ORDER BY id DESC";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);    
        return $a;
    }

    function savepost($userid)
    {
        $query = "SELECT post.* FROM post LEFT JOIN save_report ON post.id = save_report.postid WHERE save_report.userid = ? ORDER BY post.id DESC";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);    
        return $a;
    }

    function likepost($userid)
    {
        $query = "SELECT post.* FROM post LEFT JOIN like_report ON post.id = like_report.postid WHERE like_report.userid = ? and like_report.rating_action = 'like' ORDER BY post.id DESC";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);    
        return $a;
    }

    function checkfiletype($filename)
    {
        $file_extension = explode('.',$filename);
        $file_extension = strtolower(end($file_extension));
        $image_type = array('jpeg','jpg','png','gif');
        $video_type = array('mp4','webm');
        if(in_array($file_extension,$image_type)) 
        {           
            return "image";
        }
        else if(in_array($file_extension,$video_type))
        {
            return "video";
        }
    }

    function loadpostbyuserid($userfollowingid)
    {
        $data=array();
        $query = "SELECT * FROM " . $this->table_name . " WHERE userid = ?";
        $paramType = "i";
        $paramValue = array($userfollowingid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);
        return $a;
    }

    function a($userfollowingid)
    {
        $data=array();
        $query = "SELECT id FROM " . $this->table_name . " WHERE userid = ?";
        $paramType = "i";
        $paramValue = array($userfollowingid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);
        return $a;
    }

    function loadpost($postid,$userid)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $paramType = "i";
        $paramValue = array($postid);
        $post=$this->conn->runQuery($query, $paramType, $paramValue);   
        return $post;
    }

    
    function getuserpostview($userid)
    {
        $query=  "select view from post where id=".$userid;
        $a=$this->conn->runBaseQuery($query);
        return $a;
    }

    function userpost($all)
    {
        $length=sizeof($all);
        if($length > 0)
        {
            $arr[] = array();
            foreach($all as $userfollowingid)
            {
                $loadpost=$this->a($userfollowingid);
                while($row = mysqli_fetch_assoc($loadpost)) 
                {
                    $arr[] = $row["id"];
                }
            }
            $l=sizeof($arr);
            if($l > 0)
            {
                rsort($arr);
                return $arr;
            }
        }
    }

    function totalpost($userid)
    {
        $counter=0;
        $query = "SELECT * FROM " . $this->table_name . " WHERE userid = ?";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);
        
        if($a)
        {
            $c=mysqli_num_rows($a);
            if ($c > 0) 
            {
                while($row = mysqli_fetch_assoc($a)) 
                {
                    $counter++;
                }
            }
        }
        return $counter;
    }

    function getalluserpost()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $a=$this->conn->runBaseQuery($query);
        return $a;
    }	
}

?>

