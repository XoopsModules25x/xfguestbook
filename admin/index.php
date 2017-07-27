<?php

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author     XOOPS Development Team
 */

include_once __DIR__ . '/admin_header.php';
xoops_cp_header();

//$adminObject = \Xmf\Module\Admin::getInstance();

$folder[]   = '/uploads/xfguestbook/';
$result     = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('xfguestbook_msg') . ' WHERE   moderate>0');
list($totalWaitingMsg) = $xoopsDB->fetchRow($result);
if ($totalWaitingMsg > 0) {
    $totalWaitingMsg = "<span style='color: #ff0000; font-weight: bold;'>{$totalWaitingMsg}</span>";
}

$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('xfguestbook_msg') . ' WHERE   moderate=0');
list($totalModerateMsg) = $xoopsDB->fetchRow($result);

$adminObject->addInfoBox(MD_XFGUESTBOOK_MSGCONF);
/*
if (0 == $totalWaitingMsg) {
    //$adminObject->addLineLabel(MD_XFGUESTBOOK_MSGCONF, MD_XFGUESTBOOK_MSGWAITING, $totalNewMsg, 'Green');
    $adminObject->addInfoBoxLine(MD_XFGUESTBOOK_MSGWAITING, $totalWaitingMsg, 'Green');
} else {
    $adminObject->addInfoBoxLine(MD_XFGUESTBOOK_MSGWAITING, $totalWaitingMsg, 'Red');
}

if (0 < $totalModerateMsg) {
    //$adminObject->addLineLabel(MD_XFGUESTBOOK_MSGWAITING, $totalNewMsg, 'Green');
    $adminObject->addInfoBoxLine(MD_XFGUESTBOOK_MSGMODERATE, $totalModerateMsg, 'Green');
} else {
    $adminObject->addInfoBoxLine(MD_XFGUESTBOOK_MSGMODERATE, $totalModerateMsg, 'Red');
}

foreach (array_keys($folder) as $i) {
    $adminObject->addConfigBoxLine(XOOPS_ROOT_PATH . $folder[$i], 'folder');
    $adminObject->addConfigBoxLine(array(XOOPS_ROOT_PATH . $folder[$i], '777'), 'chmod');
}
*/
$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayIndex();

include __DIR__ . '/admin_footer.php';
