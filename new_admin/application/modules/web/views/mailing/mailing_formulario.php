<?php /* @var $lista Listadifusion */ ?>
<section  class='content mayus' >



    <?= form_open(base_url("mailing")) ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Nuevo email</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <label>Listas:</label>
                <select  class="js-example-basic-multiple form-control" name="listas[]" multiple="multiple">
                    <?php foreach ($listas as $lista): if ($lista->getId() == 2) continue; ?>
                        <option value="<?= $lista->getId() ?>"><?= $lista->getNombre() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Destinos:</label>
                <select id="mails" class="js-example-basic-multiple form-control" name="destinos[]" multiple="multiple">

                </select>
            </div>
            <div class="form-group">
                <input class="form-control" name="mai_subject" placeholder="Asunto:">
            </div>
            <div class="form-group">
                <textarea name="mai_message" class="form-control" style="height: 300px;width: 100%"></textarea>
            </div>
            <div class="form-group">
                <input type="checkbox" name="formulario_guardavida" value="1"/>Formulario guardavida
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
            </div>
        </div>
        <!-- /.box-footer -->
    </div>
    <?= form_close() ?>

    <?php if (!isset($mailing)): ?> 
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Mails enviados</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_mailing" data-show-toggle="true" data-toggle="table" data-url="getMailingAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                           table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="mai_subject" data-align="left" data-sortable="true">Asunto</th>
                                <th class="col-md-1" data-field="mai_mensaje" data-align="left" data-sortable="true">Mensaje</th>
                                <th class="col-md-1" data-field="mai_adjunto" data-align="left" data-sortable="true">Tiene adjunto</th>
                                <th class="col-md-1" data-field="mai_fecha_in" data-align="left" data-sortable="true">Fecha</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
