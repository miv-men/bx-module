<?
/**
* Module: Malashko
* Site: http://malashko.ru/
* File: index.php
* Version: 1.0.0
**/

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class malashko_core extends CModule{

    public function __construct(){

        if(file_exists(__DIR__."/version.php")){

            $arModuleVersion = array();

            include_once(__DIR__."/version.php");

            $this->MODULE_ID 		   = str_replace("_", ".", get_class($this));
            $this->MODULE_VERSION 	   = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME 		   = Loc::getMessage("NAME");
            $this->MODULE_DESCRIPTION  = Loc::getMessage("DESCRIPTION");
            $this->PARTNER_NAME 	   = Loc::getMessage("PARTNER_NAME");
            $this->PARTNER_URI  	   = Loc::getMessage("PARTNER_URI");
        }

        return false;
    }

	public function DoInstall(){

		global $APPLICATION;

		if(CheckVersion(ModuleManager::getVersion("main"), "14.00.00")){

			$this->InstallFiles();
			$this->InstallDB();

			ModuleManager::registerModule($this->MODULE_ID);

			$this->InstallEvents();
		}else{
            // Прерываем установку если версия ниже 14.0
			$APPLICATION->ThrowException(
				Loc::getMessage("INSTALL_ERROR_VERSION")
			);
		}

		$APPLICATION->IncludeAdminFile(
			Loc::getMessage("INSTALL_TITLE")." \"".Loc::getMessage("NAME")."\"",
			__DIR__."/step.php"
		);

		return false;
	}

	public function InstallFiles(){

//		CopyDirFiles(
//			__DIR__."/assets/scripts",
//			Application::getDocumentRoot()."/bitrix/js/".$this->MODULE_ID."/",
//			true,
//			true
//		);
//
//		CopyDirFiles(
//			__DIR__."/assets/styles",
//			Application::getDocumentRoot()."/bitrix/css/".$this->MODULE_ID."/",
//			true,
//			true
//		);

		return false;
	}

	public function InstallDB(){

        global $DB;

        $DB->Query('CREATE TABLE IF NOT EXISTS `malashko_core` (  
          `code` varchar(255) NOT NULL,
          `sort` int(11) NOT NULL DEFAULT 500,
          `name` varchar(255) NOT NULL,
          PRIMARY KEY (`code`)
        )');

		return true;
	}

	public function InstallEvents(){

        $events = EventManager::getInstance();
        $events->registerEventHandler(
			"main",
			"OnBuildGlobalMenu",
			$this->MODULE_ID,
			"Malashko\Core\Admin",
			"GlobalMenu"
		);

		return false;
	}

	public function DoUninstall(){

		global $APPLICATION;

		$this->UnInstallFiles();
		$this->UnInstallDB();
		$this->UnInstallEvents();

		ModuleManager::unRegisterModule($this->MODULE_ID);

		$APPLICATION->IncludeAdminFile(
			Loc::getMessage("UNINSTALL_TITLE")." \"".Loc::getMessage("NAME")."\"",
			__DIR__."/unstep.php"
		);

		return false;
	}

	public function UnInstallFiles(){

//		Directory::deleteDirectory(
//			Application::getDocumentRoot()."/bitrix/js/".$this->MODULE_ID
//		);
//
//		Directory::deleteDirectory(
//			Application::getDocumentRoot()."/bitrix/css/".$this->MODULE_ID
//		);

		return false;
	}

	public function UnInstallDB(){

        global $DB;

        $DB->Query('DROP TABLE IF EXISTS `malashko_core`');

		return false;
	}

	public function UnInstallEvents(){

		EventManager::getInstance()->unRegisterEventHandler(
			"main",
			"OnBeforeEndBufferContent",
			$this->MODULE_ID,
			"Malashko\Core\Main",
			"GlobalMenu"
		);

		return false;
	}
}