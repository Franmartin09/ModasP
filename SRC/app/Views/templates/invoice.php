<?php
//DATOS STP
$nombre_stp="Soluciones Tecnoprofesionales";
$direccion_stp="C/Tegnologia Ed. Canadà";
$poblacion_stp="08840 Viladecans";
$pais_stp="Catalunya, España";
//DATOS CLIENTE
$direccion_cliente = $cliente->addres;
$email_cliente= $cliente->email_cliente;
$nombre_cliente = $cliente->name_surname;
//DATOS FACTURA
$referencia_factura = $factura->reference;
$numero_factura= $factura->numero_factura;
$fecha_factura = $factura->fecha;
$porcentajeImpuestos = $factura->iva;
//APLICACIONES EXTRAS
$mensajePie = "Gracias por su compra";
$descuento = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Factura</title>
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body class="w-100">
    <div class="mb-5 w-100">
        <div class="col-4 text-center" style="margin-top:30px;">
            <h1 class="display-1">Factura</h1>
        </div>
        <div class="col-4 offset-4 text-center" style="margin-top: 40px;">
            <img src="https://intranet.stp.es/img/stp.png" alt="Logotipo" style="max-width:225px;">
        </div>
    </div>


<div class="row mt-5 mb-5" style="margin:20px;">
        <div class="col-4 offset-sm-1">
            <h1 class="h3">Remitente</h1>
            <?php echo $nombre_stp ?><br>
            <?php echo $direccion_stp ?><br>
            <?php echo $poblacion_stp ?><br>
            <?php echo $pais_stp ?>
        </div>
        <div class="col-4">
            <h1 class="h3">Cliente</h1>
            <?php echo $nombre_cliente ?><br>
            <?php echo $email_cliente ?><br>
            <?php echo $direccion_cliente ?>
        </div>
        <div class="col-3">
            <strong>Nº Factura:&emsp;</strong>
            <span><?php echo $numero_factura ?></span><br>
            <strong>Referencia:&emsp;</strong>
            <span><?php echo $referencia_factura ?></span><br>
            <strong>Fecha:&emsp;&emsp;</strong>
            <span><?php echo $fecha_factura ?></span>
        </div>
    </div>


    <div class="mx-auto mt-5" style="width:90%;">
            <table class="table table-condensed table-borderless text-center">
                <thead>
                    <tr class="border-bottom">
                        <th class="h4 text-start">Descripción</th>
                        <th class="h4">Precio unitario</th>
                        <th class="h4">Cantidad</th>
                        <th class="h4">Total</th>
                    </tr>
                    <tr><th colspan="4"></th><tr>
                </thead>
                <tbody class="border-bottom">
                    <?php
                    $subtotal = 0;
                    foreach ($items as $producto) {
                        $totalProducto = $producto->quantity * $producto->price;
                        $subtotal += $totalProducto;
                        ?>
                        <tr>
                            <td class="text-start"><?php echo $producto->overview?></td>
                            <td><?php echo number_format($producto->price, 2) ?> €</td>
                            <td><?php echo number_format($producto->quantity, 2) ?></td>
                            <td><?php echo number_format($totalProducto, 2) ?> €</td>
                        </tr>
                    <?php }
                        $subtotalConDescuento = $subtotal - $descuento;
                        $impuestos = $subtotalConDescuento * ($porcentajeImpuestos / 100);
                        $total = $subtotalConDescuento + $impuestos;
                    ?>
                    <tr><td colspan="4"></td><tr>
                </tbody>
                <tfoot>
                    <tr><td colspan="4"></td><tr>
                    <tr>
                        <td colspan="3" class="text-end">Subtotal</td>
                        <td><?php echo number_format($subtotal, 2) ?> €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Descuento</td>
                        <td><?php echo number_format($descuento, 2) ?> €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Subtotal con descuento</td>
                        <td><?php echo number_format($subtotalConDescuento, 2) ?> €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Impuestos</td>
                        <td><?php echo number_format($impuestos, 2) ?> €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">
                            <h4>Total</h4></td>
                        <td>
                            <h4><?php echo number_format($total, 2) ?> €</h4>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <div class="row w-100">
        <div class="col-sm-12 text-center">
            <p class="h5"><?php echo $mensajePie ?></p>
        </div>
    </div>

</body>
</html>