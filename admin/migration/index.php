<?php

$config = require "../config.php";

$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'], $config['username'],
    $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function runTransaction()
{
    $file_list_arr = searchFilesForMigration();

    if (empty($file_list_arr)) {
        exit("Нет запросов для выполнения");
    }

    global $db;
    try {
        $db->beginTransaction();
        $result = '';

        foreach ($file_list_arr as $file) {

            $query_arr = file_get_contents($file);
            $query_arr = preg_split("/(;\n)/", $query_arr);

            foreach ($query_arr as $query) {

                if (trim($query)) {
                    $db->exec($query);
                }
            }

            $result .= $file . ' ';
        }
        $db->commit();
        saveDateMigration();
        echo "Выполнены запросы из файла(ов): <b>" . $result . "</b>";
    } catch (Exception $e) {
        $db->rollBack();
        print <<<HTML_BLOCK
        Выброшено исключение:   <b>{$e->getMessage()}</b><br>
        Строка:                 <b>{$e->getLine()}</b><br>
        В файле:                <b>{$e->getFile()}</b><br>
        Stack trace:            <b>{$e->getTrace()[0]["args"][0]}</b><br>
HTML_BLOCK;
        //throw $e;
    } catch (Throwable $e) {
        $db->rollBack();
        print <<<HTML_BLOCK
        Выброшено исключение:   <b>{$e->getMessage()}</b><br>
        Строка:                 <b>{$e->getLine()}</b><br>
        В файле:                <b>{$e->getFile()}</b><br>
        Stack trace:            <b>{$e->getTrace()[0]["args"][0]}</b><br>
HTML_BLOCK;
        //throw $e;
    }
}

/**
 * If the migration is successful, then save the migration date to a file.
 */
function saveDateMigration()
{
    $current_date = date("d.m.Y H:i:s");
    $fileName = __DIR__ . '/last_date_migration';
    file_put_contents($fileName, $current_date);
}

/**
 * @return array
 */
function searchFilesForMigration()
{
    $dir = new DirectoryIterator(dirname(__FILE__));

    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $file_list_all[] = $fileinfo->getFilename();
        }
    }

    $file_list_all = array_values(preg_grep("/.sql$/", $file_list_all));

    $last_date_migration = file_get_contents("last_date_migration");

    $file_list_arr = [];

    foreach ($file_list_all as $file_name) {
        if (file_exists($file_name)) {
            $date_file = date("d.m.Y H:i:s", filemtime($file_name));
        }
        if (strtotime($last_date_migration) < strtotime($date_file)) {

            $file_list_arr[] = $file_name;
        }
    }
    return $file_list_arr;
}

runTransaction();
