<?php

class DatabaseFactory {

  public static $db_type; // MtSQLDB

  public static function getDB()
  {
    return new self::$db_type;
  }

}
