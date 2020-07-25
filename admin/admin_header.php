<?php
/**
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use Xmf\Module\Admin;
use XoopsModules\Xfguestbook\Helper;

require dirname(__DIR__) . '/preloads/autoloader.php';

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once $GLOBALS['xoops']->path('www/class/xoopsformloader.php');
require_once dirname(__DIR__) . '/include/common.php';

$moduleDirName = basename(dirname(__DIR__));
/** @var \XoopsModules\Xfguestbook\Helper $helper */
$helper = Helper::getInstance();
/** @var \Xmf\Module\Admin $adminObject */
$adminObject = Admin::getInstance();

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('common');
$helper->loadLanguage('main');
xoops_loadLanguage('user');
