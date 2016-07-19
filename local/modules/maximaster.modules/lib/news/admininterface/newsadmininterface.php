<?php

namespace Maximaster\Modules\News\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\DateTimeWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;
use DigitalWand\AdminHelper\Widget\VisualEditorWidget;

Loc::loadMessages(__FILE__);

class NewsAdminInterface extends AdminInterface
{
    public function fields()
    {
        return array(
            'MAIN' => array(
                'NAME' => Loc::getMessage('MAXIMASTER_NEWS'),
                'FIELDS' => array(
                    'ID' => array(
                        'WIDGET' => new NumberWidget(),
                        'READONLY' => true,
                        'FILTER' => true,
                        'HIDE_WHEN_CREATE' => true
                    ),
                    'NAME' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => '80',
                        'FILTER' => true,
                        'REQUIRED' => true
                    ),
                    'TEXT' => array(
                        'WIDGET' => new VisualEditorWidget(),
                        'HEADER' => false,
                        'REQUIRED' => true
                    ),
                    'DATE_CREATE' => array(
                        'WIDGET' => new DateTimeWidget(),
                        'READONLY' => true,
                        'HIDE_WHEN_CREATE' => true,
                        'FILTER' => true
                    )
                )
            )
        );
    }

    public function helpers()
    {
        return array(
            '\Maximaster\Modules\News\AdminInterface\NewsListHelper',
            '\Maximaster\Modules\News\AdminInterface\NewsEditHelper'
        );
    }
}