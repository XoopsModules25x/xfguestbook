<?php
//
//  ------------------------------------------------------------------------ //
//             XF Guestbook                                                  //
//  ------------------------------------------------------------------------ //
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
//system menu
$moduleDirName = basename(__DIR__);

$modversion['version']        = '3.2';
$modversion['status_version'] = 'Beta 1';
$modversion['release_date']   = '2017/01/18';
$modversion['name']           = MI_XFGB_NAME;
$modversion['description']    = MI_XFGB_DESC;
$modversion['credits']        = 'phppp : randomscript, randomimage';
$modversion['author']         = 'the Cat';
$modversion['contributors']   = 'Paul Mar alias Winsion';
$modversion['help']           = 'page=help';
$modversion['license']        = 'GNU GPL 2.0';
$modversion['license_url']    = 'www.gnu.org/licenses/gpl-2.0.html/';

$modversion['official'] = 0;
$modversion['image']    = 'assets/images/logoModule.png';
$modversion['dirname']  = basename(__DIR__);
//$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
//$modversion['icons16']        = 'Frameworks/moduleclasses/icons/16';
//$modversion['icons32']        = 'Frameworks/moduleclasses/icons/32';
$modversion['modicons16'] = 'assets/images/icons/16';
$modversion['modicons32'] = 'assets/images/icons/32';

// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'] = [
    $moduleDirName . '_' . 'msg',
    $moduleDirName . '_' . 'config',
    $moduleDirName . '_' . 'country',
    $moduleDirName . '_' . 'badips',
];

//Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => MI_XFGB_OVERVIEW, 'link' => 'page=help'],
    ['name' => MI_XFGB_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => MI_XFGB_LICENSE, 'link' => 'page=license'],
    ['name' => MI_XFGB_SUPPORT, 'link' => 'page=support'],

    //    array('name' => MI_XFGB_HELP1, 'link' => 'page=help1'),
    //    array('name' => MI_XFGB_HELP2, 'link' => 'page=help2'),
    //    array('name' => MI_XFGB_HELP3, 'link' => 'page=help3'),
    //    array('name' => MI_XFGB_HELP4, 'link' => 'page=help4'),
    //    array('name' => MI_XFGB_HOWTO, 'link' => 'page=__howto'),
    //    array('name' => MI_XFGB_REQUIREMENTS, 'link' => 'page=__requirements'),
    //    array('name' => MI_XFGB_CREDITS, 'link' => 'page=__credits'),

];

// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'xfguestbook_search';

// Templates
$modversion['templates'][1]['file']        = 'xfguestbook_index.tpl';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file']        = 'xfguestbook_item.tpl';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file']        = 'xfguestbook_signform.tpl';
$modversion['templates'][3]['description'] = '';

//about
$modversion['module_website_url']  = 'http://www.xoops.org/';
$modversion['module_website_name'] = 'XOOPS';
$modversion['author_website_url']  = 'http://www.FolsomLiving.com/';
$modversion['author_website_name'] = 'Metalslug';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.8';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.1'];
$modversion['system_menu']         = 1;

// Config Settings
// anonymious can post
$modversion['config'][1] = [
    'name'        => 'anonsign',
    'title'       => 'MI_XFGB_ANONSIGN',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0'
];
// Moderate
$modversion['config'][] = [
    'name'        => 'moderate',
    'title'       => 'MI_XFGB_MODERATE',
    'description' => 'MI_XFGB_MODERATEDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0'
];
// send mail to webmaster
$modversion['config'][] = [
    'name'        => 'sendmail2wm',
    'title'       => 'MI_XFGB_SENDMAIL',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0'
];
// show mail
$modversion['config'][] = [
    'name'        => 'showemail',
    'title'       => 'MI_XFGB_SHOWEMAIL',
    'description' => 'MI_XFGB_SHOWEMAIL_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0'
];
// number messages per page
$modversion['config'][] = [
    'name'        => 'perpage',
    'title'       => 'MI_XFGB_NBMSG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '5'
];
// number flags per row
$modversion['config'][] = [
    'name'        => 'flagsperrow',
    'title'       => 'MI_XFGB_NBFLAGS',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => '3',
    'options'     => [4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9]
];
// Display avatar and rank
$modversion['config'][] = [
    'name'        => 'display_avatar',
    'title'       => 'MI_XFGB_AVATAR',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1'
];
// Photo max size
$modversion['config'][] = [
    'name'        => 'photo_maxsize',
    'title'       => 'MI_XFGB_MAXSIZEIMG',
    'description' => 'MI_XFGB_MAXSIZEIMG_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '30000'
];

// Photo max height
$modversion['config'][] = [
    'name'        => 'photo_maxheight',
    'title'       => 'MI_XFGB_MAXHEIGHTIMG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '120'
];

// Photo max width
$modversion['config'][] = [
    'name'        => 'photo_maxwidth',
    'title'       => 'MI_XFGB_MAXWIDTHIMG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '200'
];

// name of flagpack
$modversion['config'][] = [
    'name'        => 'country_caption',
    'title'       => 'MI_XFGB_COUNTRY_CAPTION',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => MI_XFGB_COUNTRY
];

// Directory and sql name of flagpack
$modversion['config'][] = [
    'name'        => 'flagdir',
    'title'       => 'MI_XFGB_FLAGDIR',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => ''
];

// Blocks
$modversion['blocks'][1]['file']        = 'xfguestbook_new.php';
$modversion['blocks'][1]['name']        = '_MB_XFGUESTBOOK_BNAME1';
$modversion['blocks'][1]['description'] = 'Shows recently added donwload files';
$modversion['blocks'][1]['show_func']   = 'b_xfguestbook_show';
$modversion['blocks'][1]['edit_func']   = 'b_xfguestbook_edit';
$modversion['blocks'][1]['options']     = '5|19';
$modversion['blocks'][1]['template']    = 'xfguestbook_block_new.tpl';

//if (!file_exists(XOOPS_ROOT_PATH . '/uploads/xfguestbook')) {
//    mkdir(XOOPS_ROOT_PATH . '/uploads/xfguestbook', 0777);
//}
