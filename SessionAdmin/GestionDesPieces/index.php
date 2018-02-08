<?php

require_once '../dbconfig.php';

if(isset($_GET['delete_id']))

{

    $stmt_select = $DB_con->prepare('SELECT cover_art FROM pieces WHERE id_piece =:uid');
    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
    unlink("user_pieces/".$imgRow['cover_art']);


    $stmt_delete = $DB_con->prepare('DELETE FROM pieces WHERE id_piece =:uid');
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
    <title>GestionPieces</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
</head>

<body style="background-color: lightblue ; ">

<div class="navbar navbar-default navbar-static-top" role="navigation">

    <div class="container" >


<div class="navbar-header" align="center"> <a class="navbar-brand" href="../gestion.php" >ESPACE ADMIN</a>
</div>


 </div>
</div>
</div>

<div class="container">

    <div class="page-header">


        <a class="btn btn-primary" href="addnew.php"> <span class="glyphicon glyphicon-plus"></span> &nbsp;Ajouter</a>
        <h2  align="center">Les Pieces <span class="badge"><?php echo $nbrP ?></span></h2>

    </div>
    <div class="panel-success" align="center">


    </div>

    <div class="row" >
        <?php

        $stmt = $DB_con->prepare('SELECT id_piece, nom_piece, nom_artiste, lien_Piece, cover_art FROM pieces ORDER BY id_piece DESC');
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                ?>
                <div class="col-xs-3" >

                    
                    <h4 class="page-header"> <label > Nom Piéce :</label><?php echo $nom_piece ?></h4>

                    <h4 class="page-header"> <label > Nom Artiste :</label><?php echo $nom_artiste?></h4>



<div>
    <a href="<?php echo  $lien_Piece; ?>" target="_blank">
<img src="user_pieces/<?php echo $row['cover_art']; ?>"
     class="img-rounded"
     width="200px"
     height="200px" />
    </a>
</div>

 <p class="page-header">
<span>
<a class="btn btn-info" href="editform.php?edit_id=<?php echo $row['id_piece']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a>
<a class="btn btn-danger" href="?delete_id=<?php echo $row['id_piece']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
</span> </p> </div>
                <?php
            }
        }
        else
        {
            ?>
            <div class="col-xs-12">
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-info-sign"></span> &nbsp;  Pas  encore des pieces ...
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