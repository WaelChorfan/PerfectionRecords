<?php

require_once 'dbconfig.php';

?>

<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
    <title>Piéces</title>
    <meta charset="utf-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css">




</head>
<body>
<div id="page">
    <div id="header">
        <ul class="section">
            <li ><a class="home"  href="../index.html">&nbsp;</a></li>
            <li ><a class="email" href="mailto:chorfanwael@gmail.com">&nbsp;</a></li>
        </ul>
        <ul class="navigation">
           <li><a href="../index.html">PerfectionRecords</a></li>
            <li ><a class="active" href="pieces.php">Piéces</a></li>
            
            <li ><a href="artistes.php">Artistes</a></li>
            <li ><a href="soumettre_piéce.html">Soumettre piéce</a></li>
            <li><a href="admin.php">Admin</a></li>
            
        </ul>
    </div>

    <div id="body">

        <?php $stmt_slctAll = $DB_con->prepare("select * from pieces");
        $stmt_slctAll->execute();
        $all = $stmt_slctAll->fetchAll(PDO::FETCH_OBJ);
        if($stmt_slctAll->rowCount() > 0)
        {
            ?>

            <?php foreach($all as $p) :?>

            <div  class="content"
                  style="
                  opacity: 0.9;
                   background-color: #afb3b6;
                    border-radius: 25px ;">

                <ul>
                    <li><h3>Nom Pièce : <a><?= $p -> nom_piece ; ?></a></h3></li>

                    <li><h3>Nom Artiste : <a> <?= $p-> nom_artiste ?></a></h3></li>


                        <a href="<?= $p-> lien_Piece ?>"  target="_blank"  >
                            <img class="img-responsive"  alt="Pas d'image" width="300" height="300"

                                 style="border-radius: 20%;  padding-left: 500px ; webkit-box-reflect: left;"
                                 src="../SessionAdmin/GestionDesPieces/user_pieces/<?php echo $p-> cover_art; ?> ">
                        </a></li>
                </ul>



            </div>
        <?php endforeach; ?>
            <?php
        }

        else
        {
            ?>
            <div  class="content"
                  style="

                   background-color: #afb3b6;
                    border-radius: 25px ;

		 opacity: 0.9">
                <div class="alert alert-warning">


                    <h1 style="color: #630c6f;font-family: 'Times New Roman'">Piéces indisponibles ...</h1>
                </div>
                <div class="loader"></div>
            </div>
            <?php
        }

        ?>









        <div id="footer" style=" border-radius: 25px;
background-color: #FFFFFF;
		 opacity: 0.6">
            <ul>
                <li id="section">
                    <p><h3 align="center">Contact Us</h3> </p>
                </li>
                <li class="connect">
                    <h2>Contacts</h2>
                    <ul>
                        <li><a class="facebook" href="https://www.facebook.com/wael.chorfan" target="_blank">Facebook</a></li>


                        <li><a class="flicker" href="https://soundcloud.com/wael-chorfan" target="_blank">SoundCloud</a></li>

                    </ul>
                </li>
            </ul>

        </div>

</body>
</html>