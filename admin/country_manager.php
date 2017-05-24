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

//include __DIR__ . '/../../../include/cp_header.php';
include_once __DIR__ . '/../include/cp_functions.php';
include_once __DIR__ . '/admin_header.php';
require __DIR__ . '/../class/util.php';

// Flag
$maxsize   = 2000;
$maxheight = 50;
$maxwidth  = 80;
$format    = 'gif';

Xmf\Request::getString('op', 'countryShow');
Xmf\Request::getInt('country_id', 0);
Xmf\Request::getString('country_code', '');
Xmf\Request::getInt('start', 0, 'GET');
Xmf\Request::getString('country_name', '', 'POST');
/*
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} elseif (isset($_POST['op'])) {
    $op = $_POST['op'];
} else {
    $op = 'countryShow';
}

if (isset($_GET['country_id'])) {
    $country_id = (int)$_GET['country_id'];
} elseif (isset($_POST['country_id'])) {
    $country_id = (int)$_POST['country_id'];
} else {
    $country_id = 0;
}

if (isset($_GET['country_code'])) {
    $country_code = $_GET['country_code'];
} elseif (isset($_POST['country_code'])) {
    $country_code = $_POST['country_code'];
} else {
    $country_code = '';
}

$start        = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$country_name = isset($_POST['country_name']) ? $_POST['country_name'] : '';
*/
/**
 * @param $country_code
 */
function flagUpload($country_code)
{
    global $xoopsModule, $xoopsModuleConfig, $maxsize, $maxwidth, $maxheight, $format;
    $array_allowed_mimetypes = ['image/' . $format];
    // photos
    if (!empty($_FILES['photo']['name'])) {
        $ext = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $_FILES['photo']['name']);
        include_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $field = $_POST['xoops_upload_file'][0];
        if (!empty($field) || $field !== '') {
            // Check if file uploaded
            if ($_FILES[$field]['tmp_name'] === '' || !is_readable($_FILES[$field]['tmp_name'])) {
                redirect_header('country_manager.php', 2, MD_XFGUESTBOOK_FILEERROR);
            }
            $photos_dir = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $xoopsModuleConfig['flagdir'];
            $uploader   = new XoopsMediaUploader($photos_dir, $array_allowed_mimetypes, $maxsize, $maxwidth, $maxheight);
            $uploader->setPrefix('tmp');
            if ($uploader->fetchMedia($field) && $uploader->upload()) {
                $tmp_name = $uploader->getSavedFileName();
                $ext      = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $tmp_name);
                $photo    = $country_code . '.' . $ext;
                if (file_exists($photos_dir . '/' . $photo)) {
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
    global $xoopsModule, $xoopsModuleConfig, $maxsize, $maxwidth, $maxheight, $format;
    include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $flagform = new XoopsThemeForm(AM_XFGUESTBOOK_SUBMITFLAG, 'op', xoops_getenv('PHP_SELF'));
    $flagform->setExtra("enctype='multipart/form-data'");

    $flag = '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $xoopsModuleConfig['flagdir'] . '/' . $country_code . '.gif';
    if (file_exists(XOOPS_ROOT_PATH . $flag)) {
        $flag_img = "<img src='" . XOOPS_URL . $flag . '\'>';
        $img_flag = new XoopsFormLabel('', '<br>' . $flag_img . '<br>');
        $flagform->addElement($img_flag);
    }
    $flag_desc = sprintf(AM_XFGUESTBOOK_FLAGDSC, $maxsize, $maxwidth, $maxheight, $format);
    $flagform->addElement(new XoopsFormLabel('', $flag_desc));

    $img_text = new XoopsFormFile(AM_XFGUESTBOOK_ADDIMG, 'photo', 30000);
    $img_text->setExtra("size ='60'");
    $flagform->addElement($img_text);

    $button_tray = new XoopsFormElementTray('', '');
    $button_tray->addElement(new XoopsFormButton('', 'post', _SUBMIT, 'submit'));
    $button_tray->addElement(new XoopsFormHidden('country_code', $country_code));
    $button_tray->addElement(new XoopsFormHidden('op', 'flagUpload'));
    $flagform->addElement($button_tray);

    $flagform->display();
}

/**
 * @param $country_code
 */
function flagDel($country_code)
{
    global $xoopsModule, $xoopsModuleConfig;
    $ok = isset($_POST['ok']) ? (int)$_POST['ok'] : 0;
    if ($ok == 1) {
        if (!$xoopsSecurity->check()) {
            redirect_header($_SERVER['PHP_SELF'], 3, implode('<br>', $xoopsSecurity->getErrors()));
        }
        $flag = '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $xoopsModuleConfig['flagdir'] . '/' . $country_code . '.gif';
        if (file_exists(XOOPS_ROOT_PATH . $flag)) {
            unlink(XOOPS_ROOT_PATH . $flag);
        }
        redirect_header('country_manager.php', 2, AM_XFGUESTBOOK_FLAGDELETED);
    } else {
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation(basename(__FILE__));
        xoops_confirm(['op' => 'flagDel', 'country_code' => $country_code, 'ok' => 1], 'country_manager.php', AM_XFGUESTBOOK_CONFDELFLAG);
        include __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
    }
}

/**
 * @param null $country_id
 */
function countryForm($country_id = null)
{
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    if ($country_id) {
        $sform        = new XoopsThemeForm(AM_XFGUESTBOOK_MODCOUNTRY, 'op', xoops_getenv('PHP_SELF'));
        $arr_country  = XfguestbookUtil::getCountry('country_id=' . $country_id, 0, 0);
        $country_code = $arr_country[0]['country_code'];
        $country_name = $arr_country[0]['country_name'];
    } else {
        $sform        = new XoopsThemeForm(AM_XFGUESTBOOK_ADDCOUNTRY, 'op', xoops_getenv('PHP_SELF'));
        $country_code = '';
        $country_name = '';
    }

    $text_code = new XoopsFormText(AM_XFGUESTBOOK_FLAGCODE, 'country_code', 5, 5, $country_code);
    if ($country_id) {
        $text_code->setExtra("readonly = 'readonly'");
    }
    $sform->addElement($text_code, true);
    $sform->addElement(new XoopsFormText(AM_XFGUESTBOOK_FLAGNAME, 'country_name', 50, 50, $country_name), true);

    $button_tray = new XoopsFormElementTray('', '');
    $button_tray->addElement(new XoopsFormButton('', 'save', _SUBMIT, 'submit'));
    if ($country_id) {
        $button_tray->addElement(new XoopsFormHidden('country_id', $country_id));
    }
    $button_tray->addElement(new XoopsFormHidden('op', 'countrySave'));
    $sform->addElement($button_tray);
    $sform->display();
}

/**
 * @param  null $criteria
 * @param  int  $limit
 * @param  int  $start
 * @return array
 */
function xfgb_getCountry($criteria = null, $limit = 0, $start = 0)
{
    global $xoopsDB, $action;
    $ret = [];

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('xfguestbook_country');
    if (isset($criteria) && $criteria !== '') {
        $sql .= ' WHERE ' . $criteria;
    }
    $sql    .= ' ORDER BY country_name ASC';
    $result = $xoopsDB->query($sql, $limit, $start);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        array_push($ret, $myrow);
    }

    return $ret;
}

/**
 * @param $country_id
 */
function countryDel($country_id)
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
    $ok = isset($_POST['ok']) ? (int)$_POST['ok'] : 0;
    if ($ok == 1) {
        if (!$xoopsSecurity->check()) {
            redirect_header($_SERVER['PHP_SELF'], 3, implode('<br>', $xoopsSecurity->getErrors()));
        }
        $arr_country = XfguestbookUtil::getCountry('country_id=' . $country_id, 0, 0);
        $flag        = '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $xoopsModuleConfig['flagdir'] . '/' . $arr_country[0]['country_code'] . '.gif';
        $sql         = 'DELETE FROM ' . $xoopsDB->prefix('xfguestbook_country') . " WHERE country_id=$country_id";
        $result      = $xoopsDB->query($sql);
        if (file_exists(XOOPS_ROOT_PATH . $flag)) {
            unlink(XOOPS_ROOT_PATH . $flag);
        }
        redirect_header('country_manager.php', 1, AM_XFGUESTBOOK_COUNTRYDELETED);
    } else {
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation(basename(__FILE__));
        xoops_confirm(['op' => 'countryDel', 'country_id' => $country_id, 'ok' => 1], 'country_manager.php', AM_XFGUESTBOOK_CONFDELCOUNTRY);
        include __DIR__ . '/admin_footer.php';
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

    $myts = MyTextSanitizer::getInstance();
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
        list($count) = $xoopsDB->fetchRow($xoopsDB->query($sql));
        if ($count > 0) {
            $messagesent = '<span style="color: #FF0000; ">' . AM_XFGUESTBOOK_COUNTRY_EXIST . '</span>';
        } else {
            $country_id = $xoopsDB->genId('country_id_seq');
            $sql        = sprintf("INSERT INTO %s (country_id, country_code, country_name) VALUES (%s, '%s', '%s')", $xoopsDB->prefix('xfguestbook_country'), $country_id, $country_code,
                                  $country_name);
            $xoopsDB->query($sql);
            $messagesent = AM_XFGUESTBOOK_COUNTRY_ADDED;
        }
    }
    redirect_header('country_manager.php', 2, $messagesent);
}

function countryShow()
{
    global $action, $start, $xoopsModule, $xoopsModuleConfig, $pathIcon16;
    $myts        = MyTextSanitizer::getInstance();
    $limit       = 15;
    $arr_country = XfguestbookUtil::getCountry('', $limit, $start);
    $scount      = count(XfguestbookUtil::getCountry('', $limit, 0));
    $totalcount  = count(XfguestbookUtil::getCountry('', 0, 0));

    echo "
    <table width='100%' cellspacing='1' cellpadding='2' border='0' style='border-left: 1px solid silver; border-top: 1px solid silver; border-right: 1px solid silver;'>
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

    if (count($arr_country) == '0') {
        echo "<tr ><td align='center' colspan ='10' class = 'head'><b>" . AM_XFGUESTBOOK_NOFLAG . '</b></td></tr>';
    }

    for ($i = 0, $iMax = count($arr_country); $i < $iMax; ++$i) {
        $all_country = [];
        $flag        = '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $xoopsModuleConfig['flagdir'] . '/' . $arr_country[$i]['country_code'] . '.gif';
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
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $pagenav = new XoopsPageNav($totalcount, $limit, $start, 'start', 'action=' . $action);
        echo "<div class='center;' class = 'head'>" . $pagenav->renderNav() . '</div><br>';
    } else {
        echo '';
    }
    echo '<br>';
}

switch ($op) {
    case 'flagForm':
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(2);
        flagForm($country_code);
        include __DIR__ . '/admin_footer.php';
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
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(2);
        countryForm($country_id);
        include __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
    case 'countrySave':
        countrySave($country_id, $country_code, $country_name);
        break;
    case 'countryAdd':
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(2);
        countryForm();
        include __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
    case 'countryShow':
    default:
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation(basename(__FILE__));
        //xfguestbook_admin_menu(2);
        countryShow();
        countryForm();
        include __DIR__ . '/admin_footer.php';
        //xoops_cp_footer();
        break;
}
