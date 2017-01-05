<?php 
    session_start();
    require_once("functions.php");
    $page = isset($_GET["page"]) ? $_GET["page"] :  'home';
    $pgname = (isset($_SESSION['username'])) ? 'logout' : 'login';
    $pageRegister = (isset($_SESSION['username'])) ? '' : 'register';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Adina's project</title>
    
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>

     function doReset(){
        var oldPassword = $('#oldPassword').val();
        var newPassword =  $('#newPassword').val();
        var newConfirmPassword =  $('#confirmPassword').val();

        if(oldPassword == ''){
            $('#oldPasswordErr').text("This field cannot be empty");
            flag = false;
        }
        else {
            $('#oldPasswordErr').text('');
        }

        if(newPassword == ''){
            $('#newPasswordErr').text("This field cannot be empty");
            flag = false;
        }
        else {
            $('#newPasswordErr').text('');
        }
        if(newConfirmPassword == ''){
            $('#confirmPasswordErr').text("This field cannot be empty");
            flag = false;
        }
        else {
            $('#confirmPasswordErr').text('');
        }
        if(newPassword != newConfirmPassword){
             $('#newPasswordErr').text("Password don t match.");
             $('#confirmPasswordErr').text("Password don t match.");
             flag = false;
        }
        if (flag) {
            return true;
        }
        return false;

     } 
     function doSubmitLogic(){
         var email = $('#email').val();
         var password = $('#password').val();

         if (email == '') {
            $('#emailErr').text('The email cannot be empty!');
             flag = false; 
          }
          else {
            $('#emailErr').text('');
          }
         if (password == '') {
            $('#passErr').text('The password cannot be empty!');
            flag = false; 
          }
           else {
            $('#passErr').text('');
          }
         if (flag){
            return true;
          }
         return false;

     }
     function doSubmit(){
          var firstName = $('#firstName').val();
          var lastName = $('#lastName').val();
          var email = $('#email').val();
          var password = $('#password').val();
          var confirmPassword= $('#confirmPassword').val();
          var age = $('#age').val();
          var address = $('#address').val();
          var flag = true;

          if (firstName == '') {
               $('#firstNameErr').text('The firstname cannot be empty!');
               flag = false;
          }
          else {
              $('#firstNameErr').text('');
          }
          if (lastName == '') {
              $('#lastNameErr').text('The lastname cannot be empty!');
              flag=false;
          }
          else {
              $('#lastNameErr').text('');
          }
          if (email == '') {
             $('#emailErr').text('The email cannot be empty!');
             flag = false; 
          }
          else {
              $('#emailErr').text('');
          }
          if (password == '') {
            $('#passErr').text('The password cannot be empty!');
            flag = false; 
          }
           else {
              $('#passErr').text('');
          }
          // if (confirmPassword == ''){
          //    $('#confirmPasswordErr').text('The confirm password cannot be empty!');
          //    flag = false; 
          // }
          // else {
          //     $('#confirmPassword').text('');
          // }
          if ( confirmPassword != password) { 
              $('#confirmPasswordErr').html('Not matching').css('color', 'red');
              flag = false; 
          }
          if (age == '') {
              $('#ageErr').text('The age cannot be empty!');
              flag = false; 
          } else if (!age.match(/^\d+/)){
                 $('#ageErr').text('The age must be integer!'); 
                 flag = false; 
          }
           else {
              $('#ageErr').text('');
          }
          if (flag){
            return true;
          }
          return false;
      }

    </script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
        <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=admin">Admin</a></li>
            <li><a href="index.php?page=articles">Article page</a></li>
            <li><a href="index.php?page=profile">Profile</a></li>
            <?php if ($pgname == 'logout') { 
               ?>  <li><a href="action.scripts.php?actiune=logout">Logout</a></li> <?php 
            }else{
                ?> <li><a href="index.php?page=login">Login</a></li> <?php 
            } 
            if ($pageRegister == 'register') {?>
            <li><a href="index.php?page=register">Register</a></li>
            <?php } ?>
        </ul>

    <div id="content">
      <?php include($page.".php"); ?>
    </div>

  </div>
</nav>

</body>
</html>
