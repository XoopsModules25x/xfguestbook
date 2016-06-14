<?php
// $Id: admin/menu.php,v 2.20 2005/08/10 C. Felix alias the Cat
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
$dirname        = basename(dirname(__DIR__));
$module_handler = xoops_getHandler('module');
$xoopsModule    = $module_handler->getByDirname($dirname);
$pathIcon32     = $xoopsModule->getInfo('icons32');

$i                      = 1;
$adminmenu[$i]['title'] = _MI_XFGB_ADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['desc']  = _MI_XFGB_ADMIN_HOME_DESC;
$adminmenu[$i]['icon']  = '../../' . $pathIcon32 . '/home.png';
$i++;
$adminmenu[$i]['title'] = _MI_XFGB_MSG_MANAGE;
$adminmenu[$i]['link']  = 'admin/main.php';
$adminmenu[$i]['icon']  = 'assets/images/admin/manage.png';
$i++;
$adminmenu[$i]['title'] = _MI_XFGB_CONF_FORM;
$adminmenu[$i]['link']  = 'admin/config.php';
$adminmenu[$i]['icon']  = 'assets/images/admin/config.png';
$i++;
$adminmenu[$i]['title'] = _MI_XFGB_COUNTRYMANAGE;
$adminmenu[$i]['link']  = 'admin/country_manager.php';
$adminmenu[$i]['icon']  = 'assets/images/admin/flag.png';
$i++;
$adminmenu[$i]['title'] = _AM_XFGB_INSTALL_IMG;
$adminmenu[$i]['link']  = 'admin/flags_install.php';
$adminmenu[$i]['icon']  = 'assets/images/admin/flag_in.png';
$i++;
$adminmenu[$i]['title'] = _AM_XFGB_IMG_MANAGER;
$adminmenu[$i]['link']  = 'admin/img_manager.php';
$adminmenu[$i]['icon']  = 'assets/images/admin/image.png';
$i++;
$adminmenu[$i]['title'] = _AM_XFGB_IP;
$adminmenu[$i]['link']  = 'admin/ip_manager.php';
$adminmenu[$i]['icon']  = 'assets/images/admin/stop.png';
$i++;
$adminmenu[$i]['title'] = _MI_XFGB_ADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = '../../' . $pathIcon32 . '/about.png';
