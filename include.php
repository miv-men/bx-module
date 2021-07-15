<?
/**
* Module: malashko
* Site: http://malashko.ru/
* File: include.php
* Version: 1.0.0
**/

CModule::AddAutoloadClasses(
    "malashko.core",
    array(
        "Malashko\\Core\\Admin" => "lib/admin/GlobalMenu.php",
    )
);
CModule::AddAutoloadClasses(
    "malashko.core",
    array(
        "Malashko\\Core\\Main" => "lib/Main.php",
    )
);

require_once('lib/functions.php');