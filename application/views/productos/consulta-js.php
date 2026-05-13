<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script type="text/javascript">
var save_method; //for save method string
var table;
var indexRow = 0;

$(document).ready(function(){

table = $("#dtRegistros").DataTable({
        processing: true,
        serverSide: false,
        keys: true,
        "iDisplayLength": 5,
		stateSave: true,
		"language": {
			"url": "<?=base_url()?>assets/js/Spanish.json",
		},
        ajax: {
            "url": "<?=base_url()?>productos/dt_consulta",
            "type": "POST",
        },
        columns: [ 
            { data: "id" },
            { data: "clave_art" },
			{ data: "clave_prov" },
			{ data: "codigo_b" },
			{ data: "descrip" },
			{ data: "precio_venta" },
			{ data: "localizacion" },
            { data: "acciones", "orderable": false}
        ],
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
        "initComplete": function(settings, json) {
            $(table.row(0).node().cells[0]).focus().click();
            $('div.dataTables_filter input').focus();
        }
    });
    
    
    table
	.on( 'key', function ( e, datatable, key, cell, originalEvent ) {
			if (key === 13) {
				 //console.log(table.row(cell.index().row).node().cells[4].childNodes[0]);
				$(table.row(cell.index().row).node().cells[6].childNodes[0]).focus();
			} else if (key == 113) {
				$('div.dataTables_filter input', table.table().container()).focus();
			}
	} )
	.on( 'key-focus', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).addClass('bg-light');
			$(table.row(cell.index().row).node().cells[1].childNodes[0]).focus();
			indexRow=cell.index().row;
			var r = table.rows( cell.index().row ).data();
			// console.log( r[0] );
			$('#exis_id').text( r[0].existencias+'  '+r[0].localizacion );
  } )
  .on( 'key-blur', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).removeClass('bg-light');
	});

	$('#myModal').on('shown.bs.modal', function () {
    	$('div.dataTables_filter input', tabla.table().container()).focus();
	});
    

$('div.dataTables_filter input').focus();

});

function reload_table()
{
    table.ajax.reload(function(settings, json) {
            $(table.row(indexRow).node().cells[0]).focus().click();
            $('div.dataTables_filter input').focus();
        },false);
}

$("#modal_form_image").on("hidden.bs.modal", function () {
    // put your default event here
    $(table.row(indexRow).node().cells[0]).focus().click();
    $('div.dataTables_filter input').focus();
});

$("#modal_form").on("hidden.bs.modal", function () {
    // put your default event here
    $(table.row(indexRow).node().cells[0]).focus().click();
    $('div.dataTables_filter input').focus();
});

function image(id)
{
    save_method = 'update';
    $('#formimagen')[0].reset(); // reset form on modals


    //Ajax Load data from ajax
    $.ajax({
    url : "<?php echo site_url('productos/ajax_edit/')?>" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        var url_image = data.imagen;//get image name

        $('[name="id"]').val(data.id);
        $('[name="imageproducto"]').attr("src","<?=base_url()?>"+url_image+"?"+new Date().getTime());

        $('#modal_form_image').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ver/Editar Imagen'); // Set title to Bootstrap modal title

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    }
});
}

$('#formimagen').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    saveImage();
    }
});

//btnSaveImage
function saveImage() {
    //e.preventDefault();
    var file =$('input[type=file]')[0].files[0];

    if(file != undefined)
    {
      var formData = new FormData();
      formData.append("id", $('[name="id"]').val());
      //formData.append('imagen1', $('input[type=file]')[0].files[0]);
      formData.append('imagen1', file );
      $.ajax({
          url: "<?php echo site_url('productos/do_upload/')?>",
          type: "post",
          dataType: "json",
          data: formData,
          cache: false,
          contentType: false,
          processData: false
      }).done(function(res){

        $('#modal_form_image').modal('hide');
          if (res.status)
          {
              toastr.success(res.mensaje);
              $('[name="imagen1"]').prop('value', "");
          }
          else
          {
              toastr.error(res.mensaje);
          }
      });

    }//CLOSE IF  NULL
    $('#modal_form_image').modal('hide');
}
//End btnSaveImage


</script>
