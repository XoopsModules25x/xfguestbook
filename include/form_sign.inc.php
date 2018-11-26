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

use XoopsModules\Xfguestbook;

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

/** @var Xfguestbook\Helper $helper */
$helper = Xfguestbook\Helper::getInstance();

//xoopsSecurity don't work with this form ???
//$signform = new \XoopsThemeForm(MD_XFGUESTBOOK_SIGN, 'signform', 'xfcreate.php','post', true);
$signform = new \XoopsThemeForm(MD_XFGUESTBOOK_SIGN, 'signform', 'xfcreate.php');
$signform->setExtra("enctype='multipart/form-data'");

$name_text = new \XoopsFormText(MD_XFGUESTBOOK_NAME, 'name', 50, 100, $name);
if ($xoopsUser) {
    $name_text->setExtra("readonly = 'readonly'");
}
$signform->addElement($name_text, true);

if ($option['opt_gender']) {
    $gender_text = new \XoopsFormSelect(MD_XFGUESTBOOK_GENDER, 'gender', $gender);
    $options     = ['' => MD_XFGUESTBOOK_UNKNOW, 'M' => MD_XFGUESTBOOK_MALE, 'F' => MD_XFGUESTBOOK_FEMALE];
    $gender_text->addOptionArray($options);
    $signform->addElement($gender_text, true);
}

// affichage pays
if ($option['opt_country']) {
    $country_text = new \XoopsModules\Xfguestbook\Form\FormSelectCountry($helper->getConfig('country_caption'), 'country', $country, 1, true);
    $country_text->setExtra('onchange="test_other(this.value)"');
    $signform->addElement($country_text, true);
    //  $other_text = new \XoopsFormText('other', 'other', 50, 50, $other);
    $other_text = new \XoopsFormText('other', 'other', 50, 50);
    $signform->addElement($other_text);
}
$uman_text = new \XoopsFormText('uman', 'uman', 50, 100, $name);
$signform->addElement($uman_text);
if ($option['opt_mail'] > 0) {
    $email_text = new \XoopsFormText(MD_XFGUESTBOOK_EMAIL, 'email', 50, 100, $email);
    $signform->addElement($email_text, $option['opt_mail'] > 1);
}

if ($option['opt_website'] > 1 || (1 == $option['opt_website'] && $xoopsUser)) {
    $url_text = new \XoopsFormText(MD_XFGUESTBOOK_URL, 'url', 50, 100, $url);
    $signform->addElement($url_text);
}

$title_text = new \XoopsFormText(MD_XFGUESTBOOK_TITLE, 'title', 60, 100, $title);
$signform->addElement($title_text, true);

if (0 == $option['opt_icon']) {
    $signform->addElement(new \XoopsFormTextArea(MD_XFGUESTBOOK_MESSAGE, 'message', $message, 6, 40), true);
} else {
    $option['opt_icon'] = ($option['opt_url'] > 1) ? 0 : $option['opt_icon'];
    $signform->addElement(new \XoopsFormDhtmlTextArea(MD_XFGUESTBOOK_MESSAGE, 'message', $message, 6, 40), true);
}

// upload image
if ($helper->getConfig('photo_maxsize') > 0) {
    $file_tray = new \XoopsFormElementTray(MD_XFGUESTBOOK_ADDIMG, '', 'photo');
    $file_img  = new \XoopsFormFile('', 'photo', $helper->getConfig('photo_maxsize'));
    $file_img->setExtra("size ='40'");
    $file_tray->addElement($file_img);
    $msg        = sprintf(MD_XFGUESTBOOK_IMG_CONFIG, (int)($helper->getConfig('photo_maxsize') / 1000), $helper->getConfig('photo_maxwidth'), $helper->getConfig('photo_maxheight'));
    $file_label = new \XoopsFormLabel('', '<br>' . $msg);
    $file_tray->addElement($file_label);
    $signform->addElement($file_tray);
}

if (1 == $option['opt_url'] && $option['opt_icon'] > 0) {
    $xoopsTpl->assign('nofollow', true);
}

$button_tray = new \XoopsFormElementTray('', '&nbsp;', 'button');
if (1 == $option['opt_code']) {
    //$button_tray->addElement(new \XoopsFormCaptcha('', 'xoopscaptcha', '',''), true);
    $button_tray->addElement(new \XoopsFormCaptcha(), true);
} else {
    $xoopsTpl->assign('reg_form', '*');
}
$button_tray->addElement(new \XoopsFormButton('', 'preview', _PREVIEW, 'submit'));
$button_tray->addElement(new \XoopsFormButton('', 'post', _SUBMIT, 'submit'));
$button_cancel = new \XoopsFormButton('', 'cancel', _CANCEL, 'button');
$button_cancel->setExtra("onclick='location=\"index.php?op=cancel\";'");
$button_tray->addElement($button_cancel);
$signform->addElement($button_tray);

$signform->addElement(new \XoopsFormHidden('user_id', $user_id));
$signform->addElement(new \XoopsFormHidden('preview_name', $preview_name));
