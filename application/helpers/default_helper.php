<?php
/*
Global function
*/

function get_sql_select_client_company()
{
    return 'CASE company WHEN "" THEN (SELECT CONCAT(firstname, " ", lastname) FROM alpha_users WHERE userid = alpha_clients.userid and is_primary = 1) ELSE company END as company';
}

?>