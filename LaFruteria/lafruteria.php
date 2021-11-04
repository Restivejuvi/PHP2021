<?php

function controlador() {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['usuario'])){
                $_SESSION['usuario'] = $_GET['usuario'];
                $contenido = mostrarFormularioPedido();
            } else {
                $contenido = mostrarFormulariUsuario();
            }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['enviar'] == 'Añadir') {
    
            $cantidad = (int) $_POST['cantidad']; 
            $_SESSION['pedido'][$_POST['fruta']] += $cantidad;
            $contenido = mostrarPedido() . mostrarFormularioPedido();
        } else {
            $contenido = mostrarPedido() . mostarFormularioNuevoCliente();
            session_destroy();   
        }
    }
    imprimirPantalla($contenido);
}

function mostrarFormulariUsuario(): string {
    $ver = '<form method="GET">';
    $ver .= '<label>Nombre de usuario <input type="text" name="usuario" size="30"></label>';
    $ver .= ' <input type="submit" value="Enviar">';
    $ver .= '</form>';

    return $ver;
}

function mostrarFormularioPedido(): string {
    $ver = "Realice su compra " . $_SESSION['usuario'] . "<br><br>";
    $ver .=  "<form method='POST'>";
    $ver .= "<select name='fruta'>";
    $ver .= "<option value='platano'>Plátano</option>";
    $ver .= "<option value='naranja'>Naranja</option>";
    $ver .= "<option value='limon'>Limón</option>";
    $ver .= "<option value='manzana'>Manzana</option>";
    $ver .= "</select>";
    $ver .= " <input type='number' name='cantidad' value='cantidad' min='1' max='20'>";
    $ver .= " <input type='submit' name='enviar' value='Añadir'>";
    $ver .= " <input type='submit' name='enviar' value='Terminar'>";
    $ver .= "</form>";

    return $ver;
}


function mostrarPedido(): string {
    $ver = '<div>';
    $ver .= '<ul>';
       
    foreach ($_SESSION['pedido'] as $_POST['fruta'] => $cantidad) {
        $ver .= '<li>' . $_POST['fruta'] . ' ' . $cantidad . '</li>';
    }
    $ver .= '</ul>';
    $ver .= '</div>';
   
    return $ver;
}

function mostarFormularioNuevoCliente(): string {
    $ver = "<p>Muchas gracias por su pedido</p>";
    $ver .= "<input type='button' name='nuevo_cliente' value='NUEVO CLIENTE' onclick='location.href=\"" . $_SERVER['PHP_SELF'] . "\"' >";
    return $ver;
}

function imprimirPantalla(string $contenido) {
    $ver = '<!DOCTYPE html>';
    $ver .= '<html lang="en">';
    $ver .= '<head>';
    $ver .= '<meta charset="UTF-8">';
    $ver .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    $ver .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $ver .= '<title>La Frutería</title>';
    $ver .= '</head>';
    $ver .= '<body>';
    $ver .= '<h1>Bienvenido a la frutería del siglo XXI</h1>';
    $ver .= $contenido;
    $ver .= '</body>';
    $ver .= '</html>';

    echo $ver;
}

controlador();

?>
