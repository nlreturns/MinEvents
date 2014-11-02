<?php
/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 * @author Ghoogendoorn
 * @version 0.2
 *
 * Version history
 * 0.1      GHoogendoorn        Initial version
 * 0.2  `   GHoogendoorn        Added msg board prio + change history.
 *
 * 
 * If the path is not found ad the following line to the config.php:
 *  ini_set('include_path', './' . PATH_SEPARATOR . "./common/". PATH_SEPARATOR . ini_get('include_path'));
 */
set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );


define("WWW_ROOT",                      "");
define("DIR_INCLUDE",                   WWW_ROOT."includes/");
define("DIR_ADMIN",                     WWW_ROOT."admin/");
define("DIR_ADMIN_INCLUDE",             DIR_ADMIN."includes/");
define("DIR_ADMIN_CLASS",               DIR_ADMIN_INCLUDE."classes/");
define("DIR_CLASS",                     WWW_ROOT."classes/");
define("DIR_LANGUAGE",                  WWW_ROOT."lang/");
define("DIR_DEFINES",                   DIR_CLASS."defs/");

define("PAGE_HOME",                     "/index.php");
define("PAGE_ADMIN",                    DIR_ADMIN."admin.php");


define ("FILE_DATABASE",                DIR_CLASS."database.php");
define ("FILE_DB_TYPE",                 DIR_CLASS."db_type.php");

/* Main messageboard files */
define("FILE_MESSAGEBOARD",             "messageboard.php");
define("FILE_CLASS_MESSAGEBOARD",       DIR_CLASS.FILE_MESSAGEBOARD);
define("FILE_DB_MESSAGEBOARD",          DIR_CLASS."db_".FILE_MESSAGEBOARD);

/* Gebruiker & Persoon*/
define("FILE_DB_GEBRUIKER",             DIR_CLASS."db_gebruiker.php");
define("FILE_DB_DATABASE",              DIR_CLASS."database.php");
define("FILE_DB_PERSOON",               DIR_CLASS."db_persoon.php");
define("FILE_GEBRUIKER",                DIR_CLASS."gebruiker.php");
define("FILE_PERSOON",                  DIR_CLASS."persoon.php");
define("FILE_AFDELING",                 DIR_CLASS."afdeling.php");
define("FILE_OBJECT",                   DIR_CLASS."object.php");
define("FILE_PRIORITEIT",               DIR_CLASS."prioriteit.php");
/* Message board status files */
define("FILE_MESSAGEBOARD_STATUS",      "messageboard_status.php");
define("FILE_DB_MESSAGEBOARD_STATUS",   DIR_CLASS."db_".FILE_MESSAGEBOARD_STATUS);
define("FILE_CLASS_MESSAGEBOARD_STATUS",DIR_CLASS.FILE_MESSAGEBOARD_STATUS);

/* Message board type files */
define("FILE_MESSAGEBOARD_TYPE",        "messageboard_type.php");
define("FILE_DB_MESSAGEBOARD_TYPE",     DIR_CLASS."db_".FILE_MESSAGEBOARD_TYPE);
define("FILE_CLASS_MESSAGEBOARD_TYPE",  DIR_CLASS.FILE_MESSAGEBOARD_TYPE);

/* Message board priority files */
define ('FILE_MESSAGEBOARD_PRIO',       'messageboard_prio.php');
define ('FILE_DB_MESSAGEBOARD_PRIO',    DIR_CLASS."db_".FILE_MESSAGEBOARD_PRIO);
define ('FILE_CLASS_MESSAGEBOARD_PRIO', DIR_CLASS.FILE_MESSAGEBOARD_PRIO);

/* Message board change history */
define ('FILE_MESSAGEBOARD_CHANGE_HIST',        'messageboard_change_history.php');
define ('FILE_DB_MESSAGBOARD_CHANGE_HIST',      DIR_CLASS."db_". FILE_MESSAGEBOARD_CHANGE_HIST);
define ('FILE_CLASS_MESSAGEBOARD_CHANGE_HIST',  DIR_CLASS.FILE_MESSAGEBOARD_CHANGE_HIST);
/* Message board status definition */
define ("MSG_STATUS_NEW",               '1');
define ("MSG_STATUS_INPROGRESS",        '2');
define ("MSG_STATUS_CLOSED",            '4');
define ("MSG_STATUS_ALL",               '7');
define ("MSG_STATUS_NOT_CLOSED",        '8');


/* Message board type definition (Only types that the classes should know) */
define ('MSG_TYPE_MODULE',              '1');
define ('MSG_TYPE_PERSON',              '2');

/* Main ticketsysteem files */
define("FILE_TICKETSYSTEEM",             DIR_CLASS."ticketsysteem.php");
define("FILE_LOCATION",                "location.php");
define("FILE_CLASS_TICKETSYSTEEM",       DIR_CLASS.FILE_TICKETSYSTEEM);
define("FILE_DB_TICKETSYSTEEM",          DIR_CLASS."db_ticket.php");
define("FILE_TESTTICKETSYSTEEM",        DIR_INCLUDE. FILE_TICKETSYSTEEM);

/* ticketsysteem status files */
define("FILE_TICKETSYSTEEM_STATUS",      "ticketsysteem_status.php");
define("FILE_DB_TICKETSYSTEEM_STATUS",   DIR_CLASS."db_".FILE_TICKETSYSTEEM_STATUS);
define("FILE_CLASS_TICKETSYSTEEM_STATUS",DIR_CLASS.FILE_TICKETSYSTEEM_STATUS);

/* ticketsysteem prio files */
define("FILE_TICKETSYSTEEM_PRIO",      "ticketsysteem_prio.php");
define("FILE_DB_TICKETSYSTEEM_PRIO",   DIR_CLASS."db_".FILE_TICKETSYSTEEM_PRIO);
define("FILE_CLASS_TICKETSYSTEEM_PRIO",DIR_CLASS.FILE_TICKETSYSTEEM_PRIO);

/* ticketsysteem loc files */
define("FILE_TICKETSYSTEEM_LOC",      "ticketsysteem_loc.php");
define("FILE_DB_TICKETSYSTEEM_LOC",   DIR_CLASS."db_".FILE_TICKETSYSTEEM_LOC);
define("FILE_CLASS_TICKETSYSTEEM_LOC",DIR_CLASS.FILE_TICKETSYSTEEM_LOC);

/* ticketsysteem type files */
define("FILE_TICKETSYSTEEM_TYPE",        "ticketsysteem_type.php");
define("FILE_DB_TICKETSYSTEEM_TYPE",     DIR_CLASS."db_".FILE_TICKETSYSTEEM_TYPE);
define("FILE_CLASS_TICKETSYSTEEM_TYPE",  DIR_CLASS.FILE_TICKETSYSTEEM_TYPE);

/* ticket systeem status definition */
define ("TICKET_STATUS_AANGEMELD",               '1');
define ("TICKET_STATUS_INUITVOERING",        '2');
define ("TICKET_STATUS_GESLOTEN",            '3');

/* ticket systeem prio definition */
define ("TICKET_PRIO_VEILIGHEID",           '1');
define ("TICKET_PRIO_COMMERCIEEL",        '2');
define ("TICKET_PRIO_ONDERHOUD",            '3');

/* ticket systeem location definition */
define ("TICKET_LOC_RECEPTIE",           '1');
define ("TICKET_LOC_BRASSERIE_BAR",        '2');
define ("TICKET_LOC_BOWLING",            '3');
define ("TICKET_LOC_TOILETTEN",           '4');
define ("TICKET_LOC_KEUKEN",        '5');
define ("TICKET_LOC_FEESTZAAL",            '6');
define ("TICKET_LOC_SPEELZAAL_COUNTER",           '7');
define ("TICKET_LOC_TERRAS_BUITEN",        '8');
define ("TICKET_LOC_LASERGAME",            '9');
define ("TICKET_LOC_KANTOOR",            '10');
define ("TICKET_LOC_OVERIG",                '11');

/* Main marketing files */
define("FILE_MARKETING",                                "marketing.php");
define("FILE_CLASS_MARKETING",                          DIR_CLASS.FILE_MARKETING);
define("FILE_DB_MARKETING",                             DIR_CLASS."db_".FILE_MARKETING);

/* Main marketing email files */
define("FILE_MARKETING_EMAIL",                          "marketing_email.php");
define("FILE_CLASS_MARKETING_EMAIL",                    DIR_CLASS.FILE_MARKETING_EMAIL);
define("FILE_DB_MARKETING_EMAIL",                       DIR_CLASS."db_".FILE_MARKETING_EMAIL);

/* Main marketing telefoontype files */
define("FILE_MARKETING_TELEFOONTYPE",                    "marketing_telefoontype.php");
define("FILE_CLASS_MARKETING_TELEFOONTYPE",              DIR_CLASS.FILE_MARKETING_TELEFOONTYPE);
define("FILE_DB_MARKETING_TELEFOONTYPE",                 DIR_CLASS."db_".FILE_MARKETING_TELEFOONTYPE);

/* Main marketing telefoonlijst files */
define("FILE_MARKETING_TELEFOONLIJST",                    "marketing_telefoonlijst.php");
define("FILE_CLASS_MARKETING_TELEFOONLIJST",              DIR_CLASS.FILE_MARKETING_TELEFOONLIJST);
define("FILE_DB_MARKETING_TELEFOONLIJST",                 DIR_CLASS."db_".FILE_MARKETING_TELEFOONLIJST);
/* Marketing status definition */
define ("MARKETING_STATUS_NEW",               '1');
define ("MARKETING_STATUS_INPROGRESS",        '2');
define ("MARKETING_STATUS_CLOSED",            '3');
define ("MARKETING_STATUS_ALL",               '7');
define ("MARKETING_STATUS_NOT_CLOSED",        '8');

/* Message board type definition (Only types that the classes should know) */
define ('MARKETING_TYPE_MODULE',              '1');
define ('MARKETING_TYPE_PERSON',              '2');

/* Main rooster files */
define("FILE_ROOSTER",                  "rooster.php");
define("FILE_CLASS_ROOSTER",            DIR_CLASS.FILE_ROOSTER);
define("FILE_DB_ROOSTER",               DIR_CLASS."db_".FILE_ROOSTER);

/* Main tijdblok files */
define("FILE_TIJDBLOK",                 "tijdblok.php");
define("FILE_CLASS_ROOSTER_TIJDBLOK",   DIR_CLASS.FILE_TIJDBLOK);
define("FILE_DB_ROOSTER_TIJDBLOK",      DIR_CLASS."db_rooster_".FILE_TIJDBLOK);

/* Main taak files */
define("FILE_TAAK",                     "taak.php");
define("FILE_CLASS_ROOSTER_TAAK",       DIR_CLASS.FILE_TAAK);
define("FILE_DB_ROOSTER_TAAK",          DIR_CLASS."db_rooster_".FILE_TAAK);

/* Main personeelsgegevens files */
define("FILE_PERSOONSGEGEVENS",                "rooster_persoonsgegevens.php");
define("FILE_CLASS_PERSOONSGEGEVENS",         DIR_CLASS.FILE_PERSOONSGEGEVENS);
define("FILE_DB_ROOSTER_PERSOONSGEGEVENS",    DIR_CLASS."db_".FILE_PERSOONSGEGEVENS);

/* Main status files */
define("FILE_STATUS",                   "rooster_status.php");
define("FILE_CLASS_STATUS",             DIR_CLASS.FILE_STATUS);
define("FILE_DB_ROOSTER_STATUS",        DIR_CLASS."db_".FILE_STATUS);


define("FILE_ITEM",                   	"item.php");
define("FILE_DB_ITEM",        			DIR_CLASS."db_".FILE_ITEM);

/* Main login files */
define("FILE_SESSION",					"session.php");
define("FILE_CLASS_SESSION",            DIR_CLASS.FILE_SESSION);
define("FILE_LOGIN",					"loginsysteem.php");
define("FILE_CLASS_LOGIN",             	DIR_CLASS.FILE_LOGIN);
define("FILE_DB_LOGIN", 				DIR_CLASS."db_".FILE_LOGIN);
/**
 *  DEBUG SECTION
 *      Turn debug off by commenting :
 *      //define ("DEBUG_ON",        0x0000);
 */
define ("DEBUG_ON",                 0);
/*
if ( defined(DEBUG_ON) ) {
    /* This is a bitfield... 
    define ("DEBUG_SQL_QUERY",      0x0001);
    define ("DEBUG_SQL_LINK",       0x0002);
    define ("DEBUG_MODULE",         0x0004);
    define ("DEBUG_CLASS",          0x0008);
    define ("DEBUG_GUI",            0x0010);

    define ("DEBUG_ALL",            0xFFFF);

    define ("DEBUG_LEVEL",              DEBUG_ALL);
} else {
   define ("DEBUG_LEVEL",           0x0000);
}*/

/**
 * End of debug section
 */
?>