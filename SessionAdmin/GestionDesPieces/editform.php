<?php

	error_reporting( ~E_NOTICE );
	
	require_once '../dbconfig.php';
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT nom_piece,  nom_artiste ,lien_Piece , cover_art FROM pieces WHERE id_piece =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$username = $_POST['user_name'];// nom piece
        $usrAAA =$_POST['usrAAA'];//nom artiste
		$userjob = $_POST['user_job'];// lien

		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = 'user_pieces/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['cover_art']);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['cover_art']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE pieces
   SET nom_piece=:uname 
 
 , lien_Piece=:ujob 
 , cover_art=:upic 
 WHERE id_piece=:uid');

            /*db restriction on update
             *
             * nom_artiste=:usrAAA
             *
             * $stmt->bindParam(':usrAAA',$usrAAA);
            */

			$stmt->bindParam(':uname',$username);

            $stmt->bindParam(':ujob',$userjob);
			$stmt->bindParam(':upic',$userpic);
            $stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Modification avec success !');
				window.location.href='index.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Pas de modification !";
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

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

<!-- custom stylesheet -->
<link rel="stylesheet" href="style.css">

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<script src="jquery-1.11.3-jquery.min.js"></script>
</head>
<body style="background-color: lightblue">
<div class="navbar navbar-default navbar-static-top" role="navigation">

	<div class="container">


<div class="navbar-header" align="center"> <a class="navbar-brand" href="../gestion.php" >ESPACE ADMIN</a> </div>


 </div>
</div>
</div>


<div class="container">


	<div class="page-header">
    	<h1 class="h2">Modifier Artiste <a class="btn btn-default" href="index.php"> Tous les pieces </a></h1>
    </div>

<div class="clearfix"></div>

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">Nom Piéce</label></td>
        <td><input class="form-control" type="text" name="user_name" value="<?php echo $nom_piece; ?>" required /></td>
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
    	<td><label class="control-label">Contact</label></td>
        <td><input class="form-control" type="text" name="user_job" value="<?php echo $lien_Piece; ?>" required /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Image Artiste</label></td>
        <td>
        	<p><img src="user_pieces/<?php echo $userPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="user_image" accept="image/*" />
        </td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Modifier
        </button>
        
        <a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-backward"></span> Annuler </a>
        
        </td>
    </tr>
    
    </table>
    
</form>



</div>
</body>
</html>