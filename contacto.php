
debug de código on vic2123nat.php.
ini_set('display_errors', 'On');//DEBUG DE CODIGO  PONER EN On
mb_internal_encoding("UTF-8");//--codificacion para que acepte tildes y eñes--//
date_default_timezone_set('America/Lima');//--hora de servidor para los registros--//
function died($error) {//--funcion de error
	echo 'Lo sentimos, hubo un error en sus datos y el formulario no puede ser enviado en este momento.<br/><br/>'; //----este texto podria ser un html si le quieren dar estilo-------
	echo 'Detalle de los errores.<br/><br/>';
	echo $error.'<br/><br/>';
	echo 'Porfavor corrija estos errores e inténtelo de nuevo.<br/><br/>';//POR CADA LINEA UN ECHO
	die();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['cf_name'])||isset($_POST['cf_tel'])||isset($_POST['cf_email'])||isset($_POST['cf_message'])){//--variable de recojida de datos
	$flag=true;//VERIFICAR NO MANDE A LANDIG EN CASO DE ERROR
	$bdhost="";//--DNS DEL HOSTING
	$bduser="";//-- USUARIO DE LA BD--  
	$bdpass="";//--PASS DE EL USUARIO DE LA BD
	$conexion=mysql_connect($bdhost, $bduser, $bdpass)or die(mysql_error());//ESTA ES LA VARIABLE DE CONEXION
	mysql_select_db("", $conexion);//ELIGE LA TABLA Y SELECCIONA LA BASE DE DATOS DESEADA ESTA PREVIAMENTE DE DE EXISTIR
	mysql_set_charset("utf8", $conexion);//CODIFICACION DE LOS CARACTERES UTF-8
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$email_subject='Contacto Web'; //ASUNTO DEL CORREO EL SUBJET 
	$email_subject2='hola';//EL SEGUNDO SUBJET
	$n=$_POST['cf_name'];//DECLARAMOS EL FORMULARIO EN VARIABLES
    $t=$_POST['cf_tel'];//telefono
    $e=$_POST['cf_email'];//email
    $m=$_POST['cf_message'];//mensaje
    $f=date('d/m/Y');//DECLARAMOS FECHA Y HORA
    $h=date('H:i:s');
    $error_message = 'Error';//VARIABLE DE MENSAJE DE ERROR
    $email_to='quien recibe el mensaje';//correo de reccepcion del email para el dueño de la web
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';//VALIDACION DE CORREO
    if(!preg_match($email_exp,$e)) {
	    $error_message.='La dirección de correo proporcionada no es válida.<br/>';//ERROR DE CORREO
	}
	$string_exp="/^[A-Za-z .'-]+$/";
 	if(!preg_match($string_exp,$n)) {
    	$error_message.='El formato del nombre no es válido<br />';
    }
    $telefono_exp='/^[0-9-]*$/';
    if(!preg_match($telefono_exp, $t)){
    	$error_message.='el formato del Telefono no es válido.<br />';
    }
    if(!preg_match($string_exp, $m)) {
    	$error_message .= 'El formato del texto no es válido.<br />';
  	}
  	if(strlen($error_message) < 0) {
	    died($error_message);
	}//-----------------------------------CONTENIDO DE EL EMAIL---------------------------------
	

	$email_message='
	<html lang="es">
	    <head>
	      <title>mensaje recibido</title>
	    </head>
	    <body>
              <!--carguer el contenido que deseen este es el correo que recibira el dueño de la web o el admin de la misma-->
	    </body>
	    </html>
	    ';
	
	$headers="content-type:text/html;charset=UTF-8"."\r\n".//DECLARO QUE EL CORREO SERA HTML
	'From: '.$e."\r\n".  //SE ENVIA DESDE "USUARIO QUE ENVIO EL CORREO" 
	'Reply-To: '.$e."\r\n".//RESPONDER AL USUARIO QUE ENVIO EL CORREO
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers);//FUNCION QUE ENVIA EL CORREO
//////////////////////////////////////correo del lado cliente//////////////////////////////////////////////////
	$email_message2='
<html lang="es">
	    <head>
	      <title>mensaje recibido</title>
	    </head>
	    <body>
              <!--carguer el contenido que deseen este es el correo que recibira el usuario de la web o quien rellene el formulario-->
	    </body>
	    </html>
	';

	$headers2="content-type:text/html;charset=UTF-8"."\r\n".//DECLARO QUE EL CORREO SERA HTML
	'From: '.$email_to."\r\n".  //SE ENVIA DESDE "USUARIO QUE ENVIO EL CORREO" 
	'Reply-To: '.$email_to."\r\n".//RESPONDER AL USUARIO QUE ENVIO EL CORREO
	'X-Mailer: PHP/' . phpversion();
	@mail($e, $email_subject2, $email_message2, $headers2);//FUNCION QUE ENVIA EL CORREO
	
//////////////////////////////////////correo del lado cliente//////////////////////////////////////////////////
	
	$resultado=mysql_query("INSERT INTO `nombre de la tabla` (`nombre`,`telefono`,`email`,`nacimiento`,`fecha`,`hora`) VALUES ('$n','$t','$e','$m','$f','$h')");//BASE DE DATOS 
	mysql_close($conexion);
	
	if(!$resultado){
		$flag=false;
	}
	if($flag){
		header("Location: http://midominio.com");//PAGINA DE DESTINO
	}
}
else{
	died('Lo sentimos pero parece haber un problema con los datos enviados.');//ERROR
}
vic2123nat.php
