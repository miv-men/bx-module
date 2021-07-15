<?
/**
 * Module: malashko
 * Site: http://malashko.ru/
 * File: Main.php
 * Version: 1.0.0
 **/

namespace Malashko\Core;

use DataTable;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;

class Main {

    public $data;

    public function __construct()
    {

        $module_id = pathinfo(dirname(__DIR__))["basename"];

        $this->data = [
            "switch_on" 	=> Option::get($module_id, "switch_on", "Y"),
            "title_row" 	=> Option::get($module_id, "title_row", "-"),
            "create_webp" 	=> Option::get($module_id, "create_webp", "A"),
        ];

        return $this->data;

    }

    public static function getTable($cond) {
        $result = DataTable::getList(
            array(
                'select' => array('*')
            ));
        $row = $result->fetch();

        return $row;
    }

}