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

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/xfgbformselectcountry.php';

$msg_form = new XoopsThemeForm(_AM_XFGB_NAME, 'msg_form', 'main.php', 'post', true);
$msg_form->setExtra("enctype='multipart/form-data'");

$date_text = new XoopsFormLabel(_AM_XFGB_DATE, formatTimestamp($msg->getVar('post_time', 'S')));
$msg_form->addElement($date_text);

$poster_ip_text = new XoopsFormLabel(_AM_XFGB_IP, $msg->getVar('poster_ip', 'S'));
$msg_form->addElement($poster_ip_text);

$uname_text = new XoopsFormText(_AM_XFGB_NAME, 'uname', 50, 255, $msg->getVar('uname', 'E'));
$msg_form->addElement($uname_text);

$gender_text = new XoopsFormRadio(_AM_XFGB_GENDER, 'gender', $msg->getVar('gender', 'E'));
//  $gender_text = new XoopsFormSelect(_MD_XFGB_SEXE, "gender", $msg->getVar("gender", "E"));
$options = array('M' => _AM_XFGB_MALE, 'F' => _AM_XFGB_FEMALE, '' => _AM_XFGB_GENDER_UNKNOW);
$gender_text->addOptionArray($options);
$msg_form->addElement($gender_text, true);

//if (trim($option['opt_country']) != '') {
$country_tray = new XoopsFormElementTray(_AM_XFGB_COUNTRY, '');
$flag         = XOOPS_ROOT_PATH
                . '/modules/'
                . $xoopsModule->dirname()
                . '/assets/images/flags/'
                . $msg->getVar('flagdir')
                . '/'
                . $msg->getVar('country')
                . '.gif';
if (file_exists($flag)) {
    $country_tray->addElement(new XoopsFormLabel('', "<img src='"
                                                     . XOOPS_URL
                                                     . '/modules/'
                                                     . $xoopsModule->dirname()
                                                     . '/assets/images/flags/'
                                                     . $msg->getVar('flagdir')
                                                     . '/'
                                                     . $msg->getVar('country')
                                                     . ".gif' name='image' id='image' alt='' /><br><br>"));
}
$country_tray->addElement(new XfgbFormSelectCountry('', 'country', $msg->getVar('country', 'E'), 1, true));
$country_tray->addElement(new XoopsFormText(_AM_XFGB_IF_OTHER, 'other', 20, 20, $msg->getVar('other', 'E')));
$msg_form->addElement($country_tray, false);
//}

$email_text = new XoopsFormText(_AM_XFGB_EMAIL, 'email', 50, 255, $msg->getVar('email', 'E'));
$msg_form->addElement($email_text);

$url_text = new XoopsFormText(_AM_XFGB_URL, 'url', 50, 255, $msg->getVar('url', 'E'));
$msg_form->addElement($url_text);

$msg_form->insertBreak('<b>' . _AM_XFGB_MESSAGE . '</b>', 'bg3');

$title_text = new XoopsFormText(_AM_XFGB_TITLE, 'title', 50, 255, $msg->getVar('title', 'E'));
$msg_form->addElement($title_text);

$message_text = new XoopsFormDhtmlTextArea(_AM_XFGB_MESSAGE, 'message', $msg->getVar('message', 'E'));
$msg_form->addElement($message_text);

$file_tray = new XoopsFormElementTray(_AM_XFGB_IMG, '');
if ($msg->getVar('photo')) {
    $file_tray->addElement(new XoopsFormLabel('', "<img src='"
                                                  . XOOPS_UPLOAD_URL
                                                  . '/'
                                                  . $xoopsModule->getVar('dirname')
                                                  . '/'
                                                  . $msg->getVar('photo')
                                                  . "' name='image' id='image' alt='' /><br><br>"));
    $check_del_img = new XoopsFormCheckBox('', 'del_img');
    $check_del_img->addOption(1, _AM_XFGB_DELIMG);
    $file_tray->addElement($check_del_img);
    $file_img = new XoopsFormFile(_AM_XFGB_REPLACEIMG, 'photo', $xoopsModuleConfig['photo_maxsize']);
    $file_img->setExtra("size ='40'");
} else {
    $file_img = new XoopsFormFile('', 'photo', $xoopsModuleConfig['photo_maxsize']);
    $file_img->setExtra("size ='40'");
}
$file_tray->addElement($file_img);
$msg_form->addElement($file_tray);

$msg_form->insertBreak('<b>' . _AM_XFGB_WM . '</b>', 'bg3');
$note_text = new XoopsFormDhtmlTextArea(_AM_XFGB_NOTE, 'note', $msg->getVar('note', 'E'));
$msg_form->addElement($note_text);

$moderate_text = new XoopsFormRadio(_AM_XFGB_APPROVE, 'moderate', $msg->getVar('moderate', 'E'));
$options       = array(0 => _YES, 1 => _NO);
$moderate_text->addOptionArray($options);
$msg_form->addElement($moderate_text);

$msg_form->addElement(new XoopsFormHidden('msg_id', $msg_id));
$msg_form->addElement(new XoopsFormHidden('user_id', $msg->getVar('user_id')));
$msg_form->addElement(new XoopsFormHidden('op', 'save'));
$msg_form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
