<?php
function usuarioOk($usuario, $contraseña) :bool {
  
    return (strlen($usuario)>=8 && $contraseña==strrev($usuario));
    
}
?>