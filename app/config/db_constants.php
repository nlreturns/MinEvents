<?php
/**
 *
 * Database definition file.
 *
 * @author GHoogendoorn
 * @version 0.1
 */

/* Database inlog gegevens */
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "Carolien123");
define("DB_NAME", "minevents");


/* TABLE definitions */
define("TBL_GEBRUIKER",                 "gebruiker");
define("TBL_PERSOON",                   "persoon");
define("TBL_MESSAGEBOARD",              "messageboard");
define("TBL_MESSAGETYPE",               "message_type");
define("TBL_MESSAGESTATUS",             "message_status");
define("TBL_MESSAGE_CHANGE_HISTORY",    "message_change_history");
define("TBL_MESSAGE_PRIO",              "message_prio");
define("TBL_MODULE",                    "module");
define("TBL_TICKETSYSTEEM",              "ticketsysteem");
define("TBL_TICKETSTATUS",             "ticket_status");
define("TBL_TICKETPRIO",               "ticket_prio");
define("TBL_TICKETLOC",               "ticket_loc");
define("TBL_ROOSTER",                   "rooster");
define("TBL_TIJDBLOK",                  "rooster_tijdblok");
define("TBL_PERSOONSGEGEVENS",          "rooster_persoonsgegevens");
define("TBL_TAAK",                      "rooster_taak");
define("TBL_TIJDBLOK_TAAK",             "rooster_tijdblok_taak");
define("TBL_ROOSTERSTATUS",             "rooster_status");
/* TABLE FIELD definitions */

/* TABLE definitions */
define("TBL_MARKETING",                 "marketing");
define("TBL_MARKETING_EMAIL",           "marketing_email");
define("TBL_MARKETING_TELEFOONTYPE",    "marketing_telefoontype");
define("TBL_MARKETING_TELEFOONLIJST",   "marketing_telefoonlijst");
define("TBL_MARKETING_STATUS",          "marketing_status");
/* TABLE FIELD definitions */

/* TBL_MESSAGEBOARD */
define("FIELD_MSGBRD_ID",               "msg_id");
define("FIELD_MSGBRD_TITLE",            "msg_titel");
define("LEN_MSGBRD_TITLE",              64);
define("FIELD_MSGBRD_DESC",             "msg_beschrijving");
define("LEN_MSGBRD_DESC",               2048);
define("FIELD_MSGBRD_FROM",             "msg_from");
define("FIELD_MSGBRD_TO",               "msg_to_persoon");
define("FIELD_MSGBRD_DEADLINE",         "msg_deadline");
define("FIELD_MSGBRD_CREATE_TIME",      "msg_create_tijd");
define("FIELD_MSGBRD_ORIGINAL_TYPE_ID", "msg_orig_creator_type");
define("FIELD_MSGBRD_ORIGINAL_CREATOR_ID","msg_orig_creator");
define("FIELD_MSGBRD_LINK",             "msg_link");
define("LEN_MSGBRD_LINK",               256);


/* TBL_MESSAGE"TYPE */
define("FIELD_MSG_TYPE_ID",             "msg_type_id");
define("FIELD_MSG_TYPE_NAME",           "msg_type_name");
define("LEN_MSG_TYPE_NAME",             32);
define("FIELD_MSG_TYPE_DESC",           "msg_type_beschrijving");
define("LEN_MSG_TYPE_DESC",             128);

/* TBL_MESSAGESTATUS */
define("FIELD_MSG_STATUS_ID",           "msg_status_id");
define("FIELD_MSG_STATUS_NAME",         "msg_status_label");
define("LEN_MSG_STATUS_NAME",           32);
define("FIELD_MSG_STATUS_DESC",         "msg_status_beschrijving");
define("LEN_MSG_STATUS_DESC",           128);

/* TBL_MESSAGE_CHANGE_HISTORY */
define("FIELD_MSG_CHANGE_ID",               "msg_change_id");
define("FIELD_MSG_CHANGE_TIME",             "msg_change_time");
define("FIELD_MSG_CHANGE_DESC",             "msg_change_beschrijving");

/* TBL_MESSAGE_PRIO */
define("FIELD_MSG_PRIO_LEVEL",              "msg_prio_level");
define("LEN_MSG_PRIO_LEVEL",                16);
define("FIELD_MSG_PRIO_DESC",               "msg_prio_beschrijving");

/* TBL_MODULE */
define( "FIELD_MODULE_ID",                  "module_id");
define( "FIELD_MODULE_NAME",                "module_naam");
define( "FIELD_MODULE_DESC",                "module_beschrijving");


/* TBL_USER */
define("FIELD_USER_ID",                     "pers_id");


/* TBL_TICKETSYSTEEM */
define("FIELD_TICKET_ID",               "ticket_id");
define("FIELD_PERS_ID",                 "pers_id");
//define("FIELD_TICKET_LOCATION_ID",         "ticket_loc_id");
//define("FIELD_TICKET_PRIO_ID",             "ticket_prio_id");
define("FIELD_TICKET_TITLE",            "ticket_titel");
define("LEN_TICKET_TITLE",              64);
define("FIELD_TICKET_DESC",             "ticket_beschrijving");
define("LEN_TICKET_DESC",               2048);
//define("FIELD_TICKET_STATUS_ID",           "ticket_status_id");
define("FIELD_TICKET_PROGRESS",         "ticket_progress");
define("LEN_TICKET_PROGRESS",           2048);
define("FIELD_TICKET_CREATE_TIME",      "ticket_create_tijd");
define("FIELD_TICKET_END_TIME",         "ticket_end_tijd");
define("FIELD_AFDELING_ID",             "afdeling_id");
define("FIELD_OBJECT_ID",               "object_id");

/* TBL_TICKETSYSTEEM_STATUS */
define("FIELD_TICKET_STATUS_ID",        "ticket_status_id");
define("FIELD_TICKET_STATUS_NAME",         "ticket_status_label");
define("LEN_TICKET_STATUS_NAME",           32);
define("FIELD_TICKET_STATUS_DESC",         "ticket_status_beschrijving");
define("LEN_TICKET_STATUS_DESC",           128);

/* TBL_TICKETSYSTEEM_PRIO */
define("FIELD_TICKET_PRIO_ID",             "ticket_prio_id");
define("FIELD_TICKET_PRIO_NAME",           "ticket_prio_label");
define("LEN_TICKET_PRIO_NAME",             32);
define("FIELD_TICKET_PRIO_DESC",           "ticket_prio_beschrijving");
define("LEN_TICKET_PRIO_DESC",             128);

/* TBL_TICKETSYSTEEM_LOCATIE */
define("FIELD_TICKET_LOC_ID",             "ticket_loc_id");
define("FIELD_TICKET_LOC_NAME",           "ticket_loc_label");
define("LEN_TICKET_LOC_NAME",             32);
define("FIELD_TICKET_LOC_DESC",           "ticket_loc_beschrijving");
define("LEN_TICKET_LOC_DESC",             128);

/* TBL_MARKETING */
define("FIELD_MARKETING_KLANT_ID",         "marketing_klant_id");
define("FIELD_MARKETING_VOORNAAM",         "marketing_voornaam");
define("LEN_MARKETING_VOORNAAM",           32);
define("FIELD_MARKETING_ACHTERNAAM",       "marketing_achternaam");
define("LEN_MARKETING_ACHTERNAAM",         32);
define("FIELD_MARKETING_POSTCODE",         "marketing_postcode");
define("LEN_MARKETING_POSTCODE",           32);
define("FIELD_MARKETING_VOORKEUREN",       "marketing_voorkeuren");
define("FIELD_MARKETING_GEBOORTEDATUM",    "marketing_geboortedatum");
define("LEN_MARKETING_GEBOORTEDATUM",      10);
define("FIELD_MARKETING_CREATE_TIME",      "marketing_create_tijd");

/* TBL_MARKETING_EMAIL */
//define("FIELD_MARKETING_KLANT_ID",            "marketing_klant_id");
define("FIELD_MARKETING_EMAILADRES",            "marketing_emailadres");
define("LEN_MARKETING_EMAILADRES",              32);
define("FIELD_MARKETING_BESCHRIJVING",          "marketing_beschrijving");  
define("LEN_MARKETING_BESCHRIJVING",            256);  

/* TBL_MARKETING_TELEFOONLIJST */
define("FIELD_MARKETING_TYPE",                  "marketing_type");
define("FIELD_MARKETING_NUMMER",                "marketing_nummer");

/* TBL_MARKETING_TELEFOONTYPE */
define("FIELD_MARKETING_NAAM",                  "marketing_naam");
define("LEN_MARKETING_NAAM",                    32);

/* TBL_ROOSTER */
define("FIELD_ROOSTER_ID",              "rooster_id");
define("FIELD_ROOSTER_CREATE_TIME",     "creatietijd");
define("FIELD_ROOSTER_AANMAAK_PERSOON", "aanmaakpersoon");
define("LEN_ROOSTER_AANMAAK_PERSOON",   64);
define("FIELD_ROOSTER_STATUS",          "roosterstatus");
define("LEN_ROOSTER_STATUS",            64);
define("FIELD_ROOSTER_TEXT",            "tekst");
define("LEN_ROOSTER_TEXT",              132);

/* TBL_ROOSTER"TIJDBLOK */
define("FIELD_ROOSTER_TIJDBL_TIJD_ID",         "tijd_id");
define("FIELD_ROOSTER_TIJDBL_BEGINTIJD",       "begintijd");
define("FIELD_ROOSTER_TIJDBL_EINDTIJD",        "eindtijd");

/* TBL_ROOSTER"PERSOONSGEGEGEVENS */
define("FIELD_ROOSTER_PERSG_PERSOON_ID",         "persoon_id");
define("FIELD_ROOSTER_PERSG_PERSOON_TAAK",       "taak");
define("LEN_ROOSTER_PERSG_PERSOON_TAAK",         64);

/* TBL_ROOSTER"TAAK */
define("FIELD_ROOSTER_TAAK_ID",                 "taak_id");
define("FIELD_ROOSTER_TAAK_DESC",               "taak_beschrijving");
define("LEN_ROOSTER_TAAK_DESC",                 64);

/* TBL_ROOSTERSTATUS */
define("FIELD_ROOSTER_STATUS_ID",           "rooster_status_id");
define("FIELD_ROOSTER_STATUS_NAME",         "rooster_status_label");
define("LEN_ROOSTER_STATUS_NAME",           32);
define("FIELD_ROOSTER_STATUS_DESC",         "rooster_status_beschrijving");
define("LEN_ROOSTER_STATUS_DESC",           128);

// text constants
define("TXT_NO_DATA",               "Geen gegevens gevonden.");

?>
