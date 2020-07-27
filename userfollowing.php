<?php
    include("config/connection.php");
    $db = new Database();
    include('object/user.php');
    $user = new User($db);
    include('object/report.php');
    $report = new Report($db);

    // Get UserID By User EmailID 
    $userid=$user->finduserid($_SESSION['email']);
?>

<div class="container">
    <table class="table">
        <?php
            // User Following List
            $report->findfollowing($userid);
        ?>
    </table>
</div>

