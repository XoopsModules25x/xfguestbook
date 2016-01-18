<?php
// $Id: xoops_version.php,v 1.81 2006/03/18 C.Felix alias the Cat$
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

$modversion['name']         = _MI_XFGB_NAME;
$modversion['version']      = '3.1';
$modversion['description']  = _MI_XFGB_DESC;
$modversion['credits']      = 'phppp : randomscript, randomimage';
$modversion['author']       = 'the Cat';
$modversion['contributors'] = 'Paul Mar alias Winsion';
$modversion['help']         = 'page=help';
$modversion['license']      = 'GNU GPL 2.0';
$modversion['license_url']  = 'www.gnu.org/licenses/gpl-2.0.html/';

$modversion['official']       = 0;
$modversion['image']          = 'assets/images/module_logo.png';
$modversion['dirname']        = 'xfguestbook';
$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16']        = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32']        = 'Frameworks/moduleclasses/icons/32';

// Sql file
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0]        = 'xfguestbook_msg';
$modversion['tables'][1]        = 'xfguestbook_config';
$modversion['tables'][2]        = 'xfguestbook_country';
$modversion['tables'][3]        = 'xfguestbook_badips';

//Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;

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
$modversion['status_version']      = 'RC';
$modversion['release_date']        = '2011/09/09';
$modversion['module_website_url']  = 'http://www.xoops.org/';
$modversion['module_website_name'] = 'XOOPS';
$modversion['module_status']       = 'RC';
$modversion['author_website_url']  = 'http://www.FolsomLiving.com/';
$modversion['author_website_name'] = 'Metalslug';
$modversion['min_php']             = 5.2;
$modversion['min_xoops']           = '2.5.0';
$modversion['min_admin']           = '1.1';
$modversion['min_db']              = array('mysql' => '5.0.7', 'mysqli' => '5.0.7');
$modversion['system_menu']         = 1;

// Config Settings
// anonymious can post
$modversion['config'][1] = array(
    'name'        => 'anonsign',
    'title'       => '_MI_XFGB_ANONSIGN',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0');
// Moderate
$modversion['config'][] = array(
    'name'        => 'moderate',
    'title'       => '_MI_XFGB_MODERATE',
    'description' => '_MI_XFGB_MODERATEDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0');
// send mail to webmaster
$modversion['config'][] = array(
    'name'        => 'sendmail2wm',
    'title'       => '_MI_XFGB_SENDMAIL',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0');
// show mail
$modversion['config'][] = array(
    'name'        => 'showemail',
    'title'       => '_MI_XFGB_SHOWEMAIL',
    'description' => '_MI_XFGB_SHOWEMAIL_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0');
// number messages per page
$modversion['config'][] = array(
    'name'        => 'perpage',
    'title'       => '_MI_XFGB_NBMSG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '5');
// number flags per row
$modversion['config'][] = array(
    'name'        => 'flagsperrow',
    'title'       => '_MI_XFGB_NBFLAGS',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => '3',
    'options'     => array(4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9));
// Display avatar and rank
$modversion['config'][] = array(
    'name'        => 'display_avatar',
    'title'       => '_MI_XFGB_AVATAR',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1');
// Photo max size
$modversion['config'][] = array(
    'name'        => 'photo_maxsize',
    'title'       => '_MI_XFGB_MAXSIZEIMG',
    'description' => '_MI_XFGB_MAXSIZEIMG_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '30000',);

// Photo max height
$modversion['config'][] = array(
    'name'        => 'photo_maxheight',
    'title'       => '_MI_XFGB_MAXHEIGHTIMG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '120',);

// Photo max width
$modversion['config'][] = array(
    'name'        => 'photo_maxwidth',
    'title'       => '_MI_XFGB_MAXWIDTHIMG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '200',);

// name of flagpack
$modversion['config'][] = array(
    'name'        => 'country_caption',
    'title'       => '_MI_XFGB_COUNTRY_CAPTION',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => _MI_XFGB_COUNTRY,);

// Directory and sql name of flagpack
$modversion['config'][] = array(
    'name'        => 'flagdir',
    'title'       => '_MI_XFGB_FLAGDIR',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '',);

// Blocks
$modversion['blocks'][1]['file']        = 'xfguestbook_new.php';
$modversion['blocks'][1]['name']        = _MB_XFGUESTBOOK_BNAME1;
$modversion['blocks'][1]['description'] = 'Shows recently added donwload files';
$modversion['blocks'][1]['show_func']   = 'b_xfguestbook_show';
$modversion['blocks'][1]['edit_func']   = 'b_xfguestbook_edit';
$modversion['blocks'][1]['options']     = '5|19';
$modversion['blocks'][1]['template']    = 'xfguestbook_block_new.tpl';

if (!file_exists(XOOPS_ROOT_PATH . '/uploads/xfguestbook')) {
    mkdir(XOOPS_ROOT_PATH . '/uploads/xfguestbook', 0777);
}
