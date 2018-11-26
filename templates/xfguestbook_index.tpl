<table width='98%' align='center' border='0' class='fg2'>
    <tr>
        <td align='center'>
            <div style="text-align: center;">
                <br>
                <br>
                <br>
                <a href='xfcreate.php'><img src='<{$xoops_url}>/modules/xfguestbook/assets/images/guestbook.gif' border=''></a>
                <br>
                <{$msg_message_count}>
                <br>
                <{$msg_moderate_text}>
            </div>
        </td>
    </tr>
</table><br>

<{if $display_country}>
    <{html_table loop = $country cols = $flagsperrow tr_attr='align="left"'}>
    <br>
<{/if}>

<{if $display_msg}>
    <table cellspacing='0' border='0' width='98%'>
        <tr>
            <td align='right'>
                <{$msg_page_nav}>
            </td>
        </tr>
    </table>
    <!-- <ul>
<{foreach item="local" key="keys" from=$country_l}>
<li><{$keys}> (<{$local}>)</li>
<{/foreach}>
</ul>
<br>-->
    <!-- start msg item loop -->
    <{section name=i loop=$msg}>
        <{include file="db:xfguestbook_item.tpl" msg=$msg[i]}>
        <br>
    <{/section}>
    <!-- end msg item loop -->
    <table cellspacing='0' border='0' width='98%'>
        <tr>
            <td width='100%' align='right'><{$msg_page_nav}></td>
        </tr>
    </table>
<{/if}>
