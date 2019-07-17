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
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\Xfguestbook;

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link \XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_xfguestbook(\XoopsModule $module)
{
    include __DIR__ . '/common.php';
    /** @var \XoopsModules\Xfguestbook\Utility $utility */
    $utility = new \XoopsModules\Xfguestbook\Utility();
    //check for minimum XOOPS version
    $xoopsSuccess = $utility::checkVerXoops($module);

    // check for minimum PHP version
    $phpSuccess = $utility::checkVerPhp($module);

    if (false !== $xoopsSuccess && false !== $phpSuccess) {
        $moduleTables = &$module->getInfo('tables');
        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }

    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during installation of the module
 * @param \XoopsModule $module {@link \XoopsModule}
 *
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_xfguestbook(\XoopsModule $module)
{
    require_once dirname(__DIR__) . '/preloads/autoloader.php';

    $moduleDirName = basename(dirname(__DIR__));
    /** @var \XoopsModules\Xfguestbook\Helper $helper */
    $helper = \XoopsModules\Xfguestbook\Helper::getInstance();

    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');

    /** @var Xfguestbook\Common\Configurator $configurator */
    $configurator = new Xfguestbook\Common\Configurator();
    /** @var \XoopsModules\Xfguestbook\Utility $utility */
    $utility = new \XoopsModules\Xfguestbook\Utility();

    // default Permission Settings ----------------------
    global $xoopsModule;
    $moduleId = $module->getVar('mid');
    //    $moduleId2    = $helper->getModule()->mid();
    /** @var \XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler = xoops_getHandler('groupperm');
    // access rights ------------------------------------------
    $grouppermHandler->addRight($moduleDirName . '_approve', 1, XOOPS_GROUP_ADMIN, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_submit', 1, XOOPS_GROUP_ADMIN, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_ADMIN, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_USERS, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_ANONYMOUS, $moduleId);

    //  ---  CREATE FOLDERS ---------------
    if (count($configurator->uploadFolders) > 0) {
        //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (array_keys($configurator->uploadFolders) as $i) {
            $utility::createFolder($configurator->uploadFolders[$i]);
        }
    }

    //  ---  COPY blank.png FILES ---------------
    if (count($configurator->copyBlankFiles) > 0) {
        $file = dirname(__DIR__) . '/assets/images/blank.png';
        foreach (array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.png';
            $utility::copyFile($file, $dest);
        }
    }

    //  ---  COPY test msg image ---------------
    if ($configurator->copyTestFolders && is_array($configurator->copyTestFolders)) {
        foreach (array_keys($configurator->copyTestFolders) as $i) {
            $src  = $configurator->copyTestFolders[$i][0];
            $dest = $configurator->copyTestFolders[$i][1];
            $utility::rcopy($src, $dest);
        }
    }

    return true;
}
