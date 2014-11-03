<?php

	/**
 * Description of class Recht
 *
 * @version 0.1
 * @author Sander van Belleghem
 *
     */

require_once 'db_recht.php';

class Recht {

    private $beschrijving = '';
    private $recht_positie;

	public function __construct() {

	}

    public function Recht() {

    }

    public function getRechtBeschrijving() {
        return $this->beschrijving;
    }

    public function getRechtPositie() {
        return $this->recht_positie;
    }

    public function setRechtBeschrijving($beschrijving) {
        if (is_string($beschrijving)) {
            $this->beschrijving = $beschrijving;
        }
    }

    public function setRechtPositie($positie) {
        if (is_numeric($positie)) {
            $this->recht_positie = $positie;
        }
    }

	 /**
     * getRechtBeschrijvingList()
     *
     * @return array containing recht_id and recht_beschrijving from database.
     *
     */
    public function getRechtBeschrijvingList() {
        $dbRecht = new DbRecht();
        return $dbRecht->getRechtBeschrijvingList();
	}

	 /**
     * getRechtOnderdeelList()
     *
     * @return array containing recht_id and recht_onderdeel from database.
     *
     */
    public function getRechtOnderdeelList() {
        $dbRecht = new DbRecht();
        return $dbRecht->getRechtOnderdeelList();
    }

        /**
     * getRechtList()
     *
     * @param string $onderdeel
     * @return array containing all recht data from database.
     * if $onderdeel = null, all data from recht is returned.
     * if $onderdeel isset, all data from recht where $onderdeel equals recht_onderdeel (database row) is returned.
     *
     */
    public function getRechtList($onderdeel = null) {
        $dbRecht = new DbRecht();
        return $dbRecht->getRechtList($onderdeel);
	}

    /**
     * getGebruikersRechtenList()
     *
     * @return array containing all persoon (INNER JOIN `persoon`) and recht groep (INNER JOIN `recht_groep`) data from database conected to a user.
     *
     */
    public function getGebruikersRechtenList() {
        $dbRecht = new DbRecht();
        return $dbRecht->getGebruikersRechtenList();
}

    /**
     * saveRecht()
     *
     * @param int $this ->recht_positie Right position in a bitfield
     * @param string $this ->recht_beschrijving Description of the right
     *
     */
    public function saveRecht() {
        $dbRecht = new DbRecht();
        $dbRecht->setRechtPositie($this->recht_positie);
        $dbRecht->setRechtBeschrijving($this->recht_beschrijving);
        $dbRecht->saveRecht();
    }
}

class TestRecht {
    public function TestRecht() {
        try {
            //$test = new TestRecht();

            $recht_beschrijving_array = array();
            $recht_array              = array('Admin', 'Change', 'Delete', 'Update');

            foreach ($recht_array as $positie => $beschrijving) {

                $recht_beschrijving_array[$positie] = new Recht();
                $recht_beschrijving_array[$positie]->setBeschrijving($beschrijving);
                $recht_beschrijving_array[$positie]->setRechtPositie($positie + 1);

                $bitfield |= 1 << $positie;
            }

            echo "<pre>";
            var_dump($recht_beschrijving_array);
            var_dump($bitfield);
            echo "</pre>";

        } catch (Exception $e) {
            echo '<pre>';
            echo 'Caught exception: ', $e->getMessage(), "\n";
            echo '</pre>';
        }
    }
}

?>