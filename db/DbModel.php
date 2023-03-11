<?php
namespace lexuanphat\phpmvc\db;

use lexuanphat\phpmvc\App;
use lexuanphat\phpmvc\Model;

abstract class DbModel extends Model{

    abstract public function tableName() : string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string; 

    public static function prepare($sql){
       return App::$app->db->pdo->prepare($sql);
    }

    public function save(){
        
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(function($attr){
            return ":$attr";
        }, $attributes);

        $sql = "INSERT INTO $tableName (" .implode(",", $attributes). ") VALUES 
            (".implode(",", $params).")
        ";
        $statement = self::prepare($sql);

        foreach($attributes as $attr){
            $statement->bindValue(":$attr", $this->{$attr});
        }

        $statement->execute();

        return true;
        
    }

    public static function findOne(array $where){
        $className = static::class;
        $className = new $className;
        $tableName = $className->tableName();

        $attributes = array_keys($where);

        $wheres = array_map(function($attr){
            return "$attr = :$attr";
        }, $attributes);

        $sql = "SELECT * FROM $tableName WHERE ".implode(" AND ", $wheres)."";
        
        $statement = self::prepare($sql);

        foreach($where as $key => $value){
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);

    }

}