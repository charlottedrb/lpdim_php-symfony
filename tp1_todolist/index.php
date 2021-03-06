<?php

require __DIR__ . "/vendor/autoload.php";
use App\Models\Database;
use App\Models\TaskRepository;

define("DATABASE_FILE", "./data.db");
$tasks = [];
try {
    Database::initialize(DATABASE_FILE);
} catch (Exception $e) {
    echo "Cannot init the DB.";
}

$taskRepository = new TaskRepository();
$taskRepository->initialize();
?>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>My Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-1/css/all.min.css"/>
    <style>
        body {
            font-family: 'arial';
            padding: 0px;
            margin: 0px;
        }

        .checked {
            text-decoration: line-through;
        }

        .btn-no-style {
            border: none;
            background-color: transparent;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        input {
            cursor: pointer;
        }

        .taskname-column {
            width: 90%;
        }

        table tr:nth-of-type(2n+1) {
            background-color: #EAEAEA;
        }

        th {
            font-size: 100px;
        }

        .checked-icon {
            color: #48a868;
        }

        .checked-icon-grey {
            color: #AAAAAA;
        }

        .trash-icon {
            color: red;
        }

        td {
            padding: 10px;

        }

        button {
            cursor: pointer !important;
        }

        i {
            font-size: 25px !important;
        }
    </style>
</head>
<body>
<?php

if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "uncheck":
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $taskRepository->update($_GET["id"]);
            }
            break;
        case "check":
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $taskRepository->update($_GET["id"], true);
            }
            break;
        case "delete":
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $taskRepository->delete($_GET["id"]);
            }
            break;
        case "add":
            if (isset($_GET["name"])) {
                $name = $_GET["name"];
                $name = addslashes($name);
                $taskRepository->add($name);
            }
            break;
        default:
            echo "An error has occurred";
            die();
    }
}

$tasks = $taskRepository->getAll();
if (empty($tasks))
    var_dump("Il n'y a pas de tâches.");
?>
<table>
    <tr>
        <th></th>
        <th class="taskname-column">Todo</th>
        <th></th>
    </tr>
    <?php
    foreach ($tasks as $task) {
        echo "<tr><form method='get' action=''><td>";
        echo "<input type='hidden' name='id' value='" . $task["id"] . "'>";
        if ($task["checked"]) {
            echo "<button class='btn-no-style' type='submit' name='action' value='uncheck'><i class='checked-icon fas fa-check'></i></button>";
        } else {
            echo "<button class='btn-no-style' type='submit' name='action' value='check'><i class='checked-icon-grey fas fa-check'></i></button>";
        }
        echo "</td><td class='" . ($task["checked"] ? 'checked' : '') . "'>";
        // Gestion des espaces, guillemets simples et back-slash.
        $search = array("_", "-", "\\");
        $toReplace = array(" ", "'", "");
        echo str_replace($search, $toReplace, $task["name"]);
        echo "</td><td>";

        echo "<button class='btn-no-style' type='submit' name='action' value='delete'><i class='trash-icon fas fa-trash'></i></button>";

        echo "</form>";
        echo "</td></tr>";
    }
    ?>
</table>

<form method="get" action="">
    <input type="text" name="name" autofocus="autofocus"/>
    <button type="submit" name="action" value="add">Add Item</button>
</form>

</body>
</html>
