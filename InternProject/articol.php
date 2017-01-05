<?php
include("connectionFile.php");
	$id = $_GET['id'];
    $query = $conn->prepare("select * from article where id_article =?");
    $query->execute([$id]);
    $result = $query;
    foreach($result as $row){
    	$trimString = substr($row['body'], 0, 5000);
                        ?>
                        <div class = "container">
                            <p> <b> <center> <?php echo $row['title'] ;?> </center> </b></p>
                            <p> <?php echo $trimString ;?> </p>
                            <p id="date"> <?php echo $row['date'];?> </p>
                        </div>
                <?php
    }
?>