<?php

use Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Maximaster\Modules\News\NewsTable;

IncludeModuleLangFile(__FILE__);

class maximaster_modules extends CModule
{
    var $MODULE_ID = 'maximaster.modules';

    function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__ . '/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('MAXIMASTER_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MAXIMASTER_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('MAXIMASTER_PARTNER_NAME');
        $this->PARTNER_URI = '';
    }

    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        Loader::includeModule($this->MODULE_ID);

        $this->GetConnection()->query("CREATE TABLE " . NewsTable::getTableName() . " (
            ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            DATE_CREATE DATETIME NOT NULL,
            NAME VARCHAR(255) NOT NULL,
            TEXT VARCHAR(255) NOT NULL
        );");
    }

    public function DoUninstall()
    {
        Loader::includeModule($this->MODULE_ID);

        $this->GetConnection()->dropTable(NewsTable::getTableName());

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    protected function GetConnection()
    {
        return Application::getInstance()->getConnection(NewsTable::getConnectionName());
    }
}