<?php

namespace Proxies\__CG__;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Liquidacion extends \Liquidacion implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'id', 'fecha', 'fecha_pagada', 'fecha_visible_cliente', 'fecha_hasta', '' . "\0" . 'Liquidacion' . "\0" . 'cliente', '' . "\0" . 'Liquidacion' . "\0" . 'evento', '' . "\0" . 'Liquidacion' . "\0" . 'mensualidad', '' . "\0" . 'Liquidacion' . "\0" . 'pagos'];
        }

        return ['__isInitialized__', 'id', 'fecha', 'fecha_pagada', 'fecha_visible_cliente', 'fecha_hasta', '' . "\0" . 'Liquidacion' . "\0" . 'cliente', '' . "\0" . 'Liquidacion' . "\0" . 'evento', '' . "\0" . 'Liquidacion' . "\0" . 'mensualidad', '' . "\0" . 'Liquidacion' . "\0" . 'pagos'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Liquidacion $proxy) {
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
    public function getMensualidad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMensualidad', []);

        return parent::getMensualidad();
    }

    /**
     * {@inheritDoc}
     */
    public function setMensualidad($mensualidad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMensualidad', [$mensualidad]);

        return parent::setMensualidad($mensualidad);
    }

    /**
     * {@inheritDoc}
     */
    public function getPagos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPagos', []);

        return parent::getPagos();
    }

    /**
     * {@inheritDoc}
     */
    public function setPagos($pagos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPagos', [$pagos]);

        return parent::setPagos($pagos);
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
    public function setId($liq_id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$liq_id]);

        return parent::setId($liq_id);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha', []);

        return parent::getFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha($fecha)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha', [$fecha]);

        return parent::setFecha($fecha);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha_pagada()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha_pagada', []);

        return parent::getFecha_pagada();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha_pagada($fecha_pagada)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha_pagada', [$fecha_pagada]);

        return parent::setFecha_pagada($fecha_pagada);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha_visible_cliente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha_visible_cliente', []);

        return parent::getFecha_visible_cliente();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha_visible_cliente($fecha_visible_cliente)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha_visible_cliente', [$fecha_visible_cliente]);

        return parent::setFecha_visible_cliente($fecha_visible_cliente);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha_hasta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha_hasta', []);

        return parent::getFecha_hasta();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha_hasta($fecha_hasta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha_hasta', [$fecha_hasta]);

        return parent::setFecha_hasta($fecha_hasta);
    }

    /**
     * {@inheritDoc}
     */
    public function getCliente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCliente', []);

        return parent::getCliente();
    }

    /**
     * {@inheritDoc}
     */
    public function setCliente($cliente)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCliente', [$cliente]);

        return parent::setCliente($cliente);
    }

    /**
     * {@inheritDoc}
     */
    public function getEvento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEvento', []);

        return parent::getEvento();
    }

    /**
     * {@inheritDoc}
     */
    public function setEvento($evento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEvento', [$evento]);

        return parent::setEvento($evento);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatosArray()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatosArray', []);

        return parent::getDatosArray();
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTotal', []);

        return parent::getTotal();
    }

}
