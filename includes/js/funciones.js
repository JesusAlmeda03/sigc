/* -----------------------------------------------
	http://scalidad.ujed.mx
	Descripci�n: Funciones de validaci�n
	Ultima actualizaci�n:  25/Agosto/2010
	Autor: ISC Rogelio Casta�eda Andrade
		SWIT (http://www.swit.com.mx)
----------------------------------------------- */

var _item;
var inicio = 30;
var tmp;

/*
* Genera una contrase�a aleatoria
*/
function genera_pass( caja ) {
	var chars = "abc";
	var string_length = 3;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	
	document.getElementById( caja ).type = 'text';
	
	document.getElementById( caja ).value = randomstring;
}

/*
* Cierra le mensaje de error
*/
function cierra_msj() {
	document.getElementById('msj_box_cont').style.display = 'none';
}

/*
* Acepta el formulario con un enter
*/
function onEnter( ev ) {  
	if( ev == 13 ) { 
		valida_cajas( cajas, 'log_in' ); 
		return true;
	} 
 }
		 
/*
* desactiva la caja de mensajes tras transcurrir un tiempo ( 3 seg )
*/
function contar() {
	inicio--;
	if (inicio==0) {
		clearInterval(tmp);
		document.getElementById('msj_box_cont').style.display = 'none';
	}
}

/*
* colorea el contorno de los elementos
*/
function hover( i ) {
	document.getElementById( i ).style.border = '1px solid #CC0000';
}