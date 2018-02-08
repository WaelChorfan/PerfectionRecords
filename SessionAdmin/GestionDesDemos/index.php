<?php

require_once '../dbconfig.php';

if(isset($_GET['delete_id']))
{
    // select  from db to delete
    $stmt_select = $DB_con->prepare('SELECT demoAudio FROM demos WHERE id =:uid');
    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));


    // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM demos WHERE id =:uid');
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
    <title>GestionDémos</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
</head>

<body style="background-color: lightblue">

<div class="navbar navbar-default navbar-static-top" role="navigation">

    <div class="container">


<div class="navbar-header" align="center"> <a class="navbar-brand" href="../gestion.php" >ESPACE ADMIN</a>
</div>


 </div>
</div>
</div>





<div class="container">
  <div class="page-header">
        <h2  align="center">Les Démos  <span class="badge"><?php echo $nbrD  ?></span></h2>


    </div>
      <?php
$init = $DB_con->prepare('ALTER TABLE  demos AUTO_INCREMENT = 0');
$init->execute();
        $stmt = $DB_con->prepare('SELECT id,  NomArtiste, demoAudio, Email , prodType
FROM demos ORDER BY id DESC ');
        $stmt->execute();

        $cn = $stmt->rowCount();

        if($cn> 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);

                ?>
  

    <div class="row" >
  
                <div class="col-xs-5" >
                        
                     <h3 class="page-header"> <label > Nom Démo :</label><?php echo $prodType ?></h3>
                    
                    <h3 class="page-header"> <label > Nom Artiste :</label><?php echo $NomArtiste ?></h3>

                    <h3 class="page-header"> <label > Email :</label><?php echo $Email ?></h3>


                    <a href="<?php echo $demoAudio; ?>" target="_blank"> <h2>Lien privé</h2> </a>

                    <p class="page-header">
				<span>

				<a class="btn btn-danger" href="?delete_id=<?php echo $row['id']; ?>" title="click for delete"
                   onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
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
                    <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Pas  encore de démos...
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