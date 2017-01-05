<?php

require_once("connectionFile.php");
$stmt= $conn->query("select * from user");

if(!isset($_SESSION['role'])) 
    { 
       $_SESSION['role'] = "user";
    } 
if ($_SESSION['role'] == 'admin'){ ?>

<table border="2" class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Password</th>
      <th>Address</th>
      <th>Age</th>
      <th>Role</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if(!$stmt){
            echo '<tr><td colspan="4">No Rows Returned</td></tr>';
      }else{
        while($row = $stmt->fetch()) {
            $id=$row['id'];
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>  
                <td><?php echo $row['firstname'];?></td>
                <td><?php echo $row['lastname'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['password'];?></td>
                <td><?php echo $row['age'];?></td>
                <td><?php echo $row['address'];?></td>
                <td><?php echo $row['role'];?></td>
                <td><a href="action.scripts.php?actiune=delete&id=<?php echo $id;?>">delete</a></td>  
                <td><a href="index.php?page=update&id=<?php echo $id;?>">update</a></td>  
            </tr> 
        <?php
             }
         }
        ?>
  </tbody>
</table>

<form action = "export.php" method="post">
    <p><a href="index.php?page=register">Add user</a></p>
    <p> <a href = "action.scripts.php?actiune=logout" >Log out </a></p>
</form>
<?php
}
else{
  die("You don't have permission to view this page!");
}
?>





