<ul>
    <{foreach item=message from=$block.items}>
        <li>
            <a href="<{$xoops_url}>/modules/xfguestbook/index.php?op=show_one&msg_id=<{$message.id}>"><{$message.date}></a>&nbsp;
            <{$message.name}>&nbsp;
            <{$message.title}>
        </li>
    <{/foreach}>
    <br><br>
    <a href="<{$xoops_url}>/modules/xfguestbook/index.php"><{$smarty.const.MB_XFGUESTBOOK_BNAME1}></a>
</ul>
