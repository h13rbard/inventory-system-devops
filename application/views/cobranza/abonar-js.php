<script>
$('.abono').keyup(function(event){
	var abono = parseFloat( event.target.value);
	// var total_resta = parseFloat( $('#total_esta').val());
	// var total_abono = parseFloat( $('#total_abono').val());
	// $('#cambio_doc').val(total_pago - total);
	// console.log(event);
	// console.log(event.target());
	// console.log(event.target);
	// console.log(total_resta-abono);

	var suma_abonos=0;
	$(".abono").each(function(e) {
		// console.log(e);
		suma_abonos += parseFloat( $('.abono')[e].value);
	});

	console.log(total_resta);
	console.log(total_resta-suma_abonos);

	$("#total_abonos").text(suma_abonos);
	$("#total_resta").text(total_resta-suma_abonos);

});
</script>
