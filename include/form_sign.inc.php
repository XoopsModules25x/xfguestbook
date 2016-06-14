<?php
// $Id: include/form_sign.inc.php, v 1.40 2006/03/01 C. Felix AKA the Cat
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

//xoopsSecurity don't work with this form ???
//$signform = new XoopsThemeForm(_MD_XFGB_SIGN, 'signform', 'xfcreate.php','post', true);
$signform = new XoopsThemeForm(_MD_XFGB_SIGN, 'signform', 'xfcreate.php');
$signform->setExtra("enctype='multipart/form-data'") ;

$name_text = new XoopsFormText(_MD_XFGB_NAME, 'name', 50, 100, $name);
if ($xoopsUser) {
    $name_text->setExtra("readonly = 'readonly'") ;
}
$signform->addElement($name_text, true);

if ($option['opt_gender']) {
    $gender_text = new XoopsFormSelect(_MD_XFGB_GENDER, 'gender', $gender);
    $options = array('' => _MD_XFGB_UNKNOW, 'M' =>_MD_XFGB_MALE, 'F' => _MD_XFGB_FEMALE);
    $gender_text->addOptionArray($options);
    $signform->addElement($gender_text, true);
}

// affichage pays
if ($option['opt_country']) {
    $country_text = new XfgbFormSelectCountry($xoopsModuleConfig['country_caption'], 'country', $country, 1, true);
    $country_text->setExtra('onchange="test_other(this.value)"');
    $signform->addElement($country_text, true);
//  $other_text = new XoopsFormText('other', 'other', 50, 50, $other);
    $other_text = new XoopsFormText('other', 'other', 50, 50);
    $signform->addElement($other_text);
}
$uman_text=new XoopsFormText('uman', 'uman', 50, 100, $uman);
$signform->addElement($uman_text);
if ($option['opt_mail'] > 0) {
    $email_text = new XoopsFormText(_MD_XFGB_EMAIL, 'email', 50, 100, $email);
    $signform->addElement($email_text, $option['opt_mail'] > 1);
}

if ($option['opt_website'] > 1 || ($option['opt_website'] == 1 && $xoopsUser)) {
    $url_text = new XoopsFormText(_MD_XFGB_URL, 'url', 50, 100, $url);
    $signform->addElement($url_text);
}

$title_text = new XoopsFormText(_MD_XFGB_TITLE, 'title', 60, 100, $title);
$signform->addElement($title_text, true);

if ($option['opt_icon'] == 0) {
    $signform->addElement(new XoopsFormTextArea(_MD_XFGB_MESSAGE, 'message', $message, 6, 40), true);
} else {
    $option['opt_icon'] = ($option['opt_url'] > 1) ? 0 : $option['opt_icon'];
    $signform->addElement(new XoopsFormDhtmlTextArea(_MD_XFGB_MESSAGE, 'message', $message, 6, 40), true);
}

    // upload image
    if ($xoopsModuleConfig['photo_maxsize'] > 0) {
        $file_tray = new XoopsFormElementTray(_MD_XFGB_ADDIMG, '', 'photo');
        $file_img = new XoopsFormFile('', 'photo', $xoopsModuleConfig['photo_maxsize']);
        $file_img->setExtra("size ='40'") ;
        $file_tray->addElement($file_img);
        $msg = sprintf(_MD_XFGB_IMG_CONFIG, (int)($xoopsModuleConfig['photo_maxsize']/1000), $xoopsModuleConfig['photo_maxwidth'], $xoopsModuleConfig['photo_maxheight']);
        $file_label = new XoopsFormLabel('', '<br>'.$msg);
        $file_tray->addElement($file_label);
        $signform->addElement($file_tray);
    }

    if ($option['opt_url'] == 1 && $option['opt_icon'] > 0) {
        $xoopsTpl->assign('nofollow', true);
    }

$button_tray = new XoopsFormElementTray('', '&nbsp;', 'button');
if ($option['opt_code']==1) {
    //$button_tray->addElement(new XoopsFormCaptcha('', 'xoopscaptcha', '',''), true);
    $button_tray->addElement(new XoopsFormCaptcha(), true);
} else {
    $xoopsTpl->assign('reg_form', '*');
}
$button_tray->addElement(new XoopsFormButton('', 'preview', _PREVIEW, 'submit'));
$button_tray->addElement(new XoopsFormButton('', 'post', _SEND, 'submit'));
$button_cancel = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
$button_cancel->setExtra("onclick='location=\"index.php?op=cancel\";'");
$button_tray->addElement($button_cancel);
$signform->addElement($button_tray);

$signform->addElement(new XoopsFormHidden('user_id', $user_id));
$signform->addElement(new XoopsFormHidden('preview_name', $preview_name));
