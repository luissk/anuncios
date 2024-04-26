<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(!defined('APPPATH')) exit('No direct script access allowed');

if(!function_exists('nombre_mes')){
    function nombre_mes($n){
        switch($n){
            case 1: return 'ENERO';
                break;
            case 2: return 'FEBRERO';
                break;
            case 3: return 'MARZO';
                break;
            case 4: return 'ABRIL';
                break;
            case 5: return 'MAYO';
                break;
            case 6: return 'JUNIO';
                break;
            case 7: return 'JULIO';
                break;
            case 8: return 'AGOSTO';
                break;
            case 9: return 'SETIEMBRE';
                break;
            case 10: return 'OCTUBRE';
                break;
            case 11: return 'NOVIEMBRE';
                break;
            default: return 'DICIEMBRE';
        }
    }
}

if(!function_exists('help_nombreWeb')){
    function help_nombreWeb(){
		return 'Anuncios del Valle';
    }
}

if(!function_exists('stringAleatorio')){
    function stringAleatorio($length = 5, $case = 1){
		$characters       = $case == 1 ? '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' : '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString     = '';
	    for($i = 0; $i < $length; $i++){
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
    }
}

if(!function_exists('help_folderAnuncio')){
    function help_folderAnuncio(){
		return 'public/images/anuncios/';
    }
}

if ( ! function_exists('help_reemplazaCaracterUrl'))
{
    function help_reemplazaCaracterUrl($String = ''){
    	// $String = strtolower($String);
    	$String = mb_strtolower($String);

        $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
	    $String = str_replace(array('Á','À','Â','Ã','Ä'),"A",$String);
	    $String = str_replace(array('Í','Ì','Î','Ï'),"I",$String);
	    $String = str_replace(array('í','ì','î','ï'),"i",$String);
	    $String = str_replace(array('é','è','ê','ë'),"e",$String);
	    $String = str_replace(array('É','È','Ê','Ë'),"E",$String);
	    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
	    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$String);
	    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
	    $String = str_replace(array('Ú','Ù','Û','Ü'),"U",$String);
	    $String = str_replace(array("\\", "¨", "º", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".","°"),"",$String);

	    $String = str_replace("-"," ",$String);
    	//$String = str_replace("M²","M2",$String);
	    $String = str_replace("m²","m2",$String);
	    //$String = str_replace("M³","M3",$String);
	    $String = str_replace("m³","m3",$String);
    	$String = trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $String));

	    $String = str_replace("ç","c",$String);
	    $String = str_replace("Ç","C",$String);
	    $String = str_replace("ñ","n",$String);
	    $String = str_replace("Ñ","N",$String);
	    $String = str_replace("Ý","Y",$String);
	    $String = str_replace("ý","y",$String);
	     
	    $String = str_replace("&aacute;","a",$String);
	    $String = str_replace("&Aacute;","A",$String);
	    $String = str_replace("&eacute;","e",$String);
	    $String = str_replace("&Eacute;","E",$String);
	    $String = str_replace("&iacute;","i",$String);
	    $String = str_replace("&Iacute;","I",$String);
	    $String = str_replace("&oacute;","o",$String);
	    $String = str_replace("&Oacute;","O",$String);
	    $String = str_replace("&uacute;","u",$String);
	    $String = str_replace("&Uacute;","U",$String);

	    $String = str_replace(" ","-",$String);
	    
	    return $String;
    }   
}

if (!function_exists('help_remove_url_query_args'))
{
	function help_remove_url_query_args($url,$keys=array()) {
	    $url_parts = parse_url($url);
	    if(empty($url_parts['query']))return $url;
	            
	    parse_str($url_parts['query'], $result_array);
	    foreach ( $keys as $key ) { unset($result_array[$key]); }
	    $url_parts['query'] = http_build_query($result_array);
	    $url = (isset($url_parts["scheme"])?$url_parts["scheme"]."://":"").
	            (isset($url_parts["user"])?$url_parts["user"].":":"").
	            (isset($url_parts["pass"])?$url_parts["pass"]."@":"").
	            (isset($url_parts["host"])?$url_parts["host"]:"").
	            (isset($url_parts["port"])?":".$url_parts["port"]:"").
	            (isset($url_parts["path"])?$url_parts["path"]:"").
	            (isset($url_parts["query"])?"?".$url_parts["query"]:"").
	            (isset($url_parts["fragment"])?"#".$url_parts["fragment"]:"");

	    

	    return $url;
	}
}

if(!function_exists('help_Captcha')){
    function help_Captcha($codigo){
		define('ANCHO', 140);
        define('ALTO', 50);
        define('TAMANIO_FUENTE', 25);
        define('CODIGO_LENGTH', 5);
        define('NUM_LINEAS', 6);
        define('NUM_PUNTOS', 500);

        // Genera un código aleatorio de 5 caracteres
        //$codigo = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, CODIGO_LENGTH);
        $fuente = 'public/fonts/especial.ttf';

        // Guardar el código en la sesión después de aplicar hash (sha1)
        //$_SESSION['codigo_verificacion'] = sha1($codigo);

        // Crear una imagen en blanco
        $imagen = imagecreatetruecolor(ANCHO, ALTO);
        $colorFondo = imagecolorallocate($imagen, 255, 255, 255);
        imagefill($imagen, 0, 0, $colorFondo);

        // Colores para texto, líneas y puntos
        $colorText = imagecolorallocate($imagen, 50, 50, 50);
        $colorSecundario = imagecolorallocate($imagen, 0, 0, 128);

        // Agrega líneas
        for ($i = 0; $i < NUM_LINEAS; $i++) {
            imageline($imagen, 0, rand(0, ALTO), ANCHO, rand(0, ALTO), $colorSecundario);
        }

        // Agrega puntos aleatorios
        for ($i = 0; $i < NUM_PUNTOS; $i++) {
            imagesetpixel($imagen, rand(0, ANCHO), rand(0, ALTO), $colorSecundario);
        }

        // Escribe el código en la imagen usando una fuente TrueType
        imagettftext($imagen, TAMANIO_FUENTE, -5, 10, 35, $colorText, $fuente, $codigo);

        // Mostrar la imagen en el navegador y liberar la memoria
        header('Content-Type: image/png');
        imagepng($imagen);
        imagedestroy($imagen);
    }
}

if(!function_exists('help_sendMail')){
    function help_sendMail($from, $to, $subject, $body, $username = 'anunciosdelvalle2024@gmail.com', $password = 'kevdsfzdqrwndfwi'){
        $mail = new PHPMailer(true);  
        try {            
            $mail->SMTPDebug = 0;
            $mail->isSMTP();  
            $mail->Host         = 'smtp.gmail.com'; //smtp.google.com
            $mail->SMTPAuth     = true;     
            $mail->Username     = $username;  
            $mail->Password     = $password;
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;  
            $mail->Port         = 465;  
            $mail->setFrom($from[0], $from[1]);
            
            $mail->addAddress($to);  
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject      = $subject;
            $mail->Body         = $body;
            
            if(!$mail->send()) {
                //echo "Ocurrió un problema. Por favor vuelve a intentar.";
                return false;
            }
            else {
                //echo "Email enviado!.";
                return true;
            }
            
        } catch (Exception $e) {
            //echo "Hubo un problema." .$e;
            //echo "Hubo un problema, Inténtelo en un momento.";
            return false;
        }
    }
}
?>