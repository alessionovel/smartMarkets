const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});


$(document).ready(function() {
	$('#login').on('submit', function(e) {
		$("#login-check").html("");
		e.preventDefault();
		var email = document.getElementById("email").value;
		var password = document.getElementById("password").value;
		$.ajax({
			url: 'webServices/checkLogin.php',
			type: "POST",
			data: {
				email: email,
				password: password
			},
			success: function(data) {
				var risultato = JSON.parse(data);
				if (risultato.risultato != 0) {
					$("#login-check").html("Credenziali errate");
					console.log(risultato.messaggio);
				} else {
					location.reload();
				}
			},
			error: function(jXHR, textStatus, errorThrown) {
				alert(errorThrown + "banana 2");
			}
		});
	});

	$('#registrazione').on('submit', function(e2) {
		e2.preventDefault();
		$("#registrazione-check").html("");
		var email = document.getElementById("emailReg").value;
		var password = document.getElementById("passwordReg").value;
		var nome = document.getElementById("nome").value;
		var cognome = document.getElementById("cognome").value;
		if(nome=="" || password=="" || email=="" || cognome==""){
			$("#registrazione-check").html("Inserisci tutti i dati");
		}else{
			$.ajax({
				url: 'webServices/checkRegistrazione.php',
				type: "POST",
				data: {
					email: email,
					password: password,
					nome: nome,
					cognome: cognome
				},
				success: function(data) {
					var risultato = JSON.parse(data);
					if (risultato.risultato != 0) {
						$("#registrazione-check").html(risultato.messaggio);
					} else {
						$("#registrazione-check").html("Registrazione effettuata");
					}
					console.log(risultato.messaggio);
				},
				error: function(jXHR, textStatus, errorThrown) {
					alert(errorThrown + "banana 2");
				}
			});
		}
	});
});

function easterEgg(){
	$("#easterEgg").html("Potevi salvartela da qualche parte");
}
