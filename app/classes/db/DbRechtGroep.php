<?php
namespace minevents\app\classes\db;
/**
 * Description of DbRechtGroep
 *
 * @author Sander van Belleghem <sandervanbelleghem@live.nl>
 * @version 0.1
 */
class DbRechtGroep extends Database
{

    private $recht_groep_id;
    private $recht_groep_naam;
    //private $recht_bit_id;
    private $recht_bitfield = array();
    private $recht_groep_beschrijving;

    public function __construct()
    {
        parent::__construct();
    }

    // Getters
    public function getRechtGroepId()
    {
        return $this->recht_groep_id;
    }

    public function getRechtGroepBeschrijving()
    {
        return $this->recht_groep_beschrijving;
    }

    // Setters
    public function setRechtGroepId($recht_groep_id)
    {
        $this->recht_groep_id = $recht_groep_id;
    }

    public function setRechtGroepNaam($naam)
    {
        $this->recht_groep_naam = $naam;
    }

    /**
     *
     * @param array of Bitfield() $recht_bitfield
     * @return bool FALSE
     */
    public function setRechtGroepBitfield($recht_bitfield)
    {

        if (is_object($recht_bitfield)) {

            $this->recht_bitfield = $this->dataObject2Array($recht_bitfield);

        } else {
            // input error
            return false;
        }
        return true;
    }

    public function setRechtGroepBeschrijving($recht_groep_beschrijving)
    {

        //Check input
        if (!empty($recht_groep_beschrijving)) {

            // Get rid of additional leading and trailing spaces
            $this->recht_groep_beschrijving = trim($recht_groep_beschrijving);
        }
    }


    public function getRechtGroep()
    {

        $return_data = array();
        if (empty($this->recht_groep_id)) {

            return false;
        }

        /*
        ** Select from both tables recht_groep and recht_bitfield_parts
        */

        $query = "SELECT * FROM  `recht_groep` LEFT JOIN `recht_bitfield_parts`" .
            " ON  `recht_groep`.`recht_groep_id` = `recht_bitfield_parts`.`recht_groep_id`" .
            " WHERE `recht_groep`.`recht_groep_id` = '" . $this->dbInString($this->recht_groep_id) . "'" .
            " ORDER BY `recht_bitfield_parts`.`recht_groep_id`,`recht_bitfield_parts`.`recht_bitfield_nr`";
        //echo __FILE__. __LINE__. $query;
        if (!$this->dbquery($query)) {

            return false;
        }

        // If data found create return data
        if ($this->dbNumRows() >= 1) {

            $db_data = $this->dbFetchAll();

            // Format database data for the application
            $return_data = $this->dataDB2Applictie($db_data);


        } else {
            /* No data for this id ... */
            return false;
        }

        return $return_data;

    }


    public function getRechtGroepList()
    {

        /**
         * @todo Add the join on recht_bitfield_parts parts.
         */
        $query = "SELECT * FROM  `recht_groep` " .
            "ORDER BY `recht_groep_beschrijving`";


        $this->dbquery($query);

        // If error return false
        if (!$this->checkDbErrors($query)) {

            // Return type array
            $return_data = array();

            // If data get them:
            if ($this->dbNumRows() >= 1) {

                // Retrieve query data as an array
                $return_data = $this->dbFetchAll();
            }

            return $return_data;
        }

        // Found errors
        return FALSE;
    }

    public function groupNameExists($name)
    {

        /**
         *  Check id
         * @todo remove magic number 64 (length of name field)
         */
        if (!$this->checkText($name, 64)) {
            return false;
        }

        $query = "SELECT * FROM `recht_groep` WHERE `recht_groep`.`recht_groep_beschrijving` ='" . $this->dbInString(trim($name)) . "'";

        if ($this->dbquery($query)) {
            // Return TRUE if number of rows 1 or more.
            return ($this->dbNumRows() > 0);
        }
        // Error on query return
        return false;
    }

    /**
     *  Lookup the id in the database and if exists return TRUE
     *
     * @param int $id
     * @return bool TRUE if exists
     */
    public function groupExists($id)
    {

        // Check id
        if (!$this->checkId($id, 'Rechtgroup_id')) {
            return false;
        }

        $query = "SELECT * FROM `recht_groep` WHERE `recht_groep`.`recht_groep_id` = $id";

        if ($this->dbquery($query)) {
            // Return TRUE if number of rows 1 or more.
            return ($this->dbNumRows() > 0);
        }
        // Error on query return
        return false;

    }

    /**
     *
     * Save the recht_group with its description
     *
     * @return bool TRUE on succes
     *
     */
    public function saveRechtGroep($recht_bitfield)
    {
        var_dump($recht_bitfield, $this->recht_groep_naam,
            $this->recht_groep_beschrijving);
        // In order to prevent duplicate entries: The recht_group_beschrijving in DB SHOULD BE unique!!
        $insertquery = "INSERT INTO recht_groep (recht_bitfield, recht_groep_beschrijving,
        recht_groep_naam)
        VALUES ('" . $this->dbInString(serialize($recht_bitfield)) . "',
        '" . $this->dbInString($this->recht_groep_beschrijving) . "',
        '" . $this->dbInString($this->recht_groep_naam) . "')";

        if ($this->dbquery($insertquery)) {

            $this->recht_groep_id = mysql_insert_id();
            return true;

        } else {

            // Error occured
            return false;
        }
    }

    /**
     *
     * @return bool TRUE on succes | FALSE on failure
     */
    public function updateRechtGroep()
    {

        /**
         *  Update recht groep.
         */
        $query = "UPDATE recht_groep " .
            "SET recht_groep_beschrijving = '" . $this->dbInString($this->recht_groep_beschrijving) . "' " .
            "WHERE recht_groep_id =" . $this->recht_groep_id;

        echo __FILE__ . __LINE__ . $query;

        if ($this->dbquery($query)) {

            /*
             * If no error on update :
             * - Delete all current recht_bitfield_parts > 0 idx for this RechtGroep
             * - 
             * - Insert new recht_bitfield_parts fot this RechtGroep
             * 
             * On Error : Currently : No Rollback of update
             */
            if ($this->deleteBitfield()) {

                /* 
                 * On succes:
                 *  Add recht_groep met recht_bitfield_parts.
                 */
                return $this->saveBitfield();
            }
        }
        // Error during update query rechtgroup
        return false;
    }

    /**
     * Delete all db data that does belong to this group
     */
    public function deleteRechtGroep()
    {

        // Start deleting the bitfields that belong to this group
        $this->deleteBitfield();


        // No error if no bits found 
        // Now the bits are deleted, delete the rechtgroep
        if (($this->dbNumRows() == 0) || (!$this->checkDbErrors())) {
            /* Delete the recht_groep */
            return ($this->dbquery("DELETE FROM recht_groep WHERE recht_groep_id ='" . $this->recht_groep_id . "'"));
        }
        return false;
    }


    /**
     *
     * @param type $mysql_list_data
     * @return array
     */
    private function dataListDB2Applictie($mysql_list_data)
    {

        $return_data = array();
        $data_group_row = array();

        $group_id = '';
        // Order row data per group 
        foreach ($mysql_list_data as $idx => $data_row) {


            // Check for a new group
            if ($group_id !== $data_row['recht_groep_id']) {
                $group_id = $data_row['recht_groep_id'];

                // Check for data if exists transform to application data
                if ($idx != 0) {
                    // set the group id only if not 0 (this is the start group)                    
                    $return_data[] = $this->dataDB2Applictie($data_group_row);
                }
                // Reset current group row data
                $data_group_row = array();
            }

            // Collect the row per group
            $data_group_row[] = $data_row;
        }
        // Add the last collected rows to the set
        $return_data[] = $this->dataDB2Applictie($data_group_row);


        return $return_data;
    }

    /**
     * dataDB2Applictie()<br />
     *  The class converts the data from MySQL to an array<br />
     *  e.g. :
     *     $data_array['data1'] = value
     *     $data_array['data2'] = value
     *     $data_array['bitfield'][0] = part0
     *     $data_array['bitfield'][1] = part1
     *
     * @param array $myql_data_array
     * @return array Containing the data as described above.
     */
    private function dataDB2Applictie($mysql_data_array)
    {
        /**
         * return array format:
         *
         */
        $return_array = array();

        /* create a data array with for all bitfield parts a separate array */
        foreach ($mysql_data_array as $row_idx => $data) {

            /**
             ** First row save generic data
             */
            if ($row_idx == 0) {

                foreach ($data as $kolomname => $kolomdata) {

                    /** Skip the bitfield part specific fields */
                    if (($kolomname != 'recht_bitfield_part_id')
                        && ($kolomname != 'recht_bitfield_nr')
                        && ($kolomname != 'bitfield')
                    ) {

                        $return_array[$kolomname] = $kolomdata;
                    }
                }
            }
            /** Always store the bitfield parts **/
            $idx = $data["recht_bitfield_nr"];
            /**
             * If NULL store 0
             *  This is the case when the firsth time a group is saved,
             *  but no rights were asigned
             *
             */
            $return_array['bitfield'][$idx] = (is_null($data['bitfield']) ? 0 : $data['bitfield']);
        }

        return $return_array;
    }

    private function dataObject2Array($data_object)
    {

        $return_array = array();

        if (!is_object($data_object)) {

            return false;
        }

        $data_array = $data_object->getBitfield();

        foreach ($data_array as $idx => $obj) {

            if (!is_object($obj)) {
                return false;
            }
            $return_array[] = $obj->getBitfield();
        }

        return $return_array;


    }

    /**
     *
     * Delete all parts of this bitfield.
     *
     * @param type $group_id
     * @return type
     */
    private function deleteBitfield()
    {


        /* Delete the recht_bitfield_parts firsth */
        $query = "DELETE FROM recht_bitfield_parts WHERE recht_groep_id ='" . $this->recht_groep_id . "'";

        /*
         * Fire query return succes or failure of the query
         */
        return ($this->dbquery($query));

    }

    /**
     *
     * Save all parts of this bitfield.<br />
     *  The database type storing the bits parts, should be UNSIGNED.<br />
     *
     * @return bool TRUE on succes | FALSE on error
     */
    private function saveBitfield()
    {

        $result = false;

        /* Save bitfield  even*/
        foreach ($this->recht_bitfield as $idx => $bitfield) {

            // Store this part of the bitfield
            $query = "INSERT INTO `recht_bitfield_parts` " .
                "( `recht_groep_id`, `recht_bitfield_nr`, `bitfield`) " .
                "VALUES ( '" . $this->recht_groep_id . "', '" . $idx . "', '" . $bitfield . "')";

            echo __FILE__ . __LINE__ . __FUNCTION__ . '<br />';
            echo '<pre>';
            var_dump($query);
            echo '</pre>';
            $result = $this->dbquery($query);
        }

        return $result;
    }
}

class TestDbRechtGroep
{

    public function __construct()
    {
        try {
            $test = new DbRechtGroep();

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
