<?php

class DBMySQL {

  public function find($id, $table, $class)
  {
    $sql = "SELECT * FROM ".$table." WHERE id = :id";
    $stmt = Database::connect()->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $model = new $class([]);
    $model->toModel($result);
    return $model;
  }

  public function findByCampoString($campo, $valorcampo, $table, $class)
  {
    $sql = "SELECT * FROM ".$table." WHERE $campo = :campo";
    $stmt = Database::connect()->prepare($sql);
    $stmt->bindValue(":campo", $valorcampo, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $model = new $class([]);
    $model->toModel($result);
    return $model;
  }

  public function save($table, $model)
  {
    $sql = ($model->id)?$this->update($table, $model):$this->insert($table, $model);
    $stmt = Database::connect()->prepare($sql);
    foreach ($model->fillable as $column) {
      $stmt->bindValue(":$column", $model->$column);
    }
    $stmt->execute();
  }

  private function insert($table, $model)
  {
    $columns = implode(", ", $model->fillable);
    $placeholders = ":".implode(", :", $model->fillable);
    return "INSERT INTO ".$table." ($columns) VALUES ($placeholders)";
  }

  private function update($table, $model)
  {
    $set = "";
    foreach ($model->fillable as $column) {
      $set .= "$column=:$column,";
    }
    $set = trim($set, ",");
    return "UPDATE ".$table." SET $set WHERE id = ".$model->id;
  }

}
