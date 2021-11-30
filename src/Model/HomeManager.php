<?php

namespace App\Model;

/**
 * Class handling requests to DB for Home page
 */

class HomeManager extends AbstractManager
{
    public const TABLE = 'argonaut';

    public function add(string $name): void
    {
        $statement = $this->pdo->prepare('INSERT INTO argonaut (name) VALUES (:name)');
        $statement->bindvalue(":name", $name, \PDO::PARAM_STR);
        $statement->execute();
    }
}
