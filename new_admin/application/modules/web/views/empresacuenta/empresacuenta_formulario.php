<section  class='content mayus' >

            <?php if(!isset($empresacuenta)): ?> 

                <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Empresacuentas</h3>
			<button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="tabla_empresacuenta" data-show-toggle="true" data-toggle="table" data-url="getEmpresacuentaAjax" 
                                    data-side-pagination="server" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" 
                                    data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                                    table-striped" data-page-size="20">
					<thead>
						<tr>
<th class="col-md-1" data-field="emp_cbu" data-align="left" data-sortable="true">emp_cbu</th>
<th class="col-md-1" data-field="emp_alias" data-align="left" data-sortable="true">emp_alias</th>
<th class="col-md-1" data-field="emp_cuit" data-align="left" data-sortable="true">emp_cuit</th>
<th class="col-md-1" data-field="emp_empresa" data-align="left" data-sortable="true">emp_empresa</th>
<th class="col-md-1" data-field="emp_banco" data-align="left" data-sortable="true">emp_banco</th>
<th class="col-md-1" data-field="emp_activa" data-align="left" data-sortable="true">emp_activa</th>
<th class="col-md-1" data-field="acciones" data-align="left" data-formatter="actionFormatter" data-events="actionEvents">Acciones</th>
				</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
        <?php endif; ?>
<form action="http://localhost/back_inscribite/empresacuenta" method="post" accept-charset="utf-8">

<div  class='box box-primary' >
<div  class='box-header' >
<h3 class='box-title'>Empresacuenta</h3></div>

<div  class='box-body' >
<div  class='col-md-3' >
<div  class='form-group' >
<label >cbu</label>

<input  class='form-control'  type='text'  placeholder='ingresecbu'  value='<?=(isset($empresacuenta)?$empresacuenta->getCbu():"")?>'  name='emp_cbu' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >alias</label>

<input  class='form-control'  type='text'  placeholder='ingresealias'  value='<?=(isset($empresacuenta)?$empresacuenta->getAlias():"")?>'  name='emp_alias' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >cuit</label>

<input  class='form-control'  type='text'  placeholder='ingresecuit'  value='<?=(isset($empresacuenta)?$empresacuenta->getCuit():"")?>'  name='emp_cuit' ></input>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >empresa</label>

<select  class='form-control'  name='emp_empresa' ><option  selected='true'  value='emp1' >emp1</option>
<option  value='emp2' >emp2</option>
</select>
</div>
</div>
<div  class='col-md-3' >
<div  class='form-group' >
<label >banco</label>

<select  class='form-control'  name='emp_banco' ><option  selected='true'  value='ban1' >ban1</option>
<option  value='ban2' >ban2</option>
</select>
</div>
</div>
<div  class='col-md-3' ><div  class='form-group' ><label >activa</label>
<input  class='form-group'  type='checkbox'  value='si'  name='emp_activa' >si</input>
<input  class='form-group'  type='checkbox'  value='no'  name='emp_activa' >no</input>
</div>
</div>
<div  class='col-md-12 pull-right' >
<input  class='btn-sm btn-primary'  type='submit'  value='guardar' ></input>
</div>
</div>
</div>
<input  type='hidden'  value='<?=(isset($empresacuenta)?$empresacuenta->getId():"")?>'  name='emp_id' ></input>
</form>
</section>
