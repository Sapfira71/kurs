<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Maximaster\Modules\News\AdminInterface\NewsEditHelper;
use Maximaster\Modules\News\AdminInterface\NewsListHelper;

if (!Loader::includeModule('digitalwand.admin_helper') || !Loader::includeModule('maximaster.modules')) return;

Loc::loadMessages(__FILE__);

return array(
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 300,
        'icon' => 'fileman_sticker_icon',
        'page_icon' => 'fileman_sticker_icon',
        'text' => Loc::getMessage('MAXIMASTER_NEWS'),
        'url' => NewsListHelper::getUrl(),
        'more_url' => array(
            NewsEditHelper::getUrl(),
        )
    )
);