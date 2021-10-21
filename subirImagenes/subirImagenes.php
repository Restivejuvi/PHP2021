<?php
$codigosErrorSubida= [
    0 => 'Subida correcta',
    1 => 'El tamaño del archivo excede el admitido por el servidor',
    2 => 'El tamaño del archivo excede el admitido por el cliente',
    3 => 'El archivo no se pudo subir completamente',
    4 => 'No se seleccionó ningún archivo para ser subido',
    6 => 'No existe un directorio temporal donde subir el archivo',
    7 => 'No se pudo guardar el archivo en disco',
    8 => 'Una extensión PHP evito la subida del archivo'
];
 
define ('dir_subida','C:\Users\Desktop\imgusers');

if(isset($_FILES['archivo1']['name'])){
    $arrayFicheros=$_FILES['archivo1'];
    $numArchivos = count($_FILES['archivo1']['name']);
    $tamanio=array_sum( $_FILES['archivo1']['size']);
    $mensaje = '';

    if(($numArchivos>=3 && $tamanio >300000)||($numArchivos==1 && $tamanio>200000)){
        $mensaje= '<span style=" color :red;">'.$codigosErrorSubida[2];
    }else{
        $mensaje = '<b>Procesando subida de archivos :  </b><br/>';
        for($i=0;$i<$numArchivos;$i++){
            $nombreFichero   =   $arrayFicheros['name'][$i];
            $errorFichero    =   $arrayFicheros['error'][$i];
            $temporalFichero =   $arrayFicheros['tmp_name'][$i];
            $mensaje .= "- Nombre: $nombreFichero" . ' <br/>';

              if ($errorFichero > 0) {
                  $mensaje.='<span style=" color :red;">'.$codigosErrorSubida[$errorFichero].'<br>';
              }else{
                 if(comprobarSistArchivo($nombreFichero)){
                     $mensaje.=subirArchivo($nombreFichero,$temporalFichero);
                 }else{
                     $mensaje.='<span style=" color :red;">No se acepta ese sistema de archivo </span><br>';
                    }
                }
          }
     }
}

function comprobarSistArchivo($nombreFichero){
    $sistemaArchivos=[".jpg",".png"];
    for($i=0;$i<count($sistemaArchivos);$i++){
        if(strstr($nombreFichero, $sistemaArchivos[$i])){
            return true;
        }
    }
    return false;
}

function subirArchivo($nombreFichero,$temporalFichero) {
    if ( is_dir(dir_subida) && is_writable (dir_subida)) {
        if(!file_exists(dir_subida .'/'. $nombreFichero) && move_uploaded_file($temporalFichero,  dir_subida .'/'. $nombreFichero)){
            $mensaje = '<span style=" color :green;">Archivo ha sido subido con exito . </span><br/>';
        }else{
            $mensaje='<span style=" color :red;">El archivo '.$nombreFichero." ya existe</span> <br/>";
        }
    }else{
        $mensaje='<span style=" color :red;">Error de permisos en el directorio</span> <br/>';
    }
    return $mensaje;
}
?>

<html>
    <head>
    <title>Subir Imagenes</title>
    <meta charset="UTF-8">

    </head>
<body>
    <div>
        <div>
            <h2>Subir imagenes al servidor</h2>
            <h6>Podra subir una, dos o tres imagenes a la vez y cada imagen no podra pesar más de 200 Kbytes y las tres juntas no podran superar los 300  Kbytes.</h6>
        </div>
        <div>
       		 <form  enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>"  method="post"  >
              	 <input type="hidden" name="MAX_FILE_SIZE" value="300000" /> 
                 <label>Elija el archivo a subir :</label> <input name="archivo1[]" type="file" accept="image/png, image/jpg" multiple="multiple"/> <br />
                 <input type="submit" value="Subir archivo"/>
            </form>
        </div>
       		<div>
                <?php   if(!empty($mensaje)){
                            echo '<p style="text-align:center;">'.$mensaje."<br>";} ?>
            </div> 
    </div>
</body>
</html>