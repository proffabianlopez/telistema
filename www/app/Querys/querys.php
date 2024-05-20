<?php
// Login
define('SQL_LOGIN', '
        SELECT mail, user_password, id_rol 
        FROM users 
        WHERE mail= ?
            AND user_password = ?
        LIMIT 1');

// Clients
define('SQL_FROM_CLIENTS','
        SELECT * FROM clients');

define('SQL_CLIENT_BY_ID','
        SELECT * FROM clients
        WHERE id_client = ?');

define('SQL_INSERT_CLIENT', '
        INSERT INTO clients 
        (client_name, client_lastname, phone, mail, address, height, floor, departament, id_state_user) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

define('SQL_UPDATE_CLIENT', '
        UPDATE clients 
        SET client_name = ?,
            client_lastname = ?,
            phone = ?, 
            mail = ?,
            address = ?,
            height = ?, 
            floor = ?, 
            departament = ?
        WHERE id_client = ?');


define('SQL_DELETE_CLIENT','
        DELETE FROM clients WHERE id_client = ?');

?>



