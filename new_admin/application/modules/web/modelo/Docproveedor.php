<?php

/**
 * Docproveedor
 *
 *
 *
 * @Table(name="documento_proveedor")
 *
 * @Entity
 */
use Doctrine\Common\Collections\ArrayCollection;

class Docproveedor {

    /**
     *
     * @var integer $id
     * @Column(name="dop_id", type="integer", nullable=false)
     *
     *      @Id
     *
     *      @GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     *
     * @var string $numero @Column(name="dop_numero", type="string", length=120, nullable=true)
     *
     */
    private $numero;

    /**
     *
     * @var string $fecha @Column(name="dop_fecha", type="date", nullable=true)
     *
     */
    private $fecha;

    /**
     *
     * @var integer $estado @Column(name="dop_estado", type="integer", length=120, nullable=true)
     *
     */
    private $estado;

    /**
     * @OneToOne(targetEntity="Proveedor")
     *
     * @JoinColumn(name="dop_proveedor_id", referencedColumnName="proveedor_id")
     */
    private $proveedor;

    /**
     * @Column(name="dop_tipo", type="string", length=120, nullable=true)
     */
    private $tipoDocumento;

    /**
     *
     * @var integer $importe
     * @Column(name="dop_importe", type="decimal")
     *
     */
    private $importe;

    /**
     * @OneToMany(targetEntity="Documentopercepcion", mappedBy="documento", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $percepciones;

    function getPercepciones() {
        return $this->percepciones;
    }

    function setPercepciones($percepciones) {
        $this->percepciones = $percepciones;
    }

    public function getId() {
        return $this->id;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getProveedor() {
        return $this->proveedor;
    }

    public function getImporte() {
        return mostrarImporte($this->importe);
    }

    function importeConRetenciones() {
        $total = 0.00;
        foreach ($this->percepciones as $doc_percepcion) {
            $total += $doc_percepcion->getImporte();
        }
        return mostrarImporte($this->importe + $total);
    }

    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function setImporte($importe) {
        $this->importe = $importe;
    }

    public function __construct($fecha) {
        $this->percepciones = new ArrayCollection();
        $this->setEstado(3);
        $this->setFecha(new \DateTime($fecha));
    }

    function obtenerArray() {
        $arreglo = array(
            "id" => $this->id,
            "fecha" => $this->fecha->format("Y-m-d"),
            "importe" => $this->getImporte(),
            "imp_sin_ret" => $this->importeConRetenciones(),
            "numero" => $this->numero,
            "proveedor_razon_social" => $this->proveedor->getRazon_social(),
            "proveedor_condiva" => $this->proveedor->getCondicion_iva()->getNombre(),
            "proveedor_cuit" => $this->proveedor->getCuit(),
            "proveedor_id" => $this->proveedor->getId(),
            "tipo_doc" => $this->tipoDocumento
        );
        return $arreglo;
    }

}
