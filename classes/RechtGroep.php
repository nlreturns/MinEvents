<?php

define ('RECHT_GROUP_NAME_IS_ADMIN', 'Admin');
/**
 * Description of RechtGroep
 *
 * @author Sander van Belleghem <sandervanbelleghem@live.nl>  version 0.1
 * @version 0.2 G.Hoogendoorn   Change recht_bitfield: Added rechten_bitfield type RechtBitfield
 *                               and moved functionality accordingly.
 *                               Added replaceRechtBitfield() / heeftRecht().
 */
require_once 'db_rechtgroep.php';
require_once 'RechtBitfield.php';

class RechtGroep {

    private $recht_groep_beschrijving = '';

    /**
     *
     * @var RechtBitfield The RechtBitfield holds all bitfield functionality.
     */
    private $rechtgroepnaam;
    private $rechten_bitfield;
    private $recht_groep_id;

    public function __construct($id = '') {
        $this->rechten_bitfield = new RechtBitfield();
        /**
         * If an ID is provided initialize this class
         */
        if ((strlen($id) > 0) && is_numeric($id)) {
            $this->recht_groep_id = $id;
            $this->getRechtGroep();

        }

    }

    public function deleteRechtGroep() {
        $dbRechtGroep = new DbRechtGroep();
        $dbRechtGroep->setRechtGroepId($this->recht_groep_id);
        $dbRechtGroep->deleteRechtGroep();

        // Update class members
        $this->reset();
    }


    public function getRechtBitfield() {
        return $this->rechten_bitfield->getBitfield();;
    }

    /**
     *  The method will
     * @return bool
     */
    public function getRechtGroep() {
        $dbRechtGroep = new DbRechtGroep();
        $dbRechtGroep->setRechtGroepId($this->recht_groep_id);
        $data = $dbRechtGroep->getRechtGroep();

        if (!empty($data)) {
            // Update class members
            $this->populate($data);
            return TRUE;
        }
    }

    /**
     * getRecht_groep_beschrijving()
     *
     * @return type Description
     */
    public function getRechtGroepBeschrijving() {
        return $this->recht_groep_beschrijving;
    }

    /**
     *
     * @return array Containing *ALL* known RightGroups
     *
     */
    public function getRechtGroepList() {
        $dbGroep = new DbRechtGroep();
        return $dbGroep->getRechtGroepList();
    }

    /**
     * getRechtGroupNameById($id) <br />
     *  Find the name based on a single id<br />
     *
     * @param type $id
     * @return String containing the name that belongs to the id<br />
     *         or empty string if the id is not found OR is invalid.
     *
     */
    public function getRechtGroupNameById($id) {

        if (!is_numeric($id)) {

            return '';
        }

        /**
         * Get the whole list of groups
         */
        $group_array = $this->getRechtGroepList();
        /*
         * Find the name
         */
        foreach ($group_array as $group_id => $group_info_array) {

            if ($group_info_array["recht_groep_id"] == $id) {

                /* Just the name */
                return $group_info_array['recht_groep_beschrijving'];
            }
        }

        /** Oops no $id Found **/
        return '';
    }

    /**
     *
     * @param int $recht_positie Position of the right 2B checked
     * @return bool TRUE if the right exists FALSE otherwise
     */
    public function heeftRecht($recht_positie) {

        return $this->rechten_bitfield->heeftRecht($recht_positie);
    }

    /**
     *  Wrapper for the bitfield function.
     *
     * @param type $recht_array
     * @return type
     */
    public function heeftMinimaal1Recht($recht_array) {


        return $this->rechten_bitfield->heeftMinimaal1Recht($recht_array);
    }


    public function isAdmin($name) {
        // Check input param firsth
        if (strlen($name) > 0 && (!is_numeric($name))) {

            // Compare the name to the admin group name: Note make it case insensitive
            // Remember strcmp returns 0 on equal, so if equal return TRUE
            return (0 == strcmp(strtolower($name), strtolower(RECHT_GROUP_NAME_IS_ADMIN)));
        }
        return FALSE;
    }

    public function rechtGroupExists($recht_group_id) {

        // Check input param firsth
        if (strlen($recht_group_id) > 0 && is_numeric($recht_group_id)) {

            $dbRechtGroup = new DbRechtGroep();

            return $dbRechtGroup->groupExists($recht_group_id);
        }
        return FALSE;
    }

    /**
     *
     * @param String $name Groupname 2B looked up
     * @return bool TRUE if found
     */
    public function rechtGroupNameExists($name) {
        // Check input param firsth
        if (strlen($name) > 0 && (!is_numeric($name))) {

            $dbRechtGroup = new DbRechtGroep();

            return $dbRechtGroup->groupNameExists($name);
        }
        return FALSE;
    }

    /**
     * replaceRechtBitfield() <br />
     *  Replace instant the current rechten_bitfield by the positions as
     *      provided in the input array. <br />
     *      Since version 0.2
     *
     * @param Array $rechten_array Containing the positions of the rights.
     */
    public function replaceRechtBitfield($rechten_array) {


        $this->rechten_bitfield->replaceRecht($rechten_array);

        /* Save the class info to the database */
        $this->updateRechtGroep();

    }

    /**
     * Reset class members
     */
    public function reset() {

        $this->recht_groep_beschrijving = 0;
        $this->recht_groep_id           = 0;
        $this->rechten_bitfield         = new RechtBitfield();
    }

    public function setRechtGroepId($recht_groep_id) {
        if (!empty($recht_groep_id)) {
            $this->recht_groep_id = $recht_groep_id;
        }
    }

    public function setRechtGroepBeschrijving($recht_groep_beschrijving) {
        if (is_string($recht_groep_beschrijving)) {
            $this->recht_groep_beschrijving = $recht_groep_beschrijving;
        }
    }

    /**
     *
     */
    public function setRechtBitfield() {
            $this->rechten_bitfield->setBitfield($this->rechten_bitfield);

    }
    public function saveRechtGroep() {

        $dbRechtGroep = new DbRechtGroep();
        $dbRechtGroep->setRechtGroepNaam($this->rechtgroepnaam);
        $dbRechtGroep->setRechtGroepBitfield(
            serialize($this->getRechtBitfield())
        );
        $dbRechtGroep->setRechtGroepBeschrijving($this->recht_groep_beschrijving);

        if ($dbRechtGroep->saveRechtGroep($this->rechten_bitfield)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function setRechtgroepNaam($rechtgroepnaam) {
        $this->rechtgroepnaam = $rechtgroepnaam;
    }

    public function updateRechtGroep() {

        $dbRechtGroep = new DbRechtGroep();
        /**
         * Add all parts..
         */
        $dbRechtGroep->setRechtGroepId($this->recht_groep_id);
        $dbRechtGroep->setRechtGroepBitfield($this->rechten_bitfield);
        $dbRechtGroep->setRechtGroepBeschrijving($this->recht_groep_beschrijving);


        // Now update and save
        $dbRechtGroep->updateRechtGroep();
    }


    /**
     * Update class members based on db data input
     *
     * @param array $data
     * @return bool TRUE on succes | FALSE on failure
     */
    private function populate($data) {

        if (is_array($data)) {

            if (isset($data["bitfield"])) {
                $this->rechten_bitfield->setBitfield($data["bitfield"]);
            }
            if (isset($data["recht_groep_beschrijving"])) {
                $this->recht_groep_beschrijving = $data["recht_groep_beschrijving"];
            }
            if (isset($data["recht_groep_id"])) {
                $this->recht_groep_id = $data["recht_groep_id"];
            }
        }
        return TRUE;
    }

    public function addRechtgroepRecht($recht_positie) {
        $this->rechten_bitfield->addRecht($recht_positie);
    }

}

class TestRechtGroep {

    public function __construct() {
        try {
            $test = new RechtGroep();

            echo '<pre>';
            var_dump($test);
            echo '</pre>';
        } catch (Exception $e) {
            echo '<pre>';
            echo $e->getTraceAsString();
            echo '</pre>';
            trigger_error($e->getMessage());
        }
    }

}

?>
