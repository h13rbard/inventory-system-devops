<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/js/buttons.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script src="<?=base_url()?>assets/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/js/jszip.min.js"></script>
<script src="<?=base_url()?>assets/js/buttons.html5.min.js"></script> 
<script type="text/javascript">
var save_method; //for save method string
var table;
var indexRow = 0;

$(document).ready(function(){

	// $('#dtRegistros tfoot th').each( function () {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    // } );

table = $("#dtRegistros").DataTable({
        processing: true,
        serverSide: false,
        keys: true,
        "iDisplayLength": 5,
		stateSave: true,
		scrollX: true,
		dom: 'Bfrtip',
        buttons: [{ extend: 'excelHtml5',text:  '<span class="font-weight-bold text-success">Exportar</span>',exportOptions: { columns: ':visible'} }],
		"language": {
			"url": "<?=base_url()?>assets/js/Spanish.json",
		},
        ajax: {
            "url": "<?=base_url()?>productos/datatable",
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
			$('#exis_id').text( r[0].existencias+'  '+r[0].localizacion );
			$('#pvta_id').text( "$ "+ parseFloat(r[0].precio_venta).toFixed(2) );
  } )
  .on( 'key-blur', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).removeClass('bg-light');
	});

	$('#myModal').on('shown.bs.modal', function () {
    	$('div.dataTables_filter input', tabla.table().container()).focus();
	});
    

$('div.dataTables_filter input').focus();

// Apply the search
// table.columns().every( function () {
//         var that = this;
 
//         $( 'input', this.footer() ).on( 'keyup change clear', function () {
//             if ( that.search() !== this.value ) {
//                 that
//                     .search( this.value )
//                     .draw();
//             }
//         } );
//     } );

$('#form-prod').hide();

});

$('#form').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    save();
    }
});

function add()
{
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#form-prod').show(300); 
	$('#lista-prod').hide();
    $('.modal-title').text('Agregar'); 
	$( "#clave_art" ).prop( "readonly", false );
	$("#consultas").hide();
	$("#pnlbaja").hide();
}

function edit(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
	$( "#clave_art" ).prop( "readonly", true );
	$("#consultas").show();
	$("#pnlbaja").show();

    //Ajax Load data from ajax
    $.ajax({
    url : "<?php echo site_url('productos/ajax_edit/')?>" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        $('[name="id"]').val(data.id);
        $('[name="clave_art"]').val(data.clave_art);
		$('[name="clave_prov"]').val(data.clave_prov);
		$('[name="marca"]').val(data.marca);
		$('[name="descrip"]').val(data.descrip);
		$('[name="localizacion"]').val(data.localizacion);
		$('[name="unidad"]').val(data.unidad);
		$('[name="codigo_b"]').val(data.codigo_b);
		$('[name="existencias"]').val(data.existencias);
		$('[name="precio_venta_aux"]').val(data.precio_venta_aux);
		$('[name="precio_venta"]').val(data.precio_venta);
		$('[name="precio_compra"]').val(data.precio_compra);
		$('[name="precio_uni"]').val(data.precio_uni);
		$('[name="minimo"]').val(data.minimo);
		$('[name="proveedor_id"]').val(data.proveedor_id);
		$('[name="actualiza"]').val(data.actualiza);
		$('[name="act_pre"]').val(data.act_pre);
		$('[name="url"]').val(data.url);
		$('[name="baja"]').val(data.baja);

        $('#form-prod').show(300); // show bootstrap modal when complete loaded
        $('.modal-title').text('Editar'); // Set title to Bootstrap modal title
		$('#lista-prod').hide();

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    }
});
}

function reload_table()
{
    table.ajax.reload(function(settings, json) {
            $(table.row(indexRow).node().cells[0]).focus().click();
            $('div.dataTables_filter input').focus();
        },false);
    //$('div.dataTables_filter input').focus();
    //$(table.row(indexRow).node().cells[0]).focus().click();
    //$('div.dataTables_filter input').focus();
}

$("#modal_form_image").on("hidden.bs.modal", function () {
    // put your default event here
    $(table.row(indexRow).node().cells[0]).focus().click();
    $('div.dataTables_filter input').focus();
});

function cancelar() {
	$('#form-prod').hide();
	$('#lista-prod').show();
	$(table.row(indexRow).node().cells[0]).focus().click();
    $('div.dataTables_filter input').focus();
}

function save()
{
    var url;
    if(save_method == 'add')
    {
    url = "<?php echo site_url('productos/ajax_add')?>";
    }
    else
    {
    url = "<?php echo site_url('productos/ajax_update')?>";
    }

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
                //if success close modal and reload ajax table
                $('#form-prod').hide();
				$('#lista-prod').show();
                reload_table();
                toastr.success(data.mensaje);
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

function visitarPag() {
	var win = window.open($('[name="url"]').val(), '_blank');
  	win.focus();
}

function ventas() {
	var win = window.open("reportes/vtas_x_prod/"+$('[name="id"]').val(), '_blank');
  	win.focus();
}

function compras() {
	var win = window.open("reportes/compras_x_prod/"+$('[name="id"]').val(), '_blank');
  	win.focus();
}

function kardex() {
	var win = window.open("movsinv/kardex/"+$('[name="id"]').val(), '_blank');
  	win.focus();
}

function image2() {
	image($('[name="id"]').val());
}

</script>
