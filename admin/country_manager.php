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

//require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
//require_once  dirname(__DIR__) . '/include/cp_functions.php';
require_once __DIR__ . '/admin_header.php';

/** @var Helper $helper */
$helper = Helper::getInstance();

// Flag
$maxsize   = 2000;
$maxheight = 50;
$maxwidth  = 80;
$format    = 'gif';

$op = 'countryShow';
if (Request::hasVar('op', 'GET')) {
    $op = $_GET['op'];
} elseif (Request::hasVar('op', 'POST')) {
    $op = $_POST['op'];
}

if (Request::hasVar('country_id', 'GET')) {
    $country_id = Request::getInt('country_id', 0, 'GET');
} else {
    $country_id = Request::getInt('country_id', 0, 'POST');
}

$country_code = '';
if (Request::hasVar('country_code', 'GET')) {
    $country_code = $_GET['country_code'];
} elseif (Request::hasVar('country_code', 'POST')) {
    $country_code = $_POST['country_code'];
}

$start        = Request::getInt('start', 0, 'GET');
$country_name = Request::getString('country_name', '', 'POST');

/**
 * @param $country_code
 */
function flagUpload($country_code)
{
    global $xoopsModule, $maxsize, $maxwidth, $maxheight, $format;
    /** @var Helper $helper */
    $helper = Helper::getInstance();

    $array_allowed_mimetypes = ['image/' . $format];
    // photos
    if (!empty($_FILES['photo']['name'])) {
        $ext = preg_replace("/^.+\.([^.]+)$/sU", '\\1', $_FILES['photo']['name']);
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $field = $_POST['xoops_upload_file'][0];
        if (!empty($field) || '' !== $field) {
            // Check if file uploaded
            if ('' === $_FILES[$field]['tmp_name'] || !is_readable($_FILES[$field]['tmp_name'])) {
                redirect_header('country_manager.php', 2, MD_XFGUESTBOOK_FILEERROR);
            }
            $photos_dir = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $helper->getConfig('flagdir');
            $uploader   = new \XoopsMediaUploader($photos_dir, $array_allowed_mimetypes, $maxsize, $maxwidth, $maxheight);
            $uploader->setPrefix('tmp');
            if ($uploader->fetchMedia($field) && $uploader->upload()) {
                $tmp_name = $uploader->getSavedFileName();
                $ext      = preg_replace("/^.+\.([^.]+)$/sU", '\\1', $tmp_name);
                $photo    = $country_code . '.' . $ext;
                if (is_file($photos_dir . '/' . $photo)) {
                    unlink($photos_dir . '/' . $photo);
                }
                rename("$photos_dir/$tmp_name", "$photos_dir/$photo");
            } else {
                redirect_header('country_manager.php', 2, $uploader->getErrors());
            }
        }
        redirect_header('country_manager.php', 2, AM_XFGUESTBOOK_FILEUPLOADED);
    } else {
        redirect_header('country_manager.php?op=flagForm&amp;country_code=' . $country_code, 2, MD_XFGUESTBOOK_NOIMGSELECTED);
    }
    exit();
}

/**
 * @param $country_code
 */
function flagForm($country_code)
{
    global $xoopsModule, $maxsize, $maxwidth, $maxheight, $format;
    /** @var Helper $helper */
    $helper = Helper::getInstance();

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $flagform = new \XoopsThemeForm(AM_XFGUESTBOOK_SUBMITFLAG, 'op', xoops_getenv('SCRIPT_NAME'), 'post', true);
    $flagform->setExtra("enctype='multipart/form-data'");

    $flag = '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $helper->getConfig('flagdir') . '/' . $country_code . '.gif';
    if (file_exists(XOOPS_ROOT_PATH . $flag)) {
        $flag_img = "<img src='" . XOOPS_URL . $flag . '\'>';
        $img_flag = new \XoopsFormLabel('', '<br>' . $flag_img . '<br>');
        $flagform->addElement($img_flag);
    }
    $flag_desc = sprintf(AM_XFGUESTBOOK_FLAGDSC, $maxsize, $maxwidth, $maxheight, $format);
    $flagform->addElement(new \XoopsFormLabel('', $flag_desc));

    $img_text = new \XoopsFormFile(AM_XFGUESTBOOK_ADDIMG, 'photo', 30000);
    $img_text->setExtra("size ='60'");
    $flagform->addElement($img_text);

    $buttonTray = new \XoopsFormElementTray('', '');
    $buttonTray->addElement(new \XoopsFormButton('', 'post', _SUBMIT, 'submit'));
    $buttonTray->addElement(new \XoopsFormHidden('country_code', $country_code));
    $buttonTray->addElement(new \XoopsFormHidden('op', 'flagUpload'));
    $flagform->addElement($buttonTray);

    $flagform->display();
}

/**
 * @param $country_code
 */
function flagDel($country_code)
{
    global $xoopsModule;
    /** @var Helper $helper */
    $helper = Helper::getInstance();

    $ok = Request::getInt('ok', 0, 'POST');
    if (1 == $ok) {
        $flag = '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $helper->getConfig('flagdir') . '/' . $country_code . '.gif';
        if (is_file(XOOPS_ROOT_PATH . $flag)) {
            unlink(XOOPS_ROOT_PATH . $flag);
        }
        redirect_header('country_manager.php', 2, AM_XFGUESTBOOK_FLAGDELETED);
    } else {
        xoops_cp_header();
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        xoops_confirm(['op' => 'flagDel', 'country_code' => $country_code, 'ok' => 1], 'country_manager.php', AM_XFGUESTBOOK_CONFDELFLAG);
        require_once __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
    }
}

/**
 * @param null $country_id
 */
function countryForm($country_id = null)
{
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    if ($country_id) {
        $sform        = new \XoopsThemeForm(AM_XFGUESTBOOK_MODCOUNTRY, 'op', xoops_getenv('SCRIPT_NAME'), 'post', true);
        $arr_country  = Xfguestbook\Utility::getCountry('country_id=' . $country_id, 0, 0);
        $country_code = $arr_country[0]['country_code'];
        $country_name = $arr_country[0]['country_name'];
    } else {
        $sform        = new \XoopsThemeForm(AM_XFGUESTBOOK_ADDCOUNTRY, 'op', xoops_getenv('SCRIPT_NAME'), 'post', true);
        $country_code = '';
        $country_name = '';
    }

    $text_code = new \XoopsFormText(AM_XFGUESTBOOK_FLAGCODE, 'country_code', 5, 5, $country_code);
    if ($country_id) {
        $text_code->setExtra("readonly = 'readonly'");
    }
    $sform->addElement($text_code, true);
    $sform->addElement(new \XoopsFormText(AM_XFGUESTBOOK_FLAGNAME, 'country_name', 50, 50, $country_name), true);

    $buttonTray = new \XoopsFormElementTray('', '');
    $buttonTray->addElement(new \XoopsFormButton('', 'save', _SUBMIT, 'submit'));
    if ($country_id) {
        $buttonTray->addElement(new \XoopsFormHidden('country_id', $country_id));
    }
    $buttonTray->addElement(new \XoopsFormHidden('op', 'countrySave'));
    $sform->addElement($buttonTray);
    $sform->display();
}

/**
 * @param null $criteria
 * @param int  $limit
 * @param int  $start
 * @return array
 */
function xfgb_getCountry($criteria = null, $limit = 0, $start = 0)
{
    global $xoopsDB, $action;
    $ret = [];

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('xfguestbook_country');
    if (null !== $criteria && '' !== $criteria) {
        $sql .= ' WHERE ' . $criteria;
    }
    $sql    .= ' ORDER BY country_name ASC';
    $result = $xoopsDB->query($sql, $limit, $start);
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[] = $myrow;
    }

    return $ret;
}

/**
 * @param $country_id
 */
function countryDel($country_id)
{
    global $xoopsDB, $xoopsModule;
    /** @var Helper $helper */
    $helper = Helper::getInstance();

    $ok = Request::getInt('ok', 0, 'POST');
    if (1 == $ok) {
        $arr_country = Xfguestbook\Utility::getCountry('country_id=' . $country_id, 0, 0);
        $flag        = '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $helper->getConfig('flagdir') . '/' . $arr_country[0]['country_code'] . '.gif';
        $sql         = 'DELETE FROM ' . $xoopsDB->prefix('xfguestbook_country') . " WHERE country_id=$country_id";
        $result      = $xoopsDB->query($sql);
        if (is_file(XOOPS_ROOT_PATH . $flag)) {
            unlink(XOOPS_ROOT_PATH . $flag);
        }
        redirect_header('country_manager.php', 1, AM_XFGUESTBOOK_COUNTRYDELETED);
    } else {
        xoops_cp_header();
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        xoops_confirm(['op' => 'countryDel', 'country_id' => $country_id, 'ok' => 1], 'country_manager.php', AM_XFGUESTBOOK_CONFDELCOUNTRY);
        require_once __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
    }
}

/**
 * @param $country_id
 * @param $country_code
 * @param $country_name
 */
function countrySave($country_id, $country_code, $country_name)
{
    global $xoopsDB;

    $myts = \MyTextSanitizer::getInstance();
    //$country_code=$myts->makeTboxData4Save::$country_code;
    //$country_name=$myts->makeTboxData4Save::$country_name;
    echo $country_code;
    if (!empty($country_id)) {
        $sql = 'UPDATE ' . $xoopsDB->prefix('xfguestbook_country') . " SET country_code='$country_code', country_name='$country_name'";
        $sql .= " WHERE country_id=$country_id";
        $xoopsDB->query($sql);
        $messagesent = AM_XFGUESTBOOK_COUNTRY_UPDATED;
    } else {
        $sql = sprintf("SELECT COUNT(*) FROM  %s WHERE country_code = '%s'", $xoopsDB->prefix('xfguestbook_country'), $country_code);
        [$count] = $xoopsDB->fetchRow($xoopsDB->query($sql));
        if ($count > 0) {
            $messagesent = '<span style="color: #FF0000; ">' . AM_XFGUESTBOOK_COUNTRY_EXIST . '</span>';
        } else {
            $country_id = $xoopsDB->genId('country_id_seq');
            $sql        = sprintf("INSERT INTO `%s` (country_id, country_code, country_name) VALUES (%s, '%s', '%s')", $xoopsDB->prefix('xfguestbook_country'), $country_id, $country_code, $country_name);
            $xoopsDB->query($sql);
            $messagesent = AM_XFGUESTBOOK_COUNTRY_ADDED;
        }
    }
    redirect_header('country_manager.php', 2, $messagesent);
}

function countryShow()
{
    global $action, $start, $xoopsModule, $pathIcon16;
    /** @var Helper $helper */
    $helper = Helper::getInstance();

    $myts        = \MyTextSanitizer::getInstance();
    $limit       = 15;
    $arr_country = Xfguestbook\Utility::getCountry('', $limit, $start);
    $scount      = count(Xfguestbook\Utility::getCountry('', $limit, 0));
    $totalcount  = count(Xfguestbook\Utility::getCountry('', 0, 0));

    echo "
    <table width='100%' cellspacing='1' cellpadding='2' border='0' style='border-left: 1px solid #c0c0c0; border-top: 1px solid #c0c0c0; border-right: 1px solid #c0c0c0;'>
        <tr>
            <td><span style='font-weight: bold; font-size: 12px; font-variant: small-caps;'>" . AM_XFGUESTBOOK_DISPCOUNTRY . ' : ' . $totalcount . "</span></td>
            <td align='right'>
            </td>
        </tr>
    </table>";

    echo "<table border='1' width='100%' cellpadding ='2' cellspacing='1'>";
    echo "<tr class='bg3'>";
    echo "<td align='center'><b>" . AM_XFGUESTBOOK_FLAGIMG . '</td>';
    echo "<td align='center'><b>" . AM_XFGUESTBOOK_FLAGCODE . '</td>';
    echo "<td align='center'><b>" . AM_XFGUESTBOOK_FLAGNAME . '</td>';
    echo "<td align='center'><b>" . AM_XFGUESTBOOK_COUNTRY . '</td></b>';
    echo "<td align='center'><b>" . AM_XFGUESTBOOK_FLAGIMG . '</td></b>';
    echo '</tr>';

    if ('0' == count($arr_country)) {
        echo "<tr ><td align='center' colspan ='10' class = 'head'><b>" . AM_XFGUESTBOOK_NOFLAG . '</b></td></tr>';
    }

    for ($i = 0, $iMax = count($arr_country); $i < $iMax; ++$i) {
        $all_country = [];
        $flag        = '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $helper->getConfig('flagdir') . '/' . $arr_country[$i]['country_code'] . '.gif';
        if (file_exists(XOOPS_ROOT_PATH . $flag)) {
            $all_country['flag_img'] = "<img src='" . XOOPS_URL . $flag . '\'>';
        } else {
            $all_country['flag_img'] = "<img src='" . XOOPS_URL . "/images/blank.gif'>";
        }

        $all_country['country_id']   = $arr_country[$i]['country_id'];
        $all_country['country_code'] = $arr_country[$i]['country_code'];
        $all_country['country_name'] = $arr_country[$i]['country_name'];
        $all_country['msg_action']   = "<a href='country_manager.php?op=countryEdit&amp;country_id=" . $arr_country[$i]['country_id'] . '\'><img src=\'' . $pathIcon16 . "/edit.png'></a>";
        $all_country['msg_action']   .= "&nbsp;<a href='country_manager.php?op=countryDel&amp;country_id=" . $arr_country[$i]['country_id'] . '\'><img src=\'' . $pathIcon16 . "/delete.png'></a>";
        $all_country['flag_action']  = "<a href='country_manager.php?op=flagForm&amp;country_code=" . $arr_country[$i]['country_code'] . '\'><img src=\'' . $pathIcon16 . "/add.png'></a>";
        $all_country['flag_action']  .= "&nbsp;<a href='country_manager.php?op=flagDel&amp;country_code=" . $arr_country[$i]['country_code'] . '\'><img src=\'' . $pathIcon16 . "/delete.png'></a>";
        echo "<tr><td align='center' class = 'head'><b>" . $all_country['flag_img'] . '</b>';
        echo "</td><td class = 'even'>" . $all_country['country_code'] . '';
        echo "</td><td class = 'odd'>" . $all_country['country_name'] . '';
        echo "</td><td align='center' class='even'>" . $all_country['msg_action'] . '';
        echo "</td><td align='center' class='even'>" . $all_country['flag_action'] . '';
        echo '</td></tr>';
        unset($all_country);
    }

    echo '</table><br>';

    if ($totalcount > $scount) {
        require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $pagenav = new \XoopsPageNav($totalcount, $limit, $start, 'start', 'action=' . $action);
        echo "<div class='center;' class = 'head'>" . $pagenav->renderNav() . '</div><br>';
    } else {
        echo '';
    }
    echo '<br>';
}

switch ($op) {
    case 'flagForm':
        xoops_cp_header();
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(2);
        flagForm($country_code);
        require_once __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
    case 'flagUpload':
        flagUpload($country_code);
        break;
    case 'flagDel':
        flagDel($country_code);
        break;
    case 'countryDel':
        countryDel($country_id);
        break;
    case 'countryEdit':
        xoops_cp_header();
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(2);
        countryForm($country_id);
        require_once __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
    case 'countrySave':
        countrySave($country_id, $country_code, $country_name);
        break;
    case 'countryAdd':
        xoops_cp_header();
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(2);
        countryForm();
        require_once __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
    case 'countryShow':
    default:
        xoops_cp_header();
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(2);
        countryShow();
        countryForm();
        require_once __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
}
