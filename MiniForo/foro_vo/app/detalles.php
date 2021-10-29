<div>
    <b> Detalles:</b><br>
<table>
    <tr><td>Longitud:          </td><td>
		    <?php if(strlen($_REQUEST['comentario'])<300){ 
                 echo strlen($_REQUEST['comentario']);
         }else{
             echo "Excede el numero de caracteres";
    }

?></td></tr>
    <tr><td>Nº de palabras:    </td><td><?=  str_word_count($_REQUEST['comentario'], 0)?></td></tr>
<?php
    $comentario=$_REQUEST['comentario'];
    $arrayCaracter=count_chars($comentario, 1);
    $max=0;
    $caracter="";
    foreach($arrayCaracter as $letra=>$numRepe){
        if($numRepe >$max && $letra!=32){
         $max=$numRepe;
         $caracter=$letra;
        }    
    }
?>
    <tr><td>Letra + repetida:  </td><td><?= chr($caracter)?></td></tr> 
<?php 

    $arryaCadena=explode(" ",$comentario);
    $palabramas=array_unique($arryaCadena);
    $aparece=0;

    foreach($palabramas as $word){
        $veces=substr_count($comentario,$word);
        if( $veces>$aparece ){
        $palabra=$word;
        $aparece=$veces;
        }
    }

?>
    <tr><td>Palabra + repetida:</td><td><?= $palabra ?></td></tr>
</table>
</div>

