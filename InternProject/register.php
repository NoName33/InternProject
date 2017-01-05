
<div class="container">

<?php

if (isset($_GET['msg'])) {
    $mesaj = urldecode($_GET['msg']);
    echo "<h1>".$mesaj."</h1>";
}

?>
<div class="login-div">
    <form name="myForm" onSubmit="return doSubmit()" method="POST" action='action.scripts.php' enctype="multipart/form-data" role="form">
        <input type="hidden" name="actiune" value="register"/>
        <div class="form-group">
            <label> First Name </label>
            <input type="text" name="firstName" id="firstName" class="form-control" />
            <span id="firstNameErr"></span>
        </div>
        <div class="form-group">
            <label> Last Name </label>
            <input type="text" name = "lastName" id="lastName" class="form-control"/> <span  id="lastNameErr"></span >
        </div>
        <div class="form-group">
            <label> Email </label>
            <input type="email" name = "email" id="email" class="form-control"/><span id="emailErr"></span >
        </div>
        <div class="form-group">
            <label> Password </label>
            <input type="password" name = "password" id="password" class="form-control"/> <span  id="passErr"></span >
        </div>
        <div class="form-group">
            <label> Confirm Password </label>
            <input type="password" name = "confirmPassword" id="confirmPassword" class="form-control"/> <span  id="confirmPasswordErr"></span >
        </div>
        <div class="form-group">
            <label> Age </label>
            <input type="age" name = "age" id="age" class="form-control" /><span id="ageErr"></span >
        </div>
        <div class="form-group">
            <label> Address </label>
            <textarea name = "address" id="address" class="form-control"></textarea><span id="addressErr"></span >
        </div>
            <input id ="submitBtn" type="submit" class="btn btn-primary" name="button" value="Register"/>
       
    </form>


    <div id="emailError"> </div>

    </div>

</div>