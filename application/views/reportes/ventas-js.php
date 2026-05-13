<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
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
    url = "<?php echo site_url('reportes/ajax_ventas')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#reporte').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#resultado').html(data);
			$('#example').DataTable({
				keys: true,
        		"iDisplayLength": 5,
			});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

</script>
