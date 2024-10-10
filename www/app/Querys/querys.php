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
                u.id_rol,
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
////////
//users
////////
define('SQL_SELEC_USERS',
'SELECT * FROM users
 WHERE id_user=?');

/////////////////////////////////////////////////////////////////////////////////////
// Clients
//////////////////////////////////////////////////////////////////
define(
        'SQL_FROM_CLIENTS',
        'SELECT * 
        FROM clients
        WHERE id_state_user != 2'
);

define('SQL_CLIENT_BY_ID', '
        SELECT * FROM clients
        WHERE id_client = ?');

define(
        'SQL_INSERT_CLIENT',
        'INSERT INTO clients (client_name, client_lastname, phone, mail, address, height, floor, departament, id_state_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)'
);

define(
        'SQL_UPDATE_CLIENT',
        ' UPDATE clients 
        SET client_name = ?,
        client_lastname = ?,
        phone = ?, 
        address = ?,
        height = ?, 
        floor = ?, 
        departament = ?
        WHERE id_client = ?'
);


define(
        'SQL_DELETE_CLIENT',
        'UPDATE clients
        SET id_state_user = 2
        WHERE id_client = ?'
);

define(
        'SQL_SELECT_CLIENT_BY_EMAIL',
        'SELECT id_state_user
        FROM clients
        WHERE mail = ?'
);

define(
        'SQL_UPDATE_CLIENT_BY_EMAIL',
        '  UPDATE clients 
        SET client_name = ?,
        client_lastname = ?,
        phone = ?,
        address = ?,
        height = ?, 
        floor = ?, 
        departament = ?,
        id_state_user = 1
        WHERE mail = ?'
);
define(
        'SQL_VERIFIC_ORDER_CLIENT',
        ' SELECT *
        FROM orders
        WHERE id_client = ? AND (id_state_order = 3 OR id_state_order = 1)
'
);


//////////////////////////////////////////////////////////////////////////
// Admins
//////////////////////////////////////////////////////////////////
define('SQL_SELECT_ADMIN', '
SELECT u.*
FROM users u
JOIN roles r ON u.id_rol = r.id_rol
WHERE r.rol = "admin";
');

define('SQL_SELECT_ADMIN_BY_ID', '
SELECT u.*
FROM users u
WHERE u.id_rol = 1 AND u.id_user = ?;
');


//////////////////////////////////////////////////////////////////////////
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
WHERE u.id_rol = 2 AND u.id_user = ?;
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


define('SQL_SELECT_TECHNIC_BY_EMAIL_STATE_ROL', '
        SELECT r.rol, u.id_state_user
        FROM users u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE mail = ?');



/////////////////////////////////////////////////////////////////////////////////////
// Suppliers
//////////////////////////////////////////////////////////////////

define(
        'SQL_FROM_SUPPLIERS',
        'SELECT *
        FROM suppliers 
        WHERE id_state_user != 2'
);


define('SQL_INSERT_SUPPLIER', 'INSERT INTO suppliers (supplier_name, phone, mail, address, id_state_user) VALUES (?, ?, ?, ?, 1)');

define(
        'SQL_UPDATE_SUPPLIER',
        'UPDATE suppliers
        SET supplier_name = ?,
        phone = ?,
        address = ?
        WHERE id_supplier = ?'
);


define('SQL_SELECT_SUPPLIER_BY_ID', '
        SELECT * FROM suppliers
        WHERE id_supplier = ?');


define(
        'SQL_DELETE_SUPPLIER',
        'UPDATE suppliers
        SET id_state_user = 2
        WHERE id_supplier = ?'
);

define(
        'SQL_SELECT_SUPPLIER_BY_EMAIL',
        'SELECT id_state_user
        FROM suppliers
        WHERE mail = ?'
);
define(
        'SQL_UPDATE_SUPPLIER_BY_EMAIL',
        ' UPDATE suppliers
        SET supplier_name = ?,
        phone = ?,
        address = ?,
        id_state_user = 1
        WHERE mail = ?'
);
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

define(
        'SQL_UPDATE_USER_AVATAR',
        'UPDATE users
        SET avatar_user = ?
        WHERE id_user = ?'
);

//////////////////////////////////////////////////////////////////////////////////////////////////////
//Orders
//////////////////////////////////////////////////////////////////////////////////////////////////////
define('SQL_ORDER_BY_ID', '
    SELECT 
        o.id_order, 
        o.order_date, 
        o.order_description,
        o.address, 
        o.height,
        o.floor, 
        o.departament,
        o.circuit_number,
        t_w.type_work,
        o.id_client, 
        p.priority,
        so.state_order,
        u.name_user,
        u.surname_user,
        cl.client_name,
        cl.client_lastname
    FROM 
        orders o
    INNER JOIN 
        prioritys p ON o.id_priority = p.id_priority
    LEFT JOIN 
        states_orders so ON o.id_state_order = so.id_state_order
    LEFT JOIN 
        users u ON o.technic_id = u.id_user
    LEFT JOIN
        clients cl ON o.id_client = cl.id_client
    LEFT JOIN
        types_works t_w ON o.id_type_work = t_w.id_type_work
    WHERE 
        so.id_state_order != 5
    ORDER BY 
        o.circuit_number ASC
');

define('SQL_INSERT_ORDER', '
        INSERT INTO orders 
                (order_date,
                order_description,
                address, 
                height, 
                floor, 
                departament,
                circuit_number,
                id_type_work, 
                id_client,
                id_priority,
                id_state_order, 
                admin_id, 
                technic_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

define('SQL_SELECT_ORDER_BY_ID', '
        SELECT 
        o.id_order, 
        o.order_date,
        o.order_description,
        o.address, 
        o.height,
        o.floor, 
        o.departament,
        o.circuit_number,
        t_w.id_type_work,
        o.id_client,
        o.id_priority,
        p.priority,
        o.id_state_order,
        so.state_order,
        o.technic_id,
        u.name_user,
        u.surname_user,
        cl.client_name,
        cl.client_lastname,
        t_w.type_work
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
    LEFT JOIN
        types_works t_w ON o.id_type_work = t_w.id_type_work
    WHERE 
        o.id_order =?');

define('SQL_UPDATE_ORDER', '
        UPDATE 
                orders
        SET 
                order_date = ?,
                order_description = ?,
                address = ?, 
                height = ?,
                floor = ?,
                departament = ?,
                circuit_number = ?,
                id_type_work = ?,
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
    SELECT *
    FROM users
    WHERE id_user = ?');

define('SQL_SELECT_TECNS_ORDERS', '
    SELECT *
    FROM users
    WHERE id_rol = 2');

define('SQL_SELECT_CLIENTS_ORDER_BY_ID', '
    SELECT *
    FROM clients
    WHERE id_client = ?');

define('SQL_SELECT_ALL_CLIENTS', '
    SELECT id_client, client_name, client_lastname
    FROM clients
    WHERE id_state_user != 2');

define('SQL_SELECT_TYPES_WORKS_ORDER_BY_ID', '
                SELECT id_type_work, type_work
                FROM types_works
                WHERE id_type_work = ?');

define('SQL_SELECT_TYPES_WORKS_ORDERS', '
                SELECT * FROM types_works');

define('SQL_DELETE_ORDER', '
        UPDATE orders
        SET id_state_order = 5
        WHERE id_order = ?');

define('SQL_FROM_ORDERS', '
        SELECT 
        o.id_order, 
        o.order_date,
        o.order_description,
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

define('SQL_SELECT_NCUICUIT','
        SELECT COUNT(*) 
        FROM orders
        WHERE circuit_number = ? AND DATE(order_date) = ? AND technic_id = ?');

/////////////////////////////////////////////////////////////////////////////////////
// MATERIALS
//////////////////////////////////////////////////////////////////

define('SQL_SELECT_STOCK', '
        SELECT stock 
        FROM materials 
        WHERE id_material = ?');

define('SQL_UPDATE_STOCK', '
        UPDATE materials
        SET stock = stock - ?
        WHERE id_material = ? AND stock >= ?');

define('SQL_SELECT_MATERIALS', '
        SELECT u. *
        FROM materials u
        WHERE u.id_status != 2');

define(
        'SQL_SELECT_MEASURE',
        '
        SELECT id_measure
        FROM materials WHERE id_material = ?'
);
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
                remittance,
                date_buy,
                ammount,
                cost,
                id_supplier,
                id_material,
                id_measure,
                id_user,
                id_state_order)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
);

define('SQL_SELECT_BUYS', '
        SELECT b.id_buy, b.remittance, b.date_buy, b.ammount, b.cost, m.material_name, s.supplier_name, st.state_order, me.name_measure
        FROM buys b
        JOIN materials m ON b.id_material = m.id_material
        JOIN measures me ON b.id_measure = me.id_measure
        JOIN suppliers s ON b.id_supplier = s.id_supplier
        JOIN states_orders st ON b.id_state_order = st.id_state_order
        WHERE 1=1'
);


define('SQL_SELECT_BUY_BY_ID', '
            SELECT b.id_buy, b.remittance, b.date_buy, b.ammount, b.cost, b.id_material, b.id_supplier, b.id_measure
            FROM buys b
            WHERE b.id_buy = ?'
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
                remittance = ?,
                date_buy = ?,
                ammount = ?,
                cost = ?,
                id_supplier = ?,
                id_material = ?,
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
//Orders Admin
//////////////////////////////////////////////////////////////////////////////////////////////////////
define('SQL_SELECT_ORDERS_TECHNIC', '
    SELECT 
        o.id_order, 
        o.order_date, 
        o.order_description,
        o.address, 
        o.height,
        o.floor, 
        o.departament,
        o.report_technic,
        o.id_client, 
        p.priority,
        so.state_order,
        u.name_user,
        u.surname_user,
        cl.client_name,
        cl.client_lastname,
        i.name_image,
        i.id_order
    FROM 
        orders o
    INNER JOIN 
        prioritys p ON o.id_priority = p.id_priority
    LEFT JOIN 
        states_orders so ON o.id_state_order = so.id_state_order
    LEFT JOIN 
        users u ON o.technic_id = u.id_user
    LEFT JOIN
        clients cl ON o.id_client = cl.id_client
    LEFT JOIN 
        images i ON o.id_order = i.id_order
    WHERE 
        o.technic_id = ?
    ORDER BY 
        o.id_order DESC
');

//////////////////////////////////////////////////////////////////////////////////////////////////////
//Orders Tecnic
//////////////////////////////////////////////////////////////////////////////////////////////////////
define('SQL_ORDER_BY_ID_TEC', '
    SELECT 
        o.id_order, 
        o.order_date,
        o.order_description,
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
        o.technic_id = ?
    AND 
        o.id_state_order NOT IN (4, 5)
    AND 
        o.order_date >= NOW() - INTERVAL 1 DAY
');


define('SQL_UPDATE_ORDER_TECHNIC', '
        UPDATE 
                orders
        SET 
                id_state_order = ?,
                report_technic  = ?
        WHERE   
                id_order = ?');

define('SQL_INSERT_IMG_ORDER',
        'INSERT INTO images (name_image, id_order)
        VALUES (?, ?)');

define('SQL_SELECT_STATE_ORDERS', '
        SELECT state_order 
        FROM `states_orders` 
        WHERE 1');


define('SQL_SELECT_ORDERS_TECHNIC_ADMIN', '
    SELECT 
        o.id_order, 
        o.order_date, 
        o.order_description,
        o.address, 
        o.height,
        o.floor, 
        o.departament,
        o.report_technic,
        o.id_client, 
        p.priority,
        so.state_order,
        u.name_user,
        u.surname_user,
        cl.client_name,
        cl.client_lastname,
        i.name_image,
        i.id_order
    FROM 
        orders o
    INNER JOIN 
        prioritys p ON o.id_priority = p.id_priority
    LEFT JOIN 
        states_orders so ON o.id_state_order = so.id_state_order
    LEFT JOIN 
        users u ON o.technic_id = u.id_user
    LEFT JOIN
        clients cl ON o.id_client = cl.id_client
    LEFT JOIN 
        images i ON o.id_order = i.id_order
    ORDER BY 
        o.id_order DESC
');

define(
        'SQL_SELECT_IMG_TECHNIC',
        'SELECT * 
        FROM images 
        WHERE id_order = ?'
);


define(
    'SQL_UPDATE_STOCK','
        UPDATE materials
        SET stock = stock - ?
        WHERE id_material = ?
        AND stock >= ?;'
);

/////////////////////////////////////////////////////////////////////////////////////
// orders_dashboard
//////////////////////////////////////////////////////////////////
define('SQL_COUNT_ORDERS_WITH_STATE', '
    SELECT 
        COUNT(*) AS total_orders,
        SUM(CASE WHEN o.id_state_order = 1 THEN 1 ELSE 0 END) AS confirmadas,
        SUM(CASE WHEN o.id_state_order = 3 THEN 1 ELSE 0 END) AS pendientes,
        SUM(CASE WHEN o.id_state_order = 4 THEN 1 ELSE 0 END) AS realizadas,
        SUM(CASE WHEN o.id_priority = 2 THEN 1 ELSE 0 END) AS criticas
    FROM orders o
    JOIN states_orders so ON o.id_state_order = so.id_state_order
');

define('SQL_COUNT_ORDERS_WITH_STATE_WEEK', '
        SELECT 
        COUNT(*) AS total_orders,
        SUM(CASE WHEN o.id_state_order = 1 THEN 1 ELSE 0 END) AS confirmadas,
        SUM(CASE WHEN o.id_priority = 1 AND o.id_state_order = 3 THEN 1 ELSE 0 END) AS pendientes,
        SUM(CASE WHEN o.id_state_order = 4 THEN 1 ELSE 0 END) AS realizadas,
        SUM(CASE WHEN o.id_priority = 2 AND o.id_state_order = 3 THEN 1 ELSE 0 END) AS criticas,
        -- Calcular los porcentajes
        ROUND(
            (SUM(CASE WHEN o.id_state_order = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 
            2
        ) AS porcentaje_confirmadas,
        ROUND(
            (SUM(CASE WHEN o.id_state_order = 3 AND o.id_priority = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 
            2
        ) AS porcentaje_pendientes,
        ROUND(
            (SUM(CASE WHEN o.id_state_order = 4 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 
            2
        ) AS porcentaje_realizadas,
        ROUND(
            (SUM(CASE WHEN o.id_state_order = 3 AND o.id_priority = 2 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 
            2
        ) AS porcentaje_criticas
    FROM orders o
    JOIN states_orders so ON o.id_state_order = so.id_state_order
    WHERE 
        (
        -- Órdenes pendientes
        (o.id_state_order = 3 
             AND o.order_date >= CURDATE() - INTERVAL 7 DAY 
             AND o.order_date < CURDATE() + INTERVAL 1 DAY)
        OR
        -- Órdenes realizadas
        (o.id_state_order = 4 
             AND o.order_date >= CURDATE() - INTERVAL 1 DAY 
             AND o.order_date < CURDATE() + INTERVAL 1 DAY)
        )

');
// Traigo todas las ordenes de los ultimos 7 dias, contando el actual.
define('SQL_ALL_ORDERS_WEEK', '
  SELECT 
    o.id_order, 
    o.order_date,
    o.order_description,
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
    (
        -- Órdenes pendientes
        (o.id_state_order = 3 
             AND o.order_date >= CURDATE() - INTERVAL 7 DAY 
             AND o.order_date < CURDATE() + INTERVAL 1 DAY)
        OR
        -- Órdenes realizadas
        (o.id_state_order = 4 
             AND o.order_date >= CURDATE() - INTERVAL 1 DAY 
             AND o.order_date < CURDATE() + INTERVAL 1 DAY)
    )
');

// Traigo todas las ordenes del último día, contando el actual.
define('SQL_ALL_ORDERS_DAY', '
    SELECT 
    o.id_order, 
    o.order_date,
    o.order_description,
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
WHERE o.order_date >= CURDATE() - INTERVAL 1 DAY
    AND o.order_date < CURDATE() + INTERVAL 1 DAY



');

/////////////////////////////////////////////////////////////////////////////////////
// orders_dashboard_technics
//////////////////////////////////////////////////////////////////
define('SQL_COUNT_ORDERS_WITH_STATE_TECHNIC', '
    SELECT 
        COUNT(*) AS total_orders,
        SUM(CASE WHEN o.id_priority = 2 AND o.order_date >= CURDATE() THEN 1 ELSE 0 END) AS criticas,
        SUM(CASE WHEN o.id_priority = 1 AND o.order_date >= CURDATE() THEN 1 ELSE 0 END) AS pendientes,
        SUM(CASE WHEN o.id_state_order = 2 THEN 1 ELSE 0 END) AS canceladas,
        SUM(CASE WHEN o.id_priority IN (1, 2) AND o.order_date < CURDATE() THEN 1 ELSE 0 END) AS anteriores
    FROM orders o
    JOIN states_orders so ON o.id_state_order = so.id_state_order
    WHERE technic_id = ? AND 
    o.id_state_order NOT IN (4)
');


define('SQL_COUNT_ORDERS_FINISH', '
    SELECT 
        COUNT(*) AS total_orders,
        SUM(CASE WHEN o.id_state_order = 4 AND o.order_date >= CURDATE() THEN 1 ELSE 0 END) AS realizadas,
        SUM(CASE WHEN o.id_state_order = 4 AND o.order_date < CURDATE() THEN 1 ELSE 0 END) AS fin
    FROM orders o
    WHERE technic_id = ?
');

