<script>
    function createElement(tipo_elemento, atributos, valor) {
        var tiene_valor = (valor) ? valor : "";
        var elemento = $('<' + tipo_elemento + '></' + tipo_elemento + '>').attr(atributos);
        if (elemento.value !== undefined) {
            elemento.val(tiene_valor);
        } else {
            elemento.text(tiene_valor);
        }
        return elemento;
    }

    $(document).ready(function () {
        $(".row").on("click", "button.btn_borrar", function () {
            $(this).closest('div').parent('div.row').remove();
        });
    });
    var controles_actuales = 0;
    var cont_select = controles_actuales;
    var cont_checkbox = controles_actuales;
    var cont_radio = controles_actuales;
    var cont_multiSelect = controles_actuales;
    var cont_text = controles_actuales;
    var cont_textArea = controles_actuales;


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
        return;
    }



    function nuevoSelect() {
        var button = $(createElement('div', {class: 'col-md-2'})).append(createElement('button', {type: 'button', class: 'btn_borrar btn-primary btn-sm pull-right'}, 'borrar'));
        cont_select++;
        var div_contenedor = createElement('div', {class: 'row'});
        var div_label = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'label del select', type: 'text', name: 'select[' + cont_select + '][label]', class: 'form-control'})));
        var div_nombre = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'longitud campo', type: 'text', name: 'select[' + cont_select + '][longitud]', class: 'form-control'})));
        var div_value = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'valor1,valor2,etc', type: 'text', name: 'select[' + cont_select + '][values]', class: 'form-control'})));


        var div_tipo_dato = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('select', {name: 'select[' + cont_select + '][tipo_dato]', class: 'form-control'}))
                        .append($(createElement('option', {value: 'int'}, 'int')))
                        .append($(createElement('option', {value: 'bit'}, 'bit')))
                        .append($(createElement('option', {value: 'varchar'}, 'varchar')))
                        .append($(createElement('option', {value: 'text'}, 'text')))
                        .append($(createElement('option', {value: 'double'}, 'double')))
                        .append($(createElement('option', {value: 'datetime'}, 'datetime')))
                        .append($(createElement('option', {value: 'bigint'}, 'bigint'))));


        var div_nullable = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {name: 'select[' + cont_select + '][nullable]', value: '1', type: 'checkbox'})));
        $('#form_dinamico').append($(div_contenedor).append($(div_label)).append($(div_nombre)).append($(div_value)).append($(div_tipo_dato)).append($(div_nullable)).append($(button)));
    }

    function nuevoRadio() {
        var button = $(createElement('div', {class: 'col-md-2'})).append(createElement('button', {type: 'button', class: 'btn_borrar btn-primary btn-sm pull-right'}, 'borrar'));
        cont_radio++;
        var div_contenedor = createElement('div', {class: 'row'});
        var div_label = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'label del check', type: 'text', name: 'radio[' + cont_radio + '][label]', class: 'form-control'})));
        var div_nombre = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'longitud del campo', type: 'text', name: 'radio[' + cont_radio + '][longitud]', class: 'form-control'})));
        var div_value = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'si,no', type: 'text', name: 'radio[' + cont_radio + '][values]', class: 'form-control'})));
        var div_tipo_dato = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('select', {name: 'radio[' + cont_radio + '][tipo_dato]', class: 'form-control'}))
                        .append($(createElement('option', {value: 'int'}, 'int')))
                        .append($(createElement('option', {value: 'bit'}, 'bit')))
                        .append($(createElement('option', {value: 'varchar'}, 'varchar')))
                        .append($(createElement('option', {value: 'text'}, 'text')))
                        .append($(createElement('option', {value: 'double'}, 'double')))
                        .append($(createElement('option', {value: 'datetime'}, 'datetime')))
                        .append($(createElement('option', {value: 'bigint'}, 'bigint'))));

        var div_nullable = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {name: 'radio[' + cont_radio + '][nullable]', value: '1', type: 'checkbox'})));
        $('#form_dinamico').append($(div_contenedor).append($(div_label)).append($(div_nombre)).append($(div_value)).append($(div_tipo_dato)).append($(div_nullable)).append($(button)));
    }

    function nuevoCheckbox() {
        var button = $(createElement('div', {class: 'col-md-2'})).append(createElement('button', {type: 'button', class: 'btn_borrar btn-primary btn-sm pull-right'}, 'borrar'));
        cont_checkbox++;
        var div_contenedor = createElement('div', {class: 'row'});
        var div_label = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'label del check', type: 'text', name: 'checkbox[' + cont_checkbox + '][label]', class: 'form-control'})));
        var div_nombre = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'longitud del campo', type: 'text', name: 'checkbox[' + cont_checkbox + '][longitud]', class: 'form-control'})));
        var div_value = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'programador,tecnico,maquetero', type: 'text', name: 'checkbox[' + cont_checkbox + '][values]', class: 'form-control'})));

        var div_tipo_dato = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('select', {name: 'checkbox[' + cont_checkbox + '][tipo_dato]', class: 'form-control'}))
                        .append($(createElement('option', {value: 'int'}, 'int')))
                        .append($(createElement('option', {value: 'bit'}, 'bit')))
                        .append($(createElement('option', {value: 'varchar'}, 'varchar')))
                        .append($(createElement('option', {value: 'text'}, 'text')))
                        .append($(createElement('option', {value: 'double'}, 'double')))
                        .append($(createElement('option', {value: 'datetime'}, 'datetime')))
                        .append($(createElement('option', {value: 'bigint'}, 'bigint'))));

        var div_nullable = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {name: 'checkbox[' + cont_checkbox + '][nullable]', value: '1', type: 'checkbox'})));
        $('#form_dinamico').append($(div_contenedor).append($(div_label)).append($(div_nombre)).append($(div_value)).append($(div_tipo_dato)).append($(div_nullable)).append($(button)));
    }

    function nuevoMultiSelect() {
        var button = $(createElement('div', {class: 'col-md-2'})).append(createElement('button', {type: 'button', class: 'btn_borrar btn-primary btn-sm pull-right'}, 'borrar'));
        cont_multiSelect++;
        var div_contenedor = createElement('div', {class: 'row'});
        var div_label = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'label del multiselect', type: 'text', name: 'multiSelect[' + cont_multiSelect + '][label]', class: 'form-control'})));
        var div_nombre = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'longitud del campo', type: 'text', name: 'multiSelect[' + cont_multiSelect + '][longitud]', class: 'form-control'})));
        var div_value = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'valor1,valor2,etc', type: 'text', name: 'multiSelect[' + cont_multiSelect + '][values]', class: 'form-control'})));


        var div_tipo_dato = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('select', {name: 'multiSelect[' + cont_multiSelect + '][tipo_dato]', class: 'form-control'}))
                        .append($(createElement('option', {value: 'int'}, 'int')))
                        .append($(createElement('option', {value: 'bit'}, 'bit')))
                        .append($(createElement('option', {value: 'varchar'}, 'varchar')))
                        .append($(createElement('option', {value: 'text'}, 'text')))
                        .append($(createElement('option', {value: 'double'}, 'double')))
                        .append($(createElement('option', {value: 'datetime'}, 'datetime')))
                        .append($(createElement('option', {value: 'bigint'}, 'bigint'))));

        var div_nullable = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {name: 'multiSelect[' + cont_multiSelect + '][nullable]', value: '1', type: 'checkbox'})));
        $('#form_dinamico').append($(div_contenedor).append($(div_label)).append($(div_nombre)).append($(div_value)).append($(div_tipo_dato)).append($(div_nullable)).append($(button)));
    }

    function nuevoText() {
        var button = $(createElement('div', {class: 'col-md-2'})).append(createElement('button', {type: 'button', class: 'btn_borrar btn-primary btn-sm pull-right'}, 'borrar'));
        cont_text++;
        var div_contenedor = createElement('div', {class: 'row'});
        var div_nombre = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'longitud del campo', type: 'text', name: 'text[' + cont_text + '][longitud]', class: 'form-control'})));
        var div_placeholder = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'placeholder del control', type: 'text', name: 'text[' + cont_text + '][placeholder]', class: 'form-control'})));
        var div_label = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {placeholder: 'label del control', type: 'text', name: 'text[' + cont_text + '][label]', class: 'form-control'})));
        var div_tipo_dato = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('select', {name: 'text[' + cont_text + '][tipo_dato]', class: 'form-control'}))
                        .append($(createElement('option', {value: 'int'}, 'int')))
                        .append($(createElement('option', {value: 'bit'}, 'bit')))
                        .append($(createElement('option', {value: 'varchar'}, 'varchar')))
                        .append($(createElement('option', {value: 'text'}, 'text')))
                        .append($(createElement('option', {value: 'double'}, 'double')))
                        .append($(createElement('option', {value: 'datetime'}, 'datetime')))
                        .append($(createElement('option', {value: 'bigint'}, 'bigint'))));

        var div_nullable = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {name: 'text[' + cont_text + '][nullable]', value: '1', type: 'checkbox'})));
        $('#form_dinamico').append($(div_contenedor).append($(div_label)).append($(div_nombre)).append($(div_tipo_dato)).append($(div_nullable)).append($(button)));
    }

    function nuevoTextArea() {
        var button = $(createElement('div', {class: 'col-md-2'})).append(createElement('button', {type: 'button', class: 'btn_borrar btn-primary btn-sm pull-right'}, 'borrar'));
        cont_textArea++;
        var div_contenedor = createElement('div', {class: 'row'});
        var div_nombre = $(createElement('div', {class: 'col-md-2'}))
                .append($(createElement('input', {placeholder: 'longitud del campo', type: 'text', name: 'textArea[' + cont_textArea + '][longitud]', class: 'form-control'})));
        var div_placeholder = $(createElement('div', {class: 'col-md-2'}))
                .append($(createElement('input', {placeholder: 'placeholder del textarea', type: 'text', name: 'textArea[' + cont_textArea + '][placeholder]', class: 'form-control'})));
        var div_label = $(createElement('div', {class: 'col-md-2'}))
                .append($(createElement('input', {placeholder: 'label del textarea', type: 'text', name: 'textArea[' + cont_textArea + '][label]', class: 'form-control'})));

        var div_tipo_dato = $(createElement('div', {class: 'col-md-2'}))
                .append($(createElement('select', {name: 'textArea[' + cont_textArea + '][tipo_dato]', class: 'form-control'}))
                        .append($(createElement('option', {value: 'int'}, 'int')))
                        .append($(createElement('option', {value: 'bit'}, 'bit')))
                        .append($(createElement('option', {value: 'varchar'}, 'varchar')))
                        .append($(createElement('option', {value: 'text'}, 'text')))
                        .append($(createElement('option', {value: 'double'}, 'double')))
                        .append($(createElement('option', {value: 'datetime'}, 'datetime')))
                        .append($(createElement('option', {value: 'bigint'}, 'bigint'))));



        var div_nullable = $(createElement('div', {class: 'col-xs-6 col-md-2'}))
                .append($(createElement('input', {name: 'textArea[' + cont_textArea + '][nullable]', value: '1', type: 'checkbox'})));
        $('#form_dinamico').append($(div_contenedor).append($(div_label)).append($(div_nombre)).append($(div_tipo_dato)).append($(div_nullable)).append($(button)));
    }

</script>