<?php
////////////////////////////////////////////////////////////////////////////
// Login
////////////////////////////////////////////////////////
define('SQL_LOGIN', '
        SELECT 
                u.name_user, 
                u.mail, 
                u.user_password, 
                r.rol, 
                s.state_user
        FROM 
                users u
        JOIN 
                roles r ON u.id_rol = r.id_rol
        JOIN 
                states_users s ON u.id_state_user = s.id_state_user
        WHERE 
                u.mail = ? 
                AND u.user_password = ?
        LIMIT 1;');


/////////////////////////////////////////////////////////////////////////////////////
// Clients
//////////////////////////////////////////////////////////////////
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
        DELETE FROM clients
        WHERE id_client = ?');


/////////////////////////////////////////////////////////////////////////////////////
// Technics
//////////////////////////////////////////////////////////////////
define('SQL_SELEC_TECHNIC', '
        SELECT * FROM users');


define('SQL_INSERT_TECHNIC', '
INSERT INTO users (name_user, phone_user, mail, user_password, id_state_user, id_rol)
VALUES (?, ?, ?, ?, ?, ?)');

define('SQL_DELETE_TECHNIC', '
        DELETE FROM users
        WHERE id_user = ?');

?>



