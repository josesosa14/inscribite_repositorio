<section  class='content mayus' >

            <?php if(!isset($decodificado_renglones)): ?> 

                <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Decodificado_rengloness</h3>
			<button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="tabla_decodificado_renglones" data-show-toggle="true" data-toggle="table" data-url="getDecodificado_renglonesAjax" 
                                    data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                                    data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                                    table-striped" data-page-size="20">
					<thead>
						<tr>
<th class="col-md-1" data-field="dec_mediodecodificado" data-align="left" data-sortable="true">dec_mediodecodificado</th>
<th class="col-md-1" data-field="dec_dni" data-align="left" data-sortable="true">dec_dni</th>
<th class="col-md-1" data-field="dec_codigo" data-align="left" data-sortable="true">dec_codigo</th>
<th class="col-md-1" data-field="dec_importe" data-align="left" data-sortable="true">dec_importe</th>
<th class="col-md-1" data-field="dec_fechapago" data-align="left" data-sortable="true">dec_fechapago</th>
<th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
				</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
        <?php endif; ?>
<form action="http://localhost/back_inscribite/decodificado_renglones" method="post" accept-charset="utf-8">

<div  class='box box-primary' >
<div  class='box-header' >
<h3 class='box-title'>Decodificado_renglones</h3></div>

<div  class='box-body' >
<div  class='col-md-3' >
<div  class='form-group' >
<label >mediodecodificado</label>

<input  class='form-control'  type='text'  placeholder='ingresemediodecodificado'  value='<?=(isset($decodificado_renglones)?$decodificado_renglones->getMediodecodificado():"")?>'  name='dec_mediodecodificado' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >dni</label>

<input  class='form-control'  type='text'  placeholder='ingresedni'  value='<?=(isset($decodificado_renglones)?$decodificado_renglones->getDni():"")?>'  name='dec_dni' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >codigo</label>

<input  class='form-control'  type='text'  placeholder='ingresecodigo'  value='<?=(isset($decodificado_renglones)?$decodificado_renglones->getCodigo():"")?>'  name='dec_codigo' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >importe</label>

<input  class='form-control'  type='text'  placeholder='ingreseimporte'  value='<?=(isset($decodificado_renglones)?$decodificado_renglones->getImporte():"")?>'  name='dec_importe' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >fechapago</label>

<input  class='form-control'  type='text'  placeholder='ingresefechapago'  value='<?=(isset($decodificado_renglones)?$decodificado_renglones->getFechapago():"")?>'  name='dec_fechapago' ></input>
</div>
</div>
<div  class='col-md-12 pull-right' >
<input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
</div>
</div>
</div>
<input  type='hidden'  value='<?=(isset($decodificado_renglones)?$decodificado_renglones->getId():"")?>'  name='dec_id' ></input>
</form>
</section>
