 //dispara dialogo de confirmar envia el formulario si se acepta
 $('#borrarMarca').on('click', function (e) {
        var $form = $("#form2");
        e.preventDefault();
        $('#myModal').modal().one('click', '#delete', function (e) {
            $form.submit();
        });
    });


