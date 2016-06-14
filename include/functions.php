<?php
// $Id: include/functions.php,v 1.4 2006/01/01 C.Felix AKA the Cat
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

global $xoopsModule;
$cacheFolder = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->getVar('dirname');
if (!is_dir($cacheFolder)) {
    mkdir($cacheFolder, 0777);
    file_put_contents($cacheFolder . '/index.html', '');
}

function xfgb_upload()
{
    global $xoopsModule, $xoopsModuleConfig, $preview_name, $msgstop;
    $created = time();
    $ext     = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $_FILES['photo']['name']);
    include_once(XOOPS_ROOT_PATH . '/class/uploader.php');
    $field = $_POST['xoops_upload_file'][0];
    if (!empty($field) || $field !== '') {
        // Check if file uploaded
        if ($_FILES[$field]['tmp_name'] === '' || !is_readable($_FILES[$field]['tmp_name'])) {
            $msgstop .= sprintf(_MD_XFGB_FILEERROR, $xoopsModuleConfig['photo_maxsize']);
        } else {
            $photos_dir              = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->getVar('dirname');
            $array_allowed_mimetypes = array('image/gif', 'image/pjpeg', 'image/jpeg', 'image/x-png');
            $uploader                = new XoopsMediaUploader($photos_dir, $array_allowed_mimetypes, $xoopsModuleConfig['photo_maxsize'], $xoopsModuleConfig['photo_maxwidth'], $xoopsModuleConfig['photo_maxheight']);
            if ($uploader->fetchMedia($field) && $uploader->upload()) {
                if (isset($preview_name)) {
                    @unlink("$photos_dir/" . $preview_name);
                }
                $tmp_name     = $uploader->getSavedFileName();
                $ext          = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $tmp_name);
                $preview_name = 'tmp_' . $created . '.' . $ext;
                rename("$photos_dir/$tmp_name", "$photos_dir/$preview_name");
            } else {
                $msgstop .= $uploader->getErrors();
            }
        }
    }
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
    $ret = array();
    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('xfguestbook_country');
    if (isset($criteria) && $criteria !== '') {
        $sql .= ' WHERE ' . $criteria;
    }
    $sql .= ' ORDER BY country_code ASC';
    $result = $xoopsDB->query($sql, $limit, $start);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        array_push($ret, $myrow);
    }

    return $ret;
}

/**
 * @param null $criteria
 * @param int  $limit
 * @param int  $start
 * @return array
 */
function xfgb_getAllCountry($criteria = null, $limit = 0, $start = 0)
{
    global $xoopsDB, $action, $xoopsModuleConfig;
    $ret = array();
    $sql = 'SELECT country_code, country_name FROM ' . $xoopsDB->prefix('xfguestbook_country');
    if (isset($criteria) && $criteria !== '') {
        $sql .= ' WHERE ' . $criteria;
    }
    $sql .= ' ORDER BY country_code ASC';
    $result = $xoopsDB->query($sql, $limit, $start);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        //      $ret[$myrow['country_code']] = $myrow['country_name'];
        $ret[$xoopsModuleConfig['flagdir'] . '/' . $myrow['country_code']] = $myrow['country_name'];
    }

    return $ret;
}

/**
 * @param $user_id
 * @return bool
 */
function xfgb_get_user_data($user_id)
{
    global $xoopsUser, $xoopsModuleConfig;

    if (!(int)$user_id) {
        return false;
    }

    $poster = new XoopsUser($user_id);
    if ($poster->isActive()) {
        $xoopsUser ? $a_poster['poster'] = "<a href='../../userinfo.php?uid=$user_id'>" . $poster->uname() . '</a>' : $a_poster['poster'] = $poster->uname();
        if ($xoopsModuleConfig['display_avatar']) {
            $rank = $poster->rank();
            $rank['title'] ? $a_poster['rank'] = $rank['title'] : $a_poster['rank'] = '';
            $rank['image'] ? $a_poster['rank_img'] = "<img src='" . XOOPS_URL . '/uploads/' . $rank['image'] . "' alt='' />" : $a_poster['rank_img'] = '';
            $poster->user_avatar() ? $a_poster['avatar'] = "<img src='" . XOOPS_URL . '/uploads/' . $poster->user_avatar() . "' alt='' />" : $a_poster['avatar'] = '';
        } else {
            $a_poster['rank']     = '';
            $a_poster['avatar']   = '';
            $a_poster['rank_img'] = '';
        }

        return $a_poster;
    } else {
        return false;
    }
}

// Effacement fichiers temporaires
/**
 * @param        $dir_path
 * @param string $prefix
 * @return int
 */
function xfgb_clear_tmp_files($dir_path, $prefix = 'tmp_')
{
    if (!($dir = @opendir($dir_path))) {
        return 0;
    }
    $ret        = 0;
    $prefix_len = strlen($prefix);
    while (($file = readdir($dir)) !== false) {
        if (strncmp($file, $prefix, $prefix_len) === 0) {
            if (@unlink("$dir_path/$file")) {
                $ret++;
            }
        }
    }
    closedir($dir);

    return $ret;
}

// IP bannies (modérés automatiquement)
/**
 * @param null $all
 * @return array
 */
function xfgb_get_badips($all = null)
{
    global $xoopsDB;
    $ret    = array();
    $sql    = 'SELECT * FROM ' . $xoopsDB->prefix('xfguestbook_badips');
    $result = $xoopsDB->query($sql);
    if ($all) {
        while ($myrow = $xoopsDB->fetchArray($result)) {
            array_push($ret, $myrow);
        }
    } else {
        while (list($ip_id, $ip_value) = $xoopsDB->fetchRow($result)) {
            $ret[] = $ip_value;
        }
    }

    return $ret;
}

/**
 * @param $email
 * @return bool
 */
function email_exist($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    } elseif (!checkdnsrr(array_pop(explode('@', $email)), 'MX')) {
        return false;
    } else {
        return true;
    }
}
