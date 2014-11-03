<?php
namespace minevents\app\classes;
/**
 * Only a limit for the number of array elements
 */
define('NUMBER_OF_BITS_IN_BITFIELD', 32);
define('NUMBER_OF_USED_BITS', NUMBER_OF_BITS_IN_BITFIELD - 1);
define('BIT_STRING', "%0" . NUMBER_OF_USED_BITS . "s");


/**
 * Description of Bitfield
 *
 * @author GHoogendoorn
 * @version 0.1
 *
 * Version history
 * 0.1  Sander van Belleghem    Initial version
 */
class Bitfield {

    private $bitfield = 0;

    public function __construct() {
        // Initialisatie
    }

    public function Bitfield() {

    }

    /**
     *
     * @param type $bit_pos is positie in het bitveld van 1-65
     */
    public function addBit($bit_pos) {

        try {
            $this->checkBit($bit_pos);

            // Set een bit
            $this->bitfield |= 1 << ($bit_pos - 1);
        } catch (Exception $e) {

            trigger_error($e->getMessage());
        }
    }

    /**
     * addMultipleBits()
     *
     * @param array $bit_array
     * @return bool FALSE Functie addBit returnd false
     *              TRUE Bits zijn in bitfield geshift
     *
     */
    public function addMultipleBits($bit_array) {


        foreach ($bit_array as $idx => $bit_pos) {

            // Add specific right 
            if (!$this->addBit($bit_pos)) {
                // Error adding this right
                return FALSE;
            }
        }

        // Everithing added and no errors
        return TRUE;
    }

    /**
     * allBitsSet()
     *
     * @param array $bit_array
     * @return bool FALSE if one or more rights are not set in class bitfield<br />
     *              TRUE if all rights are set in class bitfield
     *
     */
    public function allBitsSet($bit_array) {

        foreach ($bit_array as $idx => $bit_pos) {
            if (!$this->isSetBit($bit_pos)) {
                return FALSE;
            }
        }
        return TRUE;
    }


    public function getBitfield() {
        return $this->bitfield;
    }

    public function getBitfieldMaxBitsUsed() {

        // MAX INT -1 one for the signed bit
        return NUMBER_OF_USED_BITS;
    }

    /**
     *
     * @param type $bitfield
     * @return type
     */
    public function getBitfieldAsString($bitfield = '') {

        // Check what bitfield is used.
        $bitfield = ((strlen($bitfield > 0) && is_int($bitfield)) ? $bitfield : $this->bitfield);

        /**
         *  Create the text string<br />
         *  Add 0's @ the left side..
         */
        $return_string = sprintf(BIT_STRING, decbin($bitfield));

        return $return_string;
    }

    public function isSetBit($bit_pos) {

        // Controleer of het bit of de biten gezet zijn in het bitveld
        try {

            $this->checkBit($bit_pos);

            if ($this->bitfield & (1 << ($bit_pos - 1))) {

                return TRUE;
            }
        } catch (Exception $e) {

            trigger_error($e->getMessage());
        }


        return FALSE;
    }


    /**
     * Replace the complete bitfield by provided integer
     *
     * @param int $bitfield
     * @return bool TRUE on succes | FALSE on failure
     */
    public function replaceBitfield($bitfield) {

        if (is_int($bitfield)) {
            $this->bitfield = $bitfield;
        }
        return TRUE;
    }

    /**
     * Replace the complete bitfield by a single bit.
     *
     * @param int $bit_pos
     * @return bool TRUE on succes
     */
    public function replaceBitfieldByBit($bit_pos) {

        // Reset firsth
        $this->resetBitfield();

        // Add bit
        $this->addBit($bit_pos);

        return TRUE;
    }

    /**
     *  Reset the bit at the given position
     *
     * @param int $offset numeric value as bitposition
     * @return (int) bitfield
     */
    public function resetBit( /* int */
        $bit_pos) {
        try {
            $this->checkBit($bit_pos);

            /**
             * Reseting a particular bit:
             *      Take a position (3)                       3
             *      Take the original bitfield:         0110110
             *      Shift a '1' for the position        0000001
             *          number (3)-1
             *      and the current bit is:             0000100
             *
             *      Invert the current bit:             1111011
             *      'AND' this with the original:       0110110
             *                                          -------
             *      Result is the resetted position:    0110010
             */
            $this->bitfield &= ~(1 << ($bit_pos - 1));
            return $this->bitfield;
        } catch (Exception $e) {

            trigger_error($e->getMessage());
        }
    }

    /**
     * Reset the complete bitfield
     */
    public function resetBitfield() {
        $this->bitfield = 0;
    }

    /**
     * Set the bitfield by a provided bitfield
     *
     * @param int $bitfield
     */
    public function setBitfield($bitfield) {
        if (is_numeric($bitfield)) {
            $this->bitfield = $bitfield;
        }
    }

    /**
     * Just show the current binary bitfield_array.
     */
    public function __toString() {
        return $this->getBitfieldAsString();
    }

    /**
     * Controleer bit positie in het bitveld van NUMBER_OF_USED_BITS
     * NUMBER_OF_BITFIELD is used -1 since the upper bit is the sign bit in php
     *
     * @param type $bit_pos
     * @throws Exception Als bit buiten bitveld range is.
     *
     */
    private function checkBit($bit_pos) {

        if (empty($bit_pos) || !is_numeric($bit_pos) || ($bit_pos > (NUMBER_OF_USED_BITS))) {
            throw new Exception('Invalid bit_pos ' . $bit_pos . ' MAX:' . (NUMBER_OF_USED_BITS));
        }
        return TRUE;
    }

}

class TestbitBitfield {

    public function TestBitfield() {
        try {
            $test = new Bitfield();

            $test->addBit(1);
            $test->addBit(3);

            echo " bit '1' bestaat " . ($test->isSetBit(1) ? "wel" : "niet") . '<br />';
            echo " bit '2' bestaat " . ($test->isSetBit(2) ? "wel" : "niet") . '<br />';
            echo " bit '3' bestaat " . ($test->isSetBit(3) ? "wel" : "niet") . '<br />';

            /*
              if ($test->allBitsSet(array(1,3)) ){
              echo "Bits voor 1 en 3 bestaan<br />";
              }else {
              echo "Bits voor 1 en 3 bestaan *NIET* <br />";
              }

              // of :
              / */
            echo "Heeft Bits voor 1 en 3 " . ($test->allBitsSet(array(1, 3)) ? "wel" : "*NIET*") . '<br />';
            //*/

            /*
              if ($test->allBitsSet(array(1,2,3))){
              echo "Bits voor 1, 2 en 3 bestaan<br />";
              }else {
              echo "Bits voor 1, 2 en 3 bestaan *NIET* <br />";
              }

              // of :
              / */
            echo "Heeft Bits voor 1, 2 en 3 " . ($test->allBitsSet(array(1, 2, 3)) ? "wel" : "*NIET*") . '<br />';
            //*/

            var_dump($test);
        } catch (Exception $e) {
            echo '<pre>';
            echo $e->getTraceAsString();
            echo '</pre>';
            trigger_error($e->getMessage());
        }
    }

}

?>
