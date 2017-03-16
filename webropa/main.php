<?php session_start(); ?>
<!DOCTYPE html>
<html ng-app="appMain">
<head>
<title></title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/css_main.css" />
<link rel="stylesheet" href="css/simple-sidebar.css" />
<?php

    if(isset($_SESSION["login"])){
        if($_SESSION["login"]==0){
            header("Location: index.php");
        }
    }else{
        header("Location: index.php");
    }
?>
</head>
<body ng-controller="appControl1">
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">

                <span id="btn_close_menu" class="glyphicon glyphicon-chevron-left btn_closemenu" ng-click="btn_menu=true"></span>
                <a href="#"  ng-click="switchMenu(1)">
                        HOME
                </a>
            </li>
            <li>
                <a href="#" ng-click="switchMenu(2)">Caja</a>
            </li>
            <li>
                <a href="#" ng-click="switchMenu(3)">Facturacion</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <div id="page-content-wrapper" style="padding:0px">
        <!-- Div Contenido -->
        <div class="container-fluid" style="padding:0px;">
        	<!-- Barra Superior -->
        	<div class="col-xs-12 barra_sup_css" style="padding:0px;">
                <div class="col-xs-1" style="padding: 5px">
                <span id="btn_menu" class="glyphicon glyphicon-menu-hamburger btn_menu_c" ng-click="btn_menu=false" ng-show="btn_menu"></span>
                </div>
                <div class="col-xs-9" style="padding-top:14px">
        		<!--<img src="img/menu.png" id="btn_menu" width="35px" height="35px" />-->
        		<center><span id="title" style="font-size: 16px;">{{ apptitle }}</span></center>
                </div>
                <div style="float: right;">
                <span></span>
        		<span class="glyphicon glyphicon-log-out" style="cursor:pointer; margin:5px;color:#D8D8D8; font-size:1.6em"
                        ng-click="switchMenu(99)"></span>
                </div>
        		
        	</div>
            <!-- Div Contenido -->
            <div class="container-fluid c_anime_div" ng-show="dvInicio" style="padding:20px; padding-top:60px;">
                <div class="col-sm-2 content_menu_interactive">
                    <div class="col-xm-12 subdiv_menu_interactive" ng-click="switchMenu(3)">
                    <center>
                        <span class="lbl_menu_int">Facturación</span><br />
                        <img src="img/invoice.png" width="90%" />
                    </center>
                    </div>
                </div>
                <div class="col-sm-2 content_menu_interactive" ng-click="switchMenu(2)">
                    <div class="col-xm-12 subdiv_menu_interactive">
                    <center>
                        <span class="lbl_menu_int">Caja</span><br />
                        <img src="img/cashier.png" width="90%" />
                    </center>
                    </div>
                </div>
            </div>
            <!-- Fin Div Contenido -->
        </div><!-- Fin Dvi Contenido -->      
    </div>
</div>
</body>

<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<!--<script type="text/javascript" src="cordova.js"></script>-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/angular.min.js"></script>
<script type="text/javascript" src="js/js_main.js"></script>

</html>
