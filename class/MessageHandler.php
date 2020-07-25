<?php

namespace XoopsModules\Xfguestbook;

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
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author       XOOPS Development Team
 */
/**
 * Class MessageHandler
 */
class MessageHandler extends \XoopsPersistableObjectHandler
{
    /** @var \XoopsMySQLDatabase $db */
    public $db;

    /**
     * MessageHandler constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        $this->db = $db;
    }

    /**
     * @param bool $isNew
     * @return Message
     */
    public function create($isNew = true)
    {
        return new Message();
    }

    /**
     * @param int|null $id
     * @param null     $fields
     * @return bool|string
     */
    public function get($id = null, $fields = null)
    {
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM ' . $this->db->prefix('xfguestbook_msg') . ' WHERE msg_id=' . $id;
            if (!$result = $this->db->query($sql)) {
                return false;
            }
            $numrows = $this->db->getRowsNum($result);
            if (1 == $numrows) {
                $msg = new Message();
                $msg->assignVars($this->db->fetchArray($result));

                return $msg;
            }
        }

        return false;
    }

    /**
     * @param \XoopsObject $msg
     * @param bool         $force
     * @return bool
     */
    public function insert(\XoopsObject $msg, $force = true)
    {
        if (Message::class !== \get_class($msg)) {
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
            $sql    = 'INSERT INTO '
                      . $this->db->prefix('xfguestbook_msg')
                      . ' (msg_id, user_id, uname, title, message, note, post_time, email, url, poster_ip, moderate, gender, country, photo, flagdir, other) VALUES ('
                      . $msg_id
                      . ','
                      . $user_id
                      . ', '
                      . $this->db->quoteString($uname)
                      . ', '
                      . $this->db->quoteString($title)
                      . ', '
                      . $this->db->quoteString($message)
                      . ', '
                      . $this->db->quoteString($note)
                      . ', '
                      . $post_time
                      . ',  '
                      . $this->db->quoteString($email)
                      . ', '
                      . $this->db->quoteString($url)
                      . ', '
                      . $this->db->quoteString($poster_ip)
                      . ', '
                      . $moderate
                      . ', '
                      . $this->db->quoteString($gender)
                      . ', '
                      . $this->db->quoteString($country)
                      . ', '
                      . $this->db->quoteString($photo)
                      . ', '
                      . $this->db->quoteString($flagdir)
                      . ', '
                      . $this->db->quoteString($other)
                      . ')';
        } else {
            $sql = 'UPDATE '
                   . $this->db->prefix('xfguestbook_msg')
                   . ' SET user_id='
                   . $user_id
                   . ', uname='
                   . $this->db->quoteString($uname)
                   . ', title='
                   . $this->db->quoteString($title)
                   . ', message='
                   . $this->db->quoteString($message)
                   . ', note='
                   . $this->db->quoteString($note)
                   . ', email='
                   . $this->db->quoteString($email)
                   . ', url='
                   . $this->db->quoteString($url)
                   . ', moderate='
                   . $moderate
                   . ', gender='
                   . $this->db->quoteString($gender)
                   . ', country='
                   . $this->db->quoteString($country)
                   . ', photo='
                   . $this->db->quoteString($photo)
                   . ', flagdir='
                   . $this->db->quoteString($flagdir)
                   . ', other='
                   . $this->db->quoteString($other)
                   . ' WHERE msg_id='
                   . $msg_id;
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

    /**
     * @param \XoopsObject $msg
     * @param bool         $force
     * @return bool
     */
    public function delete(\XoopsObject $msg, $force = false)
    {
        global $xoopsModule;
        if (Message::class !== \get_class($msg)) {
            return false;
        }
        $sql = \sprintf('DELETE FROM `%s` WHERE msg_id = %u', $this->db->prefix('xfguestbook_msg'), $msg->getVar('msg_id'));
        if (isset($this->commentstable) && '' !== $this->commentstable) {
            \xoops_comment_delete($xoopsModule->getVar('mid'), $msg_id);
        }

        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * @param null|\CriteriaElement|\CriteriaCompo $criteria
     * @param bool                                 $id_as_key
     * @param bool                                 $as_object
     * @return array
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)//getObjects(\CriteriaElement $criteria = null)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('xfguestbook_msg');
        if (null !== $criteria && $criteria instanceof \CriteriaElement) {
            $sql   .= ' ' . $criteria->renderWhere();
            $sort  = ('' !== $criteria->getSort()) ? $criteria->getSort() : 'msg_id';
            $sql   .= ' ORDER BY ' . $sort . ' ' . $criteria->getOrder();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $msg = new Message();
            $msg->assignVars($myrow);
            $ret[] = $msg;
            unset($msg);
        }

        return $ret;
    }

    /**
     * @param null|\CriteriaElement|\CriteriaCompo $criteria
     * @return int
     */
    public function countMsg(\CriteriaElement $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('xfguestbook_msg');
        if (null !== $criteria && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return 0;
        }
        [$count] = $this->db->fetchRow($result);

        return $count;
    }

    /**
     * @param null|\CriteriaElement|\CriteriaCompo $criteria
     * @return array|bool
     */
    public function countMsgByCountry(\CriteriaElement $criteria = null)
    {
        $arr = [];
        $sql = 'SELECT country, flagdir FROM ' . $this->db->prefix('xfguestbook_msg');
        if (null !== $criteria && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        while (list($country, $flagdir) = $this->db->fetchRow($result)) {
            $arr[] = $flagdir . '/' . $country;
        }
        $ret = \array_count_values($arr);
        \arsort($ret);

        return $ret;
    }

    /**
     * @param \CriteriaElement|\CriteriaCompo|null $criteria
     * @return array|bool
     */
    public function countMsgByGender(\CriteriaElement $criteria = null)
    {
        $arr = [];
        $sql = 'SELECT gender FROM ' . $this->db->prefix('xfguestbook_msg');
        if (null !== $criteria && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        while (list($gender) = $this->db->fetchRow($result)) {
            $arr[] = $gender;
        }
        $ret = \array_count_values($arr);

        return $ret;
    }

    /**
     * @param null|\CriteriaElement|\CriteriaCompo $criteria
     * @return array|int
     */
    public function getMsgImg(\CriteriaElement $criteria = null)
    {
        $arr = [];
        $sql = 'SELECT photo FROM ' . $this->db->prefix('xfguestbook_msg') . " WHERE `photo` LIKE 'msg_%'";
        if (null !== $criteria && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return 0;
        }
        while (list($photo) = $this->db->fetchRow($result)) {
            $arr[] = $photo;
        }

        return $arr;
    }
}
