<?php
include("connectionFile.php");
        $id_article = $_GET['id'];
        $stmt = $conn->prepare("select * from article where id_article=?");
        $stmt->execute([$id_article]);
        foreach($stmt as $row){ 
              $title = $row['title'];
              $body = $row['body'];
        }
?>
<div class= 'container'>
    <form name="myForm" method="POST" action='action.scripts.php?id= <?php echo $id_article;?>' role="form" enctype="multipart/form-data">
        <input type="hidden" name="actiune" value="updateArticle" />
        <div class= "form-group">
            <label> Title </label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo $title ?>"/>
            <span id="titleErr"></span>
        </div>
        <div class= "form-group">
            <label> Body </label>
            <textarea name = "body" id="body" class="form-control"> <?php echo $body ?> </textarea><span  id="bodyErr"></span >
        </div>
        <div class= "form-group">
            <label> Category </label>
            <select name="taskOption">
                <option value="Food">Food</option>
                <option value="SF">SF</option>
                <option value="Sport">Sport</option>
                <option value="Games">Games</option>
            </select>
        </div>
            <input id ="submitBtn" type="submit" class="btn btn-primary" name="button" value="Send"/>
    </form>

</div>

