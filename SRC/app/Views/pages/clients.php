
<form method="post" action="">
    <div class="row">
        <div class="col-lg-3 offset-lg-1">
            <div class="text-center" style="height:40px; width:fit-content;">
                <input class="form-check-input me-2 ms-2.5" type="radio" name="radio" value="activo" <?php if (isset($radio) && $radio=="activo") echo "checked";?>/>
                <span>Active Clients</span>
            </div>
            <div class="text-center mb-2" style="height:40px; width:fit-content;">
                <input class="form-check-input mt-2 me-2 ms-2.5" type="radio" name="radio" value="inactivo" <?php if (isset($radio) && $radio=="inactivo") echo "checked";?>/>
                <span>Inactive Clients</span>
                <button class="btn btn-outline-warning" type="submit"  onclick=showLoading() style="margin-left:20px"><i class="bi bi-funnel"></i></button>
            </div>
            <div class="text-center" style="height:40px; width:fit-content;">
                <input class="form-check-input mt-2 me-2" type="radio" name="radio" value="total" <?php if (isset($radio) && $radio=="total") echo "checked";?>/>
                <span class="mt-3">All Clients</span>
            </div>
        </div>
        <div class="col-lg-4 text-center">
            <div class="input-group">           
                <input maxlength="50" class="form-control border-0 border-bottom"  type="text" name="pattern" placeholder="Name, Email, ...">
                <span class="input-group-addon border-bottom text-center" style="font-size:20px;"><button class="border-0 bg-white" type="submit" onclick=showLoading() name="buscar"><i class="bi bi-search"></i></button></span><br>
            </div>
        </div>
    </div>
</form>
<div class="mb-1 mt-0 text-end w-90" style="margin-right:5%;margin-left:5%;">
    <form method="post" action="" >
            <button class="btn btn-secondary" type="submit" onclick=showLoading() name="crear" style="height:40px;width:100px" ><i class="bi bi-plus-lg"></i></button>
    </form>
</div>


<div class="mx-auto" style="width:90%; max-height: 600px; overflow: auto; margin-bottom:70px;">
    <table class="table table-condensed table-striped table-hover text-center" >
        <thead style="background-color:#712cf9; color:white;">
            <tr id="header">
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>CIF</th>
                <th>Date of Enrollment</th>
                <th>Date of Cancellation</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?
            if($añadir!=""){
            ?>
            <tr>
            <!-- Crear Cliente-->
                <div class="text-center">
                    <form method="post" action="" id="addclient_id"  name="signup-form">
                        <td></td>
                        <td><input type="text" name="nombre" maxlength="20"></td>
                        <td><input type="text" name="email" maxlength="30"></td>
                        <td><input style="max-width:90px;" type="text" name="phone" maxlength="12"></td>
                        <td><input type="text" name="direccion" maxlength="30"></td>
                        <td><input style="max-width:90px;" type="text" name="cif" maxlength="9"> </td>
                        <td><span><? echo date("Y-m-d H:i:s");?></span></td>
                        <td></td>
                        <td>
                            <button type="submit"  class="border-0 bg-transparent h6 ms-3 me-4 mt-1"  onclick=showLoading() name="created" style="color: #198754;"><i class="fas fa-save"></i></button>
                            <button type="submit"  class="border-0 bg-transparent h6" onclick=showLoading() name="edited_cancel" type="submit" style="color: #EE4B2B;"><i class="bi bi-x-lg"></i></button>    
                        </td>
                    </form>
                </div>
            </tr>
            <?
            }
            ?>

            <?php if(isset($users) and $users!=""){foreach ($users as $usuario) { ?>
                <?
                    if($autocomplete=="" or  $autocomplete[0]->id_cliente!=$usuario->id_cliente){?>
            <form method="post" action="">
                <tr>
                    <td><?php echo $usuario->id_cliente; ?></td>
                    <td><?php echo $usuario->name_surname; ?></td>
                    <td><?php echo $usuario->email_cliente; ?></td>
                    <td ><?php echo $usuario->phone; ?></td>
                    <td><?php echo $usuario->addres; ?></td>
                    <td ><?php echo $usuario->cif; ?></td>
                    <td ><?php echo $usuario->fecha_alta; ?></td>
                    <td ><?php echo $usuario->fecha_baja; ?></td>
                    <td>
                        <button type="submit"  class="border-0 bg-transparent" onclick=showLoading() name="facturas" value="<?php echo $usuario->id_cliente; ?>" style="color: #712cf9;"><i class="bi bi-files"></i></i></button>
                        <button type="submit"   class="border-0 bg-transparent" onclick=showLoading() name="editar" value="<?php echo $usuario->id_cliente; ?>" type="submit"><i class="bi bi-pencil"></i></button>
                        <?if ($usuario->estado=="A"){?>
                            <button type="submit"  class="border-0 bg-transparent" onclick=showLoading() name="archivar" value="<?php echo $usuario->id_cliente; ?>"><i class="bi bi-archive"></i></button>
                        <?}else {?>
                            <button type="submit"  class="border-0 bg-transparent" onclick=showLoading() name="desarchivar" value="<?php echo $usuario->id_cliente; ?>"><i class="bi bi-inbox"></i></button>
                        <?}?>
                        <button type="submit"  class="border-0 bg-transparent" onclick=showLoading() name="eliminar" value="<?php echo $usuario->id_cliente; ?>" style="color: #EE4B2B;"><i class="bi bi-trash3"></i></button>
                    </td>
                    <!-- Update Cliente-->
                </tr>
            </form>
                <?}else {
                    ?>
                    <tr id="id_editar">
                        <div class="text-center">
                            <form method="post" action="">
                                <td><span ><?php echo $autocomplete[0]->id_cliente;?></span></td>
                                <td><input maxlength="20" type="text" name="nombre" value='<?php echo $autocomplete[0]->name_surname;?>'></td>
                                <td><input maxlength="30" type="text" name="email" value='<?php echo $autocomplete[0]->email_cliente;?>'></td>
                                <td><input maxlength="12" style="max-width:90px;" type="text" name="phone" value='<?php echo $autocomplete[0]->phone;?>'></td>
                                <td><input maxlength="30" type="text" name="direccion" value='<?php echo $autocomplete[0]->addres;?>'></td>
                                <td><input maxlength="9" style="max-width:90px;" type="text"  name="cif" value='<?php echo $autocomplete[0]->cif;?>'></td>
                                <td><span ><?php echo $autocomplete[0]->fecha_alta;?></span></td>
                                <td><span ><?php echo $autocomplete[0]->fecha_baja;?></span></td>
                                <td>
                                    <button type="submit"  class="border-0 bg-transparent h6 ms-3 me-4 mt-1" onclick=showLoading()  value="<?php echo $usuario->id_cliente; ?>" name="edited" style="color: #198754;"><i class="fas fa-save"></i></button>
                                    <button type="submit"  class="border-0 bg-transparent h6" onclick=showLoading() value="<?php echo $usuario->id_cliente; ?>" name="edited_cancel" style="color: #EE4B2B;"><i class="bi bi-x-lg"></i></button>    
                                </td>
                            </form>
                        </div>
                    </tr>
                    <?
                        }
                    }
                    ?>
            <? } ?>
        </tbody>
    </table>
    </div>

    <script>
window.addEventListener('load', () => {
  const editadoElement = document.getElementById('id_editar');
  if (editadoElement) {
    const headerHeight = document.getElementById('header').offsetHeight; 
    const offset = headerHeight + 10;
    const scrollOptions = {
      behavior: 'instant',
      block: 'center',
      inline: 'nearest',
      offset: offset
    };
    editadoElement.scrollIntoView(scrollOptions);
  }
});




    </script>
