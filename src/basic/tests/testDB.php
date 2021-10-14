<?php

use app\config\db;
use PDO;


class testDB{
  
  public static function probar(){
          try{
            $base = new PDO('mysql:host='.$_ENV['DDBB_HOST'].';dbname='.$_ENV['DDBB_NAME'], 'root', $_ENV['DDBB_PASSWORD']);

            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql="INSERT INTO PUEBA1 (valor) VALUES ('prueba');";

            $resultado = $base->prepare($sql);

            $resultado->execute();
            $resultado->closeCursor();

           echo 'crado correctamente';
        }catch(Exception $e){
            die('ERROR: '. $e->GetMessage());
        }finally{
            $base=null;
        }
}
}
    ?>
