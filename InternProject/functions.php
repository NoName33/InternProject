<?php 
//require_once("connectionFile.php");


function addUser($firstname, $lastname, $email,$encrypted, $age, $address){
    include("connectionFile.php");

    $check_email_exist = $conn->prepare("select * from user where email=?");
    $check_email_exist->execute([$email]);
    $data = $check_email_exist->fetchAll();

    if ($data){
        header("Location: index.php?page=register&msg=The email already registered.Use another email");
    }
    $valueUser = "user";
    $sql = "INSERT INTO user(id, firstname, lastname, email, password, age, address, role) values(NULL,?,?,?,?,?,?,?)";
    
    try{
        $results=$conn->prepare($sql)->execute([$firstname,$lastname,$email,$encrypted,$age,$address,$valueUser]);
    }
    catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}

function updateAvatar($idUser, $fileName){
    include("connectionFile.php");
    try{
    $stmt = $conn->prepare("update user set file=? where id=?");
    $stmt->execute([$fileName, $idUser]);
    }
    catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}

function getArticlesUser($userId){
    include("connectionFile.php");
    try{
    $stmt = $conn->prepare("select * from article where user_id=?");
    $stmt->execute([$userId]);
    $result = $stmt->fetchAll();
    }
    catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return $result;

}
function addArticle($title, $body, $optionCategory){
    include("connectionFile.php");
    $userId = $_SESSION['userId'];
    $unpublishedValue = 0;
    $ord = maxOrder($userId, $optionCategory) + 1;
    $sql = "INSERT INTO article(id_article, title, body, date, ord, category, publish, user_id) values(NULL,?,?,?,?,?,?,?)";
    try{
        $results=$conn->prepare($sql);
        $results->bindValue(1,$title,PDO::PARAM_STR);
        $results->bindValue(2,$body,PDO::PARAM_STR);
        $results->bindValue(3,date("Y-m-d"),PDO::PARAM_STR);
        $results->bindValue(4,$ord,PDO::PARAM_INT);
        $results->bindValue(5,$optionCategory,PDO::PARAM_STR);
        $results->bindValue(6,$unpublishedValue,PDO::PARAM_STR);
        $results->bindValue(7,$userId,PDO::PARAM_STR);
        $results->execute();
    }
    catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}

function updateUser($firstname, $lastname, $age, $address,$email){
    include("connectionFile.php");
    $sql = "UPDATE user set firstname = ?, lastname=?, age=?, address=? where email = ?";
    try{
        $results=$conn->prepare($sql)->execute([$firstname,$lastname,$age,$address,$email]);
    }
    catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}
function updateArticle($title, $body, $optionCategory,$id_article){
    include("connectionFile.php");
    try{
        $stmt= $conn->prepare("update article set title=?, body=?, category=? where id_article= ?");
        $stmt->execute([$title,$body,$optionCategory,$id_article]);
    }
    catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}

function getPassword($email){
    include("connectionFile.php");
    $stmt = $conn->prepare("select * from user where email=?");
    $stmt->execute([$email]);
    $pass = $stmt->fetch();
    return $pass['password'];
}
function setPassword($newPassword, $email){
    include("connectionFile.php");
    $hash = password_hash($newPassword, PASSWORD_BCRYPT); 
    try{
        $sql = $conn->prepare("update user set password =? where email=?");
        $sql->bindValue(1,$hash,PDO::PARAM_STR);
        $sql->bindValue(2,$email,PDO::PARAM_STR);
        $sql->execute();
    }catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}
function clean_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function getUser($email) {
    include("connectionFile.php");
    $stmt =  $conn->prepare("SELECT * from user where email=?");
	$stmt->execute([$email]);
	$user = $stmt->fetch();
	return $user;
}

function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

function maxOrder($user_id, $category){
    include("connectionFile.php");
    $stmt = $conn->prepare("select max(ord) from article where category = ? AND user_id = ?");
    $stmt->execute([$category,$user_id]);
    $row= $stmt->fetch();
    return $row[0];
}
function returnChecked($ids) {
    include ("connectionFile.php");
    $stmt = $conn->prepare("select publish from article where id_article=?");
    $stmt->execute([$ids]);
    $row=$stmt->fetch();
    return $row[0];
}

function deleteOrderArticles($id_article, $ord, $categ){
    include ("connectionFile.php");
    try{
    $stmt = $conn->prepare("delete from article where id_article=?");
    $stmt->execute([$id_article]);
    $stmtUpdate = $conn->prepare("update article set ord=ord-1 where ord >=? AND category =?");
    $stmtUpdate->execute([$ord,$categ]);
    }catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true; 
}
function deleteUser($id){
    include ("connectionFile.php");
    try{
    $stmt = $conn->prepare("delete from user where id=?");
    $stmt->execute([$id]);
    }catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true; 
}

function orderDownArticle($id_article, $ord, $categ){
    include ("connectionFile.php");
    try{
        $stmt = $conn->prepare("update article set ord = ? where ord > ? and ord = ?+1 and category = ?");
        $stmt->execute([$ord,$ord,$ord,$categ]);
        $stmt1 = $conn->prepare("update article set ord = ord+1 where id_article=? AND category =? and ord=?");
        $stmt1->execute([$id_article,$categ,$ord]);
    }catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;

}
function orderUpArticle($id_article, $ord, $categ){
    include ("connectionFile.php");
    try{
        $stmt = $conn->prepare("update article set ord = ? where ord < ? and ord = ? -1 and category = ?");
        $stmt->execute([$ord,$ord,$ord,$categ]);
        $stmt1 = $conn->prepare("update article set ord = ord-1 where id_article=? AND category =? and ord=?");
        $stmt1->execute([$id_article,$categ,$ord]);
    }catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
    return true;

}

function displayArticles($action){
    include("connectionFile.php");
    $id = $_SESSION['userId']; 

    $title = isset($_POST['title']) ? $_POST['title'] :  NULL;
    switch($action){
        case 'Search by title': 
        $title = "%$title%";
        $stmt = $conn->prepare("select * from article where title LIKE ?");
        $stmt->execute([$title]);
        $result = $stmt->fetchAll();
        if($result){
            foreach($result as $row){    
            $id=$row['id_article'];
            $order=$row['ord'];
            $categ = $row['category'];
            $displayChecked = $row['publish'] == 1 ? 'checked' : '';
            $check = $row['publish'] == 1 ? 'true' : 'false';
            ?>
            <form action =""> 
                <tr>
                <td><?php echo $row['title'];?></td>
                <td><?php echo $row['body'];?></td>
                <td>
                    <?php echo $row['ord'];?><br />
                    <?php
                    if ($row['ord'] != 1){ ?> 
                        <a href="action.scripts.php?actiune=orderUpArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ?> ">Up</a> 
                    <?php
                    }
                    if($row['ord'] < maxOrder($_SESSION['userId'], $categ)){
                        ?>
                        <a href="action.scripts.php?actiune=orderDownArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ?> ">Down</a>
                        <?php
                    }    
                    ?>
                </td>     
                <td><?php echo $row['category'];?></td>
                <td>
                    <a href="action.scripts.php?actiune=deleteArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ;?>">delete</a> <br />
                    <a href="index.php?page=updateArticle&id=<?php echo $id;?>">update</a> <br />
                    <?php 
                    if ($check == "true") {
                        echo "Publish";
                    }else{ 
                        echo "Unpublished";}
                    ?> 
                    <input type="checkbox"  name="check"  value = "<?php echo $id?>" onclick ="add_checked(<?php echo $id;?>);" />
                </td>
                </tr> 
            </form>
            <?php
            }
        }else{
            die("No rows with title given.");
        }
        break;
        case 'Show publish articles':
            $stmt = $conn->prepare("select * from article where publish != 0 AND user_id =? order by category , ord");
            $stmt->execute([$id]);
            foreach($stmt as $row){        
                $id=$row['id_article'];
                $order=$row['ord'];
                $categ = $row['category'];
                $displayChecked = $row['publish'] == 1 ? 'checked' : '';
                $check = $row['publish'] == 1 ? 'true' : 'false';
                ?>
                <form action =""> 
                    <tr>
                    <td><?php echo $row['title'];?></td>
                    <td><?php echo $row['body'];?></td>
                    <td>
                        <?php echo $row['ord'];?><br />
                        <?php
                        if ($row['ord'] != 1){ ?> 
                            <a href="action.scripts.php?actiune=orderUpArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ?> ">Up</a> 
                        <?php
                        }
                        if($row['ord'] < maxOrder($_SESSION['userId'], $categ)){
                            ?>
                             <a href="action.scripts.php?actiune=orderDownArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ?> ">Down</a>
                            <?php
                        }    
                        ?>
                    </td>     
                    <td><?php echo $row['category'];?></td>
                    <td>
                        <a href="action.scripts.php?actiune=deleteArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ;?>">delete</a> <br />
                        <a href="index.php?page=updateArticle&id=<?php echo $id;?>">update</a> <br />
                        <?php 
                        if ($check == "true"){
                            echo "Publish";
                        }else{ 
                            echo "Unpublished";
                        }
                        ?> 
                        <input type="checkbox"  name="check"  value = "<?php echo $id?>" onclick ="add_checked(<?php echo $id;?>);" />
                    </td>
                    </tr> 
                </form>
                <?php
            }
            break;
        case 'Search by body':
            $word = "%$title%";
            $stmt = $conn->prepare("select * from article where body LIKE ? AND user_id =?");
            $stmt->execute([$word, $id]);
            foreach($stmt as $row){      
                $id=$row['id_article'];
                $order=$row['ord'];
                $categ = $row['category'];
                $displayChecked = $row['publish'] == 1 ? 'checked' : '';
                $check = $row['publish'] == 1 ? 'true' : 'false';
                ?>
                <form action =""> 
                    <tr>  
                        <td><?php echo $row['title'];?></td>
                        <td><?php echo $row['body'];?></td>
                        <td>
                            <?php echo $row['ord'];?><br />
                            <?php
                            if ($row['ord'] != 1){ ?> 
                                <a href="action.scripts.php?actiune=orderUpArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ?> ">Up</a> 
                            <?php
                            }
                            if($row['ord'] < maxOrder($_SESSION['userId'], $categ)){
                                ?>
                                 <a href="action.scripts.php?actiune=orderDownArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ?> ">Down</a>
                                <?php
                                }    
                            ?>
                        </td>     
                        <td><?php echo $row['category'];?></td>
                        <td>
                            <a href="action.scripts.php?actiune=deleteArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ;?>">delete</a> <br />2
                            <a href="index.php?page=updateArticle&id=<?php echo $id;?>">update</a> <br />
                            <?php 
                            if ($check == "true") {
                                echo "Publish";
                            }else{ 
                                echo "Unpublished";}
                            ?> 
                            <input type="checkbox"  name="check"  value = "<?php echo $id?>" onclick ="add_checked(<?php echo $id;?>);" />
                        </td>
                    </tr> 
                </form>
                <?php
            }

            break;
        default:
            $stmt = $conn->prepare("select * from article where user_id =? order by category, ord");
            $stmt->execute([$id]);
            foreach($stmt as $row){
                $id=$row['id_article'];
                $order=$row['ord'];
                $categ = $row['category'];
                $displayChecked = $row['publish'] == 1 ? 'checked' : '';
                $check = $row['publish'] == 1 ? 'true' : 'false';
                ?>
                <form action =""> 
                    <tr>
                    <td><?php echo $row['title'];?></td>
                    <td><?php echo $row['body'];?></td>
                    <td>
                        <?php echo $row['ord'];?><br />
                        <?php
                        if ($row['ord'] != 1){ ?> 
                            <a href="action.scripts.php?actiune=orderUpArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ?> ">Up</a> 
                        <?php
                        }
                        if($row['ord'] < maxOrder($_SESSION['userId'], $categ)){
                            ?>
                             <a href="action.scripts.php?actiune=orderDownArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ?> ">Down</a>
                            <?php
                            }    
                        ?>
                    </td>     
                    <td><?php echo $row['category'];?></td>
                    <td>
                        <a href="action.scripts.php?actiune=deleteArticle&id=<?php echo $id;?>&order=<?php echo $order;?>&categ=<?php echo $categ;?>">delete</a> <br />
                        <a href="index.php?page=updateArticle&id=<?php echo $id;?>">update</a> <br />
                        <?php 
                        if ($check == "true") {
                            echo "Publish";
                        }else{ 
                            echo "Unpublished";}
                        ?> 
                        <input type="checkbox"  name="check"  value = "<?php echo $id?>" onclick ="add_checked(<?php echo $id;?>);" />
                    </td>
                    </tr> 
                </form>
                <?php
            }
            break;
    }
}

?>







