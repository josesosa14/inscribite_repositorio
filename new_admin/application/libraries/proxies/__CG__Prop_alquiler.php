<?php

namespace Proxies\__CG__;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Prop_alquiler extends \Prop_alquiler implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'exclusivo', 'codigo', 'nombre', 'direccion', 'telefono', 'propietario', 'costo_diario', 'costo_semanal', 'costo_quincenal', 'costo_mensual', 'costo_anual', 'precio_diario', 'precio_quincenal', 'precio_mensual', 'precio_semanal', 'barrio', 'area', 'categoria', 'tipo', 'estadia_min', 'estadia_max', 'detalle_es', 'detalle_en', 'disposcion', 'cama_king', 'cama_single', 'cama_sofa', 'cercania_es', 'cercania_en', 'observaciones', 'video', 'usuarioAlta', 'alta_fecha', 'usuarioUpdate', 'update_fecha', 'estado', 'suspendido_desde', 'suspendido_hasta', 'promocion_tipo', 'promocion_tipo_descripcion_es', 'promocion_tipo_descripcion_en', 'bloqueo_desde', 'bloqueo_hasta', 'disponible_desde', 'disponible_hasta', 'capacidad', 'banios', 'cama_queen', 'promocion_vto', 'muestra_en_xml', 'edificio', 'edificio_grupo', 'edificio_unidades_similares', 'condiciones_grales_es', 'condiciones_grales_en', 'suspendido_motivo', 'suspendidoUsuario', 'suspendido_alta_fecha', 'detalle_por', 'condiciones_grales_por', 'detalle_en_traducir_automaticamente', 'detalle_por_traducir_automaticamente', 'condiciones_especiales_propietario', 'acepto_terminos', 'visitas', 'precio_solo_en_usd', 'mlibre_id', 'mlibre_update_fecha', 'permite_estadia_larga', 'reviews_generales', 'online', 'estadias_largas', 'latlong', 'vencimiento_destacados', 'fotos', 'notificado_vencimiento', 'precio_publicado_porc', 'costo_diario_ant', 'costo_quincenal_ant', 'costo_mensual_ant', 'costo_anual_ant', 'bpa_apto_emp', 'bpa_cuit', 'bpa_razon_social', 'bpa_tipo_fac', 'bpa_categoria', 'bpa_descuento', 'destacados', '' . "\0" . 'Prop_alquiler' . "\0" . 'features', 'punto_interes'];
        }

        return ['__isInitialized__', 'id', 'exclusivo', 'codigo', 'nombre', 'direccion', 'telefono', 'propietario', 'costo_diario', 'costo_semanal', 'costo_quincenal', 'costo_mensual', 'costo_anual', 'precio_diario', 'precio_quincenal', 'precio_mensual', 'precio_semanal', 'barrio', 'area', 'categoria', 'tipo', 'estadia_min', 'estadia_max', 'detalle_es', 'detalle_en', 'disposcion', 'cama_king', 'cama_single', 'cama_sofa', 'cercania_es', 'cercania_en', 'observaciones', 'video', 'usuarioAlta', 'alta_fecha', 'usuarioUpdate', 'update_fecha', 'estado', 'suspendido_desde', 'suspendido_hasta', 'promocion_tipo', 'promocion_tipo_descripcion_es', 'promocion_tipo_descripcion_en', 'bloqueo_desde', 'bloqueo_hasta', 'disponible_desde', 'disponible_hasta', 'capacidad', 'banios', 'cama_queen', 'promocion_vto', 'muestra_en_xml', 'edificio', 'edificio_grupo', 'edificio_unidades_similares', 'condiciones_grales_es', 'condiciones_grales_en', 'suspendido_motivo', 'suspendidoUsuario', 'suspendido_alta_fecha', 'detalle_por', 'condiciones_grales_por', 'detalle_en_traducir_automaticamente', 'detalle_por_traducir_automaticamente', 'condiciones_especiales_propietario', 'acepto_terminos', 'visitas', 'precio_solo_en_usd', 'mlibre_id', 'mlibre_update_fecha', 'permite_estadia_larga', 'reviews_generales', 'online', 'estadias_largas', 'latlong', 'vencimiento_destacados', 'fotos', 'notificado_vencimiento', 'precio_publicado_porc', 'costo_diario_ant', 'costo_quincenal_ant', 'costo_mensual_ant', 'costo_anual_ant', 'bpa_apto_emp', 'bpa_cuit', 'bpa_razon_social', 'bpa_tipo_fac', 'bpa_categoria', 'bpa_descuento', 'destacados', '' . "\0" . 'Prop_alquiler' . "\0" . 'features', 'punto_interes'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Prop_alquiler $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getDestacados()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDestacados', []);

        return parent::getDestacados();
    }

    /**
     * {@inheritDoc}
     */
    public function getPuntoInteres()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPuntoInteres', []);

        return parent::getPuntoInteres();
    }

    /**
     * {@inheritDoc}
     */
    public function setPunto_interes($punto_interes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPunto_interes', [$punto_interes]);

        return parent::setPunto_interes($punto_interes);
    }

    /**
     * {@inheritDoc}
     */
    public function esDestacado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'esDestacado', []);

        return parent::esDestacado();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getExclusivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExclusivo', []);

        return parent::getExclusivo();
    }

    /**
     * {@inheritDoc}
     */
    public function getCodigo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCodigo', []);

        return parent::getCodigo();
    }

    /**
     * {@inheritDoc}
     */
    public function getNombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombre', []);

        return parent::getNombre();
    }

    /**
     * {@inheritDoc}
     */
    public function getDireccion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDireccion', []);

        return parent::getDireccion();
    }

    /**
     * {@inheritDoc}
     */
    public function getTelefono()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTelefono', []);

        return parent::getTelefono();
    }

    /**
     * {@inheritDoc}
     */
    public function getPropietario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPropietario', []);

        return parent::getPropietario();
    }

    /**
     * {@inheritDoc}
     */
    public function getCostoDiario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCostoDiario', []);

        return parent::getCostoDiario();
    }

    /**
     * {@inheritDoc}
     */
    public function getCostoSemanal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCostoSemanal', []);

        return parent::getCostoSemanal();
    }

    /**
     * {@inheritDoc}
     */
    public function getCostoQuincenal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCostoQuincenal', []);

        return parent::getCostoQuincenal();
    }

    /**
     * {@inheritDoc}
     */
    public function getCostoMensual()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCostoMensual', []);

        return parent::getCostoMensual();
    }

    /**
     * {@inheritDoc}
     */
    public function getMinimoDiario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMinimoDiario', []);

        return parent::getMinimoDiario();
    }

    /**
     * {@inheritDoc}
     */
    public function getCosto_semanal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCosto_semanal', []);

        return parent::getCosto_semanal();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecio_semanal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecio_semanal', []);

        return parent::getPrecio_semanal();
    }

    /**
     * {@inheritDoc}
     */
    public function setCosto_semanal($costo_semanal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCosto_semanal', [$costo_semanal]);

        return parent::setCosto_semanal($costo_semanal);
    }

    /**
     * {@inheritDoc}
     */
    public function setPrecio_semanal($precio_semanal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrecio_semanal', [$precio_semanal]);

        return parent::setPrecio_semanal($precio_semanal);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecioDiario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecioDiario', []);

        return parent::getPrecioDiario();
    }

    /**
     * {@inheritDoc}
     */
    public function getAdicional()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdicional', []);

        return parent::getAdicional();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecioQuincenal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecioQuincenal', []);

        return parent::getPrecioQuincenal();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecioMensual()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecioMensual', []);

        return parent::getPrecioMensual();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecioAnual()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecioAnual', []);

        return parent::getPrecioAnual();
    }

    /**
     * {@inheritDoc}
     */
    public function getBarrio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBarrio', []);

        return parent::getBarrio();
    }

    /**
     * {@inheritDoc}
     */
    public function getArea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getArea', []);

        return parent::getArea();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoria()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCategoria', []);

        return parent::getCategoria();
    }

    /**
     * {@inheritDoc}
     */
    public function getTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipo', []);

        return parent::getTipo();
    }

    /**
     * {@inheritDoc}
     */
    public function getEstadiaMin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstadiaMin', []);

        return parent::getEstadiaMin();
    }

    /**
     * {@inheritDoc}
     */
    public function getEstadiaMax()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstadiaMax', []);

        return parent::getEstadiaMax();
    }

    /**
     * {@inheritDoc}
     */
    public function getDetalleEs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDetalleEs', []);

        return parent::getDetalleEs();
    }

    /**
     * {@inheritDoc}
     */
    public function getDetalleEn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDetalleEn', []);

        return parent::getDetalleEn();
    }

    /**
     * {@inheritDoc}
     */
    public function getDisposcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisposcion', []);

        return parent::getDisposcion();
    }

    /**
     * {@inheritDoc}
     */
    public function getCamaKing()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCamaKing', []);

        return parent::getCamaKing();
    }

    /**
     * {@inheritDoc}
     */
    public function getCamaSingle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCamaSingle', []);

        return parent::getCamaSingle();
    }

    /**
     * {@inheritDoc}
     */
    public function getCamaSofa()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCamaSofa', []);

        return parent::getCamaSofa();
    }

    /**
     * {@inheritDoc}
     */
    public function getCercaniaEs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCercaniaEs', []);

        return parent::getCercaniaEs();
    }

    /**
     * {@inheritDoc}
     */
    public function getCercaniaEn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCercaniaEn', []);

        return parent::getCercaniaEn();
    }

    /**
     * {@inheritDoc}
     */
    public function getObservaciones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObservaciones', []);

        return parent::getObservaciones();
    }

    /**
     * {@inheritDoc}
     */
    public function getVideo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVideo', []);

        return parent::getVideo();
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuarioAlta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuarioAlta', []);

        return parent::getUsuarioAlta();
    }

    /**
     * {@inheritDoc}
     */
    public function getAltaFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAltaFecha', []);

        return parent::getAltaFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuarioUpdate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuarioUpdate', []);

        return parent::getUsuarioUpdate();
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdateFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdateFecha', []);

        return parent::getUpdateFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function getEstado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstado', []);

        return parent::getEstado();
    }

    /**
     * {@inheritDoc}
     */
    public function getSuspendidoDesde()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSuspendidoDesde', []);

        return parent::getSuspendidoDesde();
    }

    /**
     * {@inheritDoc}
     */
    public function getSuspendidoHasta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSuspendidoHasta', []);

        return parent::getSuspendidoHasta();
    }

    /**
     * {@inheritDoc}
     */
    public function getPromocionTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPromocionTipo', []);

        return parent::getPromocionTipo();
    }

    /**
     * {@inheritDoc}
     */
    public function getPromocionTipoDescripcionEs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPromocionTipoDescripcionEs', []);

        return parent::getPromocionTipoDescripcionEs();
    }

    /**
     * {@inheritDoc}
     */
    public function getPromocionTipoDescripcionEn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPromocionTipoDescripcionEn', []);

        return parent::getPromocionTipoDescripcionEn();
    }

    /**
     * {@inheritDoc}
     */
    public function getBloqueoDesde()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBloqueoDesde', []);

        return parent::getBloqueoDesde();
    }

    /**
     * {@inheritDoc}
     */
    public function getBloqueoHasta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBloqueoHasta', []);

        return parent::getBloqueoHasta();
    }

    /**
     * {@inheritDoc}
     */
    public function getDisponibleDesde()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisponibleDesde', []);

        return parent::getDisponibleDesde();
    }

    /**
     * {@inheritDoc}
     */
    public function getDisponibleHasta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisponibleHasta', []);

        return parent::getDisponibleHasta();
    }

    /**
     * {@inheritDoc}
     */
    public function getCapacidad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCapacidad', []);

        return parent::getCapacidad();
    }

    /**
     * {@inheritDoc}
     */
    public function getBanios()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBanios', []);

        return parent::getBanios();
    }

    /**
     * {@inheritDoc}
     */
    public function getCamaQueen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCamaQueen', []);

        return parent::getCamaQueen();
    }

    /**
     * {@inheritDoc}
     */
    public function getPromocionVto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPromocionVto', []);

        return parent::getPromocionVto();
    }

    /**
     * {@inheritDoc}
     */
    public function getMuestraEnXml()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMuestraEnXml', []);

        return parent::getMuestraEnXml();
    }

    /**
     * {@inheritDoc}
     */
    public function getEdificio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEdificio', []);

        return parent::getEdificio();
    }

    /**
     * {@inheritDoc}
     */
    public function getEdificioGrupo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEdificioGrupo', []);

        return parent::getEdificioGrupo();
    }

    /**
     * {@inheritDoc}
     */
    public function getEdificioUnidadesSimilares()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEdificioUnidadesSimilares', []);

        return parent::getEdificioUnidadesSimilares();
    }

    /**
     * {@inheritDoc}
     */
    public function getCondicionesGralesEs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCondicionesGralesEs', []);

        return parent::getCondicionesGralesEs();
    }

    /**
     * {@inheritDoc}
     */
    public function getCondicionesGralesEn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCondicionesGralesEn', []);

        return parent::getCondicionesGralesEn();
    }

    /**
     * {@inheritDoc}
     */
    public function getSuspendidoMotivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSuspendidoMotivo', []);

        return parent::getSuspendidoMotivo();
    }

    /**
     * {@inheritDoc}
     */
    public function getSuspendidoUsuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSuspendidoUsuario', []);

        return parent::getSuspendidoUsuario();
    }

    /**
     * {@inheritDoc}
     */
    public function getSuspendidoAltaFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSuspendidoAltaFecha', []);

        return parent::getSuspendidoAltaFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function getDetallePor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDetallePor', []);

        return parent::getDetallePor();
    }

    /**
     * {@inheritDoc}
     */
    public function getCondicionesGralesPor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCondicionesGralesPor', []);

        return parent::getCondicionesGralesPor();
    }

    /**
     * {@inheritDoc}
     */
    public function getDetalleEnTraducirAutomaticamente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDetalleEnTraducirAutomaticamente', []);

        return parent::getDetalleEnTraducirAutomaticamente();
    }

    /**
     * {@inheritDoc}
     */
    public function getDetallePorTraducirAutomaticamente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDetallePorTraducirAutomaticamente', []);

        return parent::getDetallePorTraducirAutomaticamente();
    }

    /**
     * {@inheritDoc}
     */
    public function getCondicionesEspecialesPropietario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCondicionesEspecialesPropietario', []);

        return parent::getCondicionesEspecialesPropietario();
    }

    /**
     * {@inheritDoc}
     */
    public function getAceptoTerminos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAceptoTerminos', []);

        return parent::getAceptoTerminos();
    }

    /**
     * {@inheritDoc}
     */
    public function getVisitas()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVisitas', []);

        return parent::getVisitas();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecioSoloEnUsd()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecioSoloEnUsd', []);

        return parent::getPrecioSoloEnUsd();
    }

    /**
     * {@inheritDoc}
     */
    public function getMlibreId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMlibreId', []);

        return parent::getMlibreId();
    }

    /**
     * {@inheritDoc}
     */
    public function getMlibreUpdateFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMlibreUpdateFecha', []);

        return parent::getMlibreUpdateFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function getPermiteEstadiaLarga()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPermiteEstadiaLarga', []);

        return parent::getPermiteEstadiaLarga();
    }

    /**
     * {@inheritDoc}
     */
    public function getReviewsGenerales()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReviewsGenerales', []);

        return parent::getReviewsGenerales();
    }

    /**
     * {@inheritDoc}
     */
    public function getOnline()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOnline', []);

        return parent::getOnline();
    }

    /**
     * {@inheritDoc}
     */
    public function getEstadiasLargas()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstadiasLargas', []);

        return parent::getEstadiasLargas();
    }

    /**
     * {@inheritDoc}
     */
    public function getLatlong()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLatlong', []);

        return parent::getLatlong();
    }

    /**
     * {@inheritDoc}
     */
    public function getVencimientoDestacados()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVencimientoDestacados', []);

        return parent::getVencimientoDestacados();
    }

    /**
     * {@inheritDoc}
     */
    public function getNotificadoVencimiento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotificadoVencimiento', []);

        return parent::getNotificadoVencimiento();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecioPublicadoPorc()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecioPublicadoPorc', []);

        return parent::getPrecioPublicadoPorc();
    }

    /**
     * {@inheritDoc}
     */
    public function getCostoDiarioAnt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCostoDiarioAnt', []);

        return parent::getCostoDiarioAnt();
    }

    /**
     * {@inheritDoc}
     */
    public function getCostoQuincenalAnt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCostoQuincenalAnt', []);

        return parent::getCostoQuincenalAnt();
    }

    /**
     * {@inheritDoc}
     */
    public function getCostoMensualAnt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCostoMensualAnt', []);

        return parent::getCostoMensualAnt();
    }

    /**
     * {@inheritDoc}
     */
    public function getCostoAnualAnt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCostoAnualAnt', []);

        return parent::getCostoAnualAnt();
    }

    /**
     * {@inheritDoc}
     */
    public function getBpaAptoEmp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBpaAptoEmp', []);

        return parent::getBpaAptoEmp();
    }

    /**
     * {@inheritDoc}
     */
    public function getBpaCuit()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBpaCuit', []);

        return parent::getBpaCuit();
    }

    /**
     * {@inheritDoc}
     */
    public function getBpaRazonSocial()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBpaRazonSocial', []);

        return parent::getBpaRazonSocial();
    }

    /**
     * {@inheritDoc}
     */
    public function getBpaTipoFac()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBpaTipoFac', []);

        return parent::getBpaTipoFac();
    }

    /**
     * {@inheritDoc}
     */
    public function getBpaCategoria()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBpaCategoria', []);

        return parent::getBpaCategoria();
    }

    /**
     * {@inheritDoc}
     */
    public function getBpaDescuento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBpaDescuento', []);

        return parent::getBpaDescuento();
    }

    /**
     * {@inheritDoc}
     */
    public function getFotos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFotos', []);

        return parent::getFotos();
    }

    /**
     * {@inheritDoc}
     */
    public function getFeatures()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFeatures', []);

        return parent::getFeatures();
    }

    /**
     * {@inheritDoc}
     */
    public function getDatos($tarifa, $cant_dias, $desde, $hasta, $cotizacion = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatos', [$tarifa, $cant_dias, $desde, $hasta, $cotizacion]);

        return parent::getDatos($tarifa, $cant_dias, $desde, $hasta, $cotizacion);
    }

}
