<?php
namespace minevents\app\classes;
/**
 * Only a limit for the number of array elements
 */
define ('MAX_BIT_POSITION_IN_BITFIELD', 2048);
define ('NUMBER_OF_BITS_IN_BITFIELD_PART', 31);



/**
 * Description of class RechtBitfield
 *  Provide all functions that handle Bitfield operations and usage.
 *
 * @version 0.2
 * @author Sander van Belleghem
 *
 * Version history:
 * 0.1  19-apr-2012 Sander van Belleghem    Initial Version 0.1
 * 0.2  26-feb-2013 G.T. Hoogendoorn        Fixed the RemoveRecht. Added getBitfieldAsString
 *                                          Removed Magic number 65. Added reset.
 * 1.0  11-mar-2013 Arti de Lijser          Added getBitfieldMaxBitsUsed().
 */
class RechtBitfield {

    /**
     *  Depending on the amount of bits:
     *  each 32 bits a new integer is used.
     *
     * @var array of bitfield's
     */
    private $bitfield_array = array();

    public function __construct() {
        //Initialize the firsth int in the bitfield_array
        $this->bitfield_array[0] = new Bitfield();

    }


    /**
     * addRecht()
     *
     * @param int $recht_positie is positie in het bitfield array.
     *
     */
    public function addRecht($recht_positie) {
        try {

            $this->checkRecht($recht_positie);

            // Get the BitfieldArray idx 
            $idx = $this->getBitfieldArrayIndex($recht_positie);

            // Get the position of the bit in the array part for this position
            $rechtbit = $this->getBitfieldArrayPosition($recht_positie);

            /**
             * Prefend the array key not exist error
             */
            if (!array_key_exists($idx, $this->bitfield_array)) {
                //Create array key
                $this->bitfield_array[$idx] = new Bitfield();
            }
            /**
             * Add the bit to the bitfield in the appropriate array part
             */
            $this->bitfield_array[$idx]->addBit($rechtbit);


        } catch (Exception $e) {
            throw new Exception('Invalid Recht Positie.');
            trigger_error($e->getMessage());
        }
        return TRUE;
    }


    /**
     * addRechten()
     *
     * @param array $recht_array
     * @return bool FALSE Functie addRecht returnd false
     *              TRUE Rechten zijn in bitfield geshift
     *
     */
    public function addRechten($recht_array) {


        foreach ($recht_array as $idx => $recht_pos) {

            // Add specific right 
            if (!$this->addRecht($recht_pos)) {
                // Error adding this right
                return FALSE;
            }
        }

        // Everithing added and no errors
        return TRUE;
    }

    /**
     * getBitfield()
     *
     * @return Bitfield() $this->bitfield_array Opgegeven bitfield_array binnen de klasse
     *
     */
    public function getBitfield() {

        return $this->bitfield_array;
    }

    /**
     * getBitfieldAsString()
     *      If a parameter is provided the binary value as string is returned.
     *      Else the class attribute bitfield_array is returned as binary string.
     *      This function exists as of version 0.2.
     *
     * @param  int optional bitfield_array
     * @return String containing the binary representation of the bitfield_array
     */
    public function getBitfieldAsString($bitfield = '') {


        /**
         * If function parameter is provided, use parameter else class bitfield_array
         */
        $bitfield_array = strlen($bitfield > 0) ? $bitfield : $this->bitfield_array;


        if (is_array($bitfield_array)) {

            // $return type is array
            $return = '';

            // For each part of the bitfield_array create an bitlike string
            foreach ($bitfield_array as $idx => $bitfield_array_part) {

                // Get this part as string
                $return .= $bitfield_array_part->getBitfieldAsString();
                // Add end of line marks
                $return .= "<br />\n";
            }

        } else {

            /**
             *  Just an int.
             *  Use the firsth method of the bitfield array for transrforming
             */
            $return = $this->bitfield_array[0]->getBitfieldAsString($bitfield_array);;
        }
        return $return;
    }


    /**
     * heeftRechten()
     *
     * @param array $recht_array
     * @return bool FALSE if one or more rights are not set in class bitfield_array<br />
     *              TRUE if all rights are set in class bitfield_array
     *
     */
    public function heeftRecht($recht_positie) {

        try {
            // check if $recht_positie is valid
            $this->checkRecht($recht_positie);

            // Get the BitfieldArray idx 
            $idx = $this->getBitfieldArrayIndex($recht_positie);

            // Get the position of the bit in the array part for this position
            $rechtbit = $this->getBitfieldArrayPosition($recht_positie);
            
            // Check whether the idx does or does not exists 
            if (!array_key_exists($idx, $this->bitfield_array)) {
                // No array key : no rights
                return FALSE;
            }
            
            return $this->bitfield_array[$idx]->isSetBit($rechtbit);

        } catch (Exception $e) {
            throw new Exception('Invalid Recht Positie.');
            trigger_error($e->getMessage());
        }

        return FALSE;
    }

    /**
     * heeftRechten()
     *
     * @param array $recht_array
     * @return bool FALSE if one or more rights are not set in class bitfield_array<br />
     *              TRUE if all rights are set in class bitfield_array
     *
     */
    public function heeftRechten($recht_array) {

        foreach ($recht_array as $idx => $recht_pos) {
            if (!$this->heeftRecht($recht_pos)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * heeftMinimaal1Recht()
     *
     * @param array $recht_array
     * @return bool FALSE If no rights are set<br />
     *              TRUE if one or more rights are set
     *
     */
    public function heeftMinimaal1Recht($recht_array) {

        foreach ($recht_array as $idx => $recht_pos) {
            if ($this->heeftRecht($recht_pos)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * replaceRecht()
     *  This method replaces the current known rights by an provide array containing
     *  positions of the rights.
     *
     * @param type $rechten_array
     */
    public function replaceRecht($rechten_array) {

        /**
         * Just reset
         */
        $this->reset();

        /**
         * And add the known right positions array.
         */
        $this->addRechten($rechten_array);

    }

    /**
     *  removeRecht()
     *
     * @param int $recht_pos numeric value as bitposition
     * @return (int) bitfield_array
     */
    public function removeRecht($recht_positie) {
        try {
            $this->checkRecht($recht_positie);

            // Get the BitfieldArray idx 
            $idx = $this->getBitfieldArrayIndex($recht_positie);

            // Get the position of the bit in the array part for this position
            $rechtbit = $this->getBitfieldArrayPosition($recht_positie);

            // Reset in this part of the bitfield array the particular bit.
            $this->bitfield_array[$idx]->resetBit($rechtbit);


        } catch (Exception $e) {
            trigger_error($e->getMessage());
        }
        return FALSE;
    }

    /**
     * Reset the current bitfield_array to zero.
     * Add the firsth element as 0
     */
    public function reset() {
        $this->bitfield_array    = array();
        $this->bitfield_array[0] = new Bitfield();
    }


    /**
     * Just show the current binary bitfield_array.
     */
    public function __toString() {
        echo $this->getBitfieldAsString();
    }

    /**
     * setBitfield()
     *
     * @param type $bitfield_array
     *
     */
    public function setBitfield($bitfield_array) {
        
        if (!empty($bitfield_array) && is_array($bitfield_array)) {
            
            // Firsth reset bitfield (The new one could be smaller )
            $this->reset();

            /**
             * Add each part to the destination bitfield
             */
            foreach ($bitfield_array as $idx => $bitfield) {
                /**
                 * Initialize the type
                 *  Remember we reset the bitfield array
                 */
                $this->bitfield_array[$idx] = new Bitfield();

                /**
                 * Add the bitfield
                 */
                $this->bitfield_array[$idx]->setBitfield($bitfield);
            }
        }
    }


    /**
     * checkRecht()
     *
     * Functie om te controleren of opgegeven recht niet leeg is en binnen de gestelde range is.
     *
     * @param int $recht_positie
     * @throws Exception Als bit buiten bitfield_array range is.
     *
     */
    private function checkRecht($recht_positie) {

        if (empty($recht_positie) || ($recht_positie > MAX_BIT_POSITION_IN_BITFIELD)) {
            throw new Exception('Invalid Recht Positie.');
        }
    }

    /**
     *
     * getBitfieldArrayIndex()<br />
     *      Each int in the bitfield contains 32 bits.<br />
     *      So bit position :<br />
     *      1 - 32 => firsth bitfield integer : 0<br />
     *      33 -64 => second bitfield integer : 1<br />
     *      And so on
     *
     * @param int $positie The position of the bit in the bitfield
     * @return int The index nr in the bitfield array
     */
    private function getBitfieldArrayIndex($positie) {

        return (int)(($positie - 1) / $this->getBitfieldMaxBitsUsed());
    }

    /**
     * getBitfieldArrayPosition()<br />
     *      Each part of the bitfield_array contains a NUMBER_OF_BITS_IN_BITFIELD_PART bits
     *      The Position is based on the remainder of the bitfield.<br />
     *      Example:<br />
     *      Position 33: Substract the NUMBER_OF_BITS_IN_BITFIELD_PART as many as posible<br />
     *      33 - 32 = 1 => Remainder is 1 for the second bitfield part.
     * @param type $recht_position
     * @return type
     */
    private function getBitfieldArrayPosition($recht_position) {

        return ((($recht_position - 1) % $this->getBitfieldMaxBitsUsed()) + 1);


    }

    /**
     *
     *
     */
    private function getBitfieldMaxBitsUsed() {
        return $this->bitfield_array[0]->getBitfieldMaxBitsUsed();
    }

}

class TestRechtBitfield {
    public function TestRechtBitfield() {
        try {
            $test = new RechtBitfield();

            echo "Start adding right 1:<br />";
            $test->addRecht(1);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(1)) ? "" : " niet") . '<br /><br />';

            echo "Add right 4: <br />";
            $test->addRecht(4);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(4)) ? "" : " niet") . '<br /><br />';

            echo "Add right 6: <br />";
            $test->addRecht(6);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(6)) ? "" : " niet") . '<br /><br />';

            echo "Add right 31: <br />";
            $test->addRecht(31);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(31)) ? "" : " niet") . '<br /><br />';

            echo "Add right 32: <br />";
            $test->addRecht(32);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(32)) ? "" : " niet") . '<br /><br />';

            echo "Add right 33: <br />";
            $test->addRecht(33);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(33)) ? "" : " niet") . '<br /><br />';


            echo "Add right 64: <br />";
            $test->addRecht(64);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(64)) ? "" : " niet") . '<br /><br />';

            echo "Add right 65: <br />";
            $test->addRecht(65);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(65)) ? "" : " niet") . '<br /><br />';

            echo "Remove right 4: <br />";
            $test->removeRecht(4);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(4)) ? "" : " niet") . '<br /><br />';

            echo "Remove right 65: <br />";
            $test->removeRecht(65);
            echo $test->getBitfieldAsString();
            echo "Recht bestaat" . (($test->heeftRecht(65)) ? "" : " niet") . '<br /><br />';

            $recht_array = Array(128, 129);
            $test->addRechten($recht_array);
            echo $test->getBitfieldAsString();
            echo "Recht 128 bestaat" . (($test->heeftRecht(128)) ? "" : " niet") . '<br /><br />';
            echo "Recht 129 bestaat" . (($test->heeftRecht(129)) ? "" : " niet") . '<br /><br />';

            $recht_array = Array(1, 3, 5, 65, 67, 69);
            $test->replaceRecht($recht_array);
            echo $test->getBitfieldAsString();

            echo "<pre>";
            var_dump($test);
            echo "</pre>";

            $test->reset();

            echo "<pre>";
            var_dump($test);
            echo "</pre>";

            $result_array = array();
            for ($i = 1; $i < 2049; $i++) {
                $result_array[] = $i;
            }
            $test->addRechten($result_array);
            echo $test->getBitfieldAsString();


            echo "<pre>";
            var_dump($test);
            echo "</pre>";


        } catch (Exception $e) {
            echo "<pre>";
            echo $e->getTraceAsString();
            echo "</pre>";
            trigger_error($e->getMessage());
        }
    }
}

?>
