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
<head>
    <title>Factura</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body class="w-100">
    <div class="row">
        <div class="col-xs-8">
            <h1>Factura</h1>
        </div>
        <div class="col-xs-4">
            <img class="img img-responsive" src="https://intranet.stp.es/img/stp.png"  style="max-width:185px;"alt="Logotipo">
        </div>
    </div>

    <div class="row" style="margin-top:30px;margin-bottom:40px;">
        <div class="col-xs-4 offset-xs-1">
            <h1 class="h3">Remitente</h1>
            <?php echo $nombre_stp ?><br>
            <?php echo $direccion_stp ?><br>
            <?php echo $poblacion_stp ?><br>
            <?php echo $pais_stp ?>
        </div>
        <div class="col-xs-4">
            <h1 class="h3">Cliente</h1>
            <?php echo $nombre_cliente ?><br>
            <?php echo $email_cliente ?><br>
            <?php echo $direccion_cliente ?>
        </div>
        <div class="col-xs-4" style="margin-top:40px;">
            <strong>Nº Factura:&emsp;</strong>
            <span><?php echo $numero_factura ?></span><br>
            <strong>Referencia:&emsp;</strong>
            <span><?php echo $referencia_factura ?></span><br>
            <strong>Fecha:&emsp;&emsp;</strong>
            <span><?php echo $fecha_factura ?></span>
        </div>
    </div>
    <div class="row">
    <div class="col-xs-12">
        <table class="table table-condensed table-borderless table-striped">
                <thead>
                    <tr class="border-bottom">
                        <th class="h4 text-start">Descripción</th>
                        <th class="h4">Precio unitario</th>
                        <th class="h4">Cantidad</th>
                        <th class="h4">Total</th>
                    </tr>
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
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Subtotal</td>
                        <td><?php echo number_format($subtotal, 2) ?> €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Descuento</td>
                        <td><?php echo number_format($descuento, 2) ?> €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Subtotal con descuento</td>
                        <td><?php echo number_format($subtotalConDescuento, 2) ?> €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Impuestos</td>
                        <td><?php echo number_format($impuestos, 2) ?> €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">
                            <h4>Total</h4></td>
                        <td>
                            <h4><?php echo number_format($total, 2) ?> €</h4>
                        </td>
                    </tr>
                </tfoot>
            </table>
            </div>
</div>
    <div class="row w-100">
        <div class="col-xs-12 text-center">
            <p class="h5"><?php echo $mensajePie ?></p>
        </div>
    </div>

</body>
</html>