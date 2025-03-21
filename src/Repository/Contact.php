<?php

namespace App\Repository;

use App\Lib\FormatValidator;
use App\Model\DbPostgre;
use App\Model\DbResponse;
use App\Lib\Logger;

class Contact
{
    private $db_instance;

    public function __construct()
    {
        $this->db_instance = new DbPostgre();
    }

    //TODO : Poorly optimized => Better to insert all lines in a single query
    public function addContact(string $insee, string $telephone):void
    {
        if(!FormatValidator::checkInsee($insee)) {
            throw new \Exception("Wrong insee format ($insee)");
        }

        if(!FormatValidator::checkPhone($telephone)) {
            throw new \Exception("Wrong telephone format ($telephone)");
        }

        $db_response = $this->db_instance->query("
            INSERT INTO contacts

            VALUES 
            ('$insee', '$telephone')            
        ");

        if($db_response->getAffectedRows() < 1) {
            throw new \Exception("Contact insertion failed");
        }
    }

    public function getContactByInsee(string $insee):array
    {
        if(!FormatValidator::checkInsee($insee)) {
            throw new \Exception("Wrong insee format ($insee)");
        }

        $db_response = $this->db_instance->query("
            SELECT
                MIN(insee) AS insee,
                telephone

            FROM contacts

            WHERE
                insee = '$insee'

            GROUP BY
                -- To prevent duplicates
                telephone
        ");

        return $db_response->getRows();
    }
}