<?php
/**
 * ****************************************************************************
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  XOOPS Project     
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         
 * @author 	   		
 *
 * Version : $Id:
 * ****************************************************************************
 */

include_once __DIR__ . '/admin_header.php';
xoops_cp_header();

$indexAdmin = new ModuleAdmin();
$folder[] = '/uploads/xfguestbook/';
$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("xfguestbook_msg") . " WHERE 	moderate>0");
list($totalWaitingMsg) = $xoopsDB->fetchRow($result);
if ($totalWaitingMsg > 0) {
    $totalWaitingMsg = "<span style='color: #ff0000; font-weight: bold'>{$totalWaitingMsg}</span>";
}

$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("xfguestbook_msg") . " WHERE 	moderate=0");
list($totalModerateMsg) = $xoopsDB->fetchRow($result);

$indexAdmin->addInfoBox(_MD_XFGB_MSGCONF);

if (0 == $totalWaitingMsg) {
    //$indexAdmin->addLineLabel(_MD_XFGB_MSGCONF, _MD_XFGB_MSGWAITING, $totalNewMsg, 'Green');
    $indexAdmin->addInfoBoxLine(_MD_XFGB_MSGCONF, _MD_XFGB_MSGWAITING, $totalWaitingMsg, 'Green');
} else {
    $indexAdmin->addInfoBoxLine(_MD_XFGB_MSGCONF, _MD_XFGB_MSGWAITING, $totalWaitingMsg, 'Red');
}

if (0 < $totalModerateMsg) {
    //$indexAdmin->addLineLabel(_MD_XFGB_MSGCONF, _MD_XFGB_MSGWAITING, $totalNewMsg, 'Green');
    $indexAdmin->addInfoBoxLine(_MD_XFGB_MSGCONF, _MD_XFGB_MSGMODERATE, $totalModerateMsg, 'Green');
} else {
    $indexAdmin->addInfoBoxLine(_MD_XFGB_MSGCONF, _MD_XFGB_MSGMODERATE, $totalModerateMsg, 'Red');
}

foreach (array_keys($folder) as $i) {
    $indexAdmin->addConfigBoxLine(XOOPS_ROOT_PATH.$folder[$i], 'folder');
    $indexAdmin->addConfigBoxLine(array(XOOPS_ROOT_PATH.$folder[$i], '777'), 'chmod');
}
echo $indexAdmin->addNavigation('index.php');
echo $indexAdmin->renderIndex();

include __DIR__ . '/admin_footer.php';
