<?php

	$DB_HOST = 'remotemysql.com';
	$DB_USER = 'uWrmz49yk9';
	$DB_PASS = 'jqjUc8acER';
	$DB_NAME = 'uWrmz49yk9';
	

// 	$DB_HOST = 'localhost';
// 	$DB_USER = 'root';
// 	$DB_PASS = '';
// 	$DB_NAME = 'base_musique';
	try{
		$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}


        $cntAr_stmt = $DB_con->prepare('SELECT * FROM artistes ');
        $cntAr_stmt->execute();
         $nbrAr = $cntAr_stmt->rowCount();

        $cntP_stmt = $DB_con->prepare('SELECT * FROM pieces ');
        $cntP_stmt->execute();
        $nbrP = $cntP_stmt->rowCount();

        $cntD_stmt = $DB_con->prepare('SELECT * FROM demos ');
        $cntD_stmt->execute();
        $nbrD = $cntD_stmt->rowCount();


	
