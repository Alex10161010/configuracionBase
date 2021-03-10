<?php

/**
 * 	Autor: EAMM
 *	Fecha inicio: 10/03/2021 12:09 p.m
 *	Fecha  Final:
 * 	Descripcion:
 *  Modificacion:
 */

namespace Alexmome;

use Exception;
use PDO;
use PDOException;

class Conexion extends PDO
{
    private $driver;
    private $host;
    private $port;
    private $user;
    private $pass;
    private $dbName;
    private $charset;
    protected static $_connect;

    function __construct()
    {
        date_default_timezone_set("America/Mexico_City"); // Establece la zona horaria predeterminada usada por todas las funciones de fecha/hora en un script
    }

    protected function mysql_conexion()
    {
        if (!self::$_connect) {
            $this->driver =  $this->getVariableEntorno('MYSQL_DRIVER');
            $this->host =  $this->getVariableEntorno('MYSQL_HOST');
            $this->port =  $this->getVariableEntorno('MYSQL_PORT');
            $this->user =  $this->getVariableEntorno('MYSQL_USER');
            $this->pass =  $this->getVariableEntorno('MYSQL_PASS');
            $this->dbName =  $this->getVariableEntorno('MYSQL_DBNAME');
            $this->charset =  $this->getVariableEntorno('MYSQL_CHARSET');
            try {
                $opciones = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ];
                $mbd = new PDO("{$this->driver}:host={$this->host};port={$this->port};dbname={$this->dbName};charset={$this->charset}", $this->user, $this->pass, $opciones);
                self::$_connect = $mbd;
            } catch (PDOException $e) {
                print "¡Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        return self::$_connect;
    }

    public function mensajeJson($arraydata)
    {
        echo json_encode($arraydata);
    }

    /* ------------------------- */
    private function variable()
    {
        return array(
            'driver' => $this->driver,
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->user,
            'pass' => $this->pass,
            'dbName' => $this->dbName,
            'charset' => $this->charset,
        );
    }

    /**
     * Undocumented function
     *
     * @param [string] $clave
     * @return retorna
     * defined — Comprueba si existe una constante con nombre dada
     * devuelve true si la constante con nombre dada por name ha sido definida, si no devuelve false.
     * -----------
     * file_exists — Comprueba si existe un fichero o directorio
     * Devuelve true si el fichero o directorio especificado por filename existe; false si no.
     * ----------------
     * parse_ini_file — carga el fichero ini especificado en filename,
     * y devuelve las configuraciones que hay en él a un array asociativa.
     * ---------------
     * define — Define una constante con nombre
     * Define una constante con nombre en tiempo de ejecución.
     * ----------------------
     * NOTA
     * El archivo debera estar fuera en capeta raiz
     */
    public function getVariableEntorno($clave)
    {
        if (defined('ENVCACHE')) {
            $arrayAsoc = ENVCACHE;
        } else {
            $archivo = "../env.php";
            if (!file_exists($archivo)) {
                throw new Exception("El archivo de las variables de entorno ($archivo) no existe. Favor de crearlo");
            }
            $arrayAsoc = parse_ini_file($archivo);
            define("ENVCACHE", $arrayAsoc);
        }
        if (isset($arrayAsoc[$clave])) {
            return $arrayAsoc[$clave];
        } else {
            throw new Exception("La clave especificada (" . $clave . ") no existe en el archivo de las variables de entorno");
        }
    }
}
