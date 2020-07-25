<?php
//
//  ------------------------------------------------------------------------ //
//             XF Guestbook                                                  //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Xfguestbook;
use XoopsModules\Xfguestbook\Helper;

require_once __DIR__ . '/admin_header.php';
require_once dirname(__DIR__) . '/include/cp_functions.php';

/** @var Helper $helper */
$helper = Helper::getInstance();

if (!isset($_POST['flagdir'])) {
    xoops_cp_header();
    $adminObject = Admin::getInstance();
    $adminObject->displayNavigation(basename(__FILE__));
    require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $form    = new \XoopsThemeForm(AM_XFGUESTBOOK_INSTALL_FLAGS, 'selectflag', $_SERVER['SCRIPT_NAME']);
    $sel_box = new \XoopsFormSelect(AM_XFGUESTBOOK_SELECT_PACK, 'flagdir', $helper->getConfig('flagdir'));
    $sel_box->addOption('', _NONE);
    $sel_box->addOptionArray(\XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/'));
    $form->addElement($sel_box);

    $buttonTray = new \XoopsFormElementTray('', '');
    $buttonTray->addElement(new \XoopsFormButton('', 'post', _SUBMIT, 'submit'));
    $buttonCancel = new \XoopsFormButton('', 'cancel', _CANCEL, 'button');
    $buttonCancel->setExtra('\' onclick=\'javascript: history.go(-1)\'');
    $buttonTray->addElement($buttonCancel);
    $form->addElement($buttonTray);

    $form->display();
    if (count(Xfguestbook\Utility::getCountry()) > 0) {
        $msg = sprintf(AM_XFGUESTBOOK_WARNING_MSG1, $xoopsDB->prefix('xfguestbook_country'));
        echo AM_XFGUESTBOOK_WARNING . '<br>' . $msg . '&nbsp;';
    }
    //xoops_cp_footer();
    echo '<br><br>';
    require_once __DIR__ . '/admin_footer.php';
} else {
    xoops_cp_header();
    $adminObject = Admin::getInstance();
    $adminObject->displayNavigation(basename(__FILE__));

    $flagdir = Request::getString('flagdir', '', 'POST');
    $msg     = '';

    $sql    = 'TRUNCATE TABLE ' . $xoopsDB->prefix('xfguestbook_country');
    $result = $xoopsDB->queryF($sql);
    echo 'Table <b>' . $xoopsDB->prefix('xfguestbook_country') . '</b> deleted.<br>';
    if ('' !== $flagdir) {
        $sqlfile = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $flagdir . '/flags_data.sql';
        $msg     .= executeSQL($sqlfile);
    }
    if ('' === $msg) {
        /** @var \XoopsConfigHandler $configHandler */
        $configHandler = xoops_getHandler('config');
        $criteria      = new \CriteriaCompo(new \Criteria('conf_modid', $xoopsModule->mid()));
        $criteria->add(new \Criteria('conf_name', 'flagdir'));
        $config = $configHandler->getConfigs($criteria);
        /** @var \XoopsConfigItem $configItem */
        $configItem = $config[0];
        $value      = [$configItem->getConfValueForOutput()];
        $configItem->setVar('conf_value', $flagdir);
        //  $configItem->setConfValueForInput($value[0]);
        if (!$configHandler->insertConfig($configItem)) {
            $msg .= 'Could not insert flagdir config <br>';
        }
        echo $msg;
        echo '<br>&nbsp;<a href = "' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/admin/config.php">' . AM_XFGUESTBOOK_GOFORMOPT . '</a>';
    } else {
        echo sprintf(AM_XFGUESTBOOK_ERROR_FLAGS, $flagdir, $xoopsDB->prefix('xfguestbook_country'));
        echo '<br><br>&nbsp;<a href = "' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/admin/upgrade.php">' . AM_XFGUESTBOOK_GO_UPGRADE . '</a>';
    }
    //xoops_cp_footer();
    echo '<br><br>';
    require_once __DIR__ . '/admin_footer.php';
}
