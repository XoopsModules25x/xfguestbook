<?php
/**
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_functions.php';
require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
include_once dirname(dirname(dirname(__DIR__))) . '/kernel/module.php';

if ($xoopsUser) {
    $xoopsModule = XoopsModule::getByDirname('xfguestbook');
    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 3, _NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . '/', 3, _NOPERM);
    exit();
}

include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');

$moduleInfo = $module_handler->get($xoopsModule->getVar('mid'));
$pathIcon16 = XOOPS_URL . '/' . $moduleInfo->getInfo('icons16');
$pathIcon32 = XOOPS_URL . '/' . $moduleInfo->getInfo('icons32');

$myts = MyTextSanitizer::getInstance();

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new XoopsTpl();
}

//xoops_cp_header();

//Load languages
$thisModDir = $xoopsModule->getVar('dirname', 'n');
xoops_loadLanguage('admin', $thisModDir);
xoops_loadLanguage('modinfo', $thisModDir);
xoops_loadLanguage('main', $thisModDir);

xoops_loadLanguage('user');
if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
    include_once $GLOBALS['xoops']->path('/class/template.php');
    $GLOBALS['xoopsTpl'] = new XoopsTpl();
}
