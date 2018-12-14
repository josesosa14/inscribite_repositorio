      <div class="columnaderecha">

        <div class="titu">Log In</div>

        <div class="contenidocols" style="float:left;width:159px;">

<? if (($_COOKIE['usuario'] != "") || ($recienlogeado)) { ?>

          <div class="logueo" style="margin:0px;">

            <form action="" method="post" style="margin:0px;padding:0px;">

              <div style="margin:0px;">

                <label>Bienvenido,</label>

                <br/>

<?

if ($_POST['usuario'] != '')

  $result = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.$_POST['usuario'].'" LIMIT 1 ');

if ($_COOKIE['usuario'] != '')

  $result = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.$_COOKIE['usuario'].'" LIMIT 1 ');



$row = mysql_fetch_array($result);

echo $row['nombre'].' '.$row['apellido']."<br/>";

echo "dni: ".$row['dni'].'<br/><br/>';



echo "puntos: ".$row['puntos']?>

                <br/>

                <br/>

                <a href="http://www.inscribiteonline.com.ar/cerrarsesion">Cerrar Sesion</a><br/>

                <a href="http://www.inscribiteonline.com.ar/usuario/<?=$row['dni']?>">Ver mi cuenta</a><br/>

                <a href="http://www.inscribiteonline.com.ar/registrate?usuario=<?=$row['dni']?>">Cambiar mis datos</a>

              </div>

            </form>

          </div>

<? } else { ?>

          <div class="logueo">

            <form action="javascript:checkdni()" id="formdelogin" method="post" style="margin:0px;padding:0px;">

              <div style="margin:0px;">

                <span style="color:red"><? if ($_POST['usuario'] != '') {

     //$result = mysql_query('SELECT * FROM inscribite_usuarios WHERE dni = "'.$_POST['usuario'].'" LIMIT 1 ');

     //if (mysql_num_rows($result) > 1)

       echo 'Password incorrecto';

     //else

       //echo 'DNI no registrado';

                                           } ?></span>

                <label style="float:left;">Ingresá tu DNI</label>

                <input type="text" name="usuario" value="" style="width:150px;" id="dninmbusuario"<?/* onkeypress="return acceptNum(event)"*/?> title="Su nombre de usuario es el nro de DNI" onkeyup="this.value=this.value.replace('.','').replace('.','').replace('.','').replace('.','').substring(0,8)"/>

<? /*

                <label>Contraseña</label>

                <input type="password" name="passw" id="inputpassw" value="" style="width:150px;"/>

*/ ?>

                <div id="parapass">

                </div>

                <input type="submit" value="Ingresar" style="margin:3px 0px 3px 0px;float:left;"/>

              </div>

            </form>

              <a href="acercade" style="font-size:10px;float:left;clear:left;width:100%;">Nunca usaste el servicio?</a><br/>

              <a href="recordarpassword" style="font-size:10px;float:left;clear:left;width:100%;">Olvidaste tu contraseña?</a><br/>

<? /* <a href="registrate" style="font-size:10px">Registrate ahora</a><br/> */ ?>



            </div>

<? } ?>

            <div style="float:left;clear:left;width:100%;margin:0px;padding:0px;overflow:hidden;border-top:1px #757575 solid;border-bottom:1px white solid;height:0px;margin-top:10px;">

            </div>



             <div style="float:left;clear:left;font-size:12px;margin-top:10px;width:100%;border:1px #E9E9E9 solid">

             <a href="faq.php" style="font-weight:bold;">AYUDA.</a>

              Ante cualquier duda accedé a nuestras preguntas frecuentes.



<?

$result=mysql_query('SELECT * FROM inscribite_banners WHERE ver=1 AND columna=2 AND width1=160 ');

while($row=mysql_fetch_array($result)){ ?>

<br />

<a href="<?=$row['link']?>" style="display:block;"><img src="/imagenes/image_<?=$row['imagen1']?>" alt="" style="padding:0px;width:160px;display:block;margin:9px auto 8px auto;"/></a>

<? } ?><br />

<a href="http://www.bristolgroup.com.ar/ec/default.php" target="_blank"><img src="/banners/comercio160x64.gif" /></a>

<a href="http://www.trainersclub.com.ar/" target="_blank"><img src="/banners/trainers160x60.gif" /></a></div>

  </div>

          <div class="bordeabajo" style="float:left;clear:left;">

          </div>

        </div>

      </div>

      <div class="footer">

        Inscribite on line es un producto de MARITIMO SRL / 4641-4423 4643-1124 /

        <a href="mailto:comercial@maritimopro.com.ar">comercial@maritimopro.com.ar</a>

      </div>

	  <div class="lineainicioyfinal">

      </div>

    </div>

<script type="text/javascript" src="http://www.inscribiteonline.com.ar/js/script.js"></script>

<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

</script>

<script type="text/javascript">

try {

var pageTracker = _gat._getTracker("UA-6614438-1");

pageTracker._trackPageview();

} catch(err) {}</script>

  </body>

</html><?

if(is_resource($result1))mysql_free_result($result1);

if(is_resource($result2))mysql_free_result($result2);

if(is_resource($result3))mysql_free_result($result3);

mysql_close();

?>