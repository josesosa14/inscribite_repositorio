<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Formulario_model extends A_Model {

    public function __construct() {
        parent::__construct();
    }

    private function generaFormulario($information) {
        $controles = "";
        if (isset($information['text'])) {
            $controles .= $this->generaInputs($information['text'], $information['clase_nombre']);
        }
        if (isset($information['select'])) {
            $controles .= $this->generaSelects($information['select'], $information['clase_nombre']);
        }
        if (isset($information['multiSelect'])) {
            $controles .= $this->generaMultiSelects($information['multiSelect'], $information['clase_nombre']);
        }
        if (isset($information['checkbox'])) {
            $controles .= $this->generaCheckbox($information['checkbox'], $information['clase_nombre']);
        }
        if (isset($information['radio'])) {
            $controles .= $this->generaRadio($information['radio'], $information['clase_nombre']);
        }
        if (isset($information['textArea'])) {
            $controles .= $this->generatextArea($information['textArea'], $information['clase_nombre']);
        }

        $contenido = file_get_contents(base_url() . "public/templates_admin/new_form.html");
        $contenido = str_replace('{class_name}', ucfirst($information['clase_nombre']), $contenido);
        $contenido = str_replace('{class_name_minus}', strtolower($information['clase_nombre']), $contenido);
        $contenido = str_replace('{prefijo}', strtolower($information['prefijo']), $contenido);

        $cabezales = "";
        foreach ($information['controles'] as $control) {
            $cabezales .='<th class="col-md-1" data-field="' . $control['label'] . '" data-align="left" data-sortable="true">' . $control['label'] . '</th>' . PHP_EOL;
        }
        $cabezales.='<th class="col-md-1" data-field="acciones" data-align="left">Acciones</th>' . PHP_EOL;
        $contenido = str_replace('{cabezales}', $cabezales, $contenido);
        $contenido = str_replace('{controles}', $controles, $contenido);

        mkdir(VIEW . $information['clase_nombre'], 0755);
        file_put_contents(VIEW . $information['clase_nombre'] . DIRECTORY_SEPARATOR . $information['clase_nombre'] . '_formulario.php', $contenido);

        //por ahora footer vacio porq las acciones estan en entity
        $container = "";
        file_put_contents(VIEW . $information['clase_nombre'] . DIRECTORY_SEPARATOR . 'footer.php', $container);
    }

    private function modelShowMethod($control) {
        if ($control["tipo_dato"] == "datetime") {
            return 'new \DateTime($information["' . $control['nombre'] . '"])';
        }
        return '$information["' . $control['nombre'] . '"]';
    }

    private function generaModel($information) {
        $script_base = '<?php ' . PHP_EOL . '
        defined("BASEPATH") OR exit("No direct script access allowed");' . PHP_EOL . '
        class ' . ucfirst($information['clase_nombre']) . '_model extends A_Model {' . PHP_EOL . '
            public function __construct() {' . PHP_EOL . '
                parent::__construct();' . PHP_EOL . '
            }' . PHP_EOL . '
            
            public function getById($id) {
               return $this->getCollectionByid("' . ucfirst($information['clase_nombre']) . '", $id);
            }' . PHP_EOL . '
                
            public function borrar($id) {
               $objeto= $this->getCollectionByid("' . ucfirst($information['clase_nombre']) . '", $id);
               if($objeto->getActivo()){
                  $objeto->setActivo(0);
               }else{
                   $objeto->setActivo(1);
               }
               $this->orm->flush();
            }' . PHP_EOL . '

            public function insertar($information) {
                if ($information["' . $information['primary_key'] . '"]) {
$' . $information['clase_nombre'] . ' = $this->getCollectionByid("' . ucfirst($information['clase_nombre']) . '", $information["' . $information['primary_key'] . '"]);
} else {
$' . $information['clase_nombre'] . ' = new ' . ucfirst($information['clase_nombre']) . '();
$' . $information['clase_nombre'] . '->setCreated_at(new \DateTime());    
$this->orm->persist($' . $information['clase_nombre'] . ');
}' . PHP_EOL;

        foreach ($information['controles'] as $control) {
            $script_base .= '$' . $information['clase_nombre'] . '->set' . ucfirst($control['label']) . '(' . $this->modelShowMethod($control) . ');';
        }
        $script_base .= '$' . $information['clase_nombre'] . '->setActivo(isset($information["' . $information['prefijo'] . 'activo"])?1:0);';
        $script_base .= '$' . $information['clase_nombre'] . '->setModified_at(new \DateTime());';
        $script_base .= '$this->orm->flush();
}' . PHP_EOL . '

public function get' . ucfirst($information['clase_nombre']) . 'Ajax($information) {
$out = array();
if ($information["limit"]) {
$limit = $information["limit"];
} else {
$limit = 20;
}
$offset = 0;
if ($information["offset"]) {
$offset = $information["offset"];
}
$orden = "ASC";
switch ($information["order"]) {
case "asc" :
$orden = "ASC";
break;
case "desc" :
$orden = "DESC";
break;
}

$sort="c.' . $information["controles"][0]["label"] . '";
if(isset($information["sort"])){
    $sort="c.{$information["sort"]}";
}

if(isset($information["search"])){
    $where="' . $this->procesaControlesWhere($information) . '";
    $query = $this->orm->createQuery("SELECT c FROM ' . ucfirst($information['clase_nombre']) . ' c $where ORDER BY $sort $orden")->setParameter("busqueda","%".$information["search"]."%")->setFirstResult($offset)->setMaxResults($limit);
    $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM ' . ucfirst($information['clase_nombre']) . ' c $where")->setParameter("busqueda","%".$information["search"]."%")->setMaxResults(1)->getSingleScalarResult();
}else{
    $query = $this->orm->createQuery("SELECT c FROM ' . ucfirst($information['clase_nombre']) . ' c  ORDER BY $sort $orden")->setFirstResult($offset)->setMaxResults($limit);
    $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM ' . ucfirst($information['clase_nombre']) . ' c ")->setMaxResults(1)->getSingleScalarResult();
}
$' . $information['clase_nombre'] . 's = $query->getResult();
foreach ($' . $information['clase_nombre'] . 's as $' . $information['clase_nombre'] . ') {
    $out [] = $' . $information['clase_nombre'] . '->getDatosArray();
}
$data ["rows"] = $out;
return $data;
}' . PHP_EOL . '

}';

        mkdir(MODELO . $information['clase_nombre'], 0755);
        file_put_contents(MODELO . $information['clase_nombre'] . DIRECTORY_SEPARATOR . ucfirst($information['clase_nombre']) . '_model.php', $script_base);
    }

    private function procesaControlesWhere($information) {
        $response = "";
        foreach ($information["controles"] as $k => $control) {
            if ($k == 0) {
                $response = "WHERE c." . $control["label"] . " like :busqueda";
            } else {
                $response.=" OR c." . $control["label"] . " like :busqueda";
            }
        }
        return $response;
    }

    private function generaController($information) {
        $contenido = file_get_contents(base_url() . "public/templates_admin/controller.html");
        $contenido = str_replace('{class_name}', ucfirst($information['clase_nombre']), $contenido);
        $contenido = str_replace('{class_name_minus}', strtolower($information['clase_nombre']), $contenido);
        $contenido = str_replace('{prefijo}', $information["prefijo"], $contenido);
        file_put_contents(CONTROLLER . ucfirst($information['clase_nombre']) . '_controller.php', $contenido);
    }

    private function generaEntity($information) {
        $contenido = file_get_contents(base_url() . "public/templates_admin/entity.html");
        $contenido = str_replace('{class_name}', ucfirst($information['clase_nombre']), $contenido);
        $contenido = str_replace('{class_name_minus}', strtolower($information['clase_nombre']), $contenido);
        $contenido = str_replace('{prefijo}', strtolower($information['prefijo']), $contenido);
        $contenido.= PHP_EOL;
        $atributos = "";
        foreach ($information['controles'] as $control) {
            $control["prefijo"] = $information["prefijo"];
            $atributos.= $this->generaEntityField($control);
            $atributos.= PHP_EOL;
        }
        $contenido = str_replace('{atributos}', $atributos, $contenido);
        $propiedades = "";
        foreach ($information['controles'] as $control) {
            $control["prefijo"] = $information["prefijo"];
            $propiedades.= $this->generaEntityProperty($control);
            $propiedades.= PHP_EOL;
        }
        $contenido = str_replace('{propiedades}', $propiedades, $contenido);
        $str_array = $this->getDatosArrayEntity($information);
        $contenido = str_replace('{datos_array}', $str_array, $contenido);

        file_put_contents(ENTITY . ucfirst($information['clase_nombre']) . '.php', $contenido);
    }

    private function getFormatData($control, $format = 'd/m/Y') {
        $response = "";
        if ($control["tipo_dato"] == "datetime") {
            $response = "->format('$format')";
        }
        return $response;
    }

    private function getDatosArrayEntity($information) {
        $script_base = 'public function getDatosArray(){
                $array = array(';
        $script_base.='"id" => $this->getId(),' . PHP_EOL;
        foreach ($information['controles'] as $control) {
            $script_base.='"' . $control['label'] . '" => $this->get' . ucfirst($control['label']) . '()' . $this->getFormatData($control, "Y-m-d") . ', ' . PHP_EOL;
        }
        $script_base.='"acciones" => $this->getAcciones()';
        $script_base.=');
                return $array;
                }';
        return $script_base;
    }

    private function getTipoDatoEntity($tipo) {
        $response = "string";
        if ($tipo == "int") {
            $response = "integer";
        } elseif ($tipo == "bigint") {
            $response = "bigint";
        } elseif ($tipo == "datetime") {

            $response = "datetime";
        } elseif ($tipo == "double") {
            $response = "float";
        }
        return $response;
    }

    private function getLongitudField($longitud = false) {
        if ($longitud) {
            return ",length=" . $longitud;
        }
        return "";
    }

    private function getNullableField($null = false) {
        if ($null) {
            return true;
        }
        return false;
    }

    private function generaEntityProperty($control) {
        $contenido = file_get_contents(base_url() . "public/templates_admin/elements_entity/propiedades.html");
        $contenido = str_replace('{atributo}', ucfirst($control['label']), $contenido);
        $contenido = str_replace('{atributo_minus}', strtolower($control['label']), $contenido);
        return $contenido;
    }

    private function generaEntityField($control) {
        $tipo_dato = $this->getTipoDatoEntity($control['tipo_dato']);
        $contenido = file_get_contents(base_url() . "public/templates_admin/elements_entity/atributos.html");
        $contenido = str_replace('{atributo}', ucfirst($control['label']), $contenido);
        $contenido = str_replace('{atributo_minus}', strtolower($control['label']), $contenido);
        $contenido = str_replace('{type}', $tipo_dato, $contenido);
        $contenido = str_replace('{nullable}', isset($control['nullable']) ? "true" : "false", $contenido);
        $contenido = str_replace('{prefijo}', $control["prefijo"], $contenido);

        return $contenido;
    }

    private function evaluaLongitud($control) {
        if (isset($control['longitud'])) {
            return $control['longitud'];
        }
        if ($control['tipo_dato'] == "int") {
            return "11";
        }
        if ($control['tipo_dato'] == "varchar") {
            return "255";
        }
        if ($control['tipo_dato'] == "bit") {
            return "1";
        }
        if ($control['tipo_dato'] == "longtext") {
            return "65,535";
        }
        if ($control['tipo_dato'] == "decimal") {
            return "10,2";
        }
    }

    private function getArrayControles(&$information) {
        $controles = array();
        $cont_controles = 0;
        if (isset($information['text'])) {
            foreach ($information['text'] as $key_text => $textbox) {
                $controles[$cont_controles]['tipo_dato'] = $textbox['tipo_dato'];
                $controles[$cont_controles]['label'] = str_replace(" ", "", $textbox['label']);
                $controles[$cont_controles]['nombre'] = $information['prefijo'] . str_replace(" ", "", $textbox['label']);
                $controles[$cont_controles]['longitud'] = $this->evaluaLongitud($textbox);
                $controles[$cont_controles]['nullable'] = (isset($textbox['nullable']) ? $textbox['nullable'] : $information['text'][$key_text]['nullable'] = 0);
                $information['text'][$key_text]['nombre'] = $controles[$cont_controles]['nombre'];
                $cont_controles++;
            }
        }
        if (isset($information['select'])) {
            foreach ($information['select'] as $key_select => $select) {
                $controles[$cont_controles]['tipo_dato'] = $select['tipo_dato'];
                $controles[$cont_controles]['nombre'] = $information['prefijo'] . str_replace(" ", "", $select['label']);
                $controles[$cont_controles]['label'] = str_replace(" ", "", $select['label']);
                $controles[$cont_controles]['longitud'] = $this->evaluaLongitud($select);
                $controles[$cont_controles]['nullable'] = (isset($select['nullable']) ? $select['nullable'] : $information['select'][$key_select]['nullable'] = 0);
                $information['select'][$key_select]['nombre'] = $controles[$cont_controles]['nombre'];
                $cont_controles++;
            }
        }
        if (isset($information['multiSelect'])) {
            foreach ($information['multiSelect'] as $key_multi => $multiselect) {
                $controles[$cont_controles]['tipo_dato'] = $multiselect['tipo_dato'];
                $controles[$cont_controles]['nombre'] = $information['prefijo'] . str_replace(" ", "", $multiselect['label']);
                $controles[$cont_controles]['label'] = str_replace(" ", "", $multiselect['label']);
                $controles[$cont_controles]['longitud'] = $this->evaluaLongitud($multiselect);
                $controles[$cont_controles]['nullable'] = (isset($multiselect['nullable']) ? $multiselect['nullable'] : $information['multiSelect'][$key_multi]['nullable'] = 0);
                $information['multiSelect'][$key_multi]['nombre'] = $controles[$cont_controles]['nombre'];
                $cont_controles++;
            }
        }
        if (isset($information['checkbox'])) {
            foreach ($information['checkbox'] as $key_check => $checkbox) {
                $controles[$cont_controles]['tipo_dato'] = $checkbox['tipo_dato'];
                $controles[$cont_controles]['nombre'] = $information['prefijo'] . str_replace(" ", "", $checkbox['label']);
                $controles[$cont_controles]['label'] = str_replace(" ", "", $checkbox['label']);
                $controles[$cont_controles]['longitud'] = $this->evaluaLongitud($control);
                $controles[$cont_controles]['nullable'] = (isset($checkbox['nullable']) ? $checkbox['nullable'] : $information['checkbox'][$key_check]['nullable'] = 0);
                $information['checkbox'][$key_check]['nombre'] = $controles[$cont_controles]['nombre'];
                $cont_controles++;
            }
        }
        if (isset($information['radio'])) {
            foreach ($information['radio'] as $key_radio => $radio) {
                $controles[$cont_controles]['tipo_dato'] = $radio['tipo_dato'];
                $controles[$cont_controles]['nombre'] = $information['prefijo'] . str_replace(" ", "", $radio['label']);
                $controles[$cont_controles]['label'] = str_replace(" ", "", $radio['label']);
                $controles[$cont_controles]['longitud'] = $this->evaluaLongitud($radio);
                $controles[$cont_controles]['nullable'] = (isset($radio['nullable']) ? $radio['nullable'] : $information['radio'][$key_radio]['nullable'] = 0);
                $information['radio'][$key_radio]['nombre'] = $controles[$cont_controles]['nombre'];
                $cont_controles++;
            }
        }
        if (isset($information['textArea'])) {
            foreach ($information['textArea'] as $key_textarea => $textarea) {
                $controles[$cont_controles]['tipo_dato'] = $textarea['tipo_dato'];
                $controles[$cont_controles]['nombre'] = $information['prefijo'] . str_replace(" ", "", $textarea['label']);
                $controles[$cont_controles]['label'] = str_replace(" ", "", $textarea['label']);
                $controles[$cont_controles]['longitud'] = $this->evaluaLongitud($textarea);
                $controles[$cont_controles]['nullable'] = (isset($textarea['nullable']) ? $textarea['nullable'] : $information['textArea'][$key_textarea]['nullable'] = 0);
                $information['textArea'][$key_textarea]['nombre'] = $controles[$cont_controles]['nombre'];
                $cont_controles++;
            }
        }
        return $controles;
    }

    public function insertar($information) {
        $information['clase_nombre'] = strtolower(trim(str_replace(" ", "", $information['clase_nombre'])));
        $information['prefijo'] = substr($information['clase_nombre'], 0, 3) . "_";
        $information['controles'] = $this->getArrayControles($information);
        $information['primary_key'] = substr($information['clase_nombre'], 0, 3) . "_id";

        $this->creaTabla($information);
        $this->generaFormulario($information);
        $this->generaController($information);
        $this->generaModel($information);
        $this->generaEntity($information);
        $this->creaRoute($information);
        $this->insertaMenu($information);
    }

    private function insertaMenu($information) {
        $file = VIEW . "general/menu_default.php";
        $contents = file_get_contents($file);
        $datos = explode('<ul class="sidebar-menu">', $contents);
        $before = $datos[0] . PHP_EOL . '<ul class="sidebar-menu">';
        $after = $datos[1];
        $new_menu = '<li>
                    <a href="<?= base_url("admin-' . $information["clase_nombre"] . '") ?>">
                        <i class="fa fa-list"></i>
                        <span>' . ucfirst($information["clase_nombre"]) . '</span>
                    </a>
                </li>';
        $full = $before . $new_menu . $after;
        file_put_contents($file, $full);
    }

    private function creaTabla($information) {
        $query = 'CREATE TABLE IF NOT EXISTS ' . $information['clase_nombre'] . ' (
' . $information['primary_key'] . ' int(11) NOT NULL AUTO_INCREMENT, ' . $information["prefijo"] . 'activo BIT NULL DEFAULT 0,' . $information["prefijo"] . 'created_at datetime NOT NULL,' . $information["prefijo"] . 'modified_at datetime NULL,';

        foreach ($information['controles'] as $control) {
            $control['longitud'] = "(" . $control['longitud'] . ")";
            if ($control["tipo_dato"] == "datetime" || $control["tipo_dato"] == "double") {
                $control['longitud'] = "";
            } elseif (!$control["longitud"]) {
                $control['longitud'] = "(1)";
            }
            $query .= $control['nombre'] . ' ' . $control['tipo_dato'] . ' ' . $control['longitud'] . ' ' . (isset($control['nullable']) && $control["nullable"] ? "NULL" : "NOT NULL") . ', ';
        }

        $query .='PRIMARY KEY (' . $information['primary_key'] . ')
) ENGINE = InnoDB DEFAULT CHARSET = utf8';
        if (!$this->db->simple_query($query)) {
            echo 'Aca fallamos creando tabla' . $this->db->_error_message;
            echo $query;
            die;
        }
    }

    private function creaRoute($information) {
        $route_file = ROUTE_PATH;
        $ruta_nueva = '/* ' . $information['clase_nombre'] . ' rutas */' . PHP_EOL;
        $ruta_nueva .= '$route["admin-' . $information['clase_nombre'] . '"] = "' . MODULE . '/admin/' . ucfirst($information['clase_nombre']) . '_controller/index";' . PHP_EOL;
        $ruta_nueva .= '$route["admin-' . $information['clase_nombre'] . '/(:num)"] = "' . MODULE . '/admin/' . ucfirst($information['clase_nombre']) . '_controller/index/$1";' . PHP_EOL;
        $ruta_nueva .= '$route["admin-' . $information['clase_nombre'] . '/borrar/(:num)"] = "' . MODULE . '/admin/' . ucfirst($information['clase_nombre']) . '_controller/borrar/$1";' . PHP_EOL;
        $ruta_nueva .= '$route["get' . ucfirst($information['clase_nombre']) . 'Ajax"] = "' . MODULE . '/admin/' . ucfirst($information['clase_nombre']) . '_controller/get' . ucfirst($information['clase_nombre']) . 'Ajax";' . PHP_EOL;
        file_put_contents($route_file, $ruta_nueva, FILE_APPEND | LOCK_EX);
    }

    public function generaRadio($controles, $nombre_clase) {
        $response_html = "";
        foreach ($controles as $control) {
            $valores = explode(",", $control['values']);
            $checkbox = "";
            foreach ($valores as $k => $value) {
                $atributos = array(
                    "class" => "form-group",
                    "type" => "radio",
                    "value" => "$value",
                    "name" => $control['nombre']);
                $checkbox .= $this->createElement('input', $atributos, $value, "");
            }
            $label = $this->createElement('label', array(), $control['label'], "");
            $form_group = $this->createElement('div', array("class" => "form-group"), "", PHP_EOL . $label . PHP_EOL . $checkbox . PHP_EOL);
            $response_html .= $this->createElement('div', array("class" => "col-md-3"), "", PHP_EOL . $form_group . PHP_EOL);
        }
        return $response_html;
    }

    public function generaCheckbox($controles, $nombre_clase) {
        $response_html = "";
        foreach ($controles as $control) {
            $valores = explode(",", $control['values']);
            $checkbox = "";
            foreach ($valores as $k => $value) {
                $atributos = array(
                    "class" => "form-group",
                    "type" => "checkbox",
                    "value" => "$value",
                    "name" => $control['nombre']);
                $checkbox .= $this->createElement('input', $atributos, $value, "");
            }
            $label = $this->createElement('label', array(), $control['label'], "");
            $form_group = $this->createElement('div', array("class" => "form-group"), "", $label . $checkbox . PHP_EOL);
            $response_html .= $this->createElement('div', array("class" => "col-md-3"), "", $form_group . PHP_EOL);
        }
        return $response_html;
    }

    public function generatextArea($controles, $nombre_clase) {
        $response_html = "";
        foreach ($controles as $control) {
            $label = $this->createElement('label', array(), $control['label'], "");
            $atributos = array(
                "class" => "form-control",
                "name" => $control['nombre']);
            $textarea = $this->createElement('textarea', $atributos, '<?=(isset($' . $nombre_clase . ')?$' . $nombre_clase . '->get' . ucfirst($control['label']) . '():"")?>', "");
            $form_group = $this->createElement('div', array("class" => "form-group"), "", PHP_EOL . $label . PHP_EOL . $textarea . PHP_EOL);
            $response_html .= $this->createElement('div', array("class" => "col-md-3"), "", PHP_EOL . $form_group . PHP_EOL);
        }
        return $response_html;
    }

    public function generaMultiSelects($controles, $nombre_clase) {
        $response_html = "";
        foreach ($controles as $control) {
            $valores = explode(",", $control['values']);
            foreach ($valores as $k => $value) {
                if ($k == 0) {
                    $options = $this->createElement('option', array("selected" => "true", "value" => "$value"), $value, "");
                } else {
                    $options .=$this->createElement('option', array("value" => "$value"), $value, "");
                }
            }
            $label = $this->createElement('label', array(), $control['label'], "");
            $atributos = array(
                "class" => "form-control",
                "multiple" => "true",
                "name" => $control['nombre'] . "[]");
            $select = $this->createElement('select', $atributos, "", $options);
            $form_group = $this->createElement('div', array("class" => "form-group"), "", PHP_EOL . $label . PHP_EOL . $select . PHP_EOL);
            $response_html .= $this->createElement('div', array("class" => "col-md-3"), "", PHP_EOL . $form_group . PHP_EOL);
        }
        return $response_html;
    }

    public function generaSelects($controles, $nombre_clase) {
        $response_html = "";
        foreach ($controles as $control) {
            $valores = explode(",", $control['values']);
            foreach ($valores as $k => $value) {
                if ($k == 0) {
                    $options = $this->createElement('option', array("selected" => "true", "value" => "$value"), $value, "");
                } else {
                    $options .=$this->createElement('option', array("value" => "$value"), $value, "");
                }
            }
            $label = $this->createElement('label', array(), $control['label'], "");
            $atributos = array(
                "class" => "form-control",
                "name" => $control['nombre']);
            $select = $this->createElement('select', $atributos, "", $options);
            $form_group = $this->createElement('div', array("class" => "form-group"), "", PHP_EOL . $label . PHP_EOL . $select . PHP_EOL);
            $response_html .= $this->createElement('div', array("class" => "col-md-3"), "", PHP_EOL . $form_group . PHP_EOL);
        }
        return $response_html;
    }

    public function generaInputs($controles, $nombre_clase) {
        $response_html = "";
        foreach ($controles as $control) {
            $label = $this->createElement('label', array(), $control['label'], "");
            $atributos = array(
                "class" => "form-control",
                "type" => $control["tipo_dato"] != "datetime" ? "text" : "date",
                "value" => '<?=(isset($' . $nombre_clase . ')?$' . $nombre_clase . '->get' . ucfirst($control['label']) . '()' . $this->getFormatData($control,"Y-m-d") . ':"")?>',
                "name" => $control['nombre']);
            $input = $this->createElement('input', $atributos, "", "");
            $form_group = $this->createElement('div', array("class" => "form-group"), "", PHP_EOL . $label . PHP_EOL . $input . PHP_EOL);
            $response_html .= $this->createElement('div', array("class" => "col-md-3"), "", PHP_EOL . $form_group . PHP_EOL);
        }
        return $response_html;
    }

    public function createElement($tipo_elemento, $atributos = false, $valor_interno = "", $elemento_interno = "", $espacio = false) {
        $html = "<" . $tipo_elemento . " ";
        foreach ($atributos as $nombre_atributo => $atributo) {
            $html.= " " . $nombre_atributo . "='$atributo' ";
        }
        $html .= ">" . $valor_interno;
        $html .= $elemento_interno;
        $html .= '</' . $tipo_elemento . '>';

        return $html . PHP_EOL;
    }

}
