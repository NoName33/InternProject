
<?php
  require_once("connectionFile.php");
  
  $id = $_GET['id'];
  $role = $_SESSION['role'];
  
  if ($role == "admin"){
    $result = $conn->prepare("select * from user where id=? ");
        $result->execute([$id]);
        while($row = $result->fetch()) {

        $firstname = $row['firstname'];
        $lastname = $row['lastname'] ;
        $email = $row['email'];
        $password = $row['password'] ;
        $age = $row['age'];
        $address = $row['address'];
       }
    }

  else if ($role == "user") {
        $email = $_SESSION['username'];
        
        $row = getUser($email);
        $firstname = $row['firstname'];
        $lastname = $row['lastname'] ;
        $email = $row['email'];
        $password = $row['password'] ;
        $age = $row['age'] ;
        $address = $row['address'];
    } 
?>

<div class="update_page">

<form name="myForm" method="POST" action="action.scripts.php?id=<?php echo $id?>" role="form">
    <input type="hidden" name="actiune" value="update" />
    <div class= "form-group">
        <label> First Name </label>
        <input type="text" name="firstName" id="firstName" class="form-control" value="<?php echo $firstname ?>"/>
        <span id="firstNameErr"></span>
    </div>
    <div class= "form-group">
        <label> Last Name </label>
        <input type="text" name = "lastName" id="lastName" class="form-control" value="<?php echo $lastname ?>" /> <dspan  id="lastNameErr"></span >
       
    </div>
    <div class= "form-group">
        <label>Email</label>
        <input type="email" name = "email" id="email" class="form-control" value="<?php echo $email ?>" readonly/> <span  id="emailErr"></span >
    </div>
    
    <div class= "form-group">
        <label> Age </label>
        <input type="age" name = "age" id="age" class="form-control" class="form-control" value="<?php echo $age ?>"/><span id="ageErr"></span >
    </div>
    <div class= "form-group">
        <label> Address </label>
        <textarea name="address" class="form-control" id="address"> <?php echo $address ?> </textarea>
    </div>
    <div >
        <input id ="submitBtn" type="submit" class="btn btn-primary" name="button" value="Send"/>
    </div>
</form>
</div>
