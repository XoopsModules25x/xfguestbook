<?php
// $Id: admin/index.php,v 2.21 2005/11/09 C. Felix alias the Cat
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

include '../../../include/cp_header.php';
include_once '../include/cp_functions.php';
include_once 'admin_header.php';
// Flag
$maxsize = 2000;
$maxheight = 50;
$maxwidth = 80;
$format = "gif";
        
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} elseif (isset($_POST['op'])) {
    $op = $_POST['op'];
} else {
    $op ='countryShow';
}
    
if (isset($_GET['country_id'])) {
    $country_id = intval($_GET['country_id']);
} elseif (isset($_POST['country_id'])) {
    $country_id = intval($_POST['country_id']);
} else {
    $country_id = 0;
}
    
if (isset($_GET['country_code'])) {
    $country_code = $_GET['country_code'];
} elseif (isset($_POST['country_code'])) {
    $country_code = $_POST['country_code'];
} else {
    $country_code = '';
}

$start        = isset($_GET['start']) ? intval($_GET['start']) : 0;
$country_name= isset($_POST['country_name']) ? $_POST['country_name'] : '';

function flagUpload($country_code)
{
    global $xoopsModule, $xoopsModuleConfig, $maxsize, $maxwidth, $maxheight, $format;
    $array_allowed_mimetypes = array("image/".$format) ;
        // photos
        if (!empty($_FILES['photo']['name'])) {
            $ext = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $_FILES['photo']['name']) ;
            include_once(XOOPS_ROOT_PATH."/class/uploader.php");
            $field = $_POST["xoops_upload_file"][0] ;
            if (!empty($field) || $field != "") {
                // Check if file uploaded
                if ($_FILES[$field]['tmp_name'] == "" || ! is_readable($_FILES[$field]['tmp_name'])) {
                    redirect_header('country_manager.php', 2, _MD_XFGB_FILEERROR) ;
                    exit ;
                }
                $photos_dir = XOOPS_ROOT_PATH . "/modules/".$xoopsModule->dirname()."/images/flags/".$xoopsModuleConfig['flagdir'] ;
                $uploader = new XoopsMediaUploader($photos_dir, $array_allowed_mimetypes, $maxsize, $maxwidth, $maxheight) ;
                $uploader->setPrefix('tmp') ;
                if ($uploader->fetchMedia($field) && $uploader->upload()) {
                    $tmp_name = $uploader->getSavedFileName() ;
                    $ext = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $tmp_name) ;
                    $photo = $country_code.".".$ext;
                    if (file_exists($photos_dir.'/'.$photo)) {
                        unlink($photos_dir.'/'.$photo);
                    }
                    rename("$photos_dir/$tmp_name", "$photos_dir/$photo") ;
                } else {
                    redirect_header("country_manager.php", 2, $uploader->getErrors());
                    exit();
                }
            }
            redirect_header("country_manager.php", 2, _AM_XFGB_FILEUPLOADED);
        } else {
            redirect_header("country_manager.php?op=flagForm&amp;country_code=".$country_code, 2, _MD_XFGB_NOIMGSELECTED);
        }
    exit();
}

function flagForm($country_code)
{
    global $xoopsModule, $xoopsModuleConfig, $maxsize, $maxwidth, $maxheight, $format;
    include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    
    $flagform = new XoopsThemeForm(_AM_XFGB_SUBMITFLAG, "op", xoops_getenv('PHP_SELF'));
    $flagform->setExtra("enctype='multipart/form-data'") ;
    
    $flag = "/modules/".$xoopsModule->dirname()."/images/flags/".$xoopsModuleConfig['flagdir']."/".$country_code.".gif";
    if (file_exists(XOOPS_ROOT_PATH.$flag)) {
        $flag_img = "<img src='".XOOPS_URL.$flag."'>";
        $img_flag = new XoopsFormLabel('', "<br />".$flag_img."<br />");
        $flagform->addElement($img_flag);
    }
    $flag_desc = sprintf(_AM_XFGB_FLAGDSC, $maxsize, $maxwidth, $maxheight, $format);
    $flagform->addElement(new XoopsFormLabel('', $flag_desc));
    
    $img_text = new XoopsFormFile(_AM_XFGB_ADDIMG, "photo", 30000);
    $img_text->setExtra("size ='60'") ;
    $flagform->addElement($img_text);
    
    $button_tray = new XoopsFormElementTray('', '');
    $button_tray->addElement(new XoopsFormButton('', 'post', _SEND, 'submit'));
    $button_tray->addElement(new XoopsFormHidden('country_code', $country_code));
    $button_tray->addElement(new XoopsFormHidden('op', 'flagUpload'));
    $flagform->addElement($button_tray);
    
    $flagform->display();
}

function flagDel($country_code)
{
    global $xoopsModule, $xoopsModuleConfig;
    $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;
    if ($ok == 1) {
        $flag = "/modules/".$xoopsModule->dirname()."/images/flags/".$xoopsModuleConfig['flagdir']."/".$country_code.".gif";
        if (file_exists(XOOPS_ROOT_PATH.$flag)) {
            unlink(XOOPS_ROOT_PATH.$flag);
        }
        redirect_header("country_manager.php", 2, _AM_XFGB_FLAGDELETED);
    } else {
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation('country_manager.php');
        xoops_confirm(array('op' => 'flagDel', 'country_code' => $country_code, 'ok' => 1), 'country_manager.php', _AM_XFGB_CONFDELFLAG);
        include "admin_footer.php";
        //xoops_cp_footer();
    }
}

function countryForm($country_id=null)
{
    include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
        
    if ($country_id) {
        $sform = new XoopsThemeForm(_AM_XFGB_MODCOUNTRY, "op", xoops_getenv('PHP_SELF'));
        $arr_country = xfgb_getCountry('country_id='.$country_id, 0, 0);
        $country_code = $arr_country[0]['country_code'];
        $country_name = $arr_country[0]['country_name'];
    } else {
        $sform = new XoopsThemeForm(_AM_XFGB_ADDCOUNTRY, "op", xoops_getenv('PHP_SELF'));
        $country_code ='';
        $country_name = '';
    }
            
    $text_code = new XoopsFormText(_AM_XFGB_FLAGCODE, 'country_code', 5, 5, $country_code);
    if ($country_id) {
        $text_code->setExtra("readonly = 'readonly'") ;
    }
    $sform->addElement($text_code, true);
    $sform->addElement(new XoopsFormText(_AM_XFGB_FLAGNAME, 'country_name', 50, 50, $country_name), true);
            
    $button_tray = new XoopsFormElementTray('', '');
    $button_tray->addElement(new XoopsFormButton('', 'save', _SUBMIT, 'submit'));
    if ($country_id) {
        $button_tray->addElement(new XoopsFormHidden('country_id', $country_id));
    }
    $button_tray->addElement(new XoopsFormHidden('op', 'countrySave'));
    $sform->addElement($button_tray);
    $sform->display();
}

function xfgb_getCountry($criteria = null, $limit=0, $start=0)
{
    global $xoopsDB, $action;
    $ret = array();

    $sql = "SELECT * FROM ".$xoopsDB->prefix("xfguestbook_country");
    if (isset($criteria) && $criteria !='') {
        $sql .= ' WHERE '.$criteria;
    }
    $sql .= " ORDER BY country_name ASC";
    $result = $xoopsDB->query($sql, $limit, $start);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        array_push($ret, $myrow);
    }

    return $ret;
}

function countryDel($country_id)
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
    $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;
    if ($ok == 1) {
        $arr_country = xfgb_getCountry('country_id='.$country_id, 0, 0);
        $flag = "/modules/".$xoopsModule->dirname()."/images/flags/".$xoopsModuleConfig['flagdir']."/".$arr_country[0]['country_code'].".gif";
        $sql = "DELETE FROM ".$xoopsDB->prefix("xfguestbook_country")." WHERE country_id=$country_id";
        $result=$xoopsDB->query($sql);
        if (file_exists(XOOPS_ROOT_PATH.$flag)) {
            unlink(XOOPS_ROOT_PATH.$flag);
        }
        redirect_header("country_manager.php", 1, _AM_XFGB_COUNTRYDELETED);
    } else {
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation('country_manager.php');
        xoops_confirm(array('op' => 'countryDel', 'country_id' => $country_id, 'ok' => 1), 'country_manager.php', _AM_XFGB_CONFDELCOUNTRY);
        include "admin_footer.php";
        //xoops_cp_footer();
    }
}

function countrySave($country_id, $country_code, $country_name)
{
    global $xoopsDB;
        
    $myts =& MyTextSanitizer::getInstance();
    //$country_code=$myts->makeTboxData4Save::$country_code;
    //$country_name=$myts->makeTboxData4Save::$country_name;
    echo $country_code;
    if (!empty($country_id)) {
        $sql = "UPDATE ".$xoopsDB->prefix("xfguestbook_country")." SET country_code='$country_code', country_name='$country_name'";
        $sql .= " WHERE country_id=$country_id";
        $xoopsDB->query($sql);
        $messagesent = _AM_XFGB_COUNTRY_UPDATED;
    } else {
        $sql = sprintf("SELECT COUNT(*) FROM  %s WHERE country_code = '%s'", $xoopsDB->prefix("xfguestbook_country"), $country_code);
        list($count) = $xoopsDB->fetchRow($xoopsDB->query($sql));
        if ($count > 0) {
            $messagesent = '<font color="#FF0000">'._AM_XFGB_COUNTRY_EXIST.'</font>';
        } else {
            $country_id = $xoopsDB->genId('country_id_seq');
            $sql = sprintf("INSERT INTO %s (country_id, country_code, country_name) VALUES (%s, '%s', '%s')", $xoopsDB->prefix("xfguestbook_country"), $country_id, $country_code, $country_name);
            $xoopsDB->query($sql);
            $messagesent = _AM_XFGB_COUNTRY_ADDED;
        }
    }
    redirect_header("country_manager.php", 2, $messagesent);
    exit();
}

function countryShow()
{
    global $action, $start, $xoopsModule, $xoopsModuleConfig, $pathIcon16;
    $myts =& MyTextSanitizer::getInstance();
    $limit = 15;
    $arr_country = xfgb_getCountry('', $limit, $start);
    $scount = count(xfgb_getCountry('', $limit, 0));
    $totalcount = count(xfgb_getCountry('', 0, 0));
        
    echo "
	<table width='100%' cellspacing='1' cellpadding='2' border='0' style='border-left: 1px solid silver; border-top: 1px solid silver; border-right: 1px solid silver;'>
		<tr>
			<td><span style='font-weight: bold; font-size: 12px; font-variant: small-caps;'>" ._AM_XFGB_DISPCOUNTRY." : ".$totalcount."</span></td>
			<td align='right'>
			</td>
		</tr>
	</table>";

    echo "<table border='1' width='100%' cellpadding ='2' cellspacing='1'>";
    echo "<tr class='bg3'>";
    echo "<td align='center'><b>"._AM_XFGB_FLAGIMG."</td>";
    echo "<td align='center'><b>"._AM_XFGB_FLAGCODE."</td>";
    echo "<td align='center'><b>"._AM_XFGB_FLAGNAME."</td>";
    echo "<td align='center'><b>"._AM_XFGB_COUNTRY."</td></b>";
    echo "<td align='center'><b>"._AM_XFGB_FLAGIMG."</td></b>";
    echo "</tr>";

    if (count($arr_country) == '0') {
        echo "<tr ><td align='center' colspan ='10' class = 'head'><b>"._AM_XFGB_NOFLAG."</b></td></tr>";
    }

    for ($i = 0; $i < count($arr_country); $i++) {
        $all_country = array();
        $flag = "/modules/".$xoopsModule->dirname()."/images/flags/".$xoopsModuleConfig['flagdir']."/".$arr_country[$i]['country_code'].".gif";
        if (file_exists(XOOPS_ROOT_PATH.$flag)) {
            $all_country['flag_img'] = "<img src='".XOOPS_URL.$flag."'>";
        } else {
            $all_country['flag_img'] = "<img src='".XOOPS_URL."/images/blank.gif'>";
        }

        $all_country['country_id'] = $arr_country[$i]['country_id'];
        $all_country['country_code'] = $arr_country[$i]['country_code'];
        $all_country['country_name'] = $arr_country[$i]['country_name'];
        $all_country['msg_action'] = "<a href='country_manager.php?op=countryEdit&amp;country_id=".$arr_country[$i]['country_id']."'><img src='".$pathIcon16."/edit.png'></a>";
        $all_country['msg_action'] .= "&nbsp;<a href='country_manager.php?op=countryDel&amp;country_id=".$arr_country[$i]['country_id']."'><img src='".$pathIcon16."/delete.png'></a>";
        $all_country['flag_action'] = "<a href='country_manager.php?op=flagForm&amp;country_code=".$arr_country[$i]['country_code']."'><img src='".$pathIcon16."/add.png'></a>";
        $all_country['flag_action'] .= "&nbsp;<a href='country_manager.php?op=flagDel&amp;country_code=".$arr_country[$i]['country_code']."'><img src='".$pathIcon16."/delete.png'></a>";
        echo "<tr><td align='center' class = 'head'><b>".$all_country['flag_img']."</b>";
        echo "</td><td class = 'even'>".$all_country['country_code']."";
        echo "</td><td class = 'odd'>".$all_country['country_name']."";
        echo "</td><td align='center' class='even'>".$all_country['msg_action']."";
        echo "</td><td align='center' class='even'>".$all_country['flag_action']."";
        echo "</td></tr>";
        unset($all_country);
    }

    echo "</table><br />";

    if ($totalcount > $scount) {
        include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
        $pagenav = new XoopsPageNav($totalcount, $limit, $start, 'start', 'action='.$action);
        echo "<div style='text-align: center;' class = 'head'>".$pagenav->renderNav()."</div><br />";
    } else {
        echo '';
    }
    echo"<br />";
}

switch ($op) {
    case "flagForm":
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation('country_manager.php');
        //xfguestbook_admin_menu(2);
        flagForm($country_code);
        include "admin_footer.php";
        //xoops_cp_footer();
        break;
    case "flagUpload":
        flagUpload($country_code);
        break;
    case "flagDel":
        flagDel($country_code);
        break;
    case "countryDel":
        countryDel($country_id);
        break;
    case "countryEdit":
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation('country_manager.php');
        //xfguestbook_admin_menu(2);
        countryForm($country_id);
        include "admin_footer.php";
        //xoops_cp_footer();
        break;
    case "countrySave":
        countrySave($country_id, $country_code, $country_name);
        break;
    case "countryAdd":
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation('country_manager.php');
        //xfguestbook_admin_menu(2);
        countryForm();
        include "admin_footer.php";
        //xoops_cp_footer();
        break;
    case "countryShow":
    default:
        xoops_cp_header();
        $index_admin = new ModuleAdmin();
        echo $index_admin->addNavigation('country_manager.php');
        //xfguestbook_admin_menu(2);
        countryShow();
        countryForm();
        include "admin_footer.php";
        //xoops_cp_footer();
    break;
}
