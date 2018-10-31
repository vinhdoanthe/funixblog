$(document).ready(function(){

		

	//global vars

	var form = $("#form");

	var name = $("#fName");

	var nameInfo = $("#fnameInfo");

	var email = $("#email");

	var emailInfo = $("#emailInfo");

	var conEmail = $("#conEmail");

	var conEmailInfo = $("#email2Info");

	

	//On blur

	name.blur(validateName);

	email.blur(validateEmail);

	conEmail.blur(validateEmail2);

	//On key press

	name.keyup(validateName);

	email.keyup(validateEmail);

	conEmail.keyup(validateEmail2);

	

	//On Submitting

	$("#submit").click(function(){

		form.submit(function(){

			if(validateName() & validateEmail() & validateEmail2())

				return true

			else

				return false;

		});

	});

	//validation functions

	function validateEmail(){

		//testing regular expression

		var a = $("#email").val();

		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

		//if it's valid email

		if(filter.test(a)){

			email.removeClass("error");

			emailInfo.text("");

			emailInfo.removeClass("error");

			validateEmail2();

			return true;

		}

		//if it's NOT valid

		else{

			email.addClass("error");

			emailInfo.text("Type a valid e-mail please");

			emailInfo.addClass("error");

			return false;

		}

	}

	function validateName(){

		//if it's NOT valid

		if(name.val().length < 4){

			name.addClass("error");

			nameInfo.text("We want names with more than 3 letters!");

			nameInfo.addClass("error");

			return false;

		}

		//if it's valid

		else{

			name.removeClass("error");

			nameInfo.text("");

			nameInfo.removeClass("error");

			return true;

		}

	}



	function validateEmail2(){



		//are NOT valid

		if( email.val() != conEmail.val() ){

			conEmail.addClass("error");

			conEmailInfo.text("Email doesn't match!");

			conEmailInfo.addClass("error");

			return false;

		}

		//are valid

		else{

			conEmail.removeClass("error");

			conEmailInfo.text("");

			conEmailInfo.removeClass("error");

			return true;

		}

	}



	var x,id;

	//Examples of how to assign the ColorBox event to elements

    	$("a.inline").removeAttr("href");

 	$("a.inline").attr("href", "#inline_content");



	$(".inline").colorbox({

		onOpen:function(){

			id = this.id; 

			x = ".group#voucher"+id;

			$(x).css("display", "block");

		},

		inline:true, width:"600", 

		onClosed:function(){

			$(x).css("display", "none"); 

			location.reload(true);

		},

	});

	

	$("#submit").click(function(){

	//e.preventDefault();

	

	if(validateName() & validateEmail() & validateEmail2()){

		

		var dataString = $("#form").serialize() + "&id="+id;

	 

var host = window.location.host;

		var url = "http://"+ host +"/wp-content/plugins/discount-vouchers/sendmail.php";



		$.ajax({

			async: false, cache: false, dataType: "json", type: "POST",

			url: url,

			data: dataString,

			success: function(data) {

			 $("#form").html("<div class='sucessMessage'><img src='/img/dv-2.jpg' width='500' height='298'></div>");

			},

			error: function () {

				$("#form").html("<div class='errorMessage'>Error sending mail</div>");

			}

		});

		return false;

		} else {

		return false;

		}

	});

});