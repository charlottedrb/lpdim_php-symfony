<?php


class TaskRepository
{
    const TABLE = "tasks";

    public function initialize(){
        $db = Database::getInstance();
        $sql = "create table if not exists " . self::TABLE .
        " (
            id INTEGER
                constraint tasks_pk
                primary key autoincrement,
            name TEXT,
            checked INTEGER default 0
        )";
        $query = $db->prepare($sql);
        $query->execute();
        return $db;
    }

    public function getAll()
    {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT * FROM " . self::TABLE);
        $query->execute();
        return $query->fetchAll();
    }

    public function update($id, $checked = false)
    {
        $db = Database::getInstance();
        $query = $db->prepare("UPDATE " . self::TABLE . " set checked=" . $checked . "WHERE id=" . $id);
        $query->execute();
        return $query->fetchAll();
    }

    public function add($description)
    {
        $db = Database::getInstance();
        $query = $db->prepare("INSERT INTO " . self::TABLE . " (name) values('" . $description . "')");
        $query->execute();
        return $query->fetchAll();
    }

    public function delete($id)
    {
        $db = Database::getInstance();
        $query = $db->prepare("DELETE FROM ". self::TABLE ." WHERE id=" . $id);
        $query->execute();
        return $query->fetchAll();
    }
}