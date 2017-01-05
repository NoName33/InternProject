<?php
include("connectionFile.php");
$categ = isset($_GET["categ"]) ? $_GET["categ"] :  'Food';
$query = $conn->prepare("select * from article where category =? order by date desc") ;
$query->execute([$categ]);
?>
<div class="container">
    <div class="row">

        <div class="col-sm-1">
            <ul>
                <li><a href="index.php?page=articles&categ=Sport" >Sport</a></li>
                <li><a href="index.php?page=articles&categ=SF" >SF</a></li>
                <li><a href="index.php?page=articles&categ=Food" >Food</a></li>
            </ul>
        </div>

        <div class="col-sm-2">
            <?php
                foreach($query as $row){
                        $id = $row['id_article'];
                        $trimString = substr($row['body'], 0, 500);
                        ?>
                        <div class = "container">
                            <p> <b> <center> <a href="index.php?page=articol&id=<?php echo $id;?>"><?php echo $row['title'] ;?> </a></center> </b></p>
                            <p> <?php echo $trimString ;?> </p>
                            <p> <?php echo $row['date'] ;?> </p>
                        </div>
                <?php
                    }
                ?>
        </div>
    </div>


</div>



