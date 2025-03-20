<?php
namespace App\Model;

class DbResponse
{
    private $result;
    private $num_rows;

    public function __construct($pg_result)
    {
        $this->result = $pg_result;
        if(!$this->result) {
            throw new \Exception("DB_ERROR : Aucun résultat");
        }

        $this->num_rows = pg_num_rows($pg_result);
        if($this->num_rows < 0) {
            throw new \Exception("DB_ERROR : Echec de la récupération du nombre de lignes");
        }
    }

    public function getNumRows()
    {
        //TODO
    }

    public function getRows():array
    {
        $array = [];

        if($this->num_rows > 0) {
            for($i=0; $i<$this->num_rows; $i++) {
                $row = pg_fetch_array($this->result, $i, PGSQL_ASSOC);
                $array[] = $row;
            }
        }

        return $array;
    }
}