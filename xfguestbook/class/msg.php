<?php
// $Id: msg.php, v 2.20 2005/08/12 C. Felix alias the Cat
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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

if (!defined("XOOPS_ROOT_PATH")) {
    die('XOOPS root path not defined');
}
class xfguestbookMsg extends XoopsObject {
    // constructor
	function xfguestbookMsg()
	{
		$this->XoopsObject();
		$this->initVar("msg_id", XOBJ_DTYPE_INT, null, false);
		$this->initVar("user_id", XOBJ_DTYPE_INT, null, false);	 
		$this->initVar("uname", XOBJ_DTYPE_TXTBOX, '', false);
		$this->initVar("title", XOBJ_DTYPE_TXTBOX, '', true);
		$this->initVar("message", XOBJ_DTYPE_TXTAREA, '', false);
		$this->initVar("note", XOBJ_DTYPE_TXTAREA, '', false);
		$this->initVar("post_time", XOBJ_DTYPE_STIME, null, false);
		$this->initVar("email", XOBJ_DTYPE_EMAIL, '', false);
		$this->initVar("url", XOBJ_DTYPE_URL, '', false);
		$this->initVar("poster_ip", XOBJ_DTYPE_OTHER, '', false);
		$this->initVar("moderate", XOBJ_DTYPE_INT, null, false);
		$this->initVar("gender", XOBJ_DTYPE_TXTBOX, '', false,1);
		$this->initVar("country", XOBJ_DTYPE_TXTBOX, '', false,5);
		$this->initVar('photo', XOBJ_DTYPE_TXTBOX, '', false); // added v2.20
		$this->initVar("flagdir", XOBJ_DTYPE_TXTBOX, '', false); // added v2.30
		$this->initVar('other', XOBJ_DTYPE_TXTBOX, '', false); // added v2.30
	}
}

class xfguestbookMsgHandler
{
	var $db;

	function xfguestbookMsgHandler(&$db)
	{
		$this->db =& $db;
	}

	function create()
	{
		return new xfguestbookMsg();
	}

	function get($id)
	{
		$id = intval($id);
		if ($id > 0) {
			$sql = "SELECT * FROM ".$this->db->prefix("xfguestbook_msg")." WHERE msg_id=".$id ;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$msg = new xfguestbookMsg();
				$msg->assignVars($this->db->fetchArray($result));
				return $msg;
			}
		}
		return false;
	}

	function insert($msg)
	{
		if (strtolower(get_class($msg)) != 'xfguestbookmsg') {
			return false;
		}
		if (!$msg->cleanVars()) {
			return false;
		}
		foreach ($msg->cleanVars as $k => $v) {
			${$k} = $v;
		}
		if (empty($msg_id)) {
			$msg_id = $this->db->genId('xfguestbook_msg_msg_id_seq');
			$sql = 'INSERT INTO '.$this->db->prefix('xfguestbook_msg').' (msg_id, user_id, uname, title, message, note, post_time, email, url, poster_ip, moderate, gender, country, photo, flagdir, other) VALUES ('.$msg_id.','.$user_id.', '.$this->db->quoteString($uname).', '.$this->db->quoteString($title).', '.$this->db->quoteString($message).', '.$this->db->quoteString($note).', '.$post_time.',  '.$this->db->quoteString($email).', '.$this->db->quoteString($url).', '.$this->db->quoteString($poster_ip).', '.$moderate.', '.$this->db->quoteString($gender).', '.$this->db->quoteString($country).', '.$this->db->quoteString($photo).', '.$this->db->quoteString($flagdir).', '.$this->db->quoteString($other).')';
		} else {
			$sql = 'UPDATE '.$this->db->prefix('xfguestbook_msg').' SET user_id='.$user_id.', uname='.$this->db->quoteString($uname).', title='.$this->db->quoteString($title).', message='.$this->db->quoteString($message).', note='.$this->db->quoteString($note).', email='.$this->db->quoteString($email).', url='.$this->db->quoteString($url).', moderate='.$moderate.', gender='.$this->db->quoteString($gender).', country='.$this->db->quoteString($country).', photo='.$this->db->quoteString($photo).', flagdir='.$this->db->quoteString($flagdir).', other='.$this->db->quoteString($other).' WHERE msg_id='.$msg_id;
		}
		if (!$result = $this->db->queryF($sql)) {
			return false;
		}
		if (empty($msg_id)) {
			$msg_id = $this->db->getInsertId();
		}
		$msg->assignVar('msg_id', $msg_id);
		return $msg_id;
	}

	function delete($msg){
        global $xoopsModule;
		if (strtolower(get_class($msg)) != 'xfguestbookmsg') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE msg_id = %u", $this->db->prefix('xfguestbook_msg'), $msg->getVar('msg_id'));
       if (isset($this->commentstable) && $this->commentstable != "") {
            xoops_comment_delete($xoopsModule->getVar('mid'), $msg_id);
		}

		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
	
	function &getObjects($criteria = null)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('xfguestbook_msg');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
            $sort = ($criteria->getSort() != '') ? $criteria->getSort() : 'msg_id';
            $sql .= ' ORDER BY '.$sort.' '.$criteria->getOrder();
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$msg = new xfguestbookMsg();
			$msg->assignVars($myrow);
			$ret[] =$msg;
			unset($msg);
		}
		return $ret;
	}

	function countMsg($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('xfguestbook_msg');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result =& $this->db->query($sql)) {
			return 0;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	}

	function countMsgByCountry($criteria = null) {
		$arr = array();
		$sql = 'SELECT country, flagdir FROM '.$this->db->prefix('xfguestbook_msg');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result =& $this->db->query($sql)) {
			return false;
		}
        while (list($country, $flagdir) = $this->db->fetchRow($result)) {
            $arr[] = $flagdir.'/'.$country;
        }
		$ret = array_count_values($arr);
		arsort($ret);
		
		return $ret;
	}

	function countMsgByGender($criteria = null) {
		$arr = array();
		$sql = 'SELECT gender FROM '.$this->db->prefix('xfguestbook_msg');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result =& $this->db->query($sql)) {
			return false;
		}
        while (list($gender) = $this->db->fetchRow($result)) {
            $arr[] = $gender;
        }
		$ret = array_count_values($arr);
		return $ret;
	}
	
	function getMsgImg($criteria = null){
		$arr = array();
		$sql = "SELECT photo FROM ".$this->db->prefix('xfguestbook_msg')." WHERE `photo` LIKE 'msg_%'";
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result =& $this->db->query($sql)) {
			return 0;
		}
        while (list($photo) = $this->db->fetchRow($result)) {
			$arr[] = $photo;
        }
		return $arr;
	}

}


?>
