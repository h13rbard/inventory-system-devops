<script>

// $('#reporte').submit(function (e) {
//     if (e.isDefaultPrevented()) {
//     // handle the invalid form...
//     } else {
//     e.preventDefault();
//     consulta();
//     }
// });

$('#previsualizar').click(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    previsualizar();
    }
});

$('#actualizar').click(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    actualizar();
    }
});

function previsualizar()
{
    var url;
    url = "<?php echo site_url('productos/ajax_actualiza_precios')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#reporte').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#resultado').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function actualizar()
{
    var url;
    url = "<?php echo site_url('productos/ajax_actualizar_precios')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#reporte').serialize(),
        dataType: "json",
        success: function(data)
        {
            toastr.success(data.mensaje);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

</script>
