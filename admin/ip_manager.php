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
require_once __DIR__ . '/../include/cp_functions.php';
require_once __DIR__ . '/admin_header.php';
require_once __DIR__ . '/../class/utility.php';

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} elseif (isset($_POST['op'])) {
    $op = $_POST['op'];
} else {
    $op = 'badIpShow';
}

if (isset($_GET['ip_id'])) {
    $ip_id = (int)$_GET['ip_id'];
} elseif (isset($_POST['ip_id'])) {
    $ip_id = (int)$_POST['ip_id'];
} else {
    $ip_id = 0;
}

$ip_value = isset($_POST['ip_value']) ? $_POST['ip_value'] : '';

/**
 * @param $ip_id
 */
function badIpDel($ip_id)
{
    global $xoopsDB;
    $ip_count = (!empty($_POST['ip_id']) && is_array($_POST['ip_id'])) ? count($_POST['ip_id']) : 0;
    if ($ip_count > 0) {
        $messagesent = AM_XFGUESTBOOK_BADIP_DELETED;
        for ($i = 0; $i < $ip_count; $i++) {
            $sql = sprintf('DELETE FROM %s WHERE ip_id = %u', $xoopsDB->prefix('xfguestbook_badips'), $_POST['ip_id'][$i]);
            if (!$result = $xoopsDB->query($sql)) {
                $messagesent = AM_XFGUESTBOOK_ERRORDEL;
            }
        }
    } else {
        $messagesent = AM_XFGUESTBOOK_NOBADIP;
    }
    redirect_header($_SERVER['PHP_SELF'], 2, $messagesent);
}

/**
 * @param null $ip_id
 */
function badIpForm($ip_id = null)
{
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    if ($ip_id) {
        $sform    = new XoopsThemeForm(AM_XFGUESTBOOK_MOD_BADIP, 'op', xoops_getenv('PHP_SELF'), 'post', true);
        $badips   = XfguestbookUtility::get_badips(true);
        $ip_value = $badips[$ip_id]['ip_value'];
    } else {
        $sform    = new XoopsThemeForm(AM_XFGUESTBOOK_ADD_BADIP, 'op', xoops_getenv('PHP_SELF'), 'post', true);
        $ip_value = '';
    }

    $sform->addElement(new XoopsFormText(AM_XFGUESTBOOK_VALUE, 'ip_value', 50, 50, $ip_value), true);

    $button_tray = new XoopsFormElementTray('', '');
    $button_tray->addElement(new XoopsFormButton('', 'save', _SUBMIT, 'submit'));
    if ($ip_id) {
        $button_tray->addElement(new XoopsFormHidden('ip_id', $ip_id));
    }
    $button_tray->addElement(new XoopsFormHidden('op', 'badIpSave'));
    $sform->addElement($button_tray);
    $sform->display();
}

/**
 * @param $ip_id
 * @param $ip_value
 */
function badIpSave($ip_id, $ip_value)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();
    //$ip_value=$myts->makeTboxData4Save($ip_value);
    if (!empty($ip_id)) {
        $sql = 'UPDATE ' . $xoopsDB->prefix('xfguestbook_badips') . " SET ip_id='$ip_id', ip_value='$ip_value'";
        $sql .= " WHERE ip_id = $ip_id";
        $xoopsDB->query($sql);
        $messagesent = AM_XFGUESTBOOK_BADIP_UPDATED;
    } else {
        $sql = sprintf("SELECT COUNT(*) FROM  %s WHERE ip_value = '%s'", $xoopsDB->prefix('xfguestbook_badips'), $ip_value);
        list($count) = $xoopsDB->fetchRow($xoopsDB->query($sql));
        if ($count > 0) {
            $messagesent = '<span style="color: #FF0000; ">' . AM_XFGUESTBOOK_BADIP_EXIST . '</span>';
        } else {
            $country_id = $xoopsDB->genId('ip_id_seq');
            $sql        = sprintf("INSERT INTO %s (ip_id, ip_value) VALUES (%s, '%s')", $xoopsDB->prefix('xfguestbook_badips'), $ip_id, $ip_value);
            $xoopsDB->query($sql);
            $messagesent = AM_XFGUESTBOOK_BADIP_ADDED;
        }
    }
    redirect_header('ip_manager.php', 2, $messagesent);
}

function badIpShow()
{
    global $action, $start, $xoopsModule, $xoopsModuleConfig;
    $myts      = MyTextSanitizer::getInstance();
    $limit     = 15;
    $badips    = XfguestbookUtility::get_badips(true);
    $nb_badips = count($badips);

    echo "
    <table width='100%' cellspacing='1' cellpadding='2' border='0' style='border-left: 1px solid silver; border-top: 1px solid silver; border-right: 1px solid silver;'>
        <tr>
            <td><span style='font-weight: bold; font-size: 12px; font-variant: small-caps;'>" . AM_XFGUESTBOOK_DISP_BADIPS . ' : ' . $nb_badips . "</span></td>
            <td align='right'>
            </td>
        </tr>
    </table>";

    echo "<table border='1' width='100%' cellpadding ='2' cellspacing='1'>";
    echo "<tr class='bg3'>";
    echo '<td></td>';
    echo "<td align='center'><b>" . AM_XFGUESTBOOK_IPS . '</td>';
    echo "<td align='center'><b>" . AM_XFGUESTBOOK_ACTION . '</td>';
    echo '</tr>';

    if ('0' != count($badips)) {
        echo "<form name='badiplist' id='list' action='" . $_SERVER['PHP_SELF'] . '\' method=\'POST\' style=\'margin: 0;\'>';

        for ($i = 0; $i < $nb_badips; $i++) {
            echo '<tr>';
            echo "<td align='center' class='even'><input type='checkbox' name='ip_id[]' id='ip_id[]' value='" . $badips[$i]['ip_id'] . '\'></td>';
            echo "<td class = 'odd'>" . $badips[$i]['ip_value'] . '</td>';
            echo "<td align='center' class='even'><a href='ip_manager.php?op=badIpEdit&amp;ip_id=" . $badips[$i]['ip_id'] . '\'>' . _EDIT . '</a></td>';
            echo '</tr>';
            //          unset($badips);
        }
        echo "<tr class='foot'><td><select name='op'>";
        echo "<option value='badIpDel'>" . _DELETE . '</option>';
        echo '</select>&nbsp;</td>';
        echo "<td colspan='3'>" . $GLOBALS['xoopsSecurity']->getTokenHTML() . "<input type='submit' value='" . _GO . '\'>';
        echo '</td></tr>';
        echo '</form>';
    } else {
        echo "<tr ><td align='center' colspan ='3' class = 'head'><b>" . AM_XFGUESTBOOK_NOBADIP . '</b></td></tr>';
    }
    echo '</table><br>';
    echo '<br>';
}

switch ($op) {
    case 'badIpForm':
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(3);
        badIpForm($ip_id);
        include __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
    case 'badIpDel':
        badIpDel($ip_id);
        break;
    case 'badIpEdit':
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(3);
        badIpForm($ip_id);
        include __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
    case 'badIpSave':
        badIpSave($ip_id, $ip_value);
        break;
    case 'badIpAdd':
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(3);
        badIpForm();
        include __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
    case 'badIpShow':
    default:
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(3);
        badIpShow();
        badIpForm();
        include __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
}
