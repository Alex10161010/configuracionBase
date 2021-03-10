<?php

/**
 * 	Autor: EAMM
 *	Fecha inicio: 10/03/2021 12:09 p.m
 *	Fecha  Final:
 * 	Descripcion:
 *  Modificacion:
 */

namespace Alexmome\Entidades;

use Alexmome\service\Crud;
use PDO;
use PDOException;

class Usuarios extends Crud
{
    //Atributos
    const TABLA = "usuario";


    //Construtor
    function __construct()
    {
        parent::__construct(self::TABLA); //Ejecutando el construstor de la clase CRUD
    }

    public function create()
    {
        return null;
    }
    public function update()
    {
        return null;
    }

    public function getTodoRegistros()
    {
        $data = null;
        try {
            $sql = "SELECT * FROM " . self::TABLA . "";
            $stm = Crud::$_connect->prepare($sql);
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $stm = null;
        return $data;
    }

    public function getAllRegistosUsuarios()
    {
        $sql = "SELECT * FROM " . self::TABLA . "";
        return Crud::getAll($sql);
    }
}
