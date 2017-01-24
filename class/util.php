<?php

/**
 * Class MyalbumUtil
 */
class XfguestbookUtil extends XoopsObject
{
    /**
     * Function responsible for checking if a directory exists, we can also write in and create an index.html file
     *
     * @param string $folder The full path of the directory to check
     *
     * @return void
     */
    public static function createFolder($folder)
    {
        try {
            if (!file_exists($folder)) {
                if (!mkdir($folder) && !is_dir($folder)) {
                    throw new \RuntimeException(sprintf('Unable to create the %s directory', $folder));
                } else {
                    file_put_contents($folder . '/index.html', '<script>history.go(-1);</script>');
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n", '<br/>';
        }
    }

    /**
     * @param $file
     * @param $folder
     * @return bool
     */
    public static function copyFile($file, $folder)
    {
        return copy($file, $folder);
        //        try {
        //            if (!is_dir($folder)) {
        //                throw new \RuntimeException(sprintf('Unable to copy file as: %s ', $folder));
        //            } else {
        //                return copy($file, $folder);
        //            }
        //        } catch (Exception $e) {
        //            echo 'Caught exception: ', $e->getMessage(), "\n", "<br/>";
        //        }
        //        return false;
    }

    /**
     * @param $src
     * @param $dst
     */
    public static function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        //    @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file !== '.') && ($file !== '..')) {
                if (is_dir($src . '/' . $file)) {
                    self::recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     *
     * Verifies XOOPS version meets minimum requirements for this module
     * @static
     * @param XoopsModule $module
     *
     * @return bool true if meets requirements, false if not
     */
    public static function checkVerXoops(XoopsModule $module)
    {
        xoops_loadLanguage('admin', $module->dirname());
        //check for minimum XOOPS version
        $currentVer  = substr(XOOPS_VERSION, 6); // get the numeric part of string
        $currArray   = explode('.', $currentVer);
        $requiredVer = '' . $module->getInfo('min_xoops'); //making sure it's a string
        $reqArray    = explode('.', $requiredVer);
        $success     = true;
        foreach ($reqArray as $k => $v) {
            if (isset($currArray[$k])) {
                if ($currArray[$k] > $v) {
                    break;
                } elseif ($currArray[$k] == $v) {
                    continue;
                } else {
                    $success = false;
                    break;
                }
            } else {
                if ((int)$v > 0) { // handles things like x.x.x.0_RC2
                    $success = false;
                    break;
                }
            }
        }

        if (!$success) {
            $module->setErrors(sprintf(_AM_XFGUESTBOOK_ERROR_BAD_XOOPS, $requiredVer, $currentVer));
        }

        return $success;
    }

    /**
     *
     * Verifies PHP version meets minimum requirements for this module
     * @static
     * @param XoopsModule $module
     *
     * @return bool true if meets requirements, false if not
     */
    public static function checkVerPhp(XoopsModule $module)
    {
        xoops_loadLanguage('admin', $module->dirname());
        // check for minimum PHP version
        $success = true;
        $verNum  = phpversion();
        $reqVer  =& $module->getInfo('min_php');
        if (false !== $reqVer && '' !== $reqVer) {
            if (version_compare($verNum, $reqVer, '<')) {
                $module->setErrors(sprintf(_AM_XFGUESTBOOK_ERROR_BAD_PHP, $reqVer, $verNum));
                $success = false;
            }
        }

        return $success;
    }

    public static function upload()
    {
        global $xoopsModule, $xoopsModuleConfig, $preview_name, $msgstop;
        $created = time();
        $ext     = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $_FILES['photo']['name']);
        include_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $field = $_POST['xoops_upload_file'][0];
        if (!empty($field) || $field !== '') {
            // Check if file uploaded
            if ($_FILES[$field]['tmp_name'] === '' || !is_readable($_FILES[$field]['tmp_name'])) {
                $msgstop .= sprintf(MD_XFGUESTBOOK_FILEERROR, $xoopsModuleConfig['photo_maxsize']);
            } else {
                $photos_dir              = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->getVar('dirname');
                $array_allowed_mimetypes = ['image/gif', 'image/pjpeg', 'image/jpeg', 'image/x-png'];
                $uploader                = new XoopsMediaUploader($photos_dir, $array_allowed_mimetypes, $xoopsModuleConfig['photo_maxsize'], $xoopsModuleConfig['photo_maxwidth'],
                                                                  $xoopsModuleConfig['photo_maxheight']);
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
        if (isset($criteria) && $criteria !== '') {
            $sql .= ' WHERE ' . $criteria;
        }
        $sql    .= ' ORDER BY country_code ASC';
        $result = $xoopsDB->query($sql, $limit, $start);
        while ($myrow = $xoopsDB->fetchArray($result)) {
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
        global $xoopsDB, $action, $xoopsModuleConfig;
        $ret = [];
        $sql = 'SELECT country_code, country_name FROM ' . $xoopsDB->prefix('xfguestbook_country');
        if (isset($criteria) && $criteria !== '') {
            $sql .= ' WHERE ' . $criteria;
        }
        $sql    .= ' ORDER BY country_code ASC';
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
    public static function get_user_data($user_id)
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
                $rank['image'] ? $a_poster['rank_img'] = "<img src='" . XOOPS_URL . '/uploads/' . $rank['image'] . '\' alt=\'\' />' : $a_poster['rank_img'] = '';
                $poster->user_avatar() ? $a_poster['avatar'] = "<img src='" . XOOPS_URL . '/uploads/' . $poster->user_avatar() . '\' alt=\'\' />' : $a_poster['avatar'] = '';
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
        while (($file = readdir($dir)) !== false) {
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
