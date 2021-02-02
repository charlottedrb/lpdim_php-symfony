<?php

namespace App\Models;

use \PDO;
use \Exception;


class TaskRepository
{
    const TABLE = "tasks";

    public function initialize(): void
    {
        $db = Database::getInstance();
        $sql = "create table if not exists " . self::TABLE .
        " (
            id INTEGER
                constraint tasks_pk
                primary key autoincrement,
            name TEXT,
            checked INTEGER default 0
        ); 
        INSERT INTO ". self::TABLE ." (id, name, checked) VALUES (1, 'Task to be done', 0);
        INSERT INTO ". self::TABLE ." (id, name, checked) VALUES (2, 'Task done', 1);";

        $query = $db->prepare($sql);
        $query->execute();
    }

    public function getAll(): array
    {
        $db = Database::getInstance();
        $query = $db->query("SELECT * FROM " . self::TABLE, PDO::FETCH_ASSOC);
        return $query->fetchAll();
    }

    public function update($id, $checked = 0): array
    {
        $db = Database::getInstance();
        $query = $db->prepare("UPDATE " . self::TABLE . " set checked=" . $checked . " WHERE id=" . $id);
        $query->execute();
        return $query->fetchAll();
    }

    public function add($description): array
    {
        // Gestion des espaces, guillemets simples et back-slash.
        $search = array(" ", "'");
        $toReplace = array("_", "-");
        $name = str_replace($search, $toReplace, $description);

        $db = Database::getInstance();
        $query = $db->prepare("INSERT INTO " . self::TABLE . " (name) values('" . $name . "')");
        $query->execute();
        return $query->fetchAll();
    }

    public function delete($id): array
    {
        $db = Database::getInstance();
        $query = $db->prepare("DELETE FROM ". self::TABLE ." WHERE id=" . $id);
        $query->execute();
        return $query->fetchAll();
    }
}