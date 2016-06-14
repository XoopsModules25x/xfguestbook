<?php
// $Id: contact.php,v 1.11 2004/12/02 C. Felix AKA the Cat
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
include dirname(dirname(__DIR__)) . '/mainfile.php';
$op = 'form';
foreach ($_POST as $k => $v) {
    ${$k} = $v;
}
foreach ($_GET as $k => $v) {
    ${$k} = $v;
}

if (isset($preview)) {
    $op = 'preview';
} elseif (isset($post)) {
    $op = 'post';
}
include_once(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/include/functions.php');
include_once('include/config.inc.php');
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
        $ts = MyTextSanitizer::getInstance();
        xoops_header();

        if ($option['opt_code'] == 1) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                redirect_header('index.php', 3, $xoopsCaptcha->getMessage());
            }
        }
        $fullmsg = _MD_XFGB_FROMUSER . " $name_user " . _MD_XFGB_YOURMSG . ' ' . $xoopsConfig['sitename'] . ' :<br><br>';
        $fullmsg .= $title . '<br>';
        $fullmsg .= '<hr><br>';
        $fullmsg .= "$message<br><br>";
        $fullmsg .= '<hr><br>';
        $fullmsg .= _MD_XFGB_CANJOINT . ' [email]' . $email_user . '[/email]';

        $xoopsMailer =& xoops_getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setFromEmail($email_user);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setToEmails($email_author);
        $xoopsMailer->setSubject(_MD_XFGB_CONTACTAFTERMSG);
        $xoopsMailer->multimailer->isHTML(true);
        $xoopsMailer->setBody($ts->xoopsCodeDecode($fullmsg));
        $msgsend = "<div style='text-align:center;'><br><br>";
        if (!$xoopsMailer->send()) {
            $msgsend .= $xoopsMailer->getErrors();
        } else {
            $msgsend .= '<h4>' . _MD_XFGB_MSGSEND . '</h4>';
        }
        $msgsend .= "<br><br><a href=\"javascript:window.close();\">" . _MD_XFGB_CLOSEWINDOW . '</a></div>';
        echo $msgsend;
        break;

    case 'preview':

        $ts = MyTextSanitizer::getInstance();
        xoops_header();

        if ($option['opt_code'] == 1) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                redirect_header('index.php', 3, $xoopsCaptcha->getMessage());
            }
        }
        $p_title = $title;
        $p_title = $ts->htmlSpecialChars($ts->stripSlashesGPC($p_title));
        $p_msg   = _MD_XFGB_FROMUSER . " $name_user " . _MD_XFGB_YOURMSG . ' ' . $xoopsConfig['sitename'] . ' :<br>';
        $p_msg .= $title . '<br>';
        $p_msg .= '<hr><br>';
        $p_msg .= $message . '<br><br>';
        $p_msg .= '<hr><br>';
        $p_msg .= _MD_XFGB_CANJOINT . " $email_user";

        $p_msg .= '<br>';
        displaypost($p_title, $p_msg);

        $title   = $ts->htmlSpecialChars($ts->stripSlashesGPC($title));
        $message = $ts->htmlSpecialChars($ts->stripSlashesGPC($message));

        include __DIR__ . '/include/form_contact.inc.php';
        xoops_footer();
        break;

    case 'form':
    default:

        xoops_header();
        $msg_handler = &xoops_getModuleHandler('msg');
        $msg         = &$msg_handler->get($msg_id);
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
            $name_user  = ($xoopsUser->getVar('name') !== '') ? $xoopsUser->getVar('name') : $xoopsUser->getVar('uname');
            $email_user = $xoopsUser->getVar('email', 'E');
        }
        if ($option['opt_code'] == 1) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
        }
        include __DIR__ . '/include/form_contact.inc.php';
        xoops_footer();
        break;
}
