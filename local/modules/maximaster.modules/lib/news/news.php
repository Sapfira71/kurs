<?php

namespace Maximaster\Modules\News;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Entity;

Loc::loadMessages(__FILE__);

class NewsTable extends DataManager
{
    public static function getTableName()
    {
        return 'maximaster_news';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('MAXIMASTER_NEWS_ID'),
            )),
            new Entity\DatetimeField('DATE_CREATE', array(
                'required' => true,
                'default_value' => new DateTime(),
                'title' => Loc::getMessage('MAXIMASTER_NEWS_DATE_CREATE'),
            )),
            new Entity\StringField('NAME', array(
                'required' => true,
                'title' => Loc::getMessage('MAXIMASTER_NEWS_NAME')
            )),
            new Entity\TextField('TEXT', array(
                'required' => true,
                'title' => Loc::getMessage('MAXIMASTER_NEWS_TEXT')
            )),
            new Entity\StringField('TEXT_TEXT_TYPE', array())
        );
    }

    public static function getFilePath()
    {
        return __FILE__;
    }
}
