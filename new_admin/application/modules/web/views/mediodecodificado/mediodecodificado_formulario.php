<section  class='content mayus' >

            <?php if(!isset($mediodecodificado)): ?> 

                <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Mediodecodificados</h3>
			<button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="tabla_mediodecodificado" data-show-toggle="true" data-toggle="table" data-url="getMediodecodificadoAjax" 
                                    data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                                    data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                                    table-striped" data-page-size="20">
					<thead>
						<tr>
<th class="col-md-1" data-field="med_tipo" data-align="left" data-sortable="true">med_tipo</th>
<th class="col-md-1" data-field="med_cant_registros" data-align="left" data-sortable="true">med_cant_registros</th>
<th class="col-md-1" data-field="med_total" data-align="left" data-sortable="true">med_total</th>
<th class="col-md-1" data-field="med_fecha" data-align="left" data-sortable="true">med_fecha</th>
<th class="col-md-1" data-field="med_nombre_archivo" data-align="left" data-sortable="true">med_nombre_archivo</th>
<th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
				</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
        <?php endif; ?>
<form action="http://localhost/back_inscribite/mediodecodificado" method="post" accept-charset="utf-8">

<div  class='box box-primary' >
<div  class='box-header' >
<h3 class='box-title'>Mediodecodificado</h3></div>

<div  class='box-body' >
<div  class='col-md-3' >
<div  class='form-group' >
<label >tipo</label>

<input  class='form-control'  type='text'  placeholder='ingresetipo'  value='<?=(isset($mediodecodificado)?$mediodecodificado->getTipo():"")?>'  name='med_tipo' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >cant_registros</label>

<input  class='form-control'  type='text'  placeholder='ingresecant_registros'  value='<?=(isset($mediodecodificado)?$mediodecodificado->getCant_registros():"")?>'  name='med_cant_registros' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >total</label>

<input  class='form-control'  type='text'  placeholder='ingresetotal'  value='<?=(isset($mediodecodificado)?$mediodecodificado->getTotal():"")?>'  name='med_total' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >fecha</label>

<input  class='form-control'  type='text'  placeholder='ingresefecha'  value='<?=(isset($mediodecodificado)?$mediodecodificado->getFecha():"")?>'  name='med_fecha' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >nombre_archivo</label>

<input  class='form-control'  type='text'  placeholder='ingresenombre_archivo'  value='<?=(isset($mediodecodificado)?$mediodecodificado->getNombre_archivo():"")?>'  name='med_nombre_archivo' ></input>
</div>
</div>
<div  class='col-md-12 pull-right' >
<input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
</div>
</div>
</div>
<input  type='hidden'  value='<?=(isset($mediodecodificado)?$mediodecodificado->getId():"")?>'  name='med_id' ></input>
</form>
</section>
