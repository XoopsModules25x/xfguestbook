<table width="98%" cellspacing="1" class="outer">
    <tr>
        <th width="25%" align="left">
        <{$msg.i}></td>
        <img src='<{$xoops_url}>/images/icons/posticon.gif' alt=''/> <span class='comDate'>
      <{$msg.date}>
      </span>
        <th align="left">
            <{$msg.title}>
    </tr>
    <tr>
        <td width="25%" class='head'>
            <{$msg.poster}>&nbsp;
            <{$msg.gender}>
        </td>
        <td class="head" align="right">
            <div style="text-align:left; margin-bottom:-17px;">
                <{$msg.email}>
                <{$msg.url}>
            </div>
        </td>
    </tr>
    <tr align='left'>
        <td width="25%" class='odd'>
            <div class="comUserRankText"
            <{$msg.rank}>
            </div>
            <div class="comUserRankImg">
                <{$msg.rank_img}>
            </div>
            <div class="comUserImg">
                <{$msg.avatar}>
                <br>
            </div>
        </td>
        <td class='odd' valign='top'>
            <{if $msg.photo}>
                <img src="<{$xoops_url}>/uploads/xfguestbook/<{$msg.photo}>" align="left" hspace="10">
            <{/if}>
            <{$msg.message}>
            <br>
            <br>
            <i> </i> <i>
                <{if $msg.note_msg}>
            </i>
        <hr>
            <i>
                <{$smarty.const.MD_XFGUESTBOOK_NOTE}>
                <{$msg.note_msg}>
            </i>
            <{/if}>
            <p><i> </i></p>
        </td>
    </tr>
    <{if $xoops_isadmin and not $preview}>
        <tr valign='bottom'>
            <td width="25%" class="foot"><br><{$smarty.const.MD_XFGUESTBOOK_COUNTRY}>: <{$msg.local}></td>
            <td class='foot' align="right">
                <img src="<{$xoops_url}>/modules/xfguestbook/assets/images/ip.gif" border=0 title="<{$msg.poster_ip}>">&nbsp;&nbsp;
                <a href="admin/main.php?op=edit&msg_id=<{$msg.msg_id}>"><img src="<{xoModuleIcons16 edit.png}>" border=0 alt="<{$smarty.const._EDIT}>"></a>&nbsp;
                <a href="index.php?op=delete&msg_id=<{$msg.msg_id}>"><img src="<{xoModuleIcons16 delete.png}>" border=0 alt="<{$smarty.const._DELETE}>"></a>&nbsp;
                <{if $msg.moderate}>
                    <a href="index.php?op=approve&msg_id=<{$msg.msg_id}>"><img src="<{$xoops_url}>/modules/xfguestbook/assets/images/valid.gif" border=0 alt="<{$smarty.const._SUBMIT}>"></a>
                <{/if}>
            </td>
        </tr>
    <{/if}>
</table>
