<?php
namespace App\Model;

use Exception;
use App\Model\DbResponse;

class DbPostgre
{
    private $pg_connection;
    private $host;
    private $port;
    private $db_name;
    private $user;

    public function __construct()
    {
        //TODO : Install pgAdmin to create and modify local database (or use the migration file)
        $this->host = getenv('DB_HOST');
        $this->port = getenv('DB_PORT');
        $this->db_name = getenv('DB_NAME');
        $this->user = getenv('DB_USER');

        $required_properties = ['host', 'port', 'db_name', 'user'];

        foreach($required_properties as $required_property) {
            if(!isset($this->$required_property)) {
                throw new \Exception("Wrong database configuration : $required_property configuration is missing");
            }
        }

        $connect_str = "host={$this->host} port={$this->port} dbname={$this->db_name} user={$this->user} password=".(getenv('DB_PWD'));

        //More robust with PDO
        $this->pg_connection = pg_connect($connect_str);
        if($this->pg_connection === false) {
            throw new \Exception("Database connexion failed");
        }
    }

    public function query(string $query):DbResponse
    {
        $pg_result = pg_query($this->pg_connection, $query);
        if($pg_result === false) {
            $pg_error = pg_last_error($this->pg_connection);
            throw new \Exception("DB_ERROR : ".$pg_error);
        }

        return new DbResponse($pg_result);
    }
}