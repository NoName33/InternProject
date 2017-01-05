<?php
session_start();
require_once("functions.php");
require_once("connectionFile.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if ($_POST['actiune'] == 'register') {
    	$firstname = $_POST['firstName'];
    	$lastname = $_POST['lastName'];
    	$email = $_POST['email'];
    	$_SESSION['username'] = $email;
    	$password = $_POST['password'];
    	$hash = password_hash($password, PASSWORD_BCRYPT);
    	$age = $_POST['age'];
    	$address = $_POST['address'];
	    if(addUser($firstname, $lastname, $email, $hash, $age, $address)){
            if(isset($_SESSION['role'])){
		      header("Location: index.php?page=admin");
            }else{
                header("Location: index.php?page=profile");
            }
	    }
	    else
		  die("User didnt add in db.");
    }

    if($_POST['actiune'] == 'login'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $checkEmail = getUser($email);
        $pass = getPassword($email);
        $verify = password_verify($password, $pass);
        if($checkEmail){
            if ($verify) {
            	$_SESSION['username'] = $email;
                header("Location: index.php?page=profile");
            }
            else{
                header("Location: index.php?page=login&msg=Password incorrectly.");
            }
        }else{
            header("Location: index.php?page=login&msg=The email is not registered.");
        }
    }
    if($_POST['actiune'] == 'update'){
    	$firstname = $_POST['firstName'];
    	$lastname = $_POST['lastName'];
    	$age = $_POST['age'];
    	$address = $_POST['address'];
        $email = $_POST['email'];

        if(updateUser($firstname, $lastname, $age, $address, $email)){
        	header("Location: index.php?page=profile");
        }else{
        	exit("Something went wrong.");
        }
    }
    if($_POST['actiune'] == 'resetPassword'){
    	$oldPassword = $_POST['oldPassword'];
    	$newPassword = $_POST['newPassword'];
    	$confirmPassword = $_POST["confirmPassword"];
    	
    	$passwordDb = getPassword($_SESSION['username']);
    	$verify = password_verify($oldPassword, $passwordDb);
    	if($verify){
    		setPassword($newPassword, $_SESSION['username']);
            header("location: index.php?page=profile");
    	}
    }
    if($_POST['actiune'] == 'addArticle'){
        $title = $_POST['title'];
        $body = $_POST['body'];
        $optionCategory = $_POST['taskOption'];
        if(addArticle($title,$body,$optionCategory)){
            header("Location: index.php?page=userArticles");
        }
        else{
            die("Article didnt add in db.");
        }
    }
    if($_POST['actiune'] == 'updateArticle'){
        $id_article = $_GET['id'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        $optionCategory = $_POST['taskOption'];
        if(updateArticle($title,$body,$optionCategory,$id_article)){
            header("Location: index.php?page=userArticles");
        }
        else{
            die("Article didnt update in db.");
        }
    }
    if($_POST['actiune'] == 'avatar'){
        $idUser = $_POST['id'];
        if($_FILES['avatar']['name']){
            if(!$_FILES['avatar']['error']){
                $valid_file = true;
                $fileName = "file". $idUser .".png";
                if($_FILES['avatar']['size'] > (1024000)) { //can't be larger than 1 MB
                    $valid_file = false;
                    $message = 'Oops!  Your file s size is to large.';
                }

                if($valid_file){
                    move_uploaded_file($_FILES['avatar']['tmp_name'], 'avatars/'.$fileName);
                    $message = 'Congratulations!  Your file was accepted.';

                }
                else{
                    die("cannot move file to dest");
                }
            }
            else{
                $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['avatar']['error'];
            }
        }
        if(updateAvatar($idUser, $fileName)){
            header("location: index.php?page=profile");
        }else{
            die("/n Problems with uploading file.");
        }

    }
    else{
        echo 'POST actiune is not login';
    }
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if($_GET['actiune'] == 'logout'){
		session_destroy();
		header("Location: index.php?page=login");
	}
    if($_GET['actiune'] == 'publish'){
        $ids  = explode(",", $_GET["array"]); 
        for($i= 0; $i<= (count($ids)-1); $i++){
            if( returnChecked($ids[$i]) == 0){
                $sql = $conn->prepare("update article set publish= 1 where id_article=?");
                $sql->execute([$ids[$i]]);
            }else{
                $sql = $conn->prepare("update article set publish= 0 where id_article=?");
                $sql->execute([$ids[$i]]);
            }
        }
        header("location: index.php?page=userArticles"); 
    }
    if($_GET['actiune'] == 'deleteArticle'){
        $id_article = $_GET['id'];
        $ord = $_GET['order'];
        $categ = $_GET['categ'];

        if(deleteOrderArticles($id_article, $ord, $categ)){
            header("location: index.php?page=userArticles");
        }
        else{
            die("Article didnt update order in db.");
        }
    }   
    if($_GET['actiune'] == 'orderDownArticle'){
        $id_article = $_GET['id'];
        $ord = $_GET['order'];
        $categ = $_GET['categ'];
        if(orderDownArticle($id_article,$ord,$categ)){
            header("location: index.php?page=userArticles");
        }
        else{
            die("Swapping down went wrong.");
        }
    }
    if($_GET['actiune'] == 'orderUpArticle'){
        $id_article = $_GET['id'];
        $ord = $_GET['order'];
        $categ = $_GET['categ'];
        if(orderUpArticle($id_article,$ord,$categ)){
            header("location: index.php?page=userArticles");
        }
        else{
            die("Swapping down went wrong.");
        }  
    }
    if($_GET['actiune'] == 'delete'){
        $id = $_GET['id'];

        if(deleteUser($id)){
            header("location: index.php?page=admin");
        }else{
            die("Swapping down went wrong.");
        }  
    }
}
else{
	echo "Error in if main!";
}
?>