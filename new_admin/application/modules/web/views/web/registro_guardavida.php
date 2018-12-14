<?= form_open_multipart(base_url("registro-guardavida")) ?>
<div  class='box box-primary' id="form_guardavida" >
    <?php if (isset($_GET["e"]) && $_GET["e"] == 1): ?>
        <div class="popUp alert alert-success fade in">
            <strong>Datos ingresados con éxito!</strong>
        </div>
    <?php endif; ?>

    <div  class='box-header' >
        <h3 class='box-title'><?= isset($guardavida) ? "Editar" : "Nuevo" ?> Guardavida</h3>
    </div>
    <div  class='box-body' >
        <div  class='col-md-2' >
            <div  class='form-group' >
                <label >Usted es</label>
                <select  class='form-control'  name='gua_tipousuario' ><option  selected='true'  value='interesado' >interesado</option>
                    <option  value='aspirante' >aspirante</option>
                    <option  value='egresado' >egresado</option>
                    <option  value='guardavida' >guardavida</option>
                </select>
            </div>
        </div>
        <div  class='col-md-2' >
            <div  class='form-group' >
                <label >Nombre</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getNombre() : "") ?>'  name='gua_nombre' ></input>
            </div>
        </div>
        <div  class='col-md-2' >
            <div  class='form-group' >
                <label >Apellido</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getApellido() : "") ?>'  name='gua_apellido' ></input>
            </div>
        </div>
        <div  class='col-md-2' >
            <div  class='form-group' >
                <label >Email</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getEmail() : "") ?>'  name='gua_email' ></input>
            </div>
        </div>
        <div  class='col-md-2' >
            <div  class='form-group' >
                <label>Contraseña</label>
                <input  class='form-control'  type='password'  value='<?= (isset($guardavida) ? $guardavida->getPassword() : "") ?>'  name='gua_password' ></input>
            </div>
        </div>
        <div  class='col-md-2' >
            <div  class='form-group' >
                <label >DNI</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getDni() : "") ?>'  name='gua_dni' ></input>
            </div>
        </div>
        <div  class='col-md-4' >
            <div  class='form-group' >
                <label >Domicilio</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getDomicilio() : "") ?>'  name='gua_domicilio' ></input>
            </div>
        </div>
        <div  class='col-md-3' >
            <div  class='form-group' >
                <label >Provincia</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getProvincia() : "") ?>'  name='gua_provincia' ></input>
            </div>
        </div>
        <div  class='col-md-3' >
            <div  class='form-group' >
                <label >Localidad</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getLocalidad() : "") ?>'  name='gua_localidad' ></input>
            </div>
        </div>
        <div  class='col-md-2' >
            <div  class='form-group' >
                <label >Código postal</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getCodpostal() : "") ?>'  name='gua_codpostal' ></input>
            </div>
        </div>
        <div  class='col-md-3' >
            <div  class='form-group' >
                <label >Teléfono fijo</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getTelfijo() : "") ?>'  name='gua_telfijo' ></input>
            </div>
        </div>
        <div  class='col-md-3' >
            <div  class='form-group' >
                <label >Celular</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getTelcelular() : "") ?>'  name='gua_telcelular' ></input>
            </div>
        </div>
        <div  class='col-md-2' >
            <div  class='form-group' >
                <label >Foto</label>
                <input  class='form-control'  type='file'  value='<?= (isset($guardavida) ? $guardavida->getFoto() : "") ?>'  name='gua_foto' ></input>
            </div>
        </div>

        <div  class='col-md-4' >
            <div  class='form-group' >
                <label >Como nos conoció?</label>
                <input  class='form-control'  type='text'  value='<?= (isset($guardavida) ? $guardavida->getNosconocio() : "") ?>'  name='gua_nosconocio' ></input>
            </div>
        </div>

        <div  class='col-md-12 pull-right' ><input  class='btn-sm btn-primary pull-right'  type='submit'  value='Crear cuenta'/>
        </div>
    </div>
</div>
<input  type='hidden'  value='<?= (isset($guardavida) ? $guardavida->getId() : "") ?>'  name='gua_id' ></input>
<?= form_close() ?>