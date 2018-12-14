<?php

/**
 *
 * @property Doctrine\ORM\EntityManager $orm Description 
 * 
 * */
class PagoRenglonesModel extends A_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }
    
    public function getPagoRenglonesByPago($id){
        return $this->orm->createQuery("SELECT r FROM pago_renglones r WHERE r.pago = :id")->setParameter('id', $id)->getResult();
    }
}