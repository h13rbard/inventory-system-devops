<script>
	$(document).ready(function() {
		$('#example').DataTable( {
			processing: true,
			serverSide: true,
			ajax: {
				"url": "<?=base_url()?>ejemplo/dt_productos",
				"type": "POST",
			},
			columns: [
				{ data: "nombre" },
				{ data: "precio" },
				{ data: "stock" },
			],
			"pagingType": "simple"
		});

		// Stock alto
		fetch('<?=base_url()?>ejemplo/stock_alto')
		.then(function(response) {
			return response.json();
		})
		.then(function(myJson) {
			var txtStockAlto = '<table class="table table-striped table-sm">';
			txtStockAlto += '<tr><td>Nombre</td><td>Stock</td><td>Max</td></tr>';
			myJson.forEach(function(element) {
				txtStockAlto += '<tr><td>'+element.nombre+'</td><td>'+element.stock+'</td><td>'+element.max+'</td></tr>';
			});
			txtStockAlto += '<table>';
			txt = document.getElementById("stock-alto");
			txt.innerHTML = txtStockAlto;
		});

		// Stock bajo
		fetch('<?=base_url()?>ejemplo/stock_bajo')
		.then(function(response) {
			return response.json();
		})
		.then(function(myJson) {
			var txtStockBajo = '<table class="table table-striped table-sm">';
			txtStockBajo += '<tr><td>Nombre</td><td>Stock</td><td>Min</td></tr>';
			myJson.forEach(function(element) {
				txtStockBajo += '<tr><td>'+element.nombre+'</td><td>'+element.stock+'</td><td>'+element.min+'</td></tr>';
			});
			txtStockBajo += '<table>';
			txt = document.getElementById("stock-bajo");
			txt.innerHTML = txtStockBajo;
		});

		Highcharts.chart('chr-ventas', {

			chart: {
				type: 'line'
			},
			title: {
				text: 'Ventas Diciembre 2018',
			},
			xAxis: {
				categories: [<?=$productos?>]
			},
			legend: {
				layout: 'vertical',
				align: 'bottom',
				verticalAlign: 'middle'
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Ventas',
				data: [<?=$ventasMes?>]
			}
			],
			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							layout: 'horizontal',
							align: 'center',
							verticalAlign: 'bottom'
						}
					}
				}]
			}

		});

	});

</script>
