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
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author       XOOPS Development Team
 */
defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Message
 */
class Message extends \XoopsObject
{
    // constructor

    /**
     * Message constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('msg_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('user_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uname', XOBJ_DTYPE_TXTBOX, '', false);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, '', true);
        $this->initVar('message', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('note', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('post_time', XOBJ_DTYPE_STIME, null, false);
        $this->initVar('email', XOBJ_DTYPE_EMAIL, '', false);
        $this->initVar('url', XOBJ_DTYPE_URL, '', false);
        $this->initVar('poster_ip', XOBJ_DTYPE_OTHER, '', false);
        $this->initVar('moderate', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gender', XOBJ_DTYPE_TXTBOX, '', false, 1);
        $this->initVar('country', XOBJ_DTYPE_TXTBOX, '', false, 5);
        $this->initVar('photo', XOBJ_DTYPE_TXTBOX, '', false); // added v2.20
        $this->initVar('flagdir', XOBJ_DTYPE_TXTBOX, '', false); // added v2.30
        $this->initVar('other', XOBJ_DTYPE_TXTBOX, '', false); // added v2.30
    }
}
