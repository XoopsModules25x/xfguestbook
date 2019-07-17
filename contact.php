<?php
//
// ------------------------------------------------------------------------- //
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
//---------------------------------------------------------------------------//

use XoopsModules\Xfguestbook;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
//** @var Xfguestbook\Helper $helper */
$helper = Xfguestbook\Helper::getInstance();

$op = 'form';
foreach ($_POST as $k => $v) {
    ${$k} = $v;
}
foreach ($_GET as $k => $v) {
    ${$k} = $v;
}

$email_user = \Xmf\Request::getString('email_user', '');
$title = \Xmf\Request::getString('title', '');
$message = \Xmf\Request::getString('message', '');

$phone        = \Xmf\Request::getString('phone', '');
$name_user    = \Xmf\Request::getString('name_user', '');
$email_author = \Xmf\Request::getString('email_author', '');
$preview        = \Xmf\Request::getString('preview', '');
$post        = \Xmf\Request::getString('post', '');

if (isset($preview)) {
    $op = 'preview';
} elseif (isset($post)) {
    $op = 'post';
}
require_once __DIR__ . '/include/config.inc.php';
$option = getOptions();

/**
 * @param $title
 * @param $content
 */
function displaypost($title, $content)
{
    echo '<table cellpadding="4" cellspacing="1" width="98%" class="outer"><tr><td class="head">' . $title . '</td></tr><tr><td><br>' . $content . '<br></td></tr></table>';
}

switch ($op) {
    case 'post':
        global $xoopsConfig;
        $ts = \MyTextSanitizer::getInstance();
        xoops_header();

        if (1 == $option['opt_code']) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                redirect_header('index.php', 3, $xoopsCaptcha->getMessage());
            }
        }
        $fullmsg = MD_XFGUESTBOOK_FROMUSER . " $name_user " . MD_XFGUESTBOOK_YOURMSG . ' ' . $xoopsConfig['sitename'] . ' :<br><br>';
        $fullmsg .= $title . '<br>';
        $fullmsg .= '<hr><br>';
        $fullmsg .= "$message<br><br>";
        $fullmsg .= '<hr><br>';
        $fullmsg .= MD_XFGUESTBOOK_CANJOINT . ' [email]' . $email_user . '[/email]';

        $xoopsMailer = xoops_getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setFromEmail($email_user);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setToEmails($email_author);
        $xoopsMailer->setSubject(MD_XFGUESTBOOK_CONTACTAFTERMSG);
        $xoopsMailer->multimailer->isHTML(true);
        $xoopsMailer->setBody($ts->xoopsCodeDecode($fullmsg));
        $msgsend = "<div style='text-align:center;'><br><br>";
        if (!$xoopsMailer->send()) {
            $msgsend .= $xoopsMailer->getErrors();
        } else {
            $msgsend .= '<h4>' . MD_XFGUESTBOOK_MSGSEND . '</h4>';
        }
        $msgsend .= '<br><br><a href="javascript:window.close();">' . MD_XFGUESTBOOK_CLOSEWINDOW . '</a></div>';
        echo $msgsend;
        break;
    case 'preview':

        $ts = \MyTextSanitizer::getInstance();
        xoops_header();

        if (1 == $option['opt_code']) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                redirect_header('index.php', 3, $xoopsCaptcha->getMessage());
            }
        }

        $p_title = $title;
        $p_msg   = MD_XFGUESTBOOK_FROMUSER . " $name_user " . MD_XFGUESTBOOK_YOURMSG . ' ' . $xoopsConfig['sitename'] . ' :<br>';
        $p_msg   .= $title . '<br>';
        $p_msg   .= '<hr><br>';
        $p_msg   .= $message . '<br><br>';
        $p_msg   .= '<hr><br>';
        $p_msg   .= MD_XFGUESTBOOK_CANJOINT . " $email_user";

        $p_msg .= '<br>';
        displaypost($p_title, $p_msg);

        require_once __DIR__ . '/include/form_contact.inc.php';
        xoops_footer();
        break;
    case 'form':
    default:

        xoops_header();
        $msgHandler = $helper->getHandler('Message');
        $msg        = $msgHandler->get($msg_id);
        if (!$msg) {
            redirect_header('index.php', 3, _NOPERM);
        }
        $message      = '';
        $phone        = '';
        $name_user    = '';
        $email_user   = '';
        $email_author = $msg->getVar('email');
        $title        = $msg->getVar('title');
        if ($xoopsUser) {
            $name_user  = ('' !== $xoopsUser->getVar('name')) ? $xoopsUser->getVar('name') : $xoopsUser->getVar('uname');
            $email_user = $xoopsUser->getVar('email', 'E');
        }
        if (1 == $option['opt_code']) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
        }
        require_once __DIR__ . '/include/form_contact.inc.php';
        xoops_footer();
        break;
}
