<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="./Lib/Css/Style.css"> -->
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text&family=Dancing+Script:wght@700&family=Montaga&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- Title -->
    <title>Instagram</title>
</head>

<body>
  <div class="container card p-3 mt-5 col-lg-6 col-md-10 col-10">

    <h3 class="text-center mb-3">Login</h3>
    
    <form action="index.php" name="loginForm" method="post">
      
      <div class="form-group m-2 p-2 h5 small">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" name="email" Required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">
      </div>
    
      <div class="form-group m-2 p-2 h5 small">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="pass" Required class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      
      <center><button type="submit" name="login" class="btn btn-primary m-2"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;&nbsp; Login</button></center>
    
      <br/>
      
      <center class="h5 small">You Are Not An Member ? <a href="Register.php">Sign Up</a></center>
    
    </form>
  </div>

  <!-- Custom JS -->
  <script src="Lib/js/valid.js"></script>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>