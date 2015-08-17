<?php
// $Id: upgrade.php,v 1.0 2005/08/08 C. Felix AKA the Cat
// ------------------------------------------------------------------------- //
// XF Guestbook for Xoops                                                          //
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
//---------------------------------------------------------------------------//

include "../../../mainfile.php";
include("admin_header.php");
//include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/msg.php");
include_once '../../../include/cp_functions.php';
include_once '../include/cp_functions.php';

function TableExist($tablename)
{
    global $xoopsDB;
    $tablename = $xoopsDB->prefix($tablename);
    $result=$xoopsDB->queryF("SHOW TABLES LIKE '$tablename'");

    return($xoopsDB->getRowsNum($result) > 0);
}

function FieldType($tablename, $fieldname)
{
    global $xoopsDB;
    $arr = array();
    $sql = "SHOW COLUMNS FROM ".$xoopsDB->prefix($tablename)." LIKE '$fieldname'";
    $result=$xoopsDB->queryF($sql);
    if (!$result) {
        return false;
    } else {
        $myrow = $xoopsDB->fetchArray($result);

        return $myrow['Type'];
    }
}

function CountRows($tablename)
{
    global $xoopsDB;
    $sql = "SELECT * FROM ".$xoopsDB->prefix($tablename);
    $result=$xoopsDB->queryF($sql);
    if (!$result) {
        return 0;
    } else {
        $nbr = $xoopsDB->getRowsNum($result);

        return $nbr;
    }
}

$op= (isset($_POST['op'])? $_POST['op'] : 'check');
foreach ($_POST as $k => $v) {
    ${$k} = $v;
}

switch ($op) {
    case 'check' :
    default:
        xoops_cp_header();
        xfguestbook_admin_menu(99);
        $update = false;
        
// table xfguestbook_config
        $nt = 0;
        $nf = 0;
        $arr_table[$nt]['name'] = 'xfguestbook_config';
        $arr_table[$nt]['version']= _AM_XFGB_ADDED.'2.10';
        if (!TableExist('xfguestbook_config')) {
            $arr_table[$nt]['to_update'] = 1;
            $update = true;
        } elseif (CountRows('xfguestbook_config') != 10) {
            $arr_table[$nt]['to_update'] = 2;
            $update = true;
        } else {
            $arr_table[$nt]['to_update'] = 0;
        }
        
// table xfguestbook_msg
        $nt ++;
        $nf=0;
        $arr_table[$nt]['name']= 'xfguestbook_msg';
        $arr_table[$nt]['version']= '';
        
        if (!TableExist('xfguestbook_msg')) {
            $arr_table[$nt]['to_update'] = 1;
            $update = true;
        } else {
            $arr_table[$nt]['to_update'] = 0;
        }

        $arr_table[$nt]['field'][$nf]['name']='gender';
        $arr_table[$nt]['field'][$nf]['version']= _AM_XFGB_ADDED.'2.10';
        if (!FieldType('xfguestbook_msg', 'gender')) {
            $arr_table[$nt]['field'][$nf]['to_update']= 1;
            $update = true;
        } else {
            $arr_table[$nt]['field'][$nf]['to_update']= 0;
        }
        $nf++;
        
        $arr_table[$nt]['field'][$nf]['name']='country';
        $arr_table[$nt]['field'][$nf]['version']= _AM_XFGB_ADDED.'2.10 - '._AM_XFGB_CHANGED.'2.30';
        $field = FieldType('xfguestbook_msg', 'country');
        if (!$field) {
            $arr_table[$nt]['field'][$nf]['to_update']= 1;
            $update = true;
        } elseif ($field != 'varchar(5)') {
            $arr_table[$nt]['field'][$nf]['to_update']= 2;
            $update = true;
        } else {
            $arr_table[$nt]['field'][$nf]['to_update']= 0;
        }
        $nf++;
        
        $arr_table[$nt]['field'][$nf]['name']='photo';
        $arr_table[$nt]['field'][$nf]['version']= _AM_XFGB_ADDED.'2.20';
        if (!FieldType('xfguestbook_msg', 'photo')) {
            $arr_table[$nt]['field'][$nf]['to_update']= 1;
            $update = true;
        } else {
            $arr_table[$nt]['field'][$nf]['to_update']= 0;
        }
        $nf++;
        
        $arr_table[$nt]['field'][$nf]['name']='flagdir';
        $arr_table[$nt]['field'][$nf]['version']= _AM_XFGB_ADDED.'2.30';
        if (!FieldType('xfguestbook_msg', 'flagdir')) {
            $arr_table[$nt]['field'][$nf]['to_update']= 1;
            $update = true;
        } else {
            $arr_table[$nt]['field'][$nf]['to_update']= 0;
        }
        $nf++;
        
        $arr_table[$nt]['field'][$nf]['name']='other';
        $arr_table[$nt]['field'][$nf]['version']= _AM_XFGB_ADDED.'2.30';
        if (!FieldType('xfguestbook_msg', 'other')) {
            $arr_table[$nt]['field'][$nf]['to_update']= 1;
            $update = true;
        } else {
            $arr_table[$nt]['field'][$nf]['to_update']= 0;
        }
        $nf++;
        
// table xfguestbook_country
        $nt ++;
        $nf=0;
        $arr_table[$nt]['name']= 'xfguestbook_country';
        $arr_table[$nt]['version']= _AM_XFGB_ADDED.'2.10';
        
        if (!TableExist('xfguestbook_country')) {
            $arr_table[$nt]['to_update'] = 1;
            $update = true;
        } else {
            $arr_table[$nt]['to_update'] = 0;
            $arr_table[$nt]['field'][$nf]['name']='country_code';
            $arr_table[$nt]['field'][$nf]['version']= _AM_XFGB_CHANGED.'2.30';
            $field = FieldType('xfguestbook_country', 'country_code');
            if ($field != 'varchar(5)') {
                $arr_table[$nt]['field'][$nf]['to_update']= 2;
                $update = true;
            } else {
                $arr_table[$nt]['field'][$nf]['to_update']= 0;
            }
        }

// table xfguestbook_badips
        $nt ++;
        $nf=0;
        $arr_table[$nt]['name']= 'xfguestbook_badips';
        $arr_table[$nt]['version']= _AM_XFGB_ADDED.'2.40';
        
        if (!TableExist('xfguestbook_badips')) {
            $arr_table[$nt]['to_update'] = 1;
            $update = true;
        }

// affichage tableau		
        echo '<form name="form1" method="post" action="upgrade.php">';
        foreach ($arr_table as $one_table) {
            echo "<table border='1' width='100%' cellpadding ='3' cellspacing='1'>";
            echo '<tr><td width="40%" class="even">';
            echo '<b>'._AM_XFGB_TABLE.$xoopsDB->prefix($one_table['name']).'</b>';
            echo '</td>';
//			echo '<td class="even">';
            if ($one_table['to_update'] > 0) {
                echo '<td width="20%" class = "even"><img src=\''.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/images/ic15_notok.gif\' alt=\'Pas OK\' >';
            } else {
                echo '<td width="20%" class = "even"><img src=\''.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/images/ic15_ok.gif\' alt=\'OK\' >';
            }
            echo '<input type = "hidden" name = "'.$one_table['name'].'_checked" value = "'.$one_table['to_update'].'" >';
            echo '</td>';
            echo '<td class="even">'.$one_table['version'];
            echo '</td>';
            echo '</tr>';
            if (isset($one_table['field'])) {
                foreach ($one_table['field'] as $one_field) {
                    echo '<tr><td width="40%" class = "odd">';
                    echo _AM_XFGB_FIELD.$one_field['name'];
                    echo '</td>';
                    if ($one_field['to_update'] > 0) {
                        echo '<td width="20%" class = "odd"><img src=\''.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/images/ic15_notok.gif\' >';
                    } else {
                        echo '<td width="20%" class = "odd"><img src=\''.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/images/ic15_ok.gif\' >';
                    }
                    echo '<input type = "hidden" name = "'.$one_table['name'].'_'.$one_field['name'].'_checked" value = "'.$one_field['to_update'].'" >';
                    echo '<td  width="40%" class = "odd">'.$one_field['version'];
                    echo '</td>';
                }
            } else {
                echo '<tr><td colspan="3" class = "odd">';
                echo _AM_XFGB_NOCHANGE;
                echo '</td>';
                echo '</tr>';
            }
            echo '</table><br />';
        }
        
        echo "<table border='1' width='100%' ><tr><td class = 'odd'><div align='center'>";
        if ($update) {
            echo _AM_XFGB_WARNING_UPGRADE.'<br><br>';
            echo '<input type="hidden" name="op" value="upgrade" />';
            echo '<input type="submit" name="Submit" value="'._AM_XFGB_UPGRADE_GO.'">';
        } else {
            echo _AM_XFGB_NO_UPGRADE.'<br><br>';
        }
        echo '</div></td></tr></table>';
        echo '</form>';
        xoops_cp_footer();
    break;

    case 'upgrade' :
        xoops_cp_header();
        xfguestbook_admin_menu(99);
        $msg ='';
        if ($xfguestbook_config_checked > 0) {
            $sql = "DROP TABLE ".$xoopsDB->prefix('xfguestbook_config');
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
            $sqlfile = XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname().'/sql/update_config.sql';//create + insert values
            $error = executeSQL($sqlfile);
            $msg .= _AM_XFGB_ERROR.' '.$error.'<br>';
        }
        if ($xfguestbook_msg_checked > 0) {
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook')." RENAME ".$xoopsDB->prefix('xfguestbook_msg') ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook_msg')." CHANGE `xfguestbook_id` `msg_id` INT(11) NOT NULL AUTO_INCREMENT" ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
        }
        if ($xfguestbook_msg_photo_checked > 0) {
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook_msg')." ADD `photo` VARCHAR(25) NOT NULL" ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
        }
        if ($xfguestbook_msg_gender_checked > 0) {
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook_msg')." ADD `gender` TINYINT(1) NOT NULL" ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
        }
        if ($xfguestbook_msg_country_checked == 1) {
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook_msg')." ADD `country` VARCHAR(5) NOT NULL" ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
        }
        if ($xfguestbook_msg_country_checked == 2) {
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook_msg')." CHANGE `country` `country` CHAR(5) NOT NULL" ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
        }
        if ($xfguestbook_msg_flagdir_checked > 0) {
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook_msg')." ADD `flagdir` VARCHAR(20) NOT NULL" ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
            if ($xfguestbook_country_checked == 0) {
                $sql = "UPDATE ".$xoopsDB->prefix('xfguestbook_msg')." SET flagdir = 'world_flags' ";
                $result=$xoopsDB->queryF($sql);
                if (!$result) {
                    $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
                }
    //			$sqlfile = XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname().'/images/flags/world_flags/flags_data.sql';
    //			$msg .= executeSQL($sqlfile);

                $config_handler =& xoops_gethandler('config');
                $criteria = new CriteriaCompo(new Criteria('conf_modid', $xoopsModule->mid()));
                $criteria->add(new Criteria('conf_name', 'flagdir'));
                $config =& $config_handler->getConfigs($criteria);
                $value = array($config[0]->getConfValueForOutput());
                $config[0]->setVar('conf_value', 'world_flags');
                if (!$config_handler->insertConfig($config[0])) {
                    $msg .= "Could not insert flagdir config <bt />";
                }
            }
        }
        if ($xfguestbook_msg_other_checked == 1) {
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook_msg')." ADD `other`VARCHAR(20) NOT NULL" ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
        }

        if ($xfguestbook_country_checked > 0) {
            $sqlfile = XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname().'/sql/create_country.sql';//create only
            $error = executeSQL($sqlfile);
            $msg .= _AM_XFGB_ERROR.' '.$error.'<br>';
        } elseif ($xfguestbook_country_country_code_checked > 1) {
            $sql = "ALTER TABLE ".$xoopsDB->prefix('xfguestbook_country')." CHANGE `country_code` `country_code` CHAR(5) NOT NULL" ;
            $result=$xoopsDB->queryF($sql);
            if (!$result) {
                $msg .= _AM_XFGB_ERROR.' '.$sql.'<br>';
            }
        }
        
        if ($xfguestbook_badips_checked > 0) {
            $sqlfile = XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname().'/sql/create_badips.sql';//create only
            $error = executeSQL($sqlfile);
            $msg .= _AM_XFGB_ERROR.' '.$error.'<br>';
        }
        
        if ($msg == '') {
            echo _AM_XFGB_UPGRADE_SUCCESS;
        }
        xoops_cp_footer();
    break;
}
