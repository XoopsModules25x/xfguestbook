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

// require_once  dirname(__DIR__) . '/class/Helper.php';
//require_once  dirname(__DIR__) . '/include/common.php';
$helper = Xfguestbook\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');


$adminmenu[] = [
    'title' => MI_XFGUESTBOOK_ADMIN_HOME,
    'link'  => 'admin/index.php',
    'desc'  => MI_XFGUESTBOOK_ADMIN_HOME_DESC,
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => MI_XFGUESTBOOK_MSG_MANAGE,
    'link'  => 'admin/main.php',
    'icon'  => 'assets/images/admin/manage.png',
];

$adminmenu[] = [
    'title' => MI_XFGUESTBOOK_CONF_FORM,
    'link'  => 'admin/config.php',
    'icon'  => 'assets/images/admin/config.png',
];

$adminmenu[] = [
    'title' => MI_XFGUESTBOOK_COUNTRYMANAGE,
    'link'  => 'admin/country_manager.php',
    'icon'  => 'assets/images/admin/flag.png',
];

$adminmenu[] = [
    'title' => AM_XFGUESTBOOK_INSTALL_IMG,
    'link'  => 'admin/flags_install.php',
    'icon'  => 'assets/images/admin/flag_in.png',
];

$adminmenu[] = [
    'title' => AM_XFGUESTBOOK_IMG_MANAGER,
    'link'  => 'admin/img_manager.php',
    'icon'  => 'assets/images/admin/image.png',
];

$adminmenu[] = [
    'title' => MI_XFGUESTBOOK_IP,
    'link'  => 'admin/ip_manager.php',
    'icon'  => 'assets/images/admin/stop.png',
];

$adminmenu[] = [
    'title' => MI_XFGUESTBOOK_ADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
