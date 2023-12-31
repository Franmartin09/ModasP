<div id="loading" style="text-align:center; position:fixed; width:100%; height:100%;top:0; bottom:0; background-color: rgba(255,255,255,0.85); z-index:9999; display:none;">
        <img src="app/Views/templates/loading.gif" alt="Loading..." style="width:300px;margin-top:25vh;"> 
</div>

<div class="mb-1 mt-5 text-end w-90" style="margin-right:5%;margin-left:5%;">
    <form method="post" action="" >
            <button class="btn btn-secondary" type="submit" onclick=showLoading() name="crear" style="height:40px;width:100px" ><i class="bi bi-plus-lg"></i></button>
    </form>
</div>

<div class="mx-auto" style="width:90%; overflow: auto; max-height: 643px;">
    <table class="table table-condensed table-striped table-hover text-center " >
        <thead style="background-color:#712cf9; color:white;">
            <tr>
                <th>ID Invoice</th>
                <th>Reference</th>
                <th>Nº Invoice</th>
                <th>Date</th>
                <th>Net Amount</th>
                <th>IVA (%)</th>
                <th>Total Amount</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invo as $invoice) { ?>
                <form method="post" action="">
                    <tr>
                        <td><?php echo $invoice->id_factura; ?></td>
                        <td><?php echo $invoice->reference; ?></td>
                        <td><?php echo $invoice->numero_factura; ?></td>
                        <td><?php echo $invoice->fecha; ?></td>
                        <td><?php echo $invoice->importe_neto; ?></td>
                        <td><?php echo $invoice->iva; ?></td>
                        <td><?php echo $invoice->importe_total; ?></td>
                        <td>
                                <button type="submit" class="border-0 bg-transparent" name="imprimir" value="<?php echo $invoice->id_factura; ?>" style="color: #712cf9;"><i class="bi bi-printer"></i></button>
                                <button type="submit" class="border-0 bg-transparent" onclick=showLoading() name="editar" value="<?php echo $invoice->id_factura; ?>"><i class="bi bi-pencil"></i></button>
                                <button type="submit" class="border-0 bg-transparent" onclick=showLoading() name="eliminar" value="<?php echo $invoice->id_factura; ?>" style="color: #EE4B2B;"><i class="bi bi-trash3"></i></button>
                        </td>
                    </tr>
                </form>
            <?php } ?>
        </tbody>
    </table>
