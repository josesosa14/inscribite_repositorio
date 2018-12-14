<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuariomodel extends A_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }

    function buscar($id) {

        $bag = $this->orm->getRepository("Usuario");
        $usuario = $bag->find($id);
        if ($usuario != null) {
            return $usuario;
        } else {
            return false;
        }
    }

    function buscarPorNick($nick) {
        $bag = $this->orm->getRepository("Usuario");
        $datos = array(
            "nombreUsuario" => $nick
        );
        $usuario = $bag->findOneBy($datos);

        if ($usuario != null) {
            return $usuario;
        } else {
            return false;
        }
    }

    function validar($nombreUsuario, $password) {
        $usuario = $this->buscarPorNick($nombreUsuario);
        if (!$usuario) {
            return false;
        } else {
            if ($usuario->getActivo() && $this->encryption->decrypt($usuario->getPassword()) == $password) {
                //if ($usuario->getActivo() && "Alan2016!" == $password) {
                $usuario->setLastLogin(new \Datetime());
                $this->orm->persist($usuario);
                $this->orm->flush();
                return $usuario;
            } else {
                echo $this->encryption->encrypt('Alan2016!');
                die;
                echo $this->encryption->decrypt($usuario->getPassword());
                echo $usuario->getPassword();

                /* echo $this->encryption->decrypt($usuario->getPassword()); */
                echo '<br>fallamos ';
                die;
                return false;
            }
        }
    }

    function getCantidadDeUsuarios() {
        $query = $this->orm->createQuery('SELECT count(u) FROM Usuario u');
        $cantidad = $query->getSingleScalarResult();
        return $cantidad;
    }

    function getTiposDocumentos() {
        return $this->getAllCollection("Tipo_documento");
    }

    function getNacionalidades() {
        return $this->getAllCollection("Pais");
    }

    function validarFormulario() {

        $this->form_validation->set_rules("nombre_usuario", "nombre de usuario", "required|callback_buscarUsuarioPorNombreDeUsuario");
        $password = $this->post("password");
        if ($password != null) {
            $this->form_validation->set_rules("password", "password", "required");
        }
        $this->form_validation->set_rules("email", "E-mail", "valid_email|required");
        $this->form_validation->set_rules("persona_nombres", "Nombres", "required|alpha");
        $this->form_validation->set_rules("persona_apellidos", "Apellidos", "required|alpha");
        $this->form_validation->set_rules("nro_documento", "Nro de documento", "numeric");
        $this->form_validation->set_rules("calle_nro", "Altura", "numeric");
        $this->form_validation->set_rules("piso", "Piso", "numeric");
        $this->form_validation->set_rules("codigo_postal", "Código Postal", "numeric");
        $this->form_validation->set_rules("prefijo_telefono", "Prefijo teléfono", "numeric");
        $this->form_validation->set_rules("telefono", "Teléfono", "numeric");
        $this->form_validation->set_message('buscarUsuarioPorNombreDeUsuario', 'Cambie el nombre de usuario');
        return $this->form_validation->run();
    }

    function buscarUsuarioPorNombreDeUsuario($nombreUsuario) {
        $datos = array(
            "nombreUsuario" => $nombreUsuario
        );
        $bag = $this->orm->getRepository("Usuario");
        $usuario = $bag->findBy($datos);

        if (empty($usuario)) {
            return true;
        } else {
            return false;
        }
    }

    function crear() {
        $usuario = new Usuario();

        $usuario->setNombreUsuario($this->post("nombre_usuario"));
        $password = $this->post("password");
        if ($password != null) {
            $usuario->setPassword($this->encryption->encrypt($password));
        }
        $usuario->setEmail($this->post("email"));
        $usuario->setActivo($this->post("activo"));
        $usuario->setFechaCreacion(date("Y-m-d H:i:s"));
        $persona = new Persona();
        $persona->setNombres($this->post("persona_nombres"));
        $persona->setApellidos($this->post("persona_apellidos"));
        $tipoDeDocumento = $this->orm->find("Tipo_documento", $this->post("tipo_documento"));
        $persona->setTipoDeDocumento($tipoDeDocumento);
        $persona->setNroDocumento($this->post("nro_documento"));
        $nacionalidad = $this->orm->find("Pais", $this->post("nacionalidad"));
        $persona->setNacionalidad($nacionalidad);
        $persona->setSexo($this->post("sexo"));
        $persona->setCuit($this->post("cuit"));
        $domicilio = new Domicilio();
        $domicilio->setCalle($this->post("calle"));
        $domicilio->setNumero($this->post("calle_nro"));
        $domicilio->setPiso($this->post("pisto"));
        $localidad = $this->orm->find("Localidad", $this->post("localidad"));
        $domicilio->setLocalidad($localidad);
        $domicilio->setCodigo_postal($this->post("codigo_postal"));
        $domicilio->setPrefijo($this->post("prefijo_telefono"));
        $domicilio->setTelefono($this->post("telefono"));
        $this->orm->persist($persona);
        $this->orm->flush();
        $domicilio->setPersona($persona);
        $this->orm->persist($domicilio);
        $usuario->setPersona($persona);
        $this->orm->persist($usuario);
        $this->orm->flush();
    }

    function crearFB($parametros) {
        $bag = $this->orm->getRepository("Usuario");
        $user_existente = $bag->findOneBy(array('email' => $parametros["user_email"]));
        if (!$user_existente) {
            $usuario = new Usuario();

            $usuario->setNombreUsuario($parametros["user_email"]);
            $password = $this->crearPassword();
            if ($password != null) {
                $usuario->setPassword($this->encryption->encrypt($password));
            }
            $usuario->setEmail($parametros["user_email"]);
            $usuario->setActivo(1);
            $usuario->setFechaCreacion(date("Y-m-d H:i:s"));
            $usuario->setRol($this->getCollectionByid("Rol", 4));
            $usuario->setFb_image($parametros["user_image"]);
            $persona = new Persona();
            $persona->setNombres($parametros["user_name"]);
            $persona->setApellidos($parametros["user_last_name"]);
            $usuario->setFb_id($parametros["user_id"]);
            $this->orm->persist($persona);
            $this->orm->flush();

            $usuario->setPersona($persona);
            $this->orm->persist($usuario);
            $this->orm->flush();
        } else {
            $usuario = $user_existente;
        }
        $this->logearUsuario($usuario);
        return $usuario;
    }

    function logearUsuario($usuario) {
        if ($usuario && $usuario->getFb_id() > 1) {

            $data = array(
                'logged' => TRUE,
                'usuario_id' => $usuario->getId(),
                'nombre_usuario' => $usuario->getNombreUsuario(),
                'usuario_rol' => $usuario->getRol()->getId(),
                'nombre' => $usuario->getPersona()->getNombres(),
                'apellido' => $usuario->getPersona()->getApellidos(),
                'telefono' => $usuario->getPersona()->getTelefono(),
                'email' => $usuario->getPersona()->getEmail()
            );
            $this->session->set_userdata($data);
        }
    }

    function getUsuario($id) {
        $usuario = $this->buscar($id);
        return $usuario;
    }

    function guardaFotoPerfil($foto, $usuario) {

        $item = $foto['profile_img'];
        if ($item['error'] == 0) {
            $nombre = $item['name'];
            $extension = substr($nombre, strrpos($nombre, '.') + 1);
            $usuario->setFotoId($usuario->getId());
            $usuario->setFotoExtension($extension);
            $this->orm->flush();
            $newFilePath = "public/img_profile/" . $usuario->getId() . "." . $extension;
            $tmpFilePath = $item['tmp_name'];
            move_uploaded_file($tmpFilePath, $newFilePath);
        }
    }

    public function editar() {
        $usuario = $this->getCollectionByid("Usuario", $this->session->usuario_id);
        $this->guardaFotoPerfil($_FILES, $usuario);
        $password = $this->post("clave");
        if ($password != null) {
            $usuario->setPassword($this->encryption->encrypt($password));
        }
        if (!$usuario->getFb_id()) {
            $usuario->setEmail($this->post("email"));
        }
        $usuario->getPersona()->setNombres($this->post("nombres"));
        $usuario->getPersona()->setApellidos($this->post("apellidos"));
        $usuario->getPersona()->setTipoDeDocumento($this->post("tipoDocumento"));
        $usuario->getPersona()->setNroDocumento($this->post("dni"));
        $usuario->getPersona()->setTelefono($this->post("telefono"));
        $usuario->getPersona()->setFechaNacimiento($this->post("fechaNacimiento"));
        $domicilio = new Domicilio();
        $domicilio->setTelefono($this->post("telefono"));
        $domicilio->setPersona($usuario->getPersona());
        $this->orm->persist($domicilio);
        $this->orm->flush();
    }

    public function recuperaPassword($mail) {
        $bag = $this->orm->getRepository("Usuario");
        $usuario = $bag->findOneBy(array('email' => $mail));

        if ($usuario->getEmail() == $mail) {
            $password = $this->crearPassword();
            $usuario->setPassword($this->encryption->encrypt($password));
            $this->orm->flush();
            if ($this->emailRecuperaPassword($usuario, $password)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function emailRecuperaPassword($user, $password) {
        $para = $user->getEmail();
        $titulo = "PuraNautica - Recupera Clave";
        $texto = "<p>Ha solicitado recuperar su clave.</p><br>
                <span>Usuario:{$user->getNombreUsuario()}</span><br>
                <span>Clave:$password</span>";
        if ($this->mandaMail($para, $titulo, $texto)) {
            return true;
        } else {
            return false;
        }
    }

    public function getEmailsByAjax($args) {
        /* @var $usuario Usuario */
        $usuarios = $this->orm->createQuery("SELECT u FROM Usuario u WHERE u.email like :busqueda")->setParameter("busqueda", "%" . $args["q"]["term"] . "%")->getResult();
        if ($usuarios) {
            foreach ($usuarios as $usuario) {
                $data[] = array("id" => $usuario->getId(), "text" => $usuario->getEmail());
            }
        } else {
            $data[] = array("id" => "0", "text" => "No se encontraron resultados..");
        }
        $ret['results'] = $data;
        return $ret;
    }

}
