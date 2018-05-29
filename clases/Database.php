<?php

class Database {

  private static $dbName = 'budgetfork' ;
  private static $dbHost = 'localhost' ;
  private static $dbUsername = 'root';
  private static $dbUserPassword = '';
  private static $cont  = null;


  public static function connect()
  {
     // One connection through whole application
     if ( null == self::$cont )
     {
      try
      {
        self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
      }
      catch(PDOException $e)
      {
        die($e->getMessage());
      }
     }

     // self::$cont->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE:EXCEPTION);
     return self::$cont;
  }

  public static function disconnect()
  {
      self::$cont = null;
  }



}





 ?>
