<?php

namespace Maximaster\Modules\News\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

class NewsListHelper extends AdminListHelper
{
	protected static $model = '\Maximaster\Modules\News\NewsTable';
}