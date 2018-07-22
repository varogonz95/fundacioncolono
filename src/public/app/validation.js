
app.directive('letrasNumeros', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.letrasNumeros = function(modelValue, viewValue) {
				if (viewValue) {

		        	return /[0-9a-záéóúàèìòùäëïöüñ,;. ]+$/i.test( viewValue.trim() );
		        
		        }
		 
		      	return true;
		 
		      	};
	    }
	};
});

app.directive('letras', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.letras = function(modelValue, viewValue) {
	 			if (viewValue) {

		 			return /[a-záéóúàèìòùäëïöüñ ]+$/i.test( viewValue.trim() );

		        }
		 
		      	return true;
		 
		      	};
	    }
	};
});

app.directive('numeros', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.numeros = function(modelValue, viewValue) {
	 
		        if (viewValue) {
		        	
		        	return /[0-9 ]+$/.test( viewValue.trim() );

		        }
		 
		      	return true;
		 
		      	};
	    }
	};
});

app.directive('correo', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.correo = function(modelValue, viewValue) {
	 
		        if (viewValue) {
		        	
		        	return /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i.test( viewValue.trim() );

		        }
		 
		      	return true;
		 
		      	};
	    }
	};
});

app.directive('fecha', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.fecha = function(modelValue, viewValue) {
	 
		        if (viewValue) {
		        	
		        	return /^(?:3[01]|[12][0-9]|0?[1-9])([\-/.])(0?[1-9]|1[1-2])\1\d{4}$/.test( viewValue.trim() );

		        }
		 
		      	return true;
	 
	      	};
	    }
	};
});

app.directive('url', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.url = function(modelValue, viewValue) {
	 
		        if (viewValue) {
		        	
		        	return /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/i.test( viewValue.trim() );

		        }
		 
		      	return true;
	 
	      	};
	    }
	};
});

app.directive('usuario', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.usuario = function(modelValue, viewValue) {
	 
		        if (viewValue) {
		        	
		        	return /^[a-z0-9_-]{3,16}$/i.test( viewValue.trim() );

		        }
		 
		      	return true;
	 
	      	};
	    }
	};
});

app.directive('contrasena', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.contrasena = function(modelValue, viewValue) {
	 
		        if (viewValue) {
		        	
		        	return /^[a-z0-9_-]{3,16}$/i.test( viewValue.trim() );

		        }
		 
		      	return true;
	 
	      	};
	    }
	};
});


app.directive('cedula', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.cedula = function(modelValue, viewValue) {
	 
		        if (viewValue) {
		        	
		        	return /^[1-9]0\d{3}0\d{3}$/.test( viewValue.trim() );

		        }
		 
		      	return true;
	 
	      	};
	    }
	};
});


app.directive('telefonos', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, elm, attrs, ctrl) {
	      	ctrl.$validators.telefonos = function(modelValue, viewValue) {
	 
		        if (viewValue) {
		        	
		        	return /[0-9, ]+$/.test( viewValue.trim() );

		        }
		 
		      	return true;
		 
		      	};
	    }
	};
	
});