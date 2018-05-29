<?php

  class Modelo {

    public function __construct($data)
    {
      $this->toModel($data);
    }

    public static function find($id)
    {
      return DatabaseFactory::getDB()->find($id, static::$table, get_called_class());
    }

    public static function findByCampoString($campo, $valorcampo)
    {
      return DatabaseFactory::getDB()->findByCampoString($campo, $valorcampo, static::$table, get_called_class());
    }

    public function toModel($data)
    {
      if (isset($data['id'])) $this->id = $data['id'];
      if ($data){
        foreach ($data as $key => $value) {
          if (in_array($key, $this->fillable)) {
            $this->$key = $value;
          }
        }
      }
    }

    public function save()
    {
      return DatabaseFactory::getDB()->save(static::$table, $this);
    }

  }


 ?>
