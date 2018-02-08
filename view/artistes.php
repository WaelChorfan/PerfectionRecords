<?php

require_once 'dbconfig.php';
?>

<html>
<head>
	<title>Artistes</title>
	<meta charset="utf-8">
	<link href="../css/style.css" rel="stylesheet" type="text/css ;
	 https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">


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
			<li ><a href="pieces.php">Piéces</a></li>
			<li ><a class="active" href="artistes.php">Artistes</a></li>
						<li ><a href="soumettre_piéce.html">Soumettre piéce</a></li>
			<li><a href="admin.php">Admin</a></li>
		</ul>
	</div>


       <div id="body" >

           <?php $stmt_selectAll = $DB_con->prepare("select * from artistes");
           $stmt_selectAll->execute();
           $all = $stmt_selectAll->fetchAll(PDO::FETCH_OBJ);
           if($stmt_selectAll->rowCount() > 0)
           {
           ?>

           <?php foreach($all as $ar) :?>

	        <div  class="content"
                  style="
                  opacity: 0.9;
                   background-color: #afb3b6;
                    border-radius: 25px ;">

         <ul>
             <li><h3>Nom Artiste :<a><?= $ar -> userName ; ?></a></h3></li>

             <li><h3>Email: <a> <?= $ar -> userProfession ?></a></h3></li>

  <li  align="center " >
      <a>
          <img class="img-responsive" alt="Pas d'image" width="304" height="236"

               style=" border-radius: 20%; "

               src="../SessionAdmin/GestionDesArtistes/user_images/<?php echo $ar-> userPic; ?> ">
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


                       <h1 style="color: #630c6f;font-family: 'Times New Roman'">Artistes indisponibles ...</h1>
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
	</div>

</body>
</html>