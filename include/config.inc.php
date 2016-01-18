<?php
// $Id: include/config.inc.php,v 1.11 2004/12/02 C.Felix AKA the Cat
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

function getOptions()
{
    global $xoopsDB;
    $sql = "SELECT conf_name, conf_value FROM ".$xoopsDB->prefix("xfguestbook_config");
    $result = $xoopsDB->query($sql);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $arr_conf[$myrow['conf_name']] = $myrow['conf_value'];
    }

    return $arr_conf;
}

function getOptions4Admin()
{
    global $xoopsDB;
    $sql = "SELECT conf_id, conf_name, conf_value FROM ".$xoopsDB->prefix("xfguestbook_config");
    $result = $xoopsDB->query($sql);
    $i=0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $arr_conf[$i]['conf_id'] = $myrow['conf_id'];
        $arr_conf[$i]['conf_name'] = $myrow['conf_name'];
        $arr_conf[$i]['conf_value'] = $myrow['conf_value'];
        $arr_conf[$i]['conf_formtype'] = $myrow['conf_formtype'];
        $i++;
    }

    return $arr_conf;
}
