
<div class="login_page">

<?php
if ( isset($_GET['msg']) ){
    $mesaj = urldecode($_GET['msg']);
    echo "<h1>".$mesaj."</h1>";
}
?>

</div>

<div class = "container">
<form method="POST" onSubmit="return doSubmitLogic()" action="action.scripts.php" role="form" >
    <input type="hidden" name="actiune" value="login" />
    <div class="form-group">
        <label> Email </label>
        <input type="email" name = "email" id="email" class="form-control"/><span id="emailErr"></span >
    </div>
    <div class="form-group">
        <label> Password </label>
        <input type="password" name = "password" id="password" class="form-control" /> <span  id="passErr"></span >
    </div>
    
    <div class="form-group">
        <input id ="submitBtn" type="submit" name="button" class="btn btn-primary" value="Send"/>
    </div>

</form>

</div>




