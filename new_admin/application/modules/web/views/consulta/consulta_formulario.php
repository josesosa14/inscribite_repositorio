<section  class='content mayus' >

            <?php if(!isset($consulta)): ?> 

                <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Consultas</h3>
			<button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="tabla_consulta" data-show-toggle="true" data-toggle="table" data-url="getConsultaAjax" 
                                    data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                                    data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                                    table-striped" data-page-size="20">
					<thead>
						<tr>
<th class="col-md-1" data-field="con_nombre" data-align="left" data-sortable="true">con_nombre</th>
<th class="col-md-1" data-field="con_email" data-align="left" data-sortable="true">con_email</th>
<th class="col-md-1" data-field="con_telefono" data-align="left" data-sortable="true">con_telefono</th>
<th class="col-md-1" data-field="con_comentarios" data-align="left" data-sortable="true">con_comentarios</th>
<th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
				</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
        <?php endif; ?>
<form action="<?= base_url() ?>consulta" method="post" accept-charset="utf-8">
<input type="hidden" name="argit_token" value="a22c04b8ffde6556bcb886de4a671a43" style="display:none;" />
<div  class='box box-primary' ><div  class='box-header' ><h3 class='box-title'>Consulta</h3></div>

<div  class='box-body' ><div  class='row' >
<div  class='col-md-3' ><div  class='form-group' ><label >nombre</label>
<input  class='form-control'  type='text'  placeholder='ingresenombre'  value='<?=(isset($consulta)?$consulta->getNombre():"")?>'  name='con_nombre' ></input>
</div>
</div>
<div  class='col-md-3' ><div  class='form-group' ><label >email</label>
<input  class='form-control'  type='text'  placeholder='ingreseemail'  value='<?=(isset($consulta)?$consulta->getEmail():"")?>'  name='con_email' ></input>
</div>
</div>
<div  class='col-md-3' ><div  class='form-group' ><label >telefono</label>
<input  class='form-control'  type='text'  placeholder='ingresetelefono'  value='<?=(isset($consulta)?$consulta->getTelefono():"")?>'  name='con_telefono' ></input>
</div>
</div>
<div  class='col-md-3' ><div  class='form-group' ><label >comentarios</label>
<textarea  class='form-control'  placeholder=''  name='con_comentarios' ><?=(isset($consulta)?$consulta->getComentarios():"")?></textarea>
</div>
</div>
<div  class='col-md-12 pull-right' ><input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
</div>
</div>
</div>
</div>
<input  type='hidden'  value='<?=(isset($consulta)?$consulta->getId():"")?>'  name='con_id' ></input>
</form>
</section>
