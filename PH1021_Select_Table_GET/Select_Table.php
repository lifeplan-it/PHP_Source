<!-- http://localhost/php/PHP_Source/PH1020_Select_Table_POST/Select_Table.php -->

<!DOCTYPE html>
<html lang="ja">
<head>
  <MEAT chaeset="UTF-8">
  <title>PHP Sample</title>
  <style type="text/css">
	#message {color:red   ;  background-color:white; font-size: 16px;  }
	#sql           {color:black;  background-color:white; font-size: 24px;  }
  </style>
</head>

<body>
<header><h1>MySQLのカラム名をPHPで取する</h1></header>
<main>
<header><h2>概要</h2></header>
Mysqlで、テーブルのカラム名を取得するSQL文とPHPのソースコードです。<br>
<dev id="message" >
このページは実際のPHPプログラムで実行されています。<br>
</dev>

<!-- パラメータセットアップ -->
<?php
	// print(htmlspecialchars($_REQUEST['Table_name'], ENT_QUOTES)); 
	$tablename = htmlspecialchars($_REQUEST['Table_name'], ENT_QUOTES) ;
	// $tablename = '顧客マスタ' ;
 	$sql = "SELECT *  FROM $tablename; " ;

	$DataBase =  "lifeandit_eng001" ;
	$username = "lifeandit" ; 
	$password = "pass1025" ; 

	/* $DataBase =  file_get_contents('lifeandit_eng001_database.txt'); */
	/* $username = file_get_contents('lifeandit_eng001_user.txt'); */
	/* $password = file_get_contents('lifeandit_eng001_password.txt'); */ 
	$dsn = "mysql:dbname=$DataBase;host=localhost";
?>
<?php echo "<h3> $tablename </h3>" ; ?>

<!-- テーブル用のSQL文 -->
<dev id="sql">
<?php print( "データベース :  $DataBase "); print('<br>');  ?>　
<?php print( "テーブル名 :  $tablename "); print('<br>');  ?>　
<?php print( "　SQL文:  $sql "); print('<br>');  ?>　
</dev>
<?php 
  try { $dbh = new PDO($dsn, $username, $password,
           array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') );
           // SQLを実行              
          $res = $dbh->query($sql);

  } catch ( PDOException $e){ print('Error:'.$e->getMessage()); die(); }
         // カラム名の取得
         for ($i = 0; $i < $res->columnCount(); $i++) {
             $column_index[] = $res->getColumnMeta($i)['name'];
}
// $dbh をクリア
$dbh = null ;
?> 

<!-- テーブル表示 -->
<dev>
<table  border="1">
<!-- カラム名表示 -->
   <tr>
   <?php foreach ($column_index as $s)  :  ?>
	<td> <?php echo $s  ; ?></td> 
   <?php endforeach ?> 
   </tr>
<!-- データ表示 -->
<?php foreach ( $res as $row ) : ?>
   <tr>
     <?php foreach ( $column_index as $r ) : ?>
            <td> <?php echo htmlspecialchars( $row[ $r ] ) ; ?></td> 
      <?php endforeach ?> 
    </tr>
<?php endforeach ?> 
</table>
</dev>
</main>
<footer> </footer>
</body>
</html>