<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/select2/css/select2.min.css">
<style>.selection { display: inline; }</style>
<script src="<?=base_url()?>assets/select2/js/select2.min.js"></script>
<script>
$(document).ready(function(){
	$('#grupo').select2({
		width: 'resolve',
	});
});

// $('#reporte').submit(function (e) {
// 	console.log(e);
//     if (e.isDefaultPrevented()) {
//     // handle the invalid form...
//     } else {
//     e.preventDefault();
//     consulta();
//     }
// });

$('#todos').click(function (e){
	e.preventDefault();
	consulta(1);
});

$('#existencia').click(function (e){
	e.preventDefault();
	consulta(2);
});

function consulta(tipo)
{
    var url;
    url = "<?php echo site_url('grupo/ajax_consulta')?>/"+tipo;

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
