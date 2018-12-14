<section  class='content mayus' >
    <?php if (!isset($tipoatributo)): ?> 
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Tipoatributo cargados</h3>
                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_consorcio" data-show-toggle="true" data-toggle="table" data-url="getTipoatributoAjax" 
                           data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                           data-cache="false" data-height="auto" data-show-columns="true"  data-search-time-out="750" 
                           class="table table-responsive table-striped" data-page-size="20">
                        <thead>
                            <tr>
                                <th class="col-md-1" data-field="nombre" data-align="left" data-sortable="true">nombre</th>
<th class="col-md-1" data-field="acciones" data-align="left">Acciones</th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <button type="button" <?=isset($tipoatributo)?"style='display:none'":""?> class="btn btn-success" onclick="$('#form_tipoatributo').show()" >Nuevo Tipoatributo</button>
    <?=form_open(base_url("admin-tipoatributo"))?>
    <div  class='box box-primary' id="form_tipoatributo" <?=!isset($tipoatributo)?"style='display:none'":""?>>
            <div  class='box-header' >
                <h3 class='box-title'><?=isset($tipoatributo)?"Editar":"Nuevo"?> Tipoatributo</h3>
            </div>
            <div  class='box-body' >
                <div  class='col-md-3' >
<div  class='form-group' >
<label >nombre</label>

<input  class='form-control'  type='text'  value='<?=(isset($tipoatributo)?$tipoatributo->getNombre():"")?>'  name='tip_nombre' ></input>

</div>

</div>

                <div  class='col-md-12 pull-right' ><input  class='btn-sm btn-primary pull-right'  type='submit'  value='guardar' ></input>
                </div>
            </div>
        </div>
        <input  type='hidden'  value='<?= (isset($tipoatributo) ? $tipoatributo->getId() : "") ?>'  name='tip_id' ></input>
    <?=form_close()?>
</section>
