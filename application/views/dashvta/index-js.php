<link rel="stylesheet" href="https://cdn.datatables.net/keytable/2.5.1/css/keyTable.dataTables.min.css">
<script src="https://cdn.datatables.net/keytable/2.5.1/js/dataTables.keyTable.min.js"></script>
<script>

function grupos()
{
    var url;
    url = "<?php echo site_url('dashvta/ajax_grupos')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: {inicio: $('[name="inicio"]').val(), fin: $('[name="fin"]').val()},
        dataType: "HTML",
        success: function(data)
        {
            $('#res-grupos').html(data);
			$('#table-grupos').DataTable({
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

function clientes()
{
    var url;
    url = "<?php echo site_url('dashvta/ajax_clientes')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: {inicio: $('[name="inicio"]').val(), fin: $('[name="fin"]').val()},
        dataType: "HTML",
        success: function(data)
        {
            $('#res-clientes').html(data);
			$('#table-clientes').DataTable({
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

function formaPago()
{
    var url;
    url = "<?php echo site_url('dashvta/ajax_formapago')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: {inicio: $('[name="inicio"]').val(), fin: $('[name="fin"]').val()},
        dataType: "HTML",
        success: function(data)
        {
            $('#res-formapago').html(data);
			$('#table-formapago').DataTable({
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

function productos()
{
    var url;
    url = "<?php echo site_url('dashvta/ajax_productos')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: {inicio: $('[name="inicio"]').val(), fin: $('[name="fin"]').val()},
        dataType: "HTML",
        success: function(data)
        {
            $('#res-productos').html(data);
			$('#table-productos').DataTable({
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
