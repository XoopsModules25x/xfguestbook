<?php

// Common
define('AM_XFGUESTBOOK_ALLMSG', 'All messages');
define('AM_XFGUESTBOOK_PUBMSG', 'Published messages ');
define('AM_XFGUESTBOOK_WAITMSG', 'Messages waiting for validation');
define('AM_XFGUESTBOOK_NOMSG', 'No message');
//add v2.30
define('AM_XFGUESTBOOK_DISPLAY', 'Post');
define('AM_XFGUESTBOOK_SELECT_SORT', 'By order');
define('AM_XFGUESTBOOK_SORT_ASC', 'Ascending');
define('AM_XFGUESTBOOK_SORT_DESC', 'Descending');
//add v2.40
define('AM_XFGUESTBOOK_BAN', 'Moderate');
// cp_functions
// function admin_menu
define('AM_XFGUESTBOOK_CONFIG', 'Configure');
define('AM_XFGUESTBOOK_GENERALSET', 'General setting');
define('AM_XFGUESTBOOK_MSGMANAGE', 'Messages manager');
define('AM_XFGUESTBOOK_FORMOPT', 'Form options ');
define('AM_XFGUESTBOOK_COUNTRYMANAGE', 'Countries manager');
define('AM_XFGUESTBOOK_GOINDEX', 'Go to the module');
//add v2.30
define('AM_XFGUESTBOOK_UPGRADE', 'Upgrade');
define('AM_XFGUESTBOOK_MSGIMG', 'Maintenance');
//add v2.40
define('AM_XFGUESTBOOK_BADIPSMANAGE', 'Moderate IPs ');
// Redirect
define('AM_XFGUESTBOOK_DBUPDATED', 'Configuration updated');
define('AM_XFGUESTBOOK_VALIDATE', 'Message approved');
define('AM_XFGUESTBOOK_ERRORVALID', 'ERROR : Could not approve the message!');
define('AM_XFGUESTBOOK_MSGMOD', 'Message modified');
define('AM_XFGUESTBOOK_MSGDELETED', 'Message deleted');
define('AM_XFGUESTBOOK_ERRORDEL', 'ERROR : Could not delete the message!');
define('AM_XFGUESTBOOK_COUNTRY_EXIST', 'This country is already in the database!');
define('AM_XFGUESTBOOK_COUNTRY_UPDATED', 'Country updated ');
define('AM_XFGUESTBOOK_COUNTRY_ADDED', 'Country added successfully!');
define('AM_XFGUESTBOOK_COUNTRYDELETED', 'Country deleted');
define('AM_XFGUESTBOOK_MSGERROR', 'ERROR : Could not update message in the database!');
//add V2.30
define('AM_XFGUESTBOOK_MUST_UPDATE', 'You have installed files of version 2.30. <br> Please update the module');
//add V2.40
define('AM_XFGUESTBOOK_BANISHED', 'IP address saved in the database');
define('AM_XFGUESTBOOK_ERRORBANISHED', 'Error');
// Admin form
define('AM_XFGUESTBOOK_NAME', 'Author');
define('AM_XFGUESTBOOK_EMAIL', 'Email');
define('AM_XFGUESTBOOK_URL', 'Web site');
define('AM_XFGUESTBOOK_TITLE', 'Title');
define('AM_XFGUESTBOOK_MESSAGE', 'Message');
define('AM_XFGUESTBOOK_NOTE', 'Note of Webmaster');
define('AM_XFGUESTBOOK_COUNTRY', 'Country');
define('AM_XFGUESTBOOK_MALE', ' Male');
define('AM_XFGUESTBOOK_FEMALE', ' Female');
define('AM_XFGUESTBOOK_GENDER', 'Gender');
define('AM_XFGUESTBOOK_GENDER_UNKNOW', ' Unknown');
define('AM_XFGUESTBOOK_APPROVE', 'Approved');
define('AM_XFGUESTBOOK_DATE', 'Posted on');
define('AM_XFGUESTBOOK_IP', 'IP address');
//V2.20
define('AM_XFGUESTBOOK_DELIMG', ' Delete this image');
define('AM_XFGUESTBOOK_WM', 'Webmaster');
define('AM_XFGUESTBOOK_NBMSG', 'Messages quantity: ');
//add V2.30
define('AM_XFGUESTBOOK_IMG', 'Photo');
define('AM_XFGUESTBOOK_REPLACEIMG', ' <b>or</b> replace with <br>');
define('AM_XFGUESTBOOK_IF_OTHER', ' if other : ');
// function show
define('AM_XFGUESTBOOK_ACTION', 'Action');
define('AM_XFGUESTBOOK_SAVEANDPUB', 'Save and approve');
define('AM_XFGUESTBOOK_SAVE', 'Save');
define('AM_XFGUESTBOOK_PUB', 'Approve');
// config
define('AM_XFGUESTBOOK_MAILTRUE', 'Email');
define('AM_XFGUESTBOOK_GENDER_OPT', 'Ask gender');
define('AM_XFGUESTBOOK_COUNTRYDEF', 'Country by default');
define('AM_XFGUESTBOOK_OPT1', 'Textarea : icons url, mail, image, ...');
define('AM_XFGUESTBOOK_OPT2', 'Textarea : font, size, color,...)');
define('AM_XFGUESTBOOK_OPT3', 'Textarea : smiley');
// add v2.30
define('AM_XFGUESTBOOK_COUNTRY_OPT', 'Ask the country');
define('AM_XFGUESTBOOK_SEL_R0', 'Not required');
define('AM_XFGUESTBOOK_SEL_R1', 'Optional');
define('AM_XFGUESTBOOK_SEL_R2', 'Required');
define('AM_XFGUESTBOOK_URL_OPT', 'Action of links');
define('AM_XFGUESTBOOK_SEL_A0', 'no action');
define('AM_XFGUESTBOOK_SEL_A1', 'nonindexable');
define('AM_XFGUESTBOOK_SEL_A2', 'prohibited');
define('AM_XFGUESTBOOK_CODE_OPT', 'Ask verification code');
define('AM_XFGUESTBOOK_WARNING_MSG2', "<span style='color: #FF0000; '>For Selection ' YES' you must install one<a href='" . XOOPS_URL . "/modules/xfguestbook/admin/flags_install.php'>Image Pack of (flags, ...)</a></span>");
// add v2.40
define('AM_XFGUESTBOOK_WEBSITE_OPT', 'Field website authorised');
define('AM_XFGUESTBOOK_SEL_W0', 'nobody');
define('AM_XFGUESTBOOK_SEL_W1', 'members only');
define('AM_XFGUESTBOOK_SEL_W2', 'all');
// country manage
define('AM_XFGUESTBOOK_FLAGIMG', 'Flag');
define('AM_XFGUESTBOOK_FLAGCODE', 'Code');
define('AM_XFGUESTBOOK_FLAGNAME', 'Name');
define('AM_XFGUESTBOOK_ADDCOUNTRY', 'Add a country');
define('AM_XFGUESTBOOK_MODCOUNTRY', 'Modify a country');
define('AM_XFGUESTBOOK_DISPCOUNTRY', 'Display countries');
define('AM_XFGUESTBOOK_UPLOADFLAG', 'Upload');
define('AM_XFGUESTBOOK_DELETEFLAG', 'Delete');
define('AM_XFGUESTBOOK_CONFDELCOUNTRY', 'WARNING: Are you sure you want to delete this country ? <br>And the flag if exist ?');
define('AM_XFGUESTBOOK_SUBMITFLAG', 'Upload a flag');
define('AM_XFGUESTBOOK_ADDIMG', 'Select image');
define('AM_XFGUESTBOOK_FILEERROR', 'ERROR: No flag uploaded');
define('MD_XFGUESTBOOK_NOIMGSELECTED', 'ERROR: No file selected');
define('AM_XFGUESTBOOK_FILEUPLOADED', 'Image uploaded');
define('AM_XFGUESTBOOK_CONFDELFLAG', 'WARNING: Are you sure you want to delete this flag ?');
define('AM_XFGUESTBOOK_FLAGDELETED', 'Flag deleted');
define('AM_XFGUESTBOOK_FLAGDSC', 'Max size %s o, width %s pixels, height %s pixels, format %s only');
define('AM_XFGUESTBOOK_NOFLAG', 'No country');
// upgrade add v2.30
define('AM_XFGUESTBOOK_TABLE', 'Table ');
define('AM_XFGUESTBOOK_FIELD', 'Field ');
define('AM_XFGUESTBOOK_VALUE', 'Value ');
define('AM_XFGUESTBOOK_ADDED', 'Added in v ');
define('AM_XFGUESTBOOK_DELETED', 'Deleted in v ');
define('AM_XFGUESTBOOK_NOCHANGE', 'No modifications');
define('AM_XFGUESTBOOK_CHANGED', 'Changed in v ');
define('AM_XFGUESTBOOK_UPGRADE_GO', 'Upgrade');
define('AM_XFGUESTBOOK_WARNING_UPGRADE', 'Attention, this operation will modify certain tables. <br>Please make a backup first !');
define('AM_XFGUESTBOOK_ERROR', 'Error : ');
define('AM_XFGUESTBOOK_UPGRADE_SUCCESS', 'Upgrade successfull');
define('AM_XFGUESTBOOK_NO_UPGRADE', 'Upgrade not necessary');
//flags_install add V2.30
define('AM_XFGUESTBOOK_INSTALL_FLAGS', 'Install an image pack (flags, charts, ...)');
define('AM_XFGUESTBOOK_SELECT_PACK', 'Select a pack to install');
define('AM_XFGUESTBOOK_WARNING', '<b>&nbsp;Warning</b>');
define('AM_XFGUESTBOOK_WARNING_MSG1', '<span style=\'color: #FF0000; \'>&nbsp;This operation will erase the contents of the table</span> %s <span style=\'color: #FF0000; \'> and replace it.</span>');
define('AM_XFGUESTBOOK_GOFORMOPT', ' Go to form options');
define('AM_XFGUESTBOOK_GO_UPGRADE', ' To restore the table, go to Upgrade');
define('AM_XFGUESTBOOK_ERROR_FLAGS', '<span style=\'color: #FF0000; \'> Data insertion Error of %s.sql <br> Table %s deleted</span>');
// img_manager add v2.30
define('AM_XFGUESTBOOK_IMG_DELETED', ' image(s) deleted');
define('AM_XFGUESTBOOK_IMG_FILE', 'File');
define('AM_XFGUESTBOOK_IMG_ORPHEAN', ' image(s) orphan(s)');
define('AM_XFGUESTBOOK_NO_ORPHEAN', 'No orphan images');
define('AM_XFGUESTBOOK_ORPHEAN_DSC', ' This page enables you to post the images which are not attached to a message (orphan).<br>&nbsp;This can occur if a problem when sending a message.<br>&nbsp;Erase these useless images');
// ip manager add V2.40
define('AM_XFGUESTBOOK_DISP_BADIPS', 'IP addresses moderated automatically');
define('AM_XFGUESTBOOK_IPS', 'IP Address');
define('AM_XFGUESTBOOK_ADD_BADIP', 'Add an IP address ');
define('AM_XFGUESTBOOK_MOD_BADIP', 'Modify an IP address');
define('AM_XFGUESTBOOK_BADIP_VALUE', 'Value');
define('AM_XFGUESTBOOK_BADIP_EXIST', 'IP address already logged');
define('AM_XFGUESTBOOK_BADIP_ADDED', 'IP address logged!');
define('AM_XFGUESTBOOK_BADIP_UPDATED', 'IP address modified !');
define('AM_XFGUESTBOOK_BADIP_DELETED', 'IP address deleted !');
define('AM_XFGUESTBOOK_NOBADIP', 'Not an IP address !');
