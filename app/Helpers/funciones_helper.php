<?php
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

if(!function_exists('stringAleatorio')){
    function stringAleatorio($length  = 5){
		$characters       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
?>