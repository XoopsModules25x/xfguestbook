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
//  along with this program; if not, write metalslugto the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

use XoopsModules\Xfguestbook;

require_once __DIR__ . '/header.php';

//** @var Xfguestbook\Helper $helper */
$helper = Xfguestbook\Helper::getInstance();

if (\Xmf\Request::hasVar('msg_id', 'GET')) {
    $msg_id = \Xmf\Request::getInt('msg_id', 0, 'GET');
} else {
    $msg_id = \Xmf\Request::getInt('msg_id', 0, 'POST');
}

if (\Xmf\Request::hasVar('op', 'GET')) {
    $op = $_GET['op'];
} elseif (\Xmf\Request::hasVar('op', 'POST')) {
    $op = $_POST['op'];
} else {
    $op = 'show_all';
}

$msgHandler = $helper->getHandler('Message');

//Admin or not
$xoopsUser ? $adminview = $xoopsUser->isAdmin() : $adminview = 0;

/**
 * @param $msg_id
 */
function delete($msg_id)
{
    global $msgHandler, $xoopsModule;
    $ok = \Xmf\Request::getInt('ok', 0, 'POST');
    if (1 == $ok) {
        $msg        = $msgHandler->get($msg_id);
        $del_msg_ok = $msgHandler->delete($msg);
        $filename   = $msg->getVar('photo');
        if ('' !== $filename) {
            $filename = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->getVar('dirname') . '/' . $filename;
            unlink($filename);
        }
        if ($del_msg_ok) {
            $messagesent = MD_XFGUESTBOOK_MSGDELETED;
        } else {
            $messagesent = MD_XFGUESTBOOK_ERRORDEL;
        }
        redirect_header('index.php', 2, $messagesent);
    } else {
        xoops_confirm(['op' => 'delete', 'msg_id' => $msg_id, 'ok' => 1], 'index.php', _DELETE);
    }
}

/**
 * @param $msg_id
 */
function approve($msg_id)
{
    global $msgHandler;

    $msg = $msgHandler->get($msg_id);
    $msg->setVar('moderate', 0);
    if (!$msgHandler->insert($msg)) {
        $messagesent = MD_XFGUESTBOOK_ERRORVALID;
    } else {
        $messagesent = MD_XFGUESTBOOK_VALIDATE;
    }
    redirect_header('index.php?op=show_waiting', 2, $messagesent);
}

/**
 * @param $msg
 */
function xfgb_getmsg($msg)
{
    global $nbmsg, $xoopsModule, $xoopsUser,  $xoopsTpl, $xoopsConfig, $options, $opt, $xoopsDB;
    /** @var Xfguestbook\Helper $helper */
    $helper = Xfguestbook\Helper::getInstance();

    $arr_country = Xfguestbook\Utility::getAllCountry();
    $xoopsTpl->assign('display_msg', true);
    foreach ($msg as $onemsg) {
        if ($poster = Xfguestbook\Utility::get_user_data($onemsg->getVar('user_id'))) {
            $a_msg =& $poster;
        } else {
            $a_msg             = [];
            $a_msg['poster']   = $onemsg->getVar('uname');
            $a_msg['rank']     = '';
            $a_msg['rank_img'] = '';
            $a_msg['avatar']   = '';
        }
        $memberHandler = xoops_getHandler('member');
        $user          = $memberHandler->getUser($onemsg->getVar('user_id'));
        // email
        if ($helper->getConfig('showemail')
            || ($onemsg->getVar('email')
                && ((1 == $user->getVar('user_viewemail')
                     || 0 == $onemsg->getVar('user_id'))
                    && is_object($xoopsUser)))) {
            $a_msg['email'] = "<a href=\"javascript:openWithSelfMain('" . XOOPS_URL . '/modules/xfguestbook/contact.php?msg_id=' . $onemsg->getVar('msg_id') . '\', \'contact\', 600, 450);"><img src="' . XOOPS_URL . '/images/icons/email.gif" alt="' . _SENDEMAILTO . '"></a>';
        }
        // url
        if ($onemsg->getVar('url')) {
            $a_msg['url'] = '<a href="' . $onemsg->getVar('url') . '" target="_blank"><img src="' . XOOPS_URL . '/images/icons/www.gif" alt="' . _VISITWEBSITE . '"></a>';
        }
        // gender
        if ('' !== $onemsg->getVar('gender')) {
            $a_msg['gender'] = '<a href="index.php?op=show_gender&param=' . $onemsg->getVar('gender') . '"><img src="assets/images/' . $onemsg->getVar('gender') . '.gif"</a>';
        }
        // flag
        $country_name = '';
        if ('' !== $onemsg->getVar('country')) {
            if ('other' !== $onemsg->getVar('country')) {
                $flag = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/assets/images/flags/' . $onemsg->getVar('flagdir') . '/' . $onemsg->getVar('country') . '.gif';
                if (array_key_exists($onemsg->getVar('flagdir') . '/' . $onemsg->getVar('country'), $arr_country)) {
                    $country_name = $arr_country[$onemsg->getVar('flagdir') . '/' . $onemsg->getVar('country')];
                }
                if (file_exists($flag)) {
                    $a_msg['country'] = '<img src="' . XOOPS_URL . '/modules/xfguestbook/assets/images/flags/' . $onemsg->getVar('flagdir') . '/' . $onemsg->getVar('country') . '.gif" alt="' . $country_name . '">';
                } else {
                    $a_msg['country'] = $country_name;
                }
                $a_msg['country'] = '<a href="index.php?op=show_country&param=' . $onemsg->getVar('flagdir') . '/' . $onemsg->getVar('country') . '">' . $a_msg['country'] . '</a>';
            } else {
                $a_msg['country'] = $onemsg->getVar('other');
            }
        }
        $a_msg['msg_id']  = $onemsg->getVar('msg_id');
        $a_msg['i']       = $nbmsg;
        $a_msg['title']   = $onemsg->getVar('title');
        $a_msg['date']    = formatTimestamp($onemsg->getVar('post_time'), 's');
        $a_msg['message'] = $onemsg->getVar('message');
        if (1 == $options['opt_url']) {
            $a_msg['message'] = str_replace('target="_blank"', 'target="_blank" rel="nofollow"', $a_msg['message']);
        }
        $a_msg['note_msg']  = $onemsg->getVar('note');
        $a_msg['poster_ip'] = $onemsg->getVar('poster_ip');
        $a_msg['moderate']  = $onemsg->getVar('moderate');
        if (null !== $country_name) {
            $a_msg['local'] = '<a href="index.php?op=show_country&param=' . $onemsg->getVar('flagdir') . '/' . $onemsg->getVar('country') . '">' . $country_name . '</a>';
        }
        $a_msg['photo'] = $onemsg->getVar('photo');
        $xoopsTpl->append('msg', $a_msg);
        $nbmsg--;
    }
}

function xfgb_genderlist()
{
    global $options, $xoopsTpl,  $xoopsModule, $msgHandler;
    /** @var Xfguestbook\Helper $helper */
    $helper = Xfguestbook\Helper::getInstance();
    $criteria = new \Criteria('moderate', 0);
    $arr_msg  = $msgHandler->countMsgByGender($criteria);
    $i        = 0;
    $gender   = [];
    foreach ($arr_msg as $k => $v) {
        if ('M' === $k) {
            $gender[$i] = MD_XFGUESTBOOK_MALES . '<br>';
            $gender[$i] .= '<img src="assets/images/M.gif" alt="' . MD_XFGUESTBOOK_MALES . '"><br><br>';
            $gender[$i] .= '<a href="index.php?op=show_gender&param=M">' . $v . MD_XFGUESTBOOK_MESSAGES . '</a>';
        } elseif ('F' === $k) {
            $gender[$i] = MD_XFGUESTBOOK_FEMALES . '<br>';
            $gender[$i] .= '<img src="assets/images/F.gif" alt="' . MD_XFGUESTBOOK_FEMALES . '"><br><br>';
            $gender[$i] .= '<a href="index.php?op=show_gender&param=F">' . $v . MD_XFGUESTBOOK_MESSAGES . '</a>';
        } else {
            $gender[$i] = MD_XFGUESTBOOK_UNKNOW2 . '<br>';
            $gender[$i] .= '<img src="assets/images/U.gif"><br><br>';
            $gender[$i] .= $v . MD_XFGUESTBOOK_MESSAGES;
        }
        $i++;
    }
    $xoopsTpl->assign('gender', $gender);
    $xoopsTpl->assign('display_gender', $options['opt_gender']);
}

// end functions

// if op = show_***, functions needed
//if (substr($op, 0, 4) == 'show') {
if (0 === strncmp($op, 'show', 4)) {
    $debut = \Xmf\Request::getInt('debut', 0, 'GET');
    $param = \Xmf\Request::getString('param', '', 'GET');

    $GLOBALS['xoopsOption']['template_main'] = 'xfguestbook_index.tpl';
    require_once XOOPS_ROOT_PATH . '/header.php';
    require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/include/config.inc.php';
    $options = getOptions();

    $criteria = new \Criteria('moderate', 0);
    $nbmsg    = $msgHandler->countMsg($criteria);

    $xoopsTpl->assign('msg_message_count', sprintf(MD_XFGUESTBOOK_THEREIS, '<b>' . $nbmsg . '</b>'));
    $xoopsTpl->assign('msg_moderated', $helper->getConfig('moderate'));
    $xoopsTpl->assign('msg_lang_name', $xoopsConfig['language']);
    $xoopsTpl->assign('xoops_pagetitle', $xoopsModule->name() . ' -messages');
    if ($adminview) {
        $nbwait = $msgHandler->countMsg(new \Criteria('moderate', '1'));
        $xoopsTpl->assign('msg_moderate_text', sprintf(MD_XFGUESTBOOK_MODERATING, "<span class='fg2'><a href='" . XOOPS_URL . "/modules/xfguestbook/index.php?op=show_waiting'>" . $nbwait . '</a></span>'));
    }
}

switch ($op) {
    case 'delete':
        if ($adminview) {
            require_once XOOPS_ROOT_PATH . '/header.php';
            delete($msg_id);
        } else {
            redirect_header('index.php', 1, '');
        }
        break;

    case 'approve':
        if ($adminview) {
            require_once XOOPS_ROOT_PATH . '/header.php';
            approve($msg_id);
        } else {
            redirect_header('index.php', 1, '');
        }
        break;

    case 'show_stat':
        if ($options['opt_gender'] > 0) {
            xfgb_genderlist();
        }
        break;

    case 'show_waiting':
        $pagenav = new \XoopsPageNav($nbwait, $helper->getConfig('perpage'), $debut, 'debut', 'op=show_waiting');
        $xoopsTpl->assign('msg_page_nav', $pagenav->renderNav());
        $criteria = new \Criteria('moderate', 1);
        $criteria->setOrder('DESC');
        $criteria->setLimit($helper->getConfig('perpage'));
        $criteria->setStart($debut);
        $msg    = $msgHandler->getObjects($criteria);
        $nbwait -= $debut;
        $nbmsg  = $nbwait;
        xfgb_getmsg($msg);
        break;

    case 'show_one':
        if ($adminview) {
            $criteria = new \Criteria('msg_id', $msg_id);
        } else {
            $criteria = new \CriteriaCompo(new \Criteria('moderate', '0'));
            $criteria->add(new \Criteria('msg_id', $msg_id));
        }
        $msg = $msgHandler->getObjects($criteria);
        xfgb_getmsg($msg);
        if ($options['opt_gender'] > 0) {
            xfgb_genderlist();
        }
        break;

    case 'show_country':
        list($flagdir, $country) = explode('/', $param);
        $criteria = new \CriteriaCompo(new \Criteria('moderate', '0'));
        if ($flagdir == $helper->getConfig('flagdir')) {
            $criteria->add(new \Criteria('flagdir', $flagdir));
        }
        $criteria->add(new \Criteria('country', $country));
        $nbmsg   = $msgHandler->countMsg($criteria);
        $pagenav = new \XoopsPageNav($nbmsg, $helper->getConfig('perpage'), $debut, 'debut', 'op=show_country&param=' . $param);
        $criteria->setOrder('DESC');
        $criteria->setLimit($helper->getConfig('perpage'));
        $criteria->setStart($debut);
        $msg   = $msgHandler->getObjects($criteria);
        $nbmsg -= $debut;
        $xoopsTpl->assign('msg_page_nav', $pagenav->renderNav());
        xfgb_getmsg($msg);
        break;

    case 'show_gender':
        $criteria = new \CriteriaCompo(new \Criteria('moderate', '0'));
        $criteria->add(new \Criteria('gender', $param));
        $nbmsg   = $msgHandler->countMsg($criteria);
        $pagenav = new \XoopsPageNav($nbmsg, $helper->getConfig('perpage'), $debut, 'debut', 'op=show_gender&param=' . $param);
        $criteria->setOrder('DESC');
        $criteria->setLimit($helper->getConfig('perpage'));
        $criteria->setStart($debut);
        $msg   = $msgHandler->getObjects($criteria);
        $nbmsg -= $debut;
        $xoopsTpl->assign('msg_page_nav', $pagenav->renderNav());
        xfgb_getmsg($msg);
        if ($options['opt_gender'] > 0) {
            xfgb_genderlist();
        }
        break;

    case 'show_all':
    default:
        $pagenav = new \XoopsPageNav($nbmsg, $helper->getConfig('perpage'), $debut, 'debut', '');
        $xoopsTpl->assign('msg_page_nav', $pagenav->renderNav());
        $criteria = new \Criteria('moderate', 0);
        $criteria->setOrder('DESC');
        $criteria->setLimit($helper->getConfig('perpage'));
        $criteria->setStart($debut);
        $msg   = $msgHandler->getObjects($criteria);
        $nbmsg -= $debut;
        xfgb_getmsg($msg);
        if ($options['opt_gender'] > 0) {
            xfgb_genderlist();
        }
        break;

    case 'cancel':
        $photos_dir     = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->getVar('dirname');
        $nb_removed_tmp = Xfguestbook\Utility::clear_tmp_files($photos_dir);
        redirect_header('index.php', 0);
        break;
}
$sql = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xfguestbook_country') . ' ORDER BY country_name ASC');

while (false !== ($coun = $xoopsDB->fetchArray($sql))) {
    $sql2 = $xoopsDB->query('SELECT COUNT(country) tot FROM ' . $xoopsDB->prefix('xfguestbook_msg') . " WHERE country='" . $coun['country_code'] . '\'');
    list($tlocal) = $xoopsDB->fetchRow($sql2);
    $tlocal = $tlocal ?: '0';
    if ($tlocal > 0) {
        $opt['<a href="index.php?op=show_country&param=' . $helper->getConfig('flagdir') . '/' . $coun['country_code'] . '">' . $coun['country_name'] . '</a>'] = $tlocal;
    } else {
        $opt[$coun['country_name']] = $tlocal;
    }
}
$xoopsTpl->assign('country_l', $opt);

require_once XOOPS_ROOT_PATH . '/footer.php';
