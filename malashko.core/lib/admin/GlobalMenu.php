<?php

namespace Malashko\Core;

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class Admin
{

    public function GlobalMenu(&$aGlobalMenu, &$aModuleMenu){

        $aModuleMenu[] = array(
            "parent_menu" => "global_menu_services", // поместим в раздел "Сервис"
            "section" => Loc::getMessage("PARTNER_NAME"),
            "sort"        => 50,                    // сортировка пункта меню
            "url"         => "settings.php?lang=ru&mid=malashko.core&mid_menu=1",  // ссылка на пункте меню
            "text"        => Loc::getMessage("NAME"),       // текст пункта меню
            "title"       => Loc::getMessage("DESCRIPTION"), // текст всплывающей подсказки
            "icon"        => "sys_menu_icon", // малая иконка
            "page_icon"   => "sys_page_icon", // большая иконка
            "items_id"    => "malashko.core",  // идентификатор ветви
            "items"       => array()          // остальные уровни меню сформируем ниже.
        );

    }

}