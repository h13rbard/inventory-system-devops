<link rel="stylesheet" href="<?=base_url()?>assets/select2/css/select2.min.css">
<style>.selection { display: inline; }</style>
<script src="<?=base_url()?>assets/select2/js/select2.min.js"></script>
<script>
$(document).ready(function(){
	$('#grupo').select2({
		width: 'resolve',
	});
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
	var url= "<?php echo site_url('grupo/ajax_asignar')?>";

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
                toastr.success(data.mensaje);
            }
            else
            {
                toastr.error(data.mensaje);
            }
			$('[name="clave"]').val('');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
}

</script>
