<?php

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\Xfguestbook\Helper;

require dirname(dirname(__DIR__)) . '/mainfile.php';
require XOOPS_ROOT_PATH . '/header.php';

require __DIR__ . '/preloads/autoloader.php';

$moduleDirName = basename(__DIR__);

/** @var \XoopsModules\Xfguestbook\Helper $helper */
$helper = Helper::getInstance();

$modulePath = XOOPS_ROOT_PATH . '/modules/' . $moduleDirName;
require __DIR__ . '/config/config.php';

$myts = \MyTextSanitizer::getInstance();

//Handlers
//$XXXHandler = xoops_getModuleHandler('XXX', $moduleDirName);

// Load language files
$helper->loadLanguage('main');

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof \XoopsTpl)) {
    require $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new XoopsTpl();
}

