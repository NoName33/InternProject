
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    
<form name = "myForm" onSubmit="return doReset()" method="POST"  action="action.scripts.php" role="form">
	 <input type="hidden" name="actiune" value="resetPassword" />
	<div class = "container">

	    <div class="form-group">
			<label> Enter the old password: </label>
			<input type="password" name = "oldPassword" id="oldPassword" class="form-control"/> <span  id="oldPasswordErr"></span >
		</div>
		<div class="form-group">
		    <label> Enter the new password: </label>
		    <input type="password" name = "newPassword" id="newPassword" class="form-control"/> <span  id="newPasswordErr"></span >
	    </div>
	    <div class="form-group">
		    <label> Confirm the new password: </label>
		    <input type="password" name = "confirmPassword" id="confirmPassword" class="form-control"/> <span  id="confirmPasswordErr"></span >
	    </div>
	    <input type="submit" name="button" id="button" value = "Reset" class="btn btn-primary"/>

	</div>
</form>