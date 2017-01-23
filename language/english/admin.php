<?php
// Common
define('AM_XFGB_ALLMSG', 'All messages');
define('AM_XFGB_PUBMSG', 'Published messages ');
define('AM_XFGB_WAITMSG', 'Messages waiting for validation');
define('AM_XFGB_NOMSG', 'No message');
//add v2.30
define('AM_XFGB_DISPLAY', 'Post');
define('AM_XFGB_SELECT_SORT', 'By order');
define('AM_XFGB_SORT_ASC', 'Ascending');
define('AM_XFGB_SORT_DESC', 'Descending');
//add v2.40
define('AM_XFGB_BAN', 'Moderate');
// cp_functions
// function admin_menu
define('AM_XFGB_CONFIG', 'Configure');
define('AM_XFGB_GENERALSET', 'General setting');
define('AM_XFGB_MSGMANAGE', 'Messages manager');
define('AM_XFGB_FORMOPT', 'Form options ');
define('AM_XFGB_COUNTRYMANAGE', 'Countries manager');
define('AM_XFGB_GOINDEX', 'Go to the module');
//add v2.30
define('AM_XFGB_UPGRADE', 'Upgrade');
define('AM_XFGB_MSGIMG', 'Maintenance');
//add v2.40
define('AM_XFGB_BADIPSMANAGE', 'Moderate IPs ');
// Redirect
define('AM_XFGB_DBUPDATED', 'Configuration updated');
define('AM_XFGB_VALIDATE', 'Message approved');
define('AM_XFGB_ERRORVALID', 'ERROR : Could not approve the message!');
define('AM_XFGB_MSGMOD', 'Message modified');
define('AM_XFGB_MSGDELETED', 'Message deleted');
define('AM_XFGB_ERRORDEL', 'ERROR : Could not delete the message!');
define('AM_XFGB_COUNTRY_EXIST', 'This country is already in the database!');
define('AM_XFGB_COUNTRY_UPDATED', 'Country updated ');
define('AM_XFGB_COUNTRY_ADDED', 'Country added successfully!');
define('AM_XFGB_COUNTRYDELETED', 'Country deleted');
define('AM_XFGB_MSGERROR', 'ERROR : Could not update message in the database!');
//add V2.30
define('AM_XFGB_MUST_UPDATE', 'You have installeeacute;  files of version 2.30. <br> Veuillez faire une mise &agrave; jour du module');
//add V2.40
define('AM_XFGB_BANISHED', 'IP address saved in the database');
define('AM_XFGB_ERRORBANISHED', 'Error');
// Admin form
define('AM_XFGB_NAME', 'Author');
define('AM_XFGB_EMAIL', 'Email');
define('AM_XFGB_URL', 'Web site');
define('AM_XFGB_TITLE', 'Title');
define('AM_XFGB_MESSAGE', 'Message');
define('AM_XFGB_NOTE', 'Note of Webmaster');
define('AM_XFGB_COUNTRY', 'Country');
define('AM_XFGB_MALE', ' Male');
define('AM_XFGB_FEMALE', ' Female');
define('AM_XFGB_GENDER', 'Gender');
define('AM_XFGB_GENDER_UNKNOW', ' Unknown');
define('AM_XFGB_APPROVE', 'Approved');
define('AM_XFGB_DATE', 'Posted on');
define('AM_XFGB_IP', 'IP address');
//V2.20
define('AM_XFGB_DELIMG', ' Delete this image');
define('AM_XFGB_WM', 'Webmaster');
define('AM_XFGB_NBMSG', 'Messages quantity: ');
//add V2.30
define('AM_XFGB_IMG', 'Photo');
define('AM_XFGB_REPLACEIMG', ' <b>or</b> replace with <br>');
define('AM_XFGB_IF_OTHER', ' if other : ');
// function show
define('AM_XFGB_ACTION', 'Action');
define('AM_XFGB_SAVEANDPUB', 'Save and approve');
define('AM_XFGB_SAVE', 'Save');
define('AM_XFGB_PUB', 'Approve');
// config
define('AM_XFGB_MAILTRUE', 'Email');
define('AM_XFGB_GENDER_OPT', 'Ask gender');
define('AM_XFGB_COUNTRYDEF', 'Country by default');
define('AM_XFGB_OPT1', 'Textarea : icons url, mail, image, ...');
define('AM_XFGB_OPT2', 'Textarea : font, size, color,...)');
define('AM_XFGB_OPT3', 'Textarea : smiley');
// add v2.30
define('AM_XFGB_COUNTRY_OPT', 'Ask the country');
define('AM_XFGB_SEL_R0', 'Not required');
define('AM_XFGB_SEL_R1', 'Optional');
define('AM_XFGB_SEL_R2', 'Required');
define('AM_XFGB_URL_OPT', 'Action of links');
define('AM_XFGB_SEL_A0', 'no action');
define('AM_XFGB_SEL_A1', 'nonindexable');
define('AM_XFGB_SEL_A2', 'prohibited');
define('AM_XFGB_CODE_OPT', 'Ask verification code');
define('AM_XFGB_WARNING_MSG2',
       "<span style='color: #FF0000; '>For Selection ' YES' you must install one<a href='" . XOOPS_URL . "/modules/xfguestbook/admin/flags_install.php'>Image Pack of (flags, ...)</a></span>");
// add v2.40
define('AM_XFGB_WEBSITE_OPT', 'Field website authorised');
define('AM_XFGB_SEL_W0', 'nobody');
define('AM_XFGB_SEL_W1', 'members only');
define('AM_XFGB_SEL_W2', 'all');
// country manage
define('AM_XFGB_FLAGIMG', 'Flag');
define('AM_XFGB_FLAGCODE', 'Code');
define('AM_XFGB_FLAGNAME', 'Name');
define('AM_XFGB_ADDCOUNTRY', 'Add a country');
define('AM_XFGB_MODCOUNTRY', 'Modify a country');
define('AM_XFGB_DISPCOUNTRY', 'Display countries');
define('AM_XFGB_UPLOADFLAG', 'Upload');
define('AM_XFGB_DELETEFLAG', 'Delete');
define('AM_XFGB_CONFDELCOUNTRY', 'WARNING: Are you sure you want to delete this country ? <br>And the flag if exist ?');
define('AM_XFGB_SUBMITFLAG', 'Upload a flag');
define('AM_XFGB_ADDIMG', 'Select image');
define('AM_XFGB_FILEERROR', 'ERROR: No flag uploaded');
define('MD_XFGB_NOIMGSELECTED', 'ERROR: No file selected');
define('AM_XFGB_FILEUPLOADED', 'Image uploaded');
define('AM_XFGB_CONFDELFLAG', 'WARNING: Are you sure you want to delete this flag ?');
define('AM_XFGB_FLAGDELETED', 'Flag deleted');
define('AM_XFGB_FLAGDSC', 'Max size %s o, width %s pixels, height %s pixels, format %s only');
define('AM_XFGB_NOFLAG', 'No country');
// upgrade add v2.30
define('AM_XFGB_TABLE', 'Table ');
define('AM_XFGB_FIELD', 'Field ');
define('AM_XFGB_VALUE', 'Value ');
define('AM_XFGB_ADDED', 'Added in v ');
define('AM_XFGB_DELETED', 'Deleted in v ');
define('AM_XFGB_NOCHANGE', 'No modifications');
define('AM_XFGB_CHANGED', 'Changed in v ');
define('AM_XFGB_UPGRADE_GO', 'Upgrade');
define('AM_XFGB_WARNING_UPGRADE', 'Attention, this operation will modify certain tables. <br>Please make a backup first !');
define('AM_XFGB_ERROR', 'Error : ');
define('AM_XFGB_UPGRADE_SUCCESS', 'Upgrade successfull');
define('AM_XFGB_NO_UPGRADE', 'Upgrade not necessary');
//flags_install add V2.30
define('AM_XFGB_INSTALL_FLAGS', 'Install an image pack (flags, charts, ...)');
define('AM_XFGB_SELECT_PACK', 'Select a pack to install');
define('AM_XFGB_WARNING', '<b>&nbsp;Warning</b>');
define('AM_XFGB_WARNING_MSG1', '<span style=\'color: #FF0000; \'>&nbsp;This operation will erase the contents of the table</span> %s <span style=\'color: #FF0000; \'> and replace it.</span>');
define('AM_XFGB_GOFORMOPT', ' Go to form options');
define('AM_XFGB_GO_UPGRADE', ' To restore the table, go to Upgrade');
define('AM_XFGB_ERROR_FLAGS', '<span style=\'color: #FF0000; \'> Data insertion Error of %s.sql <br> Table %s deleted</span>');
// img_manager add v2.30
define('AM_XFGB_IMG_DELETED', ' image(s) deleted');
define('AM_XFGB_IMG_FILE', 'File');
define('AM_XFGB_IMG_ORPHEAN', ' image(s) orphan(s)');
define('AM_XFGB_NO_ORPHEAN', 'No orphan images');
define('AM_XFGB_ORPHEAN_DSC',
       ' This page enables you to post the images which are not attached to a message (orphan).<br>&nbsp;This can occur if a problem when sending a message.<br>&nbsp;Erase these useless images');
// ip manager add V2.40
define('AM_XFGB_DISP_BADIPS', 'IP addresses moderated automatically');
define('AM_XFGB_IPS', 'IP Address');
define('AM_XFGB_ADD_BADIP', 'Add an IP address ');
define('AM_XFGB_MOD_BADIP', 'Modify an IP address');
define('AM_XFGB_BADIP_VALUE', 'Value');
define('AM_XFGB_BADIP_EXIST', 'IP address already logged');
define('AM_XFGB_BADIP_ADDED', 'IP address logged!');
define('AM_XFGB_BADIP_UPDATED', 'IP address modified !');
define('AM_XFGB_BADIP_DELETED', 'IP address presuming !');
define('AM_XFGB_NOBADIP', 'Not an IP address !');
