<?
/**
* Module: malashko
* Site: http://malashko.ru/
* File: options.php
* Version: 1.0.0
**/

use Bitrix\Main\Localization\Loc;
use	Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);

$aTabs = array(
	array(
		"DIV" 	  => "edit",
		"TAB" 	  => Loc::getMessage("MALASHKO_OPTIONS_TAB_NAME"),
		"TITLE"   => Loc::getMessage("MALASHKO_OPTIONS_TAB_NAME"),
		"OPTIONS" => array(
			Loc::getMessage("MALASHKO_OPTIONS_TAB_COMMON"),
			array(
				"switch_on",
				Loc::getMessage("MALASHKO_OPTIONS_TAB_SWITCH_ON"),
				"Y",
				array("checkbox")
			),
			Loc::getMessage("MALASHKO_OPTIONS_TAB_HEADER"),
            array(
                "title_row",
                Loc::getMessage("MALASHKO_OPTIONS_TITLE"),
                "",
                array("text", 50)
            ),
			Loc::getMessage("MALASHKO_OPTIONS_WEBP"),
			array(
				"create_webp",
				Loc::getMessage("MALASHKO_OPTIONS_TAB_WIDTH"),
				"fluid",
                array('selectbox', array(
                    'A' => Loc::getMessage('MALASHKO_OPTIONS_A'),
                    'Y' => Loc::getMessage('MALASHKO_OPTIONS_Y'),
                    'N' => Loc::getMessage('MALASHKO_OPTIONS_N'),
                )),
			),
		)
	),
    array(
        "DIV" 	  => "edit2",
        "TAB" 	  => Loc::getMessage("MALASHKO_OPTIONS_TAB_INDEX_DESIGNER"),
        "TITLE"   => Loc::getMessage("MALASHKO_OPTIONS_TITLE_INDEX_DESIGNER"),
        "CONTENT" => '
            <div class="index-constructor">
                <p>Конструктор главной</p>
            </div>
        '
    )
);


if($request->isPost() && check_bitrix_sessid()){

    foreach($aTabs as $aTab){

        foreach($aTab["OPTIONS"] as $arOption){

            if(!is_array($arOption)){

                continue;
            }

            if($arOption["note"]){

                continue;
            }

            if($request["apply"]){

                $optionValue = $request->getPost($arOption[0]);

                if($arOption[0] == "switch_on"
                    || $arOption[0] == "top_menu_bool"){

                    if($optionValue == ""){

                        $optionValue = "N";
                    }
                }

                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
            }elseif($request["default"]){

                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }

    LocalRedirect($APPLICATION->GetCurPage()."?mid=".$module_id."&lang=".LANG);
}

$tabControl = new CAdminTabControl(
    "tabControl",
    $aTabs
);

$tabControl->Begin();
?>

<form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>" method="post">

    <?

    //    dd($aTabs);

    foreach($aTabs as $aTab){

        if($aTab["OPTIONS"]){

            $tabControl->BeginNextTab();

            __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
        }

    }

    $tabControl->Buttons();
    ?>


    <input type="submit" name="apply" value="<? echo(Loc::GetMessage("MALASHKO_OPTIONS_INPUT_APPLY")); ?>" class="adm-btn-save" />
    <input type="submit" name="default" value="<? echo(Loc::GetMessage("MALASHKO_OPTIONS_INPUT_DEFAULT")); ?>" />

    <?
    echo(bitrix_sessid_post());
    ?>

</form>
<?
$tabControl->End();
?>

