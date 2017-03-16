<?php session_start(); ?>
<!DOCTYPE html>
<html ng-app="appMain">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title></title>

<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/css_main.css" />
<link rel="stylesheet" href="css/simple-sidebar.css" />
<?php 
    if(isset($_SESSION["login"])){
        if($_SESSION["login"]==1){
            header("Location: main.php");
        }
    }
?>
</head>
<body ng-controller="appControl1" style="background-color:#424242">
<div class="container">

    <br />
    <div class="col-md-4"></div>
    <div class="col-md-4" style="box-shadow: 0px 1px 5px; border-radius: 5px; background-color:#E6E6E6; margin-top: 50px">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <br />
            <center>
                <img src="img/logo.png" width="190px" height="110px" />
                <label>Venta de Ropa Nueva y Usada JIREH</label>
            </center>
            <br />
            <div class="inner-addon left-addon" style="margin-bottom:6px">
                <span class="glyphicon glyphicon-user" style="color:gray"></span>
                <input type="text" id="user" ng-model="user" placeholder="Usuario" class="form-control"/>
            </div>

            <div class="inner-addon left-addon" style="margin-bottom:6px">
                <span class="glyphicon glyphicon-lock" style="color:gray"></span>
                <input type="password" id="pwd" ng-model="pwd" placeholder="Clave" class="form-control"/>
            </div>
            <center><input type="button" style="margin-top:10px; margin-bottom:10px" id="login" value="LogIn" class="btn btn-success" ng-click="login()" /></center>
            <center><span style="font-size:1.2em; color:#B40404" >{{ msj_login }}</span></center>
            <br />
        </div>
    </div>
</div>
</body>

<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<!--<script type="text/javascript" src="cordova.js"></script>-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>


<script src="js/angular.min.js"></script>
<script type="text/javascript" src="js/js_index.js"></script>
<script type="text/javascript">
</script>

</html>
