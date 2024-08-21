<?php
define('SQLSELECT_FRM_EMAIL', 'SELECT * FROM `configs_emails` WHERE 1');
define('SQLUPDATE_FRM_EMAIL', 'UPDATE `configs_emails` SET mail_host = ?, mail_port = ?, mail_username = ?, mail_password = ?, mail_setfrom = ?, mail_addaddress = ?, webpage = ? WHERE 1');
define('SQLINSERT_FRM_EMAIL', 
        'INSERT INTO configs_emails (
            mail_host, 
            mail_port,
            mail_username,
            mail_password,
            mail_setfrom,
            mail_addaddress,
            webpage) 
        VALUES(?, ?, ?, ?, ?, ?, ?)'
    );
?>