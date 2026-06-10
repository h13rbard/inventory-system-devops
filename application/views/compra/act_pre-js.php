<script>

$('#reporte').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    consulta();
    }
});

function consulta()
{
    var url;
    url = "<?php echo site_url('compra/actualizar_precios_compra')?>";

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

</script>
