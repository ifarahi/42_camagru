<?php
    require_once 'database.php';

    try {
        $db = new database;
        $sql = file_get_contents('../app/config/database_tables.sql');
        $db->query($sql);
        $db->execute();
    } catch (Exception $error) {
        echo $error;
    }