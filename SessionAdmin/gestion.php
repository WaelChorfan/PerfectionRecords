<!DOCTYPE html>
<?php

require_once 'dbconfig.php';



?>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Gestion</title>
    <link  rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" >
</head>
<body style="
background-color:lightblue ; padding: 50px ;500px;500px ;500px ">

<div class="panel panel-default"><div class="panel panel-default">


<h1 align="center" class="header" >ESPACE ADMIN</h1>





<div class="
<?php
if ($nbrAr>0)

{
    echo "alert alert-info";
}
else echo "alert alert-danger"
?>
" >


        <strong><a  align="center" href="GestionDesArtistes/index.php"><h3 >Gestion des artistes
        <span class="badge"><?php echo $nbrAr ?></span> </h3></a></strong>
    </div>






<div class="<?php
if ($nbrP>0)

{
    echo "alert alert-info";
}
else echo "alert alert-danger"
?>">
  <strong><a  align="center"  href="GestionDesPieces/index.php"><h3  >Gestion des pieces 
  <span class="badge"><?php echo $nbrP ?></span></h3></a></strong>
</div>


<div class="<?php
if ($nbrD>0)

{
    echo "alert alert-info";
}
else echo "alert alert-danger"
?>">
    <strong><a align="center"   href="GestionDesDemos/index.php"><h3   >Gestion des demos
    <span class="badge"><?php echo $nbrD?></span> </h3></a></strong>
</div>




        <div class="panel-footer">
<div class="footer">
<p align="center">
    <button  class="btn btn-warningr"  style="
    border-radius: 10px">

        <a  href="../SessionAdmin/logout.php"> Déconnexion </a></button>
</p>

</div>
        </div></div>
</div>
</body>
</html>
