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

define('SQL_SELECT_STATE_BY_ID', '
        SELECT state_user, id_state_user 
        FROM states_users
        WHERE id_state_user = ?');

define('SQL_INSERT_TECHNIC', '
INSERT INTO users (name_user, surname_user, phone_user, mail, user_password, id_state_user, id_rol)
VALUES (?, ?, ?, ?, ?, ?, ?)');

define(
        'SQL_UPDATE_TECHNIC',
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
// Users
////////////////////////

define(
        'SQL_SELECT_USERS',
        'SELECT u.*, r.*
        FROM users u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_state_user != 2'
);


define(
        'SQL_SELECT_USER_BY_ID',
        'SELECT u.*
        FROM users u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_user = ?;'
);
define(
        'SQL_UPDATE_USER',
        "UPDATE users
        SET
        name_user = ?,
        surname_user = ?,
        phone_user = ?,
        id_rol = ?,
        user_password = CASE
                        WHEN ? IS NOT NULL AND ? != '' THEN ?
                        ELSE user_password
                        END
        WHERE id_user = ?"
);

define(
        'SQL_SELECT_USER_BY_EMAIL_STATE_ROL',
        'SELECT r.rol, u.id_state_user
        FROM users u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE mail = ?'
);
define(
        'SQL_UPDATE_USER_BY_EMAIL',
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
        'SQL_INSERT_USER',
        'INSERT INTO users (name_user, surname_user, phone_user, mail, user_password, id_state_user, id_rol)
        VALUES (?, ?, ?, ?, ?, ?, ?)'
);
define(
        'SQL_DELETE_USER',
        'UPDATE users
        SET id_state_user = 2
        WHERE id_user = ?'
);

define(
        'SQL_VERIFIC_ORDER_USER',
        ' SELECT *
        FROM orders 
        WHERE technic_id = ? AND id_state_order = 3'
);

//////////////////////////////////////////////////////////////////////////////////////////////////////
//Orders
//////////////////////////////////////////////////////////////////////////////////////////////////////
define('SQL_ORDER_BY_ID', '
    SELECT 
        o.id_order, 
        o.order_date, 
        o.order_description, 
        o.order_server,
        o.address, 
        o.height,
        o.floor, 
        o.departament,
        o.id_client, 
        p.priority,
        so.state_order,
        u.name_user,
        u.surname_user,
        cl.client_name,
        cl.client_lastname
    FROM 
        orders o
    JOIN 
        prioritys p ON o.id_priority = p.id_priority
    LEFT JOIN 
        states_orders so ON o.id_state_order = so.id_state_order
    LEFT JOIN 
        users u ON o.technic_id = u.id_user
    LEFT JOIN
        clients cl ON o.id_client = cl.id_client
    WHERE 
        o.id_client = ?');

define('SQL_INSERT_ORDER', '
        INSERT INTO orders 
                (order_date,
                order_description, 
                order_server, 
                address, 
                height, 
                floor, 
                departament, 
                id_client,
                id_priority,
                id_state_order, 
                admin_id, 
                technic_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

define('SQL_SELECT_ORDER_BY_ID', '
        SELECT 
        o.id_order, 
        o.order_date,
        o.order_description, 
        o.order_server,
        o.address, 
        o.height,
        o.floor, 
        o.departament,
        o.id_client,
        p.priority,
        so.state_order,
        u.name_user,
        u.surname_user,
        cl.client_name,
        cl.client_lastname
    FROM 
        orders o
    JOIN 
        prioritys p ON o.id_priority = p.id_priority
    LEFT JOIN 
        states_orders so ON o.id_state_order = so.id_state_order
    LEFT JOIN 
        users u ON o.technic_id = u.id_user
    LEFT JOIN
        clients cl ON o.id_client = cl.id_client
    WHERE 
        o.id_order =?');

define('SQL_SELECT_STATE_ORDER_BY_ID', '
            SELECT id_state_order, state_order 
            FROM states_orders
            WHERE id_state_order = ?');

define('SQL_SELECT_STATUS_ORDERS', '
            SELECT * FROM states_orders');

define('SQL_UPDATE_ORDER', '
        UPDATE 
                orders
        SET 
                order_description = ?,
                order_server = ?,
                address = ?, 
                height = ?,
                floor = ?,
                departament = ?,
                id_client = ?,
                id_priority = ?,
                id_state_order = ?,
                technic_id = ?
        WHERE   
                id_order = ?');



define('SQL_SELECT_PRIORITYS_ORDER_BY_ID', '
        SELECT id_priority, priority 
        FROM prioritys
        WHERE id_priority = ?');

define('SQL_SELECT_PRIORITYS_ORDERS', '
        SELECT * FROM prioritys');

define('SQL_SELECT_TECNS_ORDER_BY_ID', '
    SELECT id_user, name_user, surname_user, id_rol 
    FROM users
    WHERE id_user = ?');

define('SQL_SELECT_TECNS_ORDERS', '
    SELECT id_user, name_user, surname_user, id_rol 
    FROM users
    WHERE id_rol = 2');

define('SQL_SELECT_CLIENT_BY_ID', '
        SELECT id_client, client_name, client_lastname
        FROM clients 
        WHERE id_client = ?');

define('SQL_DELETE_ORDER', '
        DELETE FROM orders
        WHERE id_client = ? AND id_order = ?');

define('SQL_FROM_ORDERS', '
        SELECT 
        o.id_order, 
        o.order_date,
        o.order_description, 
        o.order_server,
        o.address, 
        o.height,
        o.floor, 
        o.departament,
        o.id_client,
        p.priority,
        so.state_order,
        u.name_user,
        u.surname_user,
        cl.client_name,
        cl.client_lastname
    FROM 
        orders o
    JOIN 
        prioritys p ON o.id_priority = p.id_priority
    LEFT JOIN 
        states_orders so ON o.id_state_order = so.id_state_order
    LEFT JOIN 
        users u ON o.technic_id = u.id_user
    LEFT JOIN
        clients cl ON o.id_client = cl.id_client');

/////////////////////////////////////////////////////////////////////////////////////
// Products
//////////////////////////////////////////////////////////////////


define('SQL_SELECT_MATERIALS', '
        SELECT u. *
        FROM materials u
        WHERE u.id_status != 2');



define(
        'SQL_SELECT_PRODUCT_BY_ID',
        '
        SELECT u.*
        FROM materials u
        WHERE u.id_material = ?;'
);

define('SQL_UPDATE_PRODUCT', '
        UPDATE materials
        SET material_name = ?,
        description = ?,
        stock = ?,
        stock_alert = ?,
        id_measure = ?
        WHERE id_material = ?');


define('SQL_SELECT_MEASURE_BY_ID', '
        SELECT name_measure
        FROM measures 
        WHERE id_measure = ?');


define('SQL_SELECT_MEASURES', '
        SELECT * FROM  measures');


define(
        'SQL_INSERT_PRODUCT',
        'INSERT INTO materials (
                material_name,
                description,
                stock,
                stock_alert,
                id_measure,
                id_status)
        VALUES (?, ?, ?, ?, ?, ?)'
);

define(
        'SQL_DESACTIVE_PRODUCT',
        'UPDATE materials
        SET id_status = 2
        WHERE id_material = ?'
);

define('SQL_SELECT_STATE', '
        SELECT state_user
        FROM states_users
        WHERE id_state_user = ?');
        
/////////////////////////////////////////////////////////////////////////////////////
// Buys
//////////////////////////////////////////////////////////////////

define(
        'SQL_INSERT_BUY',
        'INSERT INTO buys (
                date_buy,
                ammount,
                cost,
                id_supplier,
                id_material,
                id_measure,
                id_user,
                id_state_order)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
);

define('SQL_SELECT_BUYS', '
       SELECT 
            b.id_buy,
            b.ammount,
            b.cost,
            so.state_order AS name_state,
            m.name_measure,
            p.material_name,
            s.supplier_name
        FROM 
            buys b
        JOIN 
            states_orders so ON b.id_state_order = so.id_state_order
        JOIN 
            measures m ON b.id_measure = m.id_measure
        JOIN 
            materials p ON b.id_material = p.id_material
        JOIN 
            suppliers s ON b.id_supplier = s.id_supplier');

define(
        'SQL_SELECT_BUY_BY_ID', '
        SELECT u.*
        FROM buys u
        WHERE u.id_buy = ?;'
);

define(
        'SQL_MODIFY_STATUS_BUY',
        '
        UPDATE buys
        SET id_state_order = 4
        WHERE id_buy = ?'
);


define(
        'SQL_UPDATE_BUY',
        'UPDATE buys
        SET 
                date_buy = ?,
                ammount = ?,
                cost = ?,
                id_supplier = ?,
                id_material = ?,
                id_measure = ?,
                id_user = ?
        WHERE id_buy = ?'
);

define(
        'SQL_MODIFY_CANCEL_BUY',
        '
        UPDATE buys
        SET id_state_order = 2
        WHERE id_buy = ?'
);

//////////////////////////////////////////////////////////////////////////////////////////////////////
//Orders Tecnic
//////////////////////////////////////////////////////////////////////////////////////////////////////
define('SQL_ORDER_BY_ID_TEC', '
    SELECT 
        o.id_order, 
        o.order_date,
        o.order_description, 
        o.order_server,
        o.address, 
        o.height,
        o.floor, 
        o.departament,
        o.id_client, 
        p.priority,
        so.state_order,
        u.name_user,
        u.surname_user,
        cl.client_name,
        cl.client_lastname
    FROM 
        orders o
    JOIN 
        prioritys p ON o.id_priority = p.id_priority
    LEFT JOIN 
        states_orders so ON o.id_state_order = so.id_state_order
    LEFT JOIN 
        users u ON o.technic_id = u.id_user
    LEFT JOIN
        clients cl ON o.id_client = cl.id_client
    WHERE 
        o.technic_id = ?');
