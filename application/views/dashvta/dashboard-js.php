<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script src="<?=base_url()?>assets/vendor/chart.js/Chart.min.js"></script>
<script>

$('#form-consulta').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    consultar();
    }
});

function consultar()
{
    var url;
    url = "<?php echo site_url('dashvta/resultados_datos')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form-consulta').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#resultados').html(data);
			$('#table-resultados').DataTable({
				keys: true,
				"scrollX": true,
				"columnDefs": [
					{ "visible": false, "targets": 0 }
				],
        		// "iDisplayLength": 5,
			});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function grafica() {
    var url;
    url = "<?php echo site_url('dashvta/resultados_grafica')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form-consulta').serialize(),
        dataType: "json",
        success: function(data)
        {
            setGrafica(data);
			setTotales(data.totales);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function setGrafica(data) {
	var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        datasets: [{
            label: 'Ventas',
            data: data.ventas, 
            type: 'line',
            borderColor: ['rgba(204,0,204,1)'],
            borderWidth: 2,
			fill: false,
        }, {
            label: 'Contado',
            data: data.contado, 
            type: 'line',
            borderColor: ['rgba(255,0,127,1)'],
            borderWidth: 2,
			fill: false,
        }, {
            label: 'Credito',
            data: data.credito, 
            type: 'line',
            borderColor: ['rgba(127,0,255,1)'],
            borderWidth: 2,
			fill: false,
        }, {
            label: 'Compras',
            data: data.compras, 
            type: 'line',
            borderColor: ['rgba(255,255,0,1)'],
            borderWidth: 2,
			fill: false,
        }, {
            label: 'Cobranza',
            data: data.cobranza, 
            type: 'line',
            borderColor: ['rgba(255,128,0,1)'],
            borderWidth: 2,
			fill: false,
        }
        ],
        labels: data.semanas
    },
    options: {
        // scales: {
        //     yAxes: [{
        //         ticks: {
        //             beginAtZero:true
        //         }
        //     }]
        // }
		elements: {
            line: {
                tension: 0, // disables bezier curves
            }
        }
    }
});
}

function setTotales(totales) {
	salida = '<table class="table table-sm"><tbody>';
	salida += '<tr><td>Ventas:</td><td class="text-right">'+totales.ventas+'</td></tr>';
	salida += '<tr><td>Contado:</td><td class="text-right">'+totales.contado+'</td></tr>';
	salida += '<tr><td>Credito:</td><td class="text-right">'+totales.credito+'</td></tr>';
	salida += '<tr><td>Compras:</td><td class="text-right">'+totales.compras+'</td></tr>';
	salida += '<tr><td>Cobranza:</td><td class="text-right">'+totales.cobranza+'</td></tr>';
	salida += "</tbody></table>";
	$("#totales").html(salida);
}

</script>
