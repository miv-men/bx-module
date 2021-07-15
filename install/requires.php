<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

?>
<div class="adm-info-message-wrap adm-info-message-red">
    <div class="adm-info-message">
        <div class="adm-info-message-title">
            <?= Loc::getMessage('REQUIRES_ERROR') ?>.<br />
        </div>
        <div class="adm-info-message-icon"></div>
    </div>
</div>