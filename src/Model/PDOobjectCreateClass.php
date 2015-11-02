<?php
require_once __DIR__. '/../config/config.php';

class DBHandlerException extends PDOException {
}

class DBHandler {


    /**
     * Sterownik bazy danych
     */
    const DB_DRIVER = 'mysql';

    /**
     * Czy wyswietlac dokladne komunikaty bledow
     */
    const DEBUG_MODE = true;

    /**
     * @var PDO singleton PDO
     */
    private static $pdo = null;

    /**
     * Zwraca singleton PDO lub wyswietla komunikat bledu i zwraca null.
     * @return PDO|null
     */
    public static function getPDO() {
        try {
            if (self::$pdo === null) {
                self::$pdo = self::createPDO();
            }
            return self::$pdo;
        }
        catch (DBHandlerException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * @return PDO zwraca nowa instancje PDO
     * @throws DBHandlerException
     */
    private static function createPDO() {
        if (!extension_loaded('PDO')) throw new DBHandlerException('Brak modulu PDO');
        try {
            $pdo = new PDO(
                self::DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
        catch(PDOException $e) {
            if (self::DEBUG_MODE == true) {
                throw new DBHandlerException("Blad bazy danych : {$e->getMessage()}");
            }
            else {
                throw new DBHandlerException('Blad bazy danych');
            }
        }
    }

    /**
     * Zapobiega tworzeniu obiektu.
     */
    private function __construct() {
        throw new Exception('Nie mozna stworzyc tego obiektu!');
    }

    /**
     * Zapobiega klonowaniu obiektu.
     */
    private function __clone() {
        throw new Exception('Nie mozna klonowac tego obiektu!');
    }
}