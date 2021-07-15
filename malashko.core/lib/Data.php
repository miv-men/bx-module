<?php
namespace Malashko\Core;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class StatTable
 *
 * Fields:
 * <ul>
 * <li> COUNT int mandatory
 * <li> TIME datetime optional
 * </ul>
 *
 * @package Bitrix\Data
 **/

class StatTable extends Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }

    public static function getTableName()
    {
        return 'malashko';
    }

    public static function getMap()
    {
        return array(
            'COUNT' => array(
                'data_type' => 'integer',
                'primary' => true,
                'required' => true,
                'title' => Loc::getMessage('STAT_ENTITY_COUNT_FIELD'),
            ),
            'TIME' => array(
                'data_type' => 'datetime',
                'title' => Loc::getMessage('STAT_ENTITY_TIME_FIELD'),
            ),
        );
    }
}