$(document).ready(function() {

	$(".validate").validate();
	$(".validate_1").validate();
	$(".validate_2").validate();
	$(".validate_3").validate();
	$(".validate_4").validate();


	$.validator.addMethod(
	    "validatePhone", //name of a virtual validator
	    $.validator.methods.digits, //use the actual email validator
	    "Cep telefonu hatalı"
	);

	jQuery('.digitsOnly').keyup(function () {
	    this.value = this.value.replace(/[^0-9]/g,'');
	});
	jQuery('.numbersOnly').keyup(function () {
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	});

	/* tooltip */
	$('[data-toggle="tooltip"]').tooltip();



    $('.dataTable').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     false
    });



});
