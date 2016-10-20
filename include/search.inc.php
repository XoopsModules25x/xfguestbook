<?php
//
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

/**
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $user_id
 * @return array
 */
function xfguestbook_search($queryarray, $andor, $limit, $offset, $user_id)
{
    global $xoopsDB;
    $sql = 'SELECT msg_id,user_id,title,post_time FROM ' . $xoopsDB->prefix('xfguestbook_msg') . ' WHERE moderate=0 ';
    if (0 != $user_id) {
        $sql .= ' AND user_id=' . $user_id . ' ';
    }
    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((message LIKE '%$queryarray[0]%' OR title LIKE '%$queryarray[0]%')";
        for ($i=1;$i<$count;$i++) {
            $sql .= " $andor ";
            $sql .= "(message LIKE '%$queryarray[$i]%' OR title LIKE '%$queryarray[$i]%')";
        }
        $sql .= ') ';
    }
    $sql .= 'ORDER BY post_time DESC';
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret = array();
    $i = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$i]['image'] = 'assets/images/xfguestbook.gif';
        $ret[$i]['link'] = 'index.php?op=show_one&msg_id=' . $myrow['msg_id'] . '';
        $ret[$i]['title'] = $myrow['title'];
        $ret[$i]['time'] = $myrow['post_time'];
        $ret[$i]['uid'] = $myrow['user_id'];
        $i++;
    }

    return $ret;
}
