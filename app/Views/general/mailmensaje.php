<table width="700" cellpadding="12" cellspacing="0" style="border: 1px solid #ddd;-webkit-border-radius:3px;border-radius:5px;" align="center">
    <tr>
        <td valign="middle">
        	<span style='font-size:20px;font-weight:bold;color:#198754'>Tienes un mensaje sobre uno de tus anuncios</span>
        </td>
    </tr>
    <tr>
    	<td colspan="2" style="color:#000">
        	Hola <b style="text-decoration:none;"><?=$email?></b>, una persona te ha contactado por tu anuncio "<a href="<?=$linkanuncio?>"><?=$nombre_anu?></a>". A continuación te mostramos sus datos:</p>
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="4">
                <tr>
                    <th width="100px" style="color: #444">Correo: </th>
                    <td style="color:#666"><?=$mensaje['txtMail']?></td>
                </tr>
                <tr>
                    <th width="100px" style="color: #444">Nombre: </th>
                    <td style="color:#666"><?=$mensaje['txtNombre']?></td>
                </tr>
                <tr>
                    <th width="100px" style="color: #444">Teléfono: </th>
                    <td style="color:#666"><?=$mensaje['txtFono']?></td>
                </tr>
                <tr>
                    <th width="100px" style="color: #444">Mensaje: </th>
                    <td style="color:#666"><?=$mensaje['txtMensaje']?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr bgcolor="#F3F5F4">
            <td>
                <table border="0"  width="100%">
                    <tr>
                        <td width="100%" style="font-size:13px;text-align:center">
                           si tienes dudas o alg&uacute;n comentario cont&aacute;ctanos a:
                           contacto@advalle.com
                           <hr width="80%">
                           Gracias por utilizar <a style="color:#47493F"  href="<?=base_url()?>">www.advalle.com</a>
                           <br><br>
                           Copyright - <?=date('Y')?>
                        </td>
                    </tr>
                    
                </table>
           
           </td>  
      </tr>
</table>