<?php
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

use XoopsModules\Xfguestbook;

require_once __DIR__ . '/header.php';

if (!is_object($xoopsUser) && 1 != $helper->getConfig('anonsign')) {
    redirect_header(XOOPS_URL . '/user.php', 2, MD_XFGUESTBOOK_MUSTREGFIRST);
}

require_once __DIR__ . '/include/config.inc.php';

///** @var Xfguestbook\Helper $helper */
//$helper = Xfguestbook\Helper::getInstance();

$option     = getOptions();
$msgHandler = $helper->getHandler('Message');

$confirm_code = \Xmf\Request::getString('confirm_code', '', 'POST');
$confirm_str  = \Xmf\Request::getString('confirm_str', '', 'POST');
$user_id      = \Xmf\Request::getInt('user_id', 0, 'POST');
$title        = \Xmf\Request::getString('title', '', 'POST');
$message      = \Xmf\Request::getString('message', '', 'POST');
$gender       = \Xmf\Request::getString('gender', '', 'POST');
$preview_name = \Xmf\Request::getString('preview_name', '', 'POST');
$email        = \Xmf\Request::getString('email', '', 'POST');
$name         = \Xmf\Request::getString('name', '', 'POST');
$url          = \Xmf\Request::getString('url', '', 'POST');
$country      = \Xmf\Request::getString('country', '', 'POST');

$op = 'form';

if (\Xmf\Request::hasVar('preview', 'POST')) {
    $op = 'preview';
} elseif (\Xmf\Request::hasVar('post', 'POST')) {
    $op = 'post';
}

$badip = in_array($_SERVER['REMOTE_ADDR'], Xfguestbook\Utility::get_badips()) ? true : false;

switch ($op) {
    case 'cancel':
        $photos_dir     = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->getVar('dirname');
        $nb_removed_tmp = Xfguestbook\Utility::clear_tmp_files($photos_dir);
        redirect_header('index.php', 0);
        break;
    case 'preview':
        $ts                                      = \MyTextSanitizer::getInstance();
        $GLOBALS['xoopsOption']['template_main'] = 'xfguestbook_signform.tpl';
        require_once XOOPS_ROOT_PATH . '/header.php';
        $msgstop = '';

        /*if ($option['opt_code']==1) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                $msgstop .= $xoopsCaptcha->getMessage();
            }
        }*/
        if (2 == $option['opt_url'] && preg_match('/^(http)|(https)|(www)/i', $message)) {
            $msgstop .= MD_XFGUESTBOOK_URL_DISABLED . '<br>';
        }

        if ('' !== $email && !checkEmail($email)) {
            $msgstop .= MD_XFGUESTBOOK_INVALIDMAIL . '<br>';
        }
        if (!empty($_FILES['photo']['name'])) {
            Xfguestbook\Utility::upload();
        }
        //        $title   = $ts->htmlSpecialChars($ts->stripSlashesGPC($title));
        //        $message = $ts->htmlSpecialChars($ts->stripSlashesGPC($message));
        if (!empty($msgstop)) {
            $xoopsTpl->assign('preview', true);
            $xoopsTpl->assign('msgstop', $msgstop);
            require_once __DIR__ . '/include/form_sign.inc.php';
            $signform->assign($xoopsTpl);
            require_once XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }
        $msgpost['title']   = $ts->previewTarea($title);
        $msgpost['message'] = $ts->previewTarea($message);
        $msgpost['poster']  = $name;
        $msgpost['user_id'] = $user_id;
        $msgpost['date']    = formatTimestamp(time(), 's');
        $msgpost['photo']   = $preview_name;
        if (1 == $option['opt_url']) {
            $msgpost['message'] = str_replace('target="_blank"', 'target="_blank" rel="nofollow"', $msgpost['message']);
        }
        if ($gender) {
            $msgpost['gender'] = '<img src="assets/images/' . $gender . '.gif"';
        }
        if ($email) {
            $msgpost['email'] = '<img src="' . XOOPS_URL . '/images/icons/email.gif" alt="' . _SENDEMAILTO . '">';
        }
        if ($url) {
            $msgpost['url'] = '<img src="' . XOOPS_URL . '/images/icons/www.gif" alt="' . _VISITWEBSITE . '">';
        }
        if ($country) {
            $flag         = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $helper->getConfig('flagdir') . '/' . $country . '.gif';
            $arr_country  = Xfguestbook\Utility::getCountry("country_code ='" . $country . '\'');
            $country_name = (count($arr_country) > 0) ? $arr_country[0]['country_name'] : '';
            if (file_exists($flag)) {
                $msgpost['country'] = '<img src="' . XOOPS_URL . '/modules/xfguestbook/assets/images/flags/' . $helper->getConfig('flagdir') . '/' . $country . '.gif" alt="' . $country_name . '">';
            } else {
                $msgpost['country'] = $country_name;
            }
        }

        $xoopsTpl->assign('preview', true);
        $xoopsTpl->assign('msgstop', $msgstop);
        require_once __DIR__ . '/include/form_sign.inc.php';
        $xoopsTpl->assign('msg', $msgpost);
        $signform->assign($xoopsTpl);
        require_once XOOPS_ROOT_PATH . '/footer.php';
        break;
    case 'post':
        $msgstop = '';
        if (1 == $option['opt_code']) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                $msgstop .= $xoopsCaptcha->getMessage() . '<br><br>';
            }
            require_once XOOPS_ROOT_PATH . '/header.php';
        }
        if ('' !== $_POST['uman']) {
            redirect_header('index.php', 2, '');
        }
        if (2 == $option['opt_url'] && preg_match('/^(http)|(https)|(www)/i', $message)) {
            $msgstop .= MD_XFGUESTBOOK_URL_DISABLED . '<br><br>';
        }

        if (2 == $option['opt_mail'] && !Xfguestbook\Utility::email_exist($email)) {
            $msgstop .= MD_XFGUESTBOOK_INVALIDMAIL . '<br><br>';
        }
        if (2 == $option['opt_mail'] && '' !== $email && !checkEmail($email)) {
            $msgstop .= MD_XFGUESTBOOK_INVALIDMAIL . '<br><br>';
        }

        if (!empty($_FILES['photo']['name'])) {
            Xfguestbook\Utility::upload();
        }
        if (!empty($msgstop)) {
            $GLOBALS['xoopsOption']['template_main'] = 'xfguestbook_signform.tpl';
            require_once XOOPS_ROOT_PATH . '/header.php';
            $xoopsTpl->assign('preview', true);
            $xoopsTpl->assign('msgstop', $msgstop);
            require_once __DIR__ . '/include/form_sign.inc.php';
            $signform->assign($xoopsTpl);
            require_once XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }
        $photos_dir = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->getVar('dirname');
        if ('' !== $preview_name) {
            $photo = str_replace('tmp_', 'msg_', $preview_name);
            rename("$photos_dir/$preview_name", "$photos_dir/$photo");
        }

        $msgpost = $msgHandler->create();
        $xoopsUser ? $user_id = $xoopsUser->uid() : $user_id = 0;
        $xoopsUser ? $username = $xoopsUser->uname() : $username = $name;
        $msgpost->setVar('user_id', $user_id);
        $msgpost->setVar('uname', $username);
        $msgpost->setVar('title', $title);
        $msgpost->setVar('message', $message);
        $msgpost->setVar('note', '');
        $msgpost->setVar('post_time', time());
        $msgpost->setVar('email', $email);
        $msgpost->setVar('url', $url);
        $msgpost->setVar('poster_ip', $_SERVER['REMOTE_ADDR']);
        $msgpost->setVar('country', $country);
        $msgpost->setVar('flagdir', $helper->getConfig('flagdir'));
        $msgpost->setVar('gender', $gender);
        if (!isset($photo)) {
            $photo = '';
        }
        $msgpost->setVar('photo', $photo);

        if ($badip) {
            $msgpost->setVar('moderate', 1);
        } else {
            $msgpost->setVar('moderate', $helper->getConfig('moderate'));
        }
        $nb_removed_tmp = Xfguestbook\Utility::clear_tmp_files($photos_dir);
        $messagesent    = MD_XFGUESTBOOK_MESSAGESENT;

        if ($msgHandler->insert($msgpost)) {
            if ($badip || $helper->getConfig('moderate')) {
                $messagesent .= '<br>' . MD_XFGUESTBOOK_AFTERMODERATE;
            }

            // Send mail to webmaster
            if (1 == $helper->getConfig('sendmail2wm')) {
                $subject     = $xoopsConfig['sitename'] . ' - ' . MD_XFGUESTBOOK_NAMEMODULE;
                $xoopsMailer = xoops_getMailer();
                $xoopsMailer->useMail();
                $xoopsMailer->setToEmails($xoopsConfig['adminmail']);
                $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
                $xoopsMailer->setFromName($xoopsConfig['sitename']);
                $xoopsMailer->setSubject($subject);
                $xoopsMailer->setBody(MD_XFGUESTBOOK_NEWMESSAGE . ' ' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/');
                if (!$xoopsMailer->send()) {
                    echo $xoopsMailer->getErrors();
                }
            }
            redirect_header('index.php', 2, $messagesent);
        } else {
            $messagesent = $msgpost->getHtmlErrors();
            redirect_header('index.php', 2, $messagesent);
        }
        break;
    case 'form':
    default:
        $GLOBALS['xoopsOption']['template_main'] = 'xfguestbook_signform.tpl';

        require_once XOOPS_ROOT_PATH . '/header.php';
        $user_id = !empty($xoopsUser) ? $xoopsUser->getVar('uid', 'E') : 0;
        $name    = !empty($xoopsUser) ? $xoopsUser->getVar('uname', 'E') : '';
        $email   = !empty($xoopsUser) ? $xoopsUser->getVar('email', 'E') : '';
        $url     = !empty($xoopsUser) ? $xoopsUser->getVar('url', 'E') : '';
        $country = $option['countrybydefault'];

        if (1 == $option['opt_code']) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
        }
        if ($badip || $helper->getConfig('moderate')) {
            $xoopsTpl->assign('moderate', MD_XFGUESTBOOK_MODERATED);
        }

        require_once __DIR__ . '/include/form_sign.inc.php';
        $signform->assign($xoopsTpl);
        require_once XOOPS_ROOT_PATH . '/footer.php';
        break;
}
