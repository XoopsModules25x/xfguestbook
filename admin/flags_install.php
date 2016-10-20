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

include __DIR__ . '/../../../include/cp_header.php';
include_once __DIR__ . '/../include/cp_functions.php';
include_once __DIR__ . '/../include/functions.php';
include_once __DIR__ . '/admin_header.php';

if (!isset($_POST['flagdir'])) {
    xoops_cp_header();
    $index_admin = new ModuleAdmin();
    echo $index_admin->addNavigation(basename(__FILE__));
    include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $form    = new XoopsThemeForm(_AM_XFGB_INSTALL_FLAGS, 'selectflag', $_SERVER['PHP_SELF']);
    $sel_box = new XoopsFormSelect(_AM_XFGB_SELECT_PACK, 'flagdir', $xoopsModuleConfig['flagdir']);
    $sel_box->addOption('', _NONE);
    $sel_box->addOptionArray(XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/'));
    $form->addElement($sel_box);

    $button_tray = new XoopsFormElementTray('', '');
    $button_tray->addElement(new XoopsFormButton('', 'post', _SUBMIT, 'submit'));
    $button_cancel = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
    $button_cancel->setExtra("' onclick='javascript: history.go(-1)'");
    $button_tray->addElement($button_cancel);
    $form->addElement($button_tray);

    $form->display();
    if (count(xfgb_getCountry()) > 0) {
        $msg = sprintf(_AM_XFGB_WARNING_MSG1, $xoopsDB->prefix('xfguestbook_country'));
        echo _AM_XFGB_WARNING . '<br>' . $msg . '&nbsp;';
    }
    //xoops_cp_footer();
    echo '<br><br>';
    include __DIR__ . '/admin_footer.php';
} else {
    xoops_cp_header();
    $index_admin = new ModuleAdmin();
    echo $index_admin->addNavigation(basename(__FILE__));

    $flagdir = $_POST['flagdir'];
    $msg     = '';

    $sql    = 'TRUNCATE TABLE ' . $xoopsDB->prefix('xfguestbook_country');
    $result = $xoopsDB->queryF($sql);
    echo 'Table <b>' . $xoopsDB->prefix('xfguestbook_country') . '</b> deleted.<br>';
    if ($flagdir !== '') {
        $sqlfile = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $flagdir . '/flags_data.sql';
        $msg .= executeSQL($sqlfile);
    }
    if ($msg === '') {
        $configHandler = xoops_getHandler('config');
        $criteria      = new CriteriaCompo(new Criteria('conf_modid', $xoopsModule->mid()));
        $criteria->add(new Criteria('conf_name', 'flagdir'));
        $config = $configHandler->getConfigs($criteria);
        $value  = array($config[0]->getConfValueForOutput());
        $config[0]->setVar('conf_value', $flagdir);
        //  $config[0]->setConfValueForInput($value[0]);
        if (!$configHandler->insertConfig($config[0])) {
            $msg .= 'Could not insert flagdir config <br>';
        }
        echo $msg;
        echo '<br>&nbsp;<a href = "' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/admin/config.php">' . _AM_XFGB_GOFORMOPT . '</a>';
    } else {
        echo sprintf(_AM_XFGB_ERROR_FLAGS, $flagdir, $xoopsDB->prefix('xfguestbook_country'));
        echo '<br><br>&nbsp;<a href = "' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/admin/upgrade.php">' . _AM_XFGB_GO_UPGRADE . '</a>';
    }
    //xoops_cp_footer();
    echo '<br><br>';
    include __DIR__ . '/admin_footer.php';
}
