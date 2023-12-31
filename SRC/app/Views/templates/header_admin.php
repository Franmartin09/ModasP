<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 

    <title>Modas P.</title>
    <!-- AWESOME ICONS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
    
    <script type="text/javascript">
      function showLoading() {
        document.getElementById('loading').style.display='block';
      }
      function hideLoading() {
        document.getElementById('loading').style.display='none';
      }
    </script>
<style>
        body {
            overflow-x: hidden;
        }
        .loading-style{
            text-align:center;

            background-color: rgba(255,255,255,0.85);
            z-index:9999;
            display:none;
        }
        .button-outline{
            outline: none;
            border: none;
            background: none;
            cursor: pointer; 
        }
        .icon-header-size{
            font-size:"24px";
        }
        .img-carousel{
            height: 40%;
        }


    </style>
</head>

<body>   
    <!-- <div class="row pt-4 pb-4" style="background-color:violet;">
        <div class="col-12">
            <button class="btn button-outline mx-2" style=""  name="menu" id="menu"><i style="font-size:26px;" class="bi bi-list"></i></button>
            <a class="mx-2" style="outline: none; cursor: pointer;">OFERTAS</a>
            <a class="mx-2" style="outline: none; cursor: pointer;">SHOP NOW!</a>
            <button class="btn button-outline mx-2" style=""  name="chart" id="chart" onclick=showLoading()><i style="font-size:25px;"class="bi bi-wallet2"></i></button>
            <button class="btn button-outline mx-2" style="outline: none;"  name="chart" id="chart" onclick=showLoading()><i style="font-size:25px;" class="bi bi-cart"></i></button>
            <button class="btn button-outline mx-2 me-3" style="outline: none;"  name="logout" onclick=showLoading()><i style="font-size:25px;" class="bi bi-person"></i></button>
        </div>
    </div> -->
    <div class="row">
        <div class="col-3 h-100" id="menu" style="background-color:grey;"></div>

