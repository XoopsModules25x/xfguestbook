<?php
// $Id: admin/config.php,v 2.20 2005/08/09 C. Felix alias the Cat
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

include dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
include_once dirname(__DIR__) . '/include/cp_functions.php';
include_once __DIR__ . '/admin_header.php';
/**
 * @param int $cat
 * @return mixed
 */
function getOptions4Admin($cat = 2)
{
    global $xoopsDB;
    $sql    = 'SELECT conf_id, conf_name, conf_value, conf_title, conf_formtype, conf_desc  FROM ' . $xoopsDB->prefix('xfguestbook_config') . ' WHERE conf_cat=' . $cat . ' ORDER BY conf_order ASC';
    $result = $xoopsDB->query($sql);
    $i      = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
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

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} elseif (isset($_POST['op'])) {
    $op = $_POST['op'];
} else {
    $op = 'show';
}

switch ($op) {

    case 'save':
        $option = getOptions4Admin();
        $nb_opt = count($option);

        for ($i = 0; $i < $nb_opt; $i++) {
            $sql    = 'UPDATE ' . $xoopsDB->prefix('xfguestbook_config') . " SET conf_value='" . ${$option[$i]['conf_name']} . "' WHERE conf_id=" . $option[$i]['conf_id'];
            $result = $xoopsDB->query($sql);
        }
        redirect_header('config.php', 1, _AM_XFGB_DBUPDATED);
        break;

    case 'show':
    default:
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(1);
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/xfgbformselectcountry.php';

        $option = getOptions4Admin();
        $nb_opt = count($option);

        $sform = new XoopsThemeForm(_AM_XFGB_FORMOPT, 'op', xoops_getenv('PHP_SELF'));

        for ($i = 0; $i < $nb_opt; $i++) {
            $title = (!defined($option[$i]['conf_desc']) || constant($option[$i]['conf_desc']) === '') ? constant($option[$i]['conf_title']) : constant($option[$i]['conf_title'])
                                                                                                                                               . '<br><br><span style="font-weight:normal;">'
                                                                                                                                               . constant($option[$i]['conf_desc']) . '</span>';
            switch ($option[$i]['conf_formtype']) {
                case 'yesno':
                    if ($xoopsModuleConfig['flagdir'] === '' && $option[$i]['conf_name'] === 'opt_country') {
                        $title .= '<br><span style="font-weight:normal;">' . _AM_XFGB_WARNING_MSG2 . '</span>';
                    }
                    $ele = new XoopsFormRadioYN($title, $option[$i]['conf_name'], $option[$i]['conf_value'], _YES, _NO);
                    break;
                case 'selectcountry':
                    $ele = new XfgbFormSelectCountry($title, $option[$i]['conf_name'], $option[$i]['conf_value'], 1, true);
                    break;
                case 'selectmail':
                    $ele     = new XoopsFormSelect($title, $option[$i]['conf_name'], $option[$i]['conf_value']);
                    $options = array(0 => _AM_XFGB_SEL_R0, 1 => _AM_XFGB_SEL_R1, 2 => _AM_XFGB_SEL_R2);
                    $ele->addOptionArray($options);
                    break;
                case 'selectaction':
                    $ele     = new XoopsFormSelect($title, $option[$i]['conf_name'], $option[$i]['conf_value']);
                    $options = array(0 => _AM_XFGB_SEL_A0, 1 => _AM_XFGB_SEL_A1, 2 => _AM_XFGB_SEL_A2);
                    $ele->addOptionArray($options);
                    break;
                case 'selectwebsite':
                    $ele     = new XoopsFormSelect($title, $option[$i]['conf_name'], $option[$i]['conf_value']);
                    $options = array(0 => _AM_XFGB_SEL_W0, 1 => _AM_XFGB_SEL_W1, 2 => _AM_XFGB_SEL_W2);
                    $ele->addOptionArray($options);
                    break;
            }
            $old_opt = new XoopsFormHidden('old_' . $option[$i]['conf_name'], $option[$i]['conf_value']);
            $hidden  = new XoopsFormHidden('conf_ids[]', $option[$i]['conf_id']);
            $sform->addElement($ele);
            $sform->addElement($hidden);
            unset($ele);
            unset($hidden);
        }

        $button_tray = new XoopsFormElementTray('', '');
        $hidden      = new XoopsFormHidden('op', 'save');
        $button_tray->addElement($hidden);
        $button_tray->addElement(new XoopsFormButton('', 'post', _GO, 'submit'));
        $sform->addElement($button_tray);
        $sform->display();
        break;

}
include __DIR__ . '/admin_footer.php';
