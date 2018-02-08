<?php

error_reporting( ~E_NOTICE ); // avoid notice

require_once '../dbconfig.php';

if(isset($_POST['btnsave']))
{
    $username = $_POST['user_name'];//nom-peiece
    $usrAAA = $_POST['usrAAA'];//nom_artiste
    $userjob = $_POST['user_job'];

    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];


    if(empty($username)){
        $errMSG = "Donner le Nom de la Piece.";
    }
    if(empty($usrAAA)){
        $errMSG = "Donner le Nom de l'artiste.";
    }
    else if(empty($userjob)){
        $errMSG = "Donner le lien";
    }
    else if(empty($imgFile)){
        $errMSG = "Selectionner le cover art pour cette piéce.";
    }
    else
    {
        $upload_dir = 'user_pieces/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        $userpic = rand(1000,1000000).".".$imgExt;

        // allow valid image file formats
        if(in_array($imgExt, $valid_extensions)){
            // Check file size '5MB'
            if($imgSize < 5000000)				{
                move_uploaded_file($tmp_dir,$upload_dir.$userpic);
            }
            else{
                $errMSG = "Sorry, your file is too large.";
            }
        }
        else{
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }


    // if no error occured, continue ....
    if(!isset($errMSG))
    {

        $stmt = $DB_con->prepare('INSERT INTO pieces VALUES(NULL , ? , ? , ? , ?)');
        $stmt->bindParam(1,$username,PDO::PARAM_STR);
        $stmt->bindParam(2,$usrAAA,PDO::PARAM_STR);
        $stmt->bindParam(3,$userjob,PDO::PARAM_STR);
        $stmt->bindParam(4,$userpic,PDO::PARAM_LOB);

        if($stmt->execute())
        {
            $successMSG = "Ajout avec succés ...";
            header("refresh:5;index.php"); // redirects image view page after 5 seconds.
        }
        else
        {
            $errMSG = "erreur d'insertion....";
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>GestionPieces</title>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">


    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

</head>
<body style="background-color: lightblue">
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header" align="center"> <a class="navbar-brand" href="../gestion.php" >ESPACE ADMIN</a>
        </div></div></div></div>

<div class="container">
    <div class="page-header">
        <h1 class="h2">Ajouter une nouvelle piéce <a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; Afficher tous les Pieces </a></h1>
    </div>
    <?php
    if(isset($errMSG)){
        ?>
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
        </div>
        <?php
    }
    else if(isset($successMSG)){
        ?>
        <div class="alert alert-success">
            <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
    }
    ?>
    <form method="post" enctype="multipart/form-data" class="form-horizontal">
        <table class="table table-bordered table-responsive">
            <tr>
                <td><label class="control-label">Nom Piece</label></td>
                <td><input class="form-control" type="text" name="user_name" placeholder="Nom Piece" value="<?php echo $username; ?>" /></td>
            </tr>




            <?php

            $stmt_selectAll = $DB_con->prepare("select * from artistes");

            $stmt_selectAll->execute();
            $tousLesArtisites = $stmt_selectAll->fetchAll(PDO::FETCH_OBJ);


            ?>


            <tr>  <td> <label >Nom Artiste :</label></td>

                <td> <select  class="form-control" id="usrAAA" name="usrAAA" >

                        <?php  foreach($tousLesArtisites as $ar) :?>

                            <option><?=  $ar->userName ?></option>
                        <?php endforeach; ?>

                    </select>

                </td>
            <tr>

            <tr>
                <td><label class="control-label">Lien</label></td>
                <td><input class="form-control" type="text" name="user_job" placeholder="Lien" value="<?php echo $userjob; ?>" /></td>
            </tr>

            <tr>
                <td><label class="control-label">Cover Art</label></td>
                <td><input class="input-group" type="file" name="user_image" accept="image/*" /></td>
            </tr>

            <tr>
                <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
                        <span class="glyphicon glyphicon-save"></span> &nbsp; Enregistrer
                    </button>
                </td>
            </tr>

        </table>

    </form>







</div>






<script src="bootstrap/js/bootstrap.min.js"></script>


</body>
</html>