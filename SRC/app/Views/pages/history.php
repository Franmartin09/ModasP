<script>
function checkForm(event) {
  const date = document.querySelector('input[name="week"]');
  if (date.value) {
    showLoading();
  }
}
</script>
<div id="loading" style="text-align:center; position:fixed; width:100%; height:100%;top:0; bottom:0; background-color: rgba(255,255,255,0.85); z-index:9999; display:none;">
        <img src="app/Views/templates/loading.gif" alt="Loading..." style="width:300px;margin-top:25vh;"> 
</div>

<form method="post" action="" name="signup-form">
    <div class="row">
        <div class="col-lg-12">
            <div class="input-group justify-content-center">           
                <input class="form-control border-0 border-bottom" style="max-width:263px;" type="week" name="week" value="<?echo $week?>" min="2020-W1" max="2040-W1">
                <span class="input-group-addon border-bottom text-center" style="font-size:20px;"><button class="border-0 bg-white" type="submit" onclick="checkForm(event)"><i class="bi bi-search"></i></button></span>
            </div>
        </div>
    </div>
</form>
<div class="mx-auto" style="width:90%;">
    <div class="row" style="max-width:100%;">
        <div class="col-xl-4 py-1">
            <div class="title">Sales Chart by Week</div>
            <div class="card mb-5">
                <div class="card-body">
                    <canvas id="chBarsemanal"></canvas>
                </div>
            </div>
            <div class="title">Sales Chart by Year</div>
            <div class="card">
                <div class="card-body">
                    <canvas id="chBaranual"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-7 offset-xl-1 py-1 mb-5">
            <div class="title">Sales Chart by Month</div>
            <div class="card">
                <div class="card-body">
                    <canvas id="chBarmensual"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?
if(isset($semanal)){
    $day=1;
    $semana=[];
    while($day<=7){
        $name_day=date('l', strtotime(date('Y-m-d', strtotime(date('Y')."W".date('W').$day))));
        $importe=$semanal[$name_day]->importe;
        if($importe=="") $importe=0;
        $importe=round($importe,2);
        $semana[]=$importe;
        $day++;
    }
    $js_semana = json_encode($semana);
} 
if(isset($mensual)){
    $day=1;
    $mes=[];
    while($day<=31){
        $importe=$mensual[$day]->importe;
        if($importe=="") $importe=0;
        $importe=round($importe,2);
        $mes[]=$importe;
        $day++;
    }
    $js_mes = json_encode($mes);
}
if(isset($anual)){
    $month=1;
    $año=[];
    while($month<=12){
        $importe=$anual[$month]->importe;
        if($importe=="") $importe=0;
        $importe=round($importe,2);
        $año[]=$importe;
        $month++;
    }
    $js_año = json_encode($año);
}
?>

<script>
     
    var colors = ['#712cf9','#5c23cc','#28a745','#333333','#c3e6cb','#dc3545','#6c757d'];

    /* bar chart */
    var chBaranual = document.getElementById("chBaranual");
    var chBarsemanal = document.getElementById("chBarsemanal");
    var chBarmensual = document.getElementById("chBarmensual");
    if (chBarsemanal) {
    new Chart(chBarsemanal, {
    type: 'bar',
    data: {
        labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
        datasets: [{
        data: <?echo $js_semana;?>,
        backgroundColor: colors[0],
        hoverBackgroundColor: colors[1]
        }]
    },
    options: {
        legend: {
        display: false
        },
        scales: {
        xAxes: [{
            barPercentage: 0.4,
            categoryPercentage: 0.5
        }]
        }
    }
    });
    }

    if (chBarmensual) {
    new Chart(chBarmensual, {
    type: 'bar',
    data: {
        labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "21", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30","31"],
        datasets: [{
        data: <?echo $js_mes;?>,
        backgroundColor: colors[0],
        hoverBackgroundColor: colors[1]
        }]
    },
    options: {
        legend: {
        display: false
        },
        scales: {
        xAxes: [{
            barPercentage: 0.4,
            categoryPercentage: 0.5
        }]
        }
    }
    });
    }
    if (chBaranual) {
    new Chart(chBaranual, {
    type: 'bar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [{
        data: <?echo $js_año;?>,
        backgroundColor: colors[0],
        hoverBackgroundColor: colors[1]
        }]
    },
    options: {
        legend: {
        display: false
        },
        scales: {
        xAxes: [{
            barPercentage: 0.4,
            categoryPercentage: 0.5
        }]
        }
    }
    });
    }
</script>

