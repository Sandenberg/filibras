<?php

// Altera o tempo de execução do programa
set_time_limit(0);

// Altera os limites de memória
ini_set('memory_limit', '512M');

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

  $tables = "*";
  $link = mysql_connect(DB_HOST,DB_USER,DB_PSWD);
  mysql_select_db(DB_NAME,$link);

  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');

    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];

    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
    $return="";

  //cycle through
  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    //print_r($num_fields);exit;
    $return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";

    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
         // $row[$j] = preg_replace("\n","\\n",$row[$j]);

          $row[$j] = preg_replace("/(\n){2,}/", "\\n", $row[$j]); 

          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";

  }
	

//save file
  $handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
 // print_r($handle);exit;
  fwrite($handle,$return);
  fclose($handle);
  // echo $return;

  //add below code to download it as a sql file
  Header('Content-type: application/octet-stream');
  Header('Content-Disposition: attachment; filename=db-backup-'.date("d-m-Y").'.sql');
  echo $return;

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;

	// Redirecionamento para a página principal do módulo
	header('Location: '.URL_ADMIN.$_GET['model'].'/');
	
}