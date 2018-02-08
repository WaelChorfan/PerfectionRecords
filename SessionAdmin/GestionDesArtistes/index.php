<?php

require_once '../dbconfig.php';

if(isset($_GET['delete_id']))
{
    // select image from db to delete
    $stmt_select = $DB_con->prepare('SELECT userPic FROM artistes WHERE userID =:uid');
    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
    unlink("user_images/".$imgRow['userPic']);

   ;

    // it will delete an actual record from db
    $stmt_delete_pre = $DB_con->prepare('DELETE FROM pieces WHERE nom_artiste =

(select userName FROM  artistes where userID =:uid)');
    $stmt_delete_pre->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete_pre->execute();

    $stmt_delete = $DB_con->prepare('DELETE FROM artistes WHERE userID =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();

    header("Location: index.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>GestionDesArtistes</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
</head>

<body style="background-color: lightblue">

<div class="navbar navbar-default navbar-static-top" role="navigation">

    <div class="container">


<div class="navbar-header" align="center"> <a class="navbar-brand" href="../gestion.php" >ESPACE ADMIN</a> </div>


</div>
</div>
<div class="container">

    <div class="page-header">
        <h2  align="center">Les Artistes <span class="badge"><?php echo $nbrAr ?></span></h2>
        <a class="btn btn-primary" href="addnew.php"> <span class="glyphicon glyphicon-plus"></span> &nbsp;Ajouter</a>
    </div>

    <div class="row">
        <?php

        $stmt = $DB_con->prepare('SELECT userID, userName, userProfession, userPic FROM artistes ORDER BY userID DESC');
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                ?>
                <div class="col-xs-3" >
                    
                     <h4 class="page-header"><label > Nom Artiste:</label><?php echo $userName?></h4>
                     
                    <h4 class="page-header"><label > Email:</label><?php echo  $userProfession; ?></h4>
                    <img src="user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="200px" height="200px" />
                    <p class="page-header">
				<span>
				<a class="btn btn-info" href="editform.php?edit_id=<?php echo $row['userID']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a>
				<a class="btn btn-danger" href="?delete_id=<?php echo $row['userID']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
				</span>
                    </p>
                </div>
                <?php
            }
        }
        else
        {
            ?>
            <div class="col-xs-12">
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-info-sign"></span>   Pas  encore des artistes ...
                </div>
            </div>
            <?php
        }

        ?>
    </div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>