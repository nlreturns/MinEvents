<?php

namespace minevents\app\classes;

/**
 * Deze klasse word gebruikt voor het toevoegen, aanpassen
 * en verwijderen van Afdelingen.
 * Een afdeling is een deel van M in Events.
 * Bijvoorbeeld: Bowlingbaan, Bar en Restaurant.
 *
 * @package    minevents\app\classes
 * @author     Donny van Walsem <donnehvw@gmail.com>
 * @version    1.0
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      File available since 11/11/2014
 */
class Afdeling {
    /**
     * Beschrijving van de afdeling.
     * @var string $afdeling_desc
     */
    public $afdeling_desc;
    /**
     * Het ID van de afdeling.
     * @var int $afdeling_id
     */
    public $afdeling_id;
    /**
     * Titel van de afdeling.
     * @var string $afdeling_title
     */
    public $afdeling_title;
    /**
     * Bevat het Mysqli object.
     * @var object Mysqli
     */
    public $mysqli;
    /**
     * @var Item
     */
    private $db;

    /**
     * Calls Item's constructor.
     */
    public function __construct() {
        // insert name of the table, id field, title field and description field
        $this->db = new Item('afdeling', 'afdeling_id', 'afdeling_naam', 'afdeling_beschrijving');
    }

    /**
     * Adds afdeling using the inserted parameters and DbItem's functions.
     * @param type $afdeling_title
     * @param type $afdeling_desc
     * @return boolean
     */
    public function add($afdeling_title, $afdeling_desc) {
        // if title and desc are empty:
        if(empty($afdeling_title) and empty($afdeling_desc)) {
            // return error
            echo ERROR_MISSING_BOTH;
            return FALSE;
            // if title is empty
        } elseif(empty($afdeling_title)) {
            // return error
            echo ERROR_MISSING_TITLE;
            return FALSE;
            // if description is empty
        } elseif(empty($afdeling_desc)) {
            // return error
            ERROR_MISSING_DESC;
            return FALSE;
            // if both vars are filled
        } elseif(!empty($afdeling_title) or !empty($afdeling_desc)) {
            // execute DbItem's addItem using inserted parameters
            return $this->db->addItem($afdeling_title, $afdeling_desc);
        }

    }

    /**
     * Edits afdeling using the inserted parameters and DbItem's functions.
     * @param type $afdeling_id
     * @param type $afdeling_title
     * @param type $afdeling_desc
     * @return type bool
     */
    public function edit($afdeling_id, $afdeling_title, $afdeling_desc) {
        return $this->db->editItem($afdeling_id, $afdeling_title, $afdeling_desc);
    }

    /**
     * Gets afdeling by id from database using DbItem's getItemById.
     * @param type $afdeling_id
     * @return type array
     */
    public function getAfdelingById($afdeling_id) {
        return $this->db->getItemById($afdeling_id);

    }

    /**
     * Gets entire list from database using DbItem's getItemList.
     * @return type array
     */
    public function getList() {
        return $this->db->getList();
    }

    /**
     * Zet de Titel van de Afdeling in object.
     * @param string $title Titel van de Afdeling
     * @return void
     */
    public function setTitel($title) {
        if(!empty($title)) {
            $this->afdeling_title = $title;
        }
    }

    /**
     * Zet de beschrijving in attribuut.
     * @param string $desc Beschrijving van Afdeling
     * @return void
     */
    public function setBeschrijving($desc) {
        if(!empty($desc)) {
            $this->afdeling_desc = $desc;
        }
    }

    public function create() {
        if(!empty($this->afdeling_id) && !empty($this->afdeling_desc)) {
            $this->db->createAfdeling($this->afdeling_title, $this->afdeling_desc);
        }
    }
}

?>