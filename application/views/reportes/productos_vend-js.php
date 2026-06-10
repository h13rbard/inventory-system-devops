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
    url = "<?php echo site_url('reportes/ajax_productos_vend')?>";

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
