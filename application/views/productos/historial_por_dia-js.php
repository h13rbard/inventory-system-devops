<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/select2/css/select2.min.css">
<style>.selection { display: inline; }</style>
<script src="<?=base_url()?>assets/select2/js/select2.min.js"></script>
<script>
$(document).ready(function(){

});

$('#consultar').click(function (e){
	e.preventDefault();
	consulta();
});

function consulta()
{
    var url;
    url = "<?php echo site_url('historialproductos/ajax_por_dia')?>";

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
				"language": {
					"url": "<?=base_url()?>assets/js/Spanish.json",
				},
			});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

</script>
