<?php

if (!isset($_SESSION['username'])) {
	echo "Please login first.";
}
else{ 
$user = getUser($_SESSION['username']);

$id=$user['id'];
$_SESSION['userId'] = $id;
$_SESSION['role'] = $user['role'];
//$_SESSION['avatar'] = $user['file'];
$avatar = $user['file'];
?>
<div id="profile">
	<p id="welcome">Welcome :<?php echo $_SESSION['username']; ?></p>
	<?php
		if ($avatar == ""){
			?>
			<img src = "http://placehold.it/400x200/0000ff/&text=Upload a picture" alt =""/> 
			<?php
		}
		else if ($avatar != ""){
			?>
			<img src="avatars/<?php echo $user['file'];?>">
			<?php	
		}
	?>
	
	<p id="modifyPf"><a href="index.php?page=update&id=<?php echo $id?>"> Modify</a></p>
	<p id="reset"><a href="index.php?page=resetPassword"> Reset password</a></p>
	<p id="articlePf"><a href="index.php?page=userArticles"> Article page</a></p>
	
    <form action="action.scripts.php" method="POST" enctype="multipart/form-data">
  		<input type="hidden" name="actiune" value="avatar">
  		<input type="hidden" name="id" value="<?php echo $user['id'];?>">
    	<p><label for="avatar">Upload an avatar:</label></p>
    	<p><input type="file" name="avatar" id="fileToUpload"></p>
   		<p><input id ="button" class="btn btn-primary" type="submit" name="button" value="Send"/></p>
	</form>
</div>
<?php
}
?>