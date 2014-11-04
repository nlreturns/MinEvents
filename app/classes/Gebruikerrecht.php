<?php
namespace minevents\app\classes;

/**
 * Class GebruikerRecht
 */
class GebruikerRecht {

    /**
     * @var RechtBitfield
     */
    private $rechten;

    /**
     * @var RechtBitfield
     */
    private $recht;
    /**
     * @var RechtGroep
     */
    private $rechtgroep;
    /**
     *
     */
    public function __construct() {
        $this->recht = new RechtBitfield();
        $this->rechtgroep = new RechtGroep();
    }

    /**
     * @param $rechtgroeparray
     */
    public function addRechtGroep() {
        $this->rechtgroep->saveRechtGroep();
    }

    public function setRechtGroepNaam($rechtgroepnaam) {
        $this->rechtgroep->setRechtGroepBeschrijving($rechtgroepnaam);
    }
    /**
     * @param $recht_positie
     */
    public function addRecht() {
           // $this->rechten->addRecht();
    }
    public function setRecht($recht) {
        $this->recht = $recht;
    }

    public function addRechtBeschrijving($beschrijving) {
        $this->rechten->addRechtBeschrijving($beschrijving);
    }

    /**
     * @return array
     */
    public function getRechtgroepList() {
        $list = $this->rechtgroep->getRechtGroepList();
        return $list;
    }

    /**
     * @param $recht_array
     */
    public function addRechten($recht_array) {
        if(!empty($recht_array)) {
            $this->recht->addRechten($recht_array);
        }
    }

    /**
     * @param $recht_array
     * @return bool
     */
    public function heeftRechten($recht_array) {
        if(!empty($recht_positie)) {
            if($this->recht->heeftrechent($recht_array)) {
                return TRUE;
            }
        }
    }
    /**
     * @param $recht_positie
     */
    public function removeRecht($recht_positie) {
        if(!empty($recht_positie)) {
            $this->recht->removeRecht($recht_positie);
        }
    }

}