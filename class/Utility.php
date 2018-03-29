<?php namespace XoopsModules\Xfguestbook;

use Xmf\Request;
use XoopsModules\Xfguestbook;
use XoopsModules\Xfguestbook\Common;
/** @var Xfguestbook\Helper $helper */
$helper = Xfguestbook\Helper::getInstance();

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------


    public static function upload()
    {
        global $xoopsModule,  $preview_name, $msgstop;
        /** @var Xfguestbook\Helper $helper */
        $helper = Xfguestbook\Helper::getInstance();

        $created = time();
        $ext     = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $_FILES['photo']['name']);
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $field = $_POST['xoops_upload_file'][0];
        if (!empty($field) || '' !== $field) {
            // Check if file uploaded
            if ('' === $_FILES[$field]['tmp_name'] || !is_readable($_FILES[$field]['tmp_name'])) {
                $msgstop .= sprintf(MD_XFGUESTBOOK_FILEERROR, $helper->getConfig('photo_maxsize'));
            } else {
                $photos_dir              = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->getVar('dirname');
                $array_allowed_mimetypes = ['image/gif', 'image/pjpeg', 'image/jpeg', 'image/x-png'];
                $uploader                = new \XoopsMediaUploader($photos_dir, $array_allowed_mimetypes, $helper->getConfig('photo_maxsize'), $helper->getConfig('photo_maxwidth'), $helper->getConfig('photo_maxheight'));
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
     * @param  null $criteria
     * @param  int  $limit
     * @param  int  $start
     * @return array
     */
    public static function getCountry($criteria = null, $limit = 0, $start = 0)
    {
        global $xoopsDB, $action;
        $ret = [];
        $sql = 'SELECT * FROM ' . $xoopsDB->prefix('xfguestbook_country');
        if (isset($criteria) && '' !== $criteria) {
            $sql .= ' WHERE ' . $criteria;
        }
        $sql    .= ' ORDER BY country_code ASC';
        $result = $xoopsDB->query($sql, $limit, $start);
        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
            array_push($ret, $myrow);
        }

        return $ret;
    }

    /**
     * @param  null $criteria
     * @param  int  $limit
     * @param  int  $start
     * @return array
     */
    public static function getAllCountry($criteria = null, $limit = 0, $start = 0)
    {
        global $xoopsDB, $action;
        /** @var Xfguestbook\Helper $helper */
        $helper = Xfguestbook\Helper::getInstance();

        $ret = [];
        $sql = 'SELECT country_code, country_name FROM ' . $xoopsDB->prefix('xfguestbook_country');
        if (isset($criteria) && '' !== $criteria) {
            $sql .= ' WHERE ' . $criteria;
        }
        $sql    .= ' ORDER BY country_code ASC';
        $result = $xoopsDB->query($sql, $limit, $start);
        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
            //      $ret[$myrow['country_code']] = $myrow['country_name'];
            $ret[$helper->getConfig('flagdir') . '/' . $myrow['country_code']] = $myrow['country_name'];
        }

        return $ret;
    }

    /**
     * @param $user_id
     * @return bool
     */
    public static function get_user_data($user_id)
    {
        global $xoopsUser;
        /** @var Xfguestbook\Helper $helper */
        $helper = Xfguestbook\Helper::getInstance();

        if (!(int)$user_id) {
            return false;
        }

        $poster = new \XoopsUser($user_id);
        if ($poster->isActive()) {
            $xoopsUser ? $a_poster['poster'] = "<a href='../../userinfo.php?uid=$user_id'>" . $poster->uname() . '</a>' : $a_poster['poster'] = $poster->uname();
            if ($helper->getConfig('display_avatar')) {
                $rank = $poster->rank();
                $rank['title'] ? $a_poster['rank'] = $rank['title'] : $a_poster['rank'] = '';
                $rank['image'] ? $a_poster['rank_img'] = "<img src='" . XOOPS_URL . '/uploads/' . $rank['image'] . '\' alt=\'\'>' : $a_poster['rank_img'] = '';
                $poster->user_avatar() ? $a_poster['avatar'] = "<img src='" . XOOPS_URL . '/uploads/' . $poster->user_avatar() . '\' alt=\'\'>' : $a_poster['avatar'] = '';
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
     * @param         $dir_path
     * @param  string $prefix
     * @return int
     */
    public static function clear_tmp_files($dir_path, $prefix = 'tmp_')
    {
        if (!($dir = @opendir($dir_path))) {
            return 0;
        }
        $ret        = 0;
        $prefix_len = strlen($prefix);
        while (false !== ($file = readdir($dir))) {
            //        if (strncmp($file, $prefix, $prefix_len) === 0) {
            if (0 === strpos($file, $prefix)) {
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
     * @param  null $all
     * @return array
     */
    public static function get_badips($all = null)
    {
        global $xoopsDB;
        $ret    = [];
        $sql    = 'SELECT * FROM ' . $xoopsDB->prefix('xfguestbook_badips');
        $result = $xoopsDB->query($sql);
        if ($all) {
            while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
                array_push($ret, $myrow);
            }
        } else {
            while (false !== (list($ip_id, $ip_value) = $xoopsDB->fetchRow($result))) {
                $ret[] = $ip_value;
            }
        }

        return $ret;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function email_exist($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } elseif (!checkdnsrr(array_pop(explode('@', $email)), 'MX')) {
            return false;
        } else {
            return true;
        }
    }
}
