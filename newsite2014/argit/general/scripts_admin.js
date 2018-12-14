var cont_select = 0;
var cont_checkbox = 0;
var cont_radio = 0;
var cont_multiSelect = 0;
var cont_text = 0;
var cont_textArea = 0;
var button = '<button type="button" class="test btn-primary btn-sm">borrar</button></div>';
function btn_tipo_control() {
    var tipo_control = $("#tipo_control").val();
    switch (tipo_control) {
        case "select":
            nuevoSelect();
            break;
        case "text":
            nuevoText();
            break;
        case "checkbox":
            nuevoCheckbox();
            break;
        case "radio":
            nuevoRadio();
            break;
        case "textArea":
            nuevoTextArea();
            break;
        case "multiSelect":
            nuevoMultiSelect();
            break;
    }
}

function nuevoSelect() {
    cont_select++;
    var htmlx = '<div class="row">';
    htmlx += '<div class="form-group col-md-1">';
    htmlx += '<label>Select ' + cont_select + '</label>';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-4">';
    htmlx += '<input type="text" name="select[' + cont_select + '][nombre]" placeholder="default value" class="form-control ">';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-4">';
    htmlx += '<input type="text" name="select[' + cont_select + '][values]" placeholder="roberto,pedro,etc" class="form-control ">';
    htmlx += '</div>';
    /*htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="select[' + cont_select + '][at_requerido]" value="1">Requerido';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="select[' + cont_select + '][at_observaciones]" value="1" class="">Observaciones';
     htmlx += '</div>';*/
    htmlx += button;
    $('#apto_medico').append(htmlx);
}

function nuevoRadio() {
    cont_radio++;
    var htmlx = '<div class="row">';
    htmlx += '<div class="form-group col-md-1">';
    htmlx += '<label>Radio ' + cont_radio + '</label>';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-4">';
    htmlx += '<input type="text" name="radio[' + cont_radio + '][nombre]" placeholder="¿Es programador?" class="form-control ">';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-4">';
    htmlx += '<input type="text" name="radio[' + cont_radio + '][values]" placeholder="si,no,etc" class="form-control ">';
    htmlx += '</div>';
    /* htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="radio[' + cont_radio + '][at_requerido]" value="1">Requerido';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="radio[' + cont_radio + '][at_observaciones]" value="1" class="">Observaciones';
     htmlx += '</div>';*/
    htmlx += button;
    $('#apto_medico').append(htmlx);
}

function nuevoCheckbox() {
    cont_checkbox++;
    var htmlx = '<div class="row">';
    htmlx += '<div class="form-group col-md-1">';
    htmlx += '<label>Checkbox ' + cont_checkbox + '</label>';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-4">';
    htmlx += '<input type="text" name="checkbox[' + cont_checkbox + '][nombre]" placeholder="¿Skills?" class="form-control ">';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-4">';
    htmlx += '<input type="text" name="checkbox[' + cont_checkbox + '][values]" placeholder="programador,analista,etc" class="form-control ">';
    htmlx += '</div>';
    /*htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="checkbox[' + cont_checkbox + '][at_requerido]" value="1" >Requerido';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="checkbox[' + cont_checkbox + '][at_observaciones]" value="1" class="">Observaciones';
     htmlx += '</div>';*/
    htmlx += button;
    $('#apto_medico').append(htmlx);
}

function nuevoMultiSelect() {
    cont_multiSelect++;
    var htmlx = '<div class="row">';
    htmlx += '<div class="form-group col-md-1">';
    htmlx += '<label>Multi Select ' + cont_multiSelect + '</label>';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-4">';
    htmlx += '<input type="text" name="multiSelect[' + cont_multiSelect + '][nombre]" placeholder="¿Skills?" class="form-control ">';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-4">';
    htmlx += '<input type="text" name="multiSelect[' + cont_multiSelect + '][values]" placeholder="programador,analista,etc" class="form-control ">';
    htmlx += '</div>';
    /*htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="multiSelect[' + cont_multiSelect + '][at_requerido]" value="1">Requerido';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="multiSelect[' + cont_multiSelect + '][at_observaciones]" value="1" class="">Observaciones';
     htmlx += '</div>';*/
    htmlx += button;
    $('#apto_medico').append(htmlx);
}

function nuevoText() {
    cont_text++;
    var htmlx = '<div class="row">';
    htmlx += '<div class="form-group col-md-1">';
    htmlx += '<label>Text ' + cont_text + '</label>';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-8">';
    htmlx += '<input type="text" name="text[' + cont_text + '][nombre]" placeholder="Placeholder del control" class="form-control ">';
    htmlx += '</div>';
    /*htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="text[' + cont_text + '][at_requerido]" value="1" >Requerido';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="text[' + cont_text + '][at_observaciones]" value="1" class="">Observaciones';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="text[' + cont_text + '][at_numerico]" value="1">Numerico';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="text" name="text[' + cont_text + '][at_min_len]" placeholder="min" class="form-control ">';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="text" name="text[' + cont_text + '][at_max_len]" placeholder="max" class="form-control ">';
     htmlx += '</div>';*/
    htmlx += button;
    $('#apto_medico').append(htmlx);
}

function nuevoTextArea() {
    cont_textArea++;
    var htmlx = '<div class="row">';
    htmlx += '<div class="form-group col-md-1">';
    htmlx += '<label>Text ' + cont_textArea + '</label>';
    htmlx += '</div>';
    htmlx += '<div class="form-group input-group col-md-8">';
    htmlx += '<input type="text" name="textArea[' + cont_textArea + '][nombre]" placeholder="Placeholder del control" class="form-control ">';
    htmlx += '</div>';
    /*htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="textArea[' + cont_textArea + '][at_requerido]" value="1" >Requerido';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="textArea[' + cont_textArea + '][at_observaciones]" value="1" class="">Observaciones';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="checkbox" name="textArea[' + cont_textArea + '][at_numerico]" value="1">Numerico';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="text" name="textArea[' + cont_textArea + '][at_min_len]" placeholder="min" class="form-control ">';
     htmlx += '</div>';
     htmlx += '<div class="form-group input-group col-md-1">';
     htmlx += '<input type="text" name="textArea[' + cont_textArea + '][at_max_len]" placeholder="max" class="form-control ">';
     htmlx += '</div>';*/
    htmlx += button;
    $('#apto_medico').append(htmlx);
}
