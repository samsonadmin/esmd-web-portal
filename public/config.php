<?php

echo "<pre>";
$APP_ENV = getenv('APP_ENV');
$HKTELPRO_username = getenv('HKTELPRO_username');
$HKTELPRO_password = getenv('HKTELPRO_password');
$WAHA_API_KEY = getenv('WAHA_API_KEY');
$WAHA_username = getenv('WAHA_username');
$WAHA_password = getenv('WAHA_password');

echo "Environment: $APP_ENV\n";
echo "HKTELPRO_username : $HKTELPRO_username\n";
echo "HKTELPRO_password : $HKTELPRO_password\n";
echo "WAHA_API_KEY : $WAHA_API_KEY\n";
echo "WAHA_username: $WAHA_username\n";
echo "WAHA_password : $WAHA_password\n";


?>