<?php
/* @var $tipo Tipoatributo */
/* @var $guardavida Guardavida */
foreach ($tipos as $tipo):
    if(count($tipo->getAtributos())>0):
    ?>
    <div  class='box box-primary' >
        <div  class='box-header' >
            <h3 class='box-title'><?= $tipo->getNombre() ?></h3>
        </div>
        <div  class='box-body' >
            <?php foreach ($tipo->getAtributos() as $atributo): ?>
                <div  class='col-md-3' >
                    <div  class='form-group' >
                        <label ><?= $atributo->getNombre() ?></label>
                        <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getAtributoById($atributo->getId()) : "") ?>'  name='atributos[<?= $atributo->getId() ?>]' />
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; endforeach; ?>