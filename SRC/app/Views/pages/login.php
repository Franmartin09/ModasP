<script>
function checkForm(event) {
  const usernameInput = document.querySelector('input[name="username"]');
  const passInput = document.querySelector('input[name="password"]');
  
  if (usernameInput.value && passInput.value) {
    showLoading();
  }
}
</script>
<div style="margin-top:100px;">
<form method="post" action="" name="signup-form" >

    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="input-group">
                <span class="input-group-addon border-bottom text-center" style="width:40px;"><i class="bi bi-person-fill"></i></span>
                <input type="text" class="form-control border-0 border-bottom" name="username" required="required" placeholder="Username" maxlength="50"> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="input-group">
                <span class="input-group-addon border-bottom text-center" style="width:40px;"><i class="bi bi-key-fill"></i></span>
                <input type="password" class="form-control border-0 border-bottom" name="password" required="required" placeholder="Password" maxlength="100">
            </div>
        </div>
    </div>

    <div class="row text-end">
        <div class="col-md-4 offset-md-4">
           <button class="btn btn-primary" type="submit" onclick=checkForm(event) name="enter" value="register" style="width:90px; margin-top:40px;">Enter</button>
        </div>
    </div>

</form>
</div>

<script>
    <?if($error==true){?>
    window.alert("Username password combination is wrong!");
<?}?>
</script>

