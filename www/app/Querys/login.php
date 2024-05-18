<?php

define('SQL_LOGIN', '
        SELECT mail, user_password, id_rol 
        FROM users 
        WHERE mail= ?
            AND user_password = ?
        LIMIT 1');

?>



