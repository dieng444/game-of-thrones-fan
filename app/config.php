<?php
/******************************************************************************************
 * This file allows you to specify informations about your app configuration.             *
 * Like database informations or other things                                             *
 * NB : For all of the settings below. just specify the value                             *
 * of the constants but not the constant name. Not really touch the name of the constant, *
 * otherwise, it will cause huge dysfunctions in the app.                                 *
 ******************************************************************************************/
define('host','your/server/host');
define('USER','your/database/user');
define('PASSWD','your/database/user/password');
define('DB_NAME','your/database/name');
define('DSN','mysql:host='.host.';dbname='.DB_NAME);
/***Cette partie sera gérer par composer dans le futur*****/
define('SRC_DIR','your/project/full/repository/path');
define('LIB_DIR','your/project/full/repository/lib/');
define('APP_DIR','your/project/full/repository/app/');

