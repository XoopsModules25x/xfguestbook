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
use XoopsModules\Xfguestbook\Form\FormSelectCountry;

require_once __DIR__ . '/admin_header.php';

/** @var Xfguestbook\Helper $helper */
$helper = Xfguestbook\Helper::getInstance();

/**
 * @param int $cat
 * @return mixed
 */
function getOptions4Admin($cat = 2)
{
    global $xoopsDB;
    $arr_conf = [];
    $sql      = 'SELECT conf_id, conf_name, conf_value, conf_title, conf_formtype, conf_desc  FROM ' . $xoopsDB->prefix('xfguestbook_config') . ' WHERE conf_cat=' . $cat . ' ORDER BY conf_order ASC';
    $result   = $xoopsDB->query($sql);
    $i        = 0;
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $arr_conf[$i]['conf_id']       = $myrow['conf_id'];
        $arr_conf[$i]['conf_name']     = $myrow['conf_name'];
        $arr_conf[$i]['conf_value']    = $myrow['conf_value'];
        $arr_conf[$i]['conf_title']    = $myrow['conf_title'];
        $arr_conf[$i]['conf_desc']     = $myrow['conf_desc'];
        $arr_conf[$i]['conf_formtype'] = $myrow['conf_formtype'];
        $i++;
    }

    return $arr_conf;
}

if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k} = $v;
    }
}

$op = Request::getCmd('op', 'show');

switch ($op) {
    case 'save':
        $option = getOptions4Admin();
        $nb_opt = count($option);

        foreach ($option as $i => $iValue) {
            $sql    = 'UPDATE ' . $xoopsDB->prefix('xfguestbook_config') . " SET conf_value='" . ${$option[$i]['conf_name']} . '\' WHERE conf_id=' . $option[$i]['conf_id'];
            $result = $xoopsDB->query($sql);
        }
        redirect_header('config.php', 1, AM_XFGUESTBOOK_DBUPDATED);
        break;
    case 'show':
    default:
        xoops_cp_header();
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(1);
        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

        $option = getOptions4Admin();
        $nb_opt = count($option);

        $sform = new \XoopsThemeForm(AM_XFGUESTBOOK_FORMOPT, 'op', xoops_getenv('SCRIPT_NAME'), 'post', true);

        for ($i = 0; $i < $nb_opt; $i++) {
            $title = (!defined($option[$i]['conf_desc'])
                      || '' === constant($option[$i]['conf_desc'])) ? constant($option[$i]['conf_title']) : constant($option[$i]['conf_title']) . '<br><br><span style="font-weight:normal;">' . constant($option[$i]['conf_desc']) . '</span>';
            switch ($option[$i]['conf_formtype']) {
                case 'yesno':
                    if ('' === $helper->getConfig('flagdir') && 'opt_country' === $option[$i]['conf_name']) {
                        $title .= '<br><span style="font-weight:normal;">' . AM_XFGUESTBOOK_WARNING_MSG2 . '</span>';
                    }
                    $ele = new \XoopsFormRadioYN($title, $option[$i]['conf_name'], $option[$i]['conf_value'], _YES, _NO);
                    break;
                case 'selectcountry':
                    $ele = new FormSelectCountry($title, $option[$i]['conf_name'], $option[$i]['conf_value'], 1, true);
                    break;
                case 'selectmail':
                    $ele     = new \XoopsFormSelect($title, $option[$i]['conf_name'], $option[$i]['conf_value']);
                    $options = [0 => AM_XFGUESTBOOK_SEL_R0, 1 => AM_XFGUESTBOOK_SEL_R1, 2 => AM_XFGUESTBOOK_SEL_R2];
                    $ele->addOptionArray($options);
                    break;
                case 'selectaction':
                    $ele     = new \XoopsFormSelect($title, $option[$i]['conf_name'], $option[$i]['conf_value']);
                    $options = [0 => AM_XFGUESTBOOK_SEL_A0, 1 => AM_XFGUESTBOOK_SEL_A1, 2 => AM_XFGUESTBOOK_SEL_A2];
                    $ele->addOptionArray($options);
                    break;
                case 'selectwebsite':
                    $ele     = new \XoopsFormSelect($title, $option[$i]['conf_name'], $option[$i]['conf_value']);
                    $options = [0 => AM_XFGUESTBOOK_SEL_W0, 1 => AM_XFGUESTBOOK_SEL_W1, 2 => AM_XFGUESTBOOK_SEL_W2];
                    $ele->addOptionArray($options);
                    break;
            }
            $old_opt = new \XoopsFormHidden('old_' . $option[$i]['conf_name'], $option[$i]['conf_value']);
            $hidden  = new \XoopsFormHidden('conf_ids[]', $option[$i]['conf_id']);
            $sform->addElement($ele);
            $sform->addElement($hidden);
            unset($ele, $hidden);
        }

        $buttonTray = new \XoopsFormElementTray('', '');
        $hidden     = new \XoopsFormHidden('op', 'save');
        $buttonTray->addElement($hidden);
        $buttonTray->addElement(new \XoopsFormButton('', 'post', _GO, 'submit'));
        $sform->addElement($buttonTray);
        $sform->display();
        break;
}
require_once __DIR__ . '/admin_footer.php';
