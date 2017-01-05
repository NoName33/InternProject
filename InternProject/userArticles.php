
<link rel="stylesheet" type="text/css" href="style.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script> 
 
var allChecked = new Array();
function add_checked(element) {
    allChecked.push(element);
}
function getArray(){
    if(typeof allChecked !== 'undefined' && allChecked.length > 0){
        window.location = 'action.scripts.php?actiune=publish&array=' + allChecked;
    }
    else{
        alert("You do not select anything to be published or unpublished");
    } 
}

</script>
<div class="container">
    <div id="article">
     <form name="myForm" method="POST" role="form">
        <input type="hidden" name="actiune" value="searchByTitle"/>
        <label> Word: </label> <input type="text" name = "title" id="title" class="form-control"/> 
        <input type="submit"  class="btn btn-primary" name="button"  id = "button" value="Search by title"/>
        <input type="submit"  class="btn btn-primary" name="button" id = "button" value="Show publish articles"/>
        <input type="submit"  class="btn btn-primary" name="button" id = "button" value="Search by body"/>
        <input type="submit"  class="btn btn-primary" name="button" id="buttonShowId" value="Show all articles"/>
    </form>
    <p id="welcome">Here are your articles :<?php echo $_SESSION['username']; ?></p>
</div>
<?php
    $userId = $_SESSION['userId'];
    $result = getArticlesUser($userId);
    if(!$result){
        ?>
        <div class="container">
            <center><b>You do not have any articles yet.</b></center>
            
        </div>
        <?php
        die();
    }
?>
<table border="2" class="table table-striped" id="mytable">
  <thead>
    <tr>
        <th>Title</th>
        <th>Body</th>
        <th>Ord</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>
    <div id="message"></div>
  </thead>
  <tbody>
    <?php
    $arg = isset($_POST['button']) ? $_POST['button'] : NULL;
    displayArticles($arg);
    ?>
  </tbody>
</table>

<input type='button' name='button' onclick= "return getArray()" value = "Publish/Unpublish articles" class="btn btn-primary">
<p><a href="index.php?page=addArticle">Add article</a></p>
<p><a href="index.php?page=articles">See articles</a></p>
</div>


