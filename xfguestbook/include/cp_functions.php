<?php
// $Id: include/cp_functions.php,v 1.3 2006/01/01 C.Felix AKA the Cat
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

function xfguestbook_admin_menu($currentoption = 0, $breadcrumb = '')
{
    
    /* Nice buttons styles */
    echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/xfguestbook/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/xfguestbook/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/xfguestbook/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";
    
    global $xoopsModule, $xoopsConfig;
    $myts = &MyTextSanitizer::getInstance();
    
    $tblColors = array();
    $tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = $tblColors[6] = $tblColors[7] = $tblColors[8] = '';
    $tblColors[$currentoption] = 'current';
    if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
        include_once XOOPS_ROOT_PATH . '/modules/xfguestbook/language/' . $xoopsConfig['language'] . '/modinfo.php';
    } else {
        include_once XOOPS_ROOT_PATH . '/modules/xfguestbook/english/modinfo.php';
    }
    
    echo "<div id='buttontop'>";
    echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
    //echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "\">" . _AM_SF_OPTS . "</a> | <a href=\"import.php\">" . _AM_SF_IMPORT . "</a> | <a href=\"../index.php\">" . _AM_SF_GOMOD . "</a> | <a href=\"../help/index.html\" target=\"_blank\">" . _AM_SF_HELP . "</a> | <a href=\"about.php\">" . _AM_SF_ABOUT . "</a></td>";
    echo "<td style='font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;'>
	  <a class='nobutton' href='" . XOOPS_URL . "/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "'>" . _AM_XFGB_GENERALSET . "</a> 
	| <a href='" . XOOPS_URL . "/modules/xfguestbook/index.php'>" . _AM_XFGB_GOINDEX. "</a> 
	| <a href='" . XOOPS_URL . "/modules/xfguestbook/admin/flags_install.php'>" . _AM_XFGB_INSTALL_IMG. "</a> 
	| <a href='" . XOOPS_URL . "/modules/xfguestbook/admin/upgrade.php'>" . _AM_XFGB_UPGRADE. "</a> 
	| <a href='" . XOOPS_URL . "/modules/xfguestbook/admin/img_manager.php'>" . _AM_XFGB_MSGIMG. "</a> 
	</td>";
    echo "<td style='font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'><b>" . $myts->displayTarea($xoopsModule->name()) . " </b> </td>";
    echo "</tr></table>";
    echo "</div>";
    
    echo "<div id='buttonbar'>";
    echo "<ul>";
    echo "<li id='" . $tblColors[0] . "'><a href=\"" . XOOPS_URL . "/modules/xfguestbook/admin/index.php\"><span>" . _AM_XFGB_MSGMANAGE . "</span></a></li>";
    echo "<li id='" . $tblColors[1] . "'><a href=\"" . XOOPS_URL . "/modules/xfguestbook/admin/config.php\"><span>" . _AM_XFGB_FORMOPT . "</span></a></li>";
    echo "<li id='" . $tblColors[2] . "'><a href=\"" . XOOPS_URL . "/modules/xfguestbook/admin/country_manager.php\"><span>" . _AM_XFGB_COUNTRYMANAGE . "</span></a></li>";
    echo "<li id='" . $tblColors[3] . "'><a href=\"" . XOOPS_URL . "/modules/xfguestbook/admin/ip_manager.php\"><span>" . _AM_XFGB_BADIPSMANAGE . "</span></a></li>";
    echo "</ul></div>&nbsp;";
}

function executeSQL($sql_file_path)
{
    global $xoopsModule;
    $error = false;
// $reservedTables = array('avatar', 'avatar_users_link', 'block_module_link', 'xoopscomments', 'config', 'configcategory', 'configoption', 'image', 'imagebody', 'imagecategory', 'imgset', 'imgset_tplset_link', 'imgsetimg', 'groups','groups_users_link','group_permission', 'online', 'bannerclient', 'banner', 'bannerfinish', 'ranks', 'session', 'smiles', 'users', 'newblocks', 'modules', 'tplfile', 'tplset', 'tplsource', 'xoopsnotifications', 'banner', 'bannerclient', 'bannerfinish');
//   $sql_file_path = XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/sql/".$sqlfile;
   if (!file_exists($sql_file_path)) {
       echo "SQL file not found at <b>$sql_file_path</b><br />";
//	   $msg = "SQL file not found at <b>$sql_file_path</b><br />";
       $error = true;
   } else {
       echo "SQL file found at <b>$sql_file_path</b>.<br  /> Creating tables...<br />";
//		$msg = "SQL file found at <b>$sql_file_path</b>.<br  /> Creating tables...<br />";
        include_once XOOPS_ROOT_PATH.'/class/database/sqlutility.php';
       $sql_query = fread(fopen($sql_file_path, 'r'), filesize($sql_file_path));
       $sql_query = trim($sql_query);
       SqlUtility::splitMySqlFile($pieces, $sql_query);
       $created_tables = array();
       foreach ($pieces as $piece) {
           // [0] contains the prefixed query
            // [4] contains unprefixed table name
            $prefixed_query = SqlUtility::prefixQuery($piece, $GLOBALS['xoopsDB']->prefix());
           if (!$prefixed_query) {
               //				$msg = "<b>$piece</b> is not a valid SQL!<br />";
                echo "<b>$piece</b> is not a valid SQL!<br />";
               $error = true;
               break;
           }
            // check if the table name is reserved
            //if (!in_array($prefixed_query[4], $reservedTables)) {
            // not reserved, so try to create one
            if (!$GLOBALS['xoopsDB']->query($prefixed_query[0])) {
                //$this->setErrors($GLOBALS['xoopsDB']->error());
                echo "erreur<br />";
                $error = true;
                break;
            } else {
                if (!in_array($prefixed_query[4], $created_tables)) {
                    //					$msg = '&nbsp;&nbsp;Table <b>'.$GLOBALS['xoopsDB']->prefix($prefixed_query[4]).'</b> created.<br />';
                    echo '&nbsp;&nbsp;Table <b>'.$GLOBALS['xoopsDB']->prefix($prefixed_query[4]).'</b> created.<br />';
                    $created_tables[] = $prefixed_query[4];
                } else {
                    echo '&nbsp;&nbsp;Data inserted to table <b>'.$GLOBALS['xoopsDB']->prefix($prefixed_query[4]).'</b>.<br />';
//					$msg = '&nbsp;&nbsp;Data inserted to table <b>'.$GLOBALS['xoopsDB']->prefix($prefixed_query[4]).'</b>.<br />';
                }
            }
//		} else {
// 			the table name is reserved, so halt the installation
//			$this->setErrors('<b>'.$prefixed_query[4]."</b> is a reserved table!");
//			$error = true;
//			break;
//		}
       }
// 		if there was an error, delete the tables created so far, so the next installation will not fail
        if ($error == true) {
            foreach ($created_tables as $ct) {
                //echo $ct;
            $GLOBALS['xoopsDB']->query("DROP TABLE ".$GLOBALS['xoopsDB']->prefix($ct));
            }
        }
   }
//}
return $error;
}
