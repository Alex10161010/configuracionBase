<?php

/**
 * 	Autor: EAMM
 *	Fecha inicio: 10/03/2021 12:09 p.m
 *	Fecha  Final:
 * 	Descripcion:
 *  Modificacion:
 */

namespace Alexmome\service;

use Alexmome\Conexion;
use PDO;
use PDOException;

abstract class Crud extends Conexion
{

    //Atributos
    private $tabla;


    //Metodo Constructor
    function __construct($tabla)
    {
        $this->tabla = $tabla;
        parent::mysql_conexion(); //Ejecuta el metodo que inicia la conexion
    }

    public function getAll($sql)
    {
        $data = null;
        try {
            $stm = Conexion::$_connect->prepare($sql);
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $stm = null;
        return $data;
    }


    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM $this->tabla WHERE id=?";
            $stm = Conexion::$_connect->prepare($sql);
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $stm = null;
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM $this->tabla WHERE id=?";
            $stm = Conexion::$_connect->prepare($sql);
            $stm->execute(array($id));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $stm = null;
    }

    abstract function create();

    abstract function update();
}
