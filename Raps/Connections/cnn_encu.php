<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnn_encu = "172.20.10.103";
$database_cnn_encu = "raps";
$username_cnn_encu = "root";
$password_cnn_encu = "1nt3rr4p1d1s1m0";
$cnn_encu = mysql_pconnect($hostname_cnn_encu, $username_cnn_encu, $password_cnn_encu) or trigger_error(mysql_error(),E_USER_ERROR); 
?>