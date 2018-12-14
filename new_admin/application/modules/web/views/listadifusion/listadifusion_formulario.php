<?php
/* @var $listadifusion Listadifusion */
?>
<section  class='content mayus' >

    <?php if (!isset($listadifusion)): ?> 

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Listas de difusión</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_listadifusion" data-show-toggle="true" data-toggle="table" data-url="getListadifusionAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="lis_nombre" data-align="left" data-sortable="true">Nombre</th>
                                <th class="col-md-1" data-field="lis_fecha" data-align="left" data-sortable="true">Creado</th>
                                <th class="col-md-1" data-field="lis_usuario" data-align="left" data-sortable="true">Usuario</th>
                                <th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?= form_open("admin-listadifusion") ?>
    <div  class='box box-primary' id="form_difusion" >
        <div  class='box-header' >
            <h3 class='box-title'>Nueva lista de difusión</h3></div>

        <div  class='box-body' >
            <div  class='col-md-3' >
                <div  class='form-group' >
                    <label >nombre</label>
                    <input  class='form-control'  type='text'  placeholder='ingresenombre'  value='<?= (isset($listadifusion) ? $listadifusion->getNombre() : "") ?>'  name='lis_nombre' ></input>
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label>Usuarios:</label>
                    <select class="form-control" required="true" style="height: 200px;" multiple name="renglones[]" id="mails">
                        <?php
                        if (isset($listadifusion)):
                            foreach ($listadifusion->getEmails() as $email):
                                ?>
                                <option selected value="<?= $email->getUsuario()->getId() ?>"><?= $email->getUsuario()->getEmail() ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            <div  class='col-md-12 pull-right' >
                <input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
            </div>
        </div>
    </div>
    <input  type='hidden'  value='<?= (isset($listadifusion) ? $listadifusion->getId() : "") ?>'  name='lis_id' ></input>
    <?= form_close() ?>

    <?php $this->load->view("mailing/nuevo_mail") ?>
</section>
