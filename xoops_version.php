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
require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

// ------------------- Informations ------------------- //
$modversion = [
    'version'             => '3.21.0',
    'module_status'       => 'Beta 2',
    'release_date'        => '2019/07/16',
    'name'                => MI_XFGUESTBOOK_NAME,
    'description'         => MI_XFGUESTBOOK_DESC,
    'official'            => 0,
    //1 indicates official XOOPS module supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'the Cat',
    'credits'             => 'XOOPS Development Team, phppp: randomscript, randomimage, Paul Mar alias Winsion',
    'author_mail'         => 'author-email',
    'author_website_url'  => 'https://xoops.org',
    'author_website_name' => 'XOOPS',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',
    // ------------------- Folders & Files -------------------
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . "/modules/$moduleDirName/docs/changelog.txt",

    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/$moduleDirName/docs/install.txt",
    // images
    'image'               => 'assets/images/logoModule.png',
    'iconsmall'           => 'assets/images/iconsmall.png',
    'iconbig'             => 'assets/images/iconbig.png',
    'dirname'             => $moduleDirName,
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    //About
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb/viewforum.php?forum=28/',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // ------------------- Min Requirements -------------------
    'min_php'             =>  '7.1',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5'],
    // ------------------- Admin Menu -------------------
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // ------------------- Main Menu -------------------
    'hasMain'             => 1,
    'sub'                 => [
        //        [
        //            'name' => MI_XFGUESTBOOK_VIEW_SEARCH,
        //            'url'  => 'index.php'
        //        ],
        [
            'name' => MI_XFGUESTBOOK_CREATE,
            'url'  => 'xfcreate.php',
        ],
    ],

    // ------------------- Install/Update -------------------
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php',
    //  'onUninstall'         => 'include/onuninstall.php',
    // -------------------  PayPal ---------------------------
    'paypal'              => [
        'business'      => 'xoopsfoundation@gmail.com',
        'item_name'     => 'Donation : ' . MI_XFGUESTBOOK_NAME,
        'amount'        => 25,
        'currency_code' => 'USD',
    ],
    // ------------------- Search ---------------------------
    'hasSearch'           => 1,
    'search'              => [
        'file' => 'include/search.inc.php',
        'func' => 'xfguestbook_search',
    ],
    // ------------------- Comments -------------------------
    //    'hasComments'         => 1,
    //    'comments'            => [
    //        'pageName'     => 'dog.php',
    //        'itemName'     => 'id',
    //        'callbackFile' => 'include/comment_functions.php',
    //        'callback'     => [
    //            'approve' => 'picture_comments_approve',
    //            'update'  => 'picture_comments_update'
    //        ],
    //    ],
    // ------------------- Notification ----------------------
    //    'hasNotification'     => 1,
    //    'notification'        => [
    //        'lookup_file' => 'include/notification.inc.php',
    //        'lookup_func' => 'lookup',
    //        'category'    => [
    //            'name'           => 'dog',
    //            'title'          => MI_XFGUESTBOOK_DOG_NOTIFY,
    //            'description'    => MI_XFGUESTBOOK_DOG_NOTIFY_DSC,
    //            'subscribe_from' => [
    //                'dog.php',
    //                'pedigree.php'
    //            ],
    //            'item_name'      => 'id',
    //            'allow_bookmark' => 1
    //        ],
    //        'event'       => [
    //            'name'          => 'change_data',
    //            'category'      => 'dog',
    //            'title'         => MI_XFGUESTBOOK_DATA_NOTIFY,
    //            'caption'       => MI_XFGUESTBOOK_DATA_NOTIFYCAP,
    //            'description'   => MI_XFGUESTBOOK_DATA_NOTIFYDSC,
    //            'mail_template' => 'dog_data_notify',
    //            'mail_subject'  => MI_XFGUESTBOOK_DATA_NOTIFYSBJ
    //        ],
    //    ],
    // ------------------- Mysql -----------------------------
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables'              => [
        $moduleDirName . '_' . 'msg',
        $moduleDirName . '_' . 'config',
        $moduleDirName . '_' . 'country',
        $moduleDirName . '_' . 'badips',
    ],
];

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => MI_XFGUESTBOOK_OVERVIEW, 'link' => 'page=help'],
    ['name' => MI_XFGUESTBOOK_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => MI_XFGUESTBOOK_LICENSE, 'link' => 'page=license'],
    ['name' => MI_XFGUESTBOOK_SUPPORT, 'link' => 'page=support'],
];

// ------------------- Templates ------------------- //

$modversion['templates'] = [
    ['file' => 'xfguestbook_index.tpl', 'description' => ''],
    ['file' => 'xfguestbook_item.tpl', 'description' => ''],
    ['file' => 'xfguestbook_signform.tpl', 'description' => ''],
];

// ------------------- Blocks ------------------- //

$modversion['blocks'][] = [
    'file'        => 'xfguestbook_new.php',
    'name'        => MI_XFGUESTBOOK_BNAME1,
    'description' => MI_XFGUESTBOOK_BNAME1_DESC,
    'show_func'   => 'b_xfguestbook_show',
    'edit_func'   => 'b_xfguestbook_edit',
    'template'    => 'xfguestbook_block_new.tpl',
    'can_clone'   => true,
    'options'     => '5|19',
];

// Config Settings
// anonymious can post
$modversion['config'][1] = [
    'name'        => 'anonsign',
    'title'       => 'MI_XFGUESTBOOK_ANONSIGN',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];
// Moderate
$modversion['config'][] = [
    'name'        => 'moderate',
    'title'       => 'MI_XFGUESTBOOK_MODERATE',
    'description' => 'MI_XFGUESTBOOK_MODERATEDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];
// send mail to webmaster
$modversion['config'][] = [
    'name'        => 'sendmail2wm',
    'title'       => 'MI_XFGUESTBOOK_SENDMAIL',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];
// show mail
$modversion['config'][] = [
    'name'        => 'showemail',
    'title'       => 'MI_XFGUESTBOOK_SHOWEMAIL',
    'description' => 'MI_XFGUESTBOOK_SHOWEMAIL_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];
// number messages per page
$modversion['config'][] = [
    'name'        => 'perpage',
    'title'       => 'MI_XFGUESTBOOK_NBMSG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '5',
];
// number flags per row
$modversion['config'][] = [
    'name'        => 'flagsperrow',
    'title'       => 'MI_XFGUESTBOOK_NBFLAGS',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => '3',
    'options'     => [4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9],
];
// Display avatar and rank
$modversion['config'][] = [
    'name'        => 'display_avatar',
    'title'       => 'MI_XFGUESTBOOK_AVATAR',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
];
// Photo max size
$modversion['config'][] = [
    'name'        => 'photo_maxsize',
    'title'       => 'MI_XFGUESTBOOK_MAXSIZEIMG',
    'description' => 'MI_XFGUESTBOOK_MAXSIZEIMG_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '30000',
];

// Photo max height
$modversion['config'][] = [
    'name'        => 'photo_maxheight',
    'title'       => 'MI_XFGUESTBOOK_MAXHEIGHTIMG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '120',
];

// Photo max width
$modversion['config'][] = [
    'name'        => 'photo_maxwidth',
    'title'       => 'MI_XFGUESTBOOK_MAXWIDTHIMG',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '200',
];

// name of flagpack
$modversion['config'][] = [
    'name'        => 'country_caption',
    'title'       => 'MI_XFGUESTBOOK_COUNTRY_CAPTION',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => MI_XFGUESTBOOK_COUNTRY,
];

// Directory and sql name of flagpack
$modversion['config'][] = [
    'name'        => 'flagdir',
    'title'       => 'MI_XFGUESTBOOK_FLAGDIR',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '',
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

//if (!file_exists(XOOPS_ROOT_PATH . '/uploads/xfguestbook')) {
//    mkdir(XOOPS_ROOT_PATH . '/uploads/xfguestbook', 0777);
//}
