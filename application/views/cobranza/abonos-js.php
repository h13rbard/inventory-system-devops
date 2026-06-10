<script>

$(function() {
    consulta();
});

$('#form').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    save();
    }
});

function save()
{
	var url;
    url = "<?php echo site_url('cobranza/ajax_add')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if (data.status)
            {      
				$('#form')[0].reset();        
                toastr.success(data.mensaje);
				consulta();
            }
            else
            {
                toastr.error(data.mensaje);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
}

function consulta()
{
    var url;
    url = "<?php echo site_url('cobranza/movimientos/').$venta_id?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "GET",
        // data: $('#reporte').serialize(),
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
