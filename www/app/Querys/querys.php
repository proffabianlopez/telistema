<?php
////////////////////////////////////////////////////////////////////////////
// Login
////////////////////////////////////////////////////////
define('SQL_LOGIN', '
        SELECT 
                u.id_user,
                u.name_user,
                u.surname_user, 
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
        LIMIT 1;');


/////////////////////////////////////////////////////////////////////////////////////
// Clients
//////////////////////////////////////////////////////////////////
define('SQL_FROM_CLIENTS', '
        SELECT * FROM clients');

define('SQL_CLIENT_BY_ID', '
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


define('SQL_DELETE_CLIENT', '
        DELETE FROM clients
        WHERE id_client = ?');


/////////////////////////////////////////////////////////////////////////////////////
// Technics
//////////////////////////////////////////////////////////////////
define('SQL_SELECT_TECHNIC', '
SELECT u.*
FROM users u
JOIN roles r ON u.id_rol = r.id_rol
WHERE r.rol = "technic";
');

define('SQL_SELECT_TECHNIC_BY_ID', '
SELECT u.*
FROM users u
JOIN roles r ON u.id_rol = r.id_rol
WHERE r.rol = "technic" AND u.id_user = ?;
');

define('SQL_SELECT_STATUS_USERS', '
        SELECT * FROM states_users');


define('SQL_SELECT_STATE_BY_ID', '
        SELECT state_user, id_state_user 
        FROM states_users
        WHERE id_state_user = ?');

define('SQL_INSERT_TECHNIC', '
INSERT INTO users (name_user, surname_user, phone_user, mail, user_password, id_state_user, id_rol)
VALUES (?, ?, ?, ?, ?, ?, ?)');

define('SQL_UPDATE_TECHNIC', '
        UPDATE users
        SET name_user = ?,
        surname_user = ?,
        phone_user = ?,
        mail = ?, 
        id_state_user = ?
        WHERE id_user = ?');

define('SQL_UPDATE_TECHNIC_BY_EMAIL', '
        UPDATE users
        SET name_user = ?,
        surname_user = ?,
        phone_user = ?,
        user_password = ?,
        id_state_user = ?,
        id_rol = ?
        WHERE mail = ?');

define(
        'SQL_UPDATE_TECHNIC_PASS',
        '
        UPDATE users
        SET user_password = ? 
        WHERE id_user = ?'
);


define('SQL_DELETE_TECHNIC', '
        DELETE FROM users
        WHERE id_user = ?');

define('SQL_SELECT_TECHNIC_BY_EMAIL_STATE_ROL', '
        SELECT r.rol, u.id_state_user
        FROM users u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE mail = ?');



/////////////////////////////////////////////////////////////////////////////////////
// Suppliers
//////////////////////////////////////////////////////////////////

define('SQL_FROM_SUPPLIERS', '
        SELECT * FROM  suppliers');


define('SQL_INSERT_SUPPLIER', '
        INSERT INTO suppliers (supplier_name, phone, mail, address, id_state_user)
        VALUES (?, ?, ?, ?, ?)');

define('SQL_UPDATE_SUPPLIER', '
        UPDATE suppliers
        SET supplier_name = ?,
        phone = ?,
        mail = ?,
        address = ?, 
        id_state_user = ?
        WHERE id_supplier = ?');


define('SQL_SELECT_SUPPLIER_BY_ID', '
        SELECT * FROM suppliers
        WHERE id_supplier = ?');


define('SQL_DELETE_SUPPLIER', '
        DELETE FROM suppliers
        WHERE id_supplier = ?');

/////////////////////////////////
// check level password
////////////////
define(
        'SQL_PASSWORD_LEVEL',
        'SELECT * FROM password_levels'
);

/////////////////////////
// ADMIN
////////////////////////

define(
        'SQL_SELECT_ADMIN',
        'SELECT u.*
        FROM users u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE r.rol = "admin" AND u.id_state_user != 2'
);


define(
        'SQL_SELECT_ADMIN_BY_ID',
        'SELECT u.*
        FROM users u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE r.rol = "admin" AND u.id_user = ?;'
);
define(
        'SQL_UPDATE_ADMIN',
        "UPDATE users
        SET
        name_user = ?,
        surname_user = ?,
        phone_user = ?,
        mail = ?,
        user_password = CASE
                        WHEN ? IS NOT NULL AND ? != '' THEN ?
                        ELSE user_password
                        END
        WHERE id_user = ?"
);

define(
        'SQL_SELECT_ADMIN_BY_EMAIL_STATE_ROL',
        'SELECT r.rol, u.id_state_user
        FROM users u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE mail = ?'
);
define(
        'SQL_UPDATE_ADMIN_BY_EMAIL',
        'UPDATE users
        SET name_user = ?,
        surname_user = ?,
        phone_user = ?,
        user_password = ?,
        id_state_user = ?,
        id_rol = ?
        WHERE mail = ?'
);
define(
        'SQL_INSERT_ADMIN',
        'INSERT INTO users (name_user, surname_user, phone_user, mail, user_password, id_state_user, id_rol)
        VALUES (?, ?, ?, ?, ?, ?, ?)'
);
define(
        'SQL_DELETE_ADMIN',
        'UPDATE users
        SET id_state_user = 2
        WHERE id_user = ?'
);


/////////////////////////////////////////////////////////////////////////////////////
// Materials
//////////////////////////////////////////////////////////////////


define('SQL_SELECT_MATERIALS', '
        SELECT * FROM  materials');