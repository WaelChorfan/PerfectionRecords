<?php
require_once 'dbconfig.php';


/*
$target_dir = "demos/";
$target_file = $target_dir . basename($_FILES["demoAudio"]["name"]);
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if($FileType != "mp3" && $FileType != "wav"  ) {
    echo "Sorry, only MP3 and WAV formats are allowed.";
}else{if (move_uploaded_file($_FILES["demoAudio"]["tmp_name"], $target_file)) {

            echo "The file " . basename($_FILES["demoAudio"]["name"]) . " has been uploaded.";*/


$NomArtiste = $_POST["NomArtiste"];
$NomPiece = $_POST["NomPiece"];
$Email = $_POST["Email"];

$prodType = $_POST["prodType"];
$sql='INSERT INTO demos 
VALUES( null , ?, ?, ?, ? )';
$stmt = $DB_con->prepare( $sql);
$stmt->bindParam(1,$NomArtiste,PDO::PARAM_STR);
$stmt->bindParam(2,$NomPiece,PDO::PARAM_STR);
$stmt->bindParam(3,$Email,PDO::PARAM_STR);

$stmt->bindParam(4,$prodType,PDO::PARAM_STR);
if($stmt->execute()){

    echo"Merci pour soumettre votre démo ,votre demande va étre traitée dans quelques jours";

}

header ('location:soumettre_piéce.html');
?>