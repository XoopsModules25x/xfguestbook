<?php
// Module Info
// The name of this module
define('MI_XFGUESTBOOK_NAME', 'Guestbook');
define('MI_XFGUESTBOOK_DESC', 'Gli utenti possono firmare il tuo Guestbook');
//Popup menu
define('MI_XFGUESTBOOK_CONF_FORM', 'Modulo di configurazione');
define('MI_XFGUESTBOOK_MSG_MANAGE', 'Gestione messaggi');
define('MI_XFGUESTBOOK_COUNTRYMANAGE', 'Gestione localit&agrave;');
// Options préférences
define('MI_XFGUESTBOOK_NBMSG', 'Numero di messaggi per pagina');
define('MI_XFGUESTBOOK_ANONSIGN', 'Gli utenti anonimi possono firmare il Guestbook');
define('MI_XFGUESTBOOK_MODERATE', 'Moderazione');
define('MI_XFGUESTBOOK_MODERATEDSC', 'Tutti i messaggi sono sottoposti a verifica.');
define('MI_XFGUESTBOOK_SENDMAIL', 'Invia un-email al webmaster per ogni nuovo messaggio inserito');
define('MI_XFGUESTBOOK_AVATAR', 'Visualizza avatar e rank');
// v2.2
define('MI_XFGUESTBOOK_MAXSIZEIMG', 'Immagini : max. peso (in bytes)');
define('MI_XFGUESTBOOK_MAXSIZEIMG_DESC', '0 per evitare upload');
define('MI_XFGUESTBOOK_MAXHEIGHTIMG', 'Immagini : max. altezza');
define('MI_XFGUESTBOOK_MAXWIDTHIMG', 'immagini : max. larghezza');
// v2.30
define('MI_XFGUESTBOOK_FLAGDIR', "Repertorio di immagini: <span style='color: #FF0000; '>non modificare</span>");
define('MI_XFGUESTBOOK_COUNTRY_CAPTION', 'Nome per le immagini (localit&agrave;, regione,...)');
define('MI_XFGUESTBOOK_NBFLAGS', 'Numero di immagini (bandiere) per linea');
define('MI_XFGUESTBOOK_COUNTRY', 'Localit&agrave;');
define('MI_XFGUESTBOOK_OTHER', 'Altro');
define('MI_XFGUESTBOOK_OTHER_TEXT', 'Altra localit&agrave;');
define('AM_XFGUESTBOOK_INSTALL_IMG', 'Pacchetti immagini');
define('AM_XFGUESTBOOK_IMG_MANAGER', 'Immagini Orfane');
//Block
define('MI_XFGUESTBOOK_BNAME1', 'Leggi il Guestbook');
// index.php
define('MI_XFGUESTBOOK_ADMIN_HOME', 'Home');
define('MI_XFGUESTBOOK_ADMIN_HOME_DESC', 'Back to Home');
define('MI_XFGUESTBOOK_ADMIN_ABOUT', 'About');
define('MI_XFGUESTBOOK_ADMIN_ABOUT_DESC', 'About this module');
if (!defined('AM_XFGUESTBOOK_IP')) {
    define('AM_XFGUESTBOOK_IP', 'Indirizzo IP');
}

define('MI_XFGUESTBOOK_SHOWEMAIL', 'Visualizza il pulsante email su tutti i messaggi');
define('MI_XFGUESTBOOK_SHOWEMAIL_DESC', '\'Si\' indipendentemente dalla scelta di visualizzare la propria mail');
