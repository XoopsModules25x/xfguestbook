<?php
// Common
define('AM_XFGB_ALLMSG', 'Tutti i messaggi');
define('AM_XFGB_PUBMSG', 'Messaggi pubblicati ');
define('AM_XFGB_WAITMSG', 'Messaggi in attesa di approvazione');
define('AM_XFGB_NOMSG', 'Nessun messaggio');
//add v2.30
define('AM_XFGB_DISPLAY', 'Post');
define('AM_XFGB_SELECT_SORT', 'in ordine');
define('AM_XFGB_SORT_ASC', 'Ascendente');
define('AM_XFGB_SORT_DESC', 'Discendente');
//add v2.40
define('AM_XFGB_BAN', 'Modera');
// cp_functions
// function admin_menu
define('AM_XFGB_CONFIG', 'Configura');
define('AM_XFGB_GENERALSET', 'Impostazioni generali');
define('AM_XFGB_MSGMANAGE', 'Gestione messaggi');
define('AM_XFGB_FORMOPT', 'Modulo opzioni ');
define('AM_XFGB_COUNTRYMANAGE', 'Gestione localit&agrave;');
define('AM_XFGB_GOINDEX', 'Vai al modulo');
//add v2.30
define('AM_XFGB_UPGRADE', 'Aggiorna');
define('AM_XFGB_MSGIMG', 'Manutenzione');
//add v2.40
define('AM_XFGB_BADIPSMANAGE', 'Modera IPs ');
// Redirect
define('AM_XFGB_DBUPDATED', 'Configurazione aggiornata');
define('AM_XFGB_VALIDATE', 'Messaggio approvato');
define('AM_XFGB_ERRORVALID', 'ERRORE : il messaggio non pu&ograve; essere approvato!');
define('AM_XFGB_MSGMOD', 'Messaggio modificato');
define('AM_XFGB_MSGDELETED', 'Messaggio cancellato');
define('AM_XFGB_ERRORDEL', 'ERRORE : il messaggio non pu&ograve; essere cancellato!');
define('AM_XFGB_COUNTRY_EXIST', 'Questa localit&agrave; &egrave; gi&agrave; nel database!');
define('AM_XFGB_COUNTRY_UPDATED', 'Localit&agrave; aggiornata ');
define('AM_XFGB_COUNTRY_ADDED', 'Localit&agrave; aggiunta con successo!');
define('AM_XFGB_COUNTRYDELETED', 'localit&agrave; cancellata');
define('AM_XFGB_MSGERROR', 'ERRORE : il messaggio non pu&ograve; essere aggiornato nel database!');
//add V2.30
define('AM_XFGB_MUST_UPDATE', 'Hai installato i files della versione 2.30.');
//add V2.40
define('AM_XFGB_BANISHED', 'Indirizzo IP salvato nel database');
define('AM_XFGB_ERRORBANISHED', 'Errore');
// Admin form
define('AM_XFGB_NAME', 'Autore');
define('AM_XFGB_EMAIL', 'Email');
define('AM_XFGB_URL', 'Sito web');
define('AM_XFGB_TITLE', 'Titolo');
define('AM_XFGB_MESSAGE', 'Messaggio');
define('AM_XFGB_NOTE', 'Note del Webmaster');
define('AM_XFGB_COUNTRY', 'Localit&agrave;');
define('AM_XFGB_MALE', ' Maschio');
define('AM_XFGB_FEMALE', ' Femmina');
define('AM_XFGB_GENDER', 'Sesso');
define('AM_XFGB_GENDER_UNKNOW', ' Sconosciuto');
define('AM_XFGB_APPROVE', 'Approvato');
define('AM_XFGB_DATE', 'Inviato il');
define('AM_XFGB_IP', 'Indirizzo IP');
//V2.20
define('AM_XFGB_DELIMG', " Cancella l'immagine");
define('AM_XFGB_WM', 'Webmaster');
define('AM_XFGB_NBMSG', 'Quantit&agrave; di messaggi: ');
//add V2.30
define('AM_XFGB_IMG', 'Foto');
define('AM_XFGB_REPLACEIMG', ' <b>o</b> sostituisci con <br>');
define('AM_XFGB_IF_OTHER', ' se altro : ');
// function show
define('AM_XFGB_ACTION', 'Azione');
define('AM_XFGB_SAVEANDPUB', 'Salva e approva');
define('AM_XFGB_SAVE', 'Salva');
define('AM_XFGB_PUB', 'Approva');
// config
define('AM_XFGB_MAILTRUE', 'Email');
define('AM_XFGB_GENDER_OPT', 'Chiedi il sesso');
define('AM_XFGB_COUNTRYDEF', 'Localit&agrave; di default');
define('AM_XFGB_OPT1', 'Editor messaggi: visualizza icone url, mail, immagini, ...');
define('AM_XFGB_OPT2', 'Editor messaggi: visualizza font, size, color,...)');
define('AM_XFGB_OPT3', 'Editor messaggi: visualizza faccine');
// add v2.30
define('AM_XFGB_COUNTRY_OPT', 'Chiedi la localit&agrave;');
define('AM_XFGB_SEL_R0', 'Non richiesta');
define('AM_XFGB_SEL_R1', 'Opzionale');
define('AM_XFGB_SEL_R2', 'Richiesta');
define('AM_XFGB_URL_OPT', 'Azione sui links');
define('AM_XFGB_SEL_A0', 'nessuna azione');
define('AM_XFGB_SEL_A1', 'nonindicizzabili');
define('AM_XFGB_SEL_A2', 'proibiti');
define('AM_XFGB_CODE_OPT', 'Chiedi codice di sicurezza');
define('AM_XFGB_WARNING_MSG2',
       "<span style='color: #FF0000; '>Se scegli ' SI ' devi installare un<a href=\"" . XOOPS_URL . '/modules/xfguestbook/admin/flags_install.php">pacchetto immagine di (bandiere, ...)</a></span>');
// add v2.40
define('AM_XFGB_WEBSITE_OPT', 'Campo sito web autorizzato');
define('AM_XFGB_SEL_W0', 'a nessuno');
define('AM_XFGB_SEL_W1', 'solo ai membri');
define('AM_XFGB_SEL_W2', 'a tutti');
// country manage
define('AM_XFGB_FLAGIMG', 'Bandiera');
define('AM_XFGB_FLAGCODE', 'Codice');
define('AM_XFGB_FLAGNAME', 'Nome');
define('AM_XFGB_ADDCOUNTRY', 'Aggiungi una localit&agrave;');
define('AM_XFGB_MODCOUNTRY', 'Modifica una localit&agrave;');
define('AM_XFGB_DISPCOUNTRY', 'Visualizza localit&agrave;');
define('AM_XFGB_UPLOADFLAG', 'Upload');
define('AM_XFGB_DELETEFLAG', 'Cancella');
define('AM_XFGB_CONFDELCOUNTRY', 'ATTENZIONE: Sei sicuro di voler cancellare questa localit&agrave; ? <br>E la bandiera se esiste ?');
define('AM_XFGB_SUBMITFLAG', 'invia una bandiera');
define('AM_XFGB_ADDIMG', "Scegli un'immagine");
define('AM_XFGB_FILEERROR', 'ERRORE: Nessuna bandiera caricata');
define('MD_XFGB_NOIMGSELECTED', 'ERRORE: Nessun file selezionato');
define('AM_XFGB_FILEUPLOADED', 'Immagine caricata');
define('AM_XFGB_CONFDELFLAG', 'ATTENZIONE: Sei sicuro di voler cancellare questa bandiera ?');
define('AM_XFGB_FLAGDELETED', 'Bandiera cancellata');
define('AM_XFGB_FLAGDSC', 'Max peso %s , larghezza %s pixels, altezza %s pixels, formato solo %s ');
define('AM_XFGB_NOFLAG', 'Nessuna localit&agrave;');
// upgrade add v2.30
define('AM_XFGB_TABLE', 'Tabella ');
define('AM_XFGB_FIELD', 'Campo ');
define('AM_XFGB_VALUE', 'Valore ');
define('AM_XFGB_ADDED', 'Aggiunto in v ');
define('AM_XFGB_DELETED', 'Cancellato in v ');
define('AM_XFGB_NOCHANGE', 'Nessuna modifica');
define('AM_XFGB_CHANGED', 'Cambiato in v ');
define('AM_XFGB_UPGRADE_GO', 'Aggiornamento');
define('AM_XFGB_WARNING_UPGRADE', 'Attenzione, questa operazione modificher&agrave; alcune tabelle. <br>Fai un backup prima !');
define('AM_XFGB_ERROR', 'Errore : ');
define('AM_XFGB_UPGRADE_SUCCESS', 'Aggiorna con successo');
define('AM_XFGB_NO_UPGRADE', 'Aggiornamento non necessario');
//flags_install add V2.30
define('AM_XFGB_INSTALL_FLAGS', 'Installa un pacchetto immagini (bandiere, mappe, ...)');
define('AM_XFGB_SELECT_PACK', 'Scegli un pacchetto da installare');
define('AM_XFGB_WARNING', '<b>&nbsp;Attenzione</b>');
define('AM_XFGB_WARNING_MSG1',
       "<span style='color: #FF0000; '>&nbsp;Questa operazione canceller&agrave; i contenuti della tabella</span> %s <span style='color: #FF0000; '> e la sostituir&agrave;.</span>");
define('AM_XFGB_GOFORMOPT', ' Vai al modulo opzioni');
define('AM_XFGB_GO_UPGRADE', " Per ripristinare le tabelle, vai all'Aggiornamento");
define('AM_XFGB_ERROR_FLAGS', "<span style='color: #FF0000; '> Errore inserimento dati di %s.sql <br> Tabella %s cancellata</span>");
// img_manager add v2.30
define('AM_XFGB_IMG_DELETED', ' immagine(i) cancellata(e)');
define('AM_XFGB_IMG_FILE', 'File');
define('AM_XFGB_IMG_ORPHEAN', ' immagine(i) orfana(e)');
define('AM_XFGB_NO_ORPHEAN', 'Nessun immagine orfana');
define('AM_XFGB_ORPHEAN_DSC', ' Questa pagina ti consente di inviare le immagini che non sono allegate a un messaggio (orfane).');
// ip manager add V2.40
define('AM_XFGB_DISP_BADIPS', 'Indirizzi IP moderati automaticamente');
define('AM_XFGB_IPS', 'Indirizzo IP');
define('AM_XFGB_ADD_BADIP', 'Aggiungi un indirizzo IP');
define('AM_XFGB_MOD_BADIP', 'Modifica un indirizzo IP');
define('AM_XFGB_BADIP_VALUE', 'Valore');
define('AM_XFGB_BADIP_EXIST', "L'indirizzo IP &egrave; gi&agrave; loggato");
define('AM_XFGB_BADIP_ADDED', 'Indirizzo IP loggato!');
define('AM_XFGB_BADIP_UPDATED', 'Indirizzo IP modificato !');
define('AM_XFGB_BADIP_DELETED', 'Indirizzo IP cancellato !');
define('AM_XFGB_NOBADIP', 'Non un indirizzo IP !');
