

var appM = angular.module('appMain', []);

appM.controller('appControl1', function($scope,$http) {
    $scope.btn_menu = false;
    $scope.dvCaja = false;
    $scope.dvFacturacion = false;
    $scope.cApertura = true;
    $scope.apptitle = "Venta de Ropa Nueva y Usada JIREH";
    $scope.vCierre = {"vCaja":"", "vCajero":"", "Fopen":"","devs":0,"egresos":0, "sob_fal":0, "saldo_ini":0, "saldo_fin":0};
    $scope.vArr_Cierres = {};

    $scope.arrTiendas = [];

    reset_apertura();
    if(window.innerWidth<900){
        $scope.btn_menu = true;
    }
    
    $scope.switchMenu = function(vM){
        switch(vM){
            case 1:
                $scope.dvInicio = true;
                $scope.dvCaja = false;
                $scope.dvFacturacion = false;
                $scope.btn_menu =true;
                window.location.replace('../../main.php');
            break;
            case 2:
                $scope.dvInicio = true;
                $scope.dvCaja = false;
                $scope.dvFacturacion = false;
                $scope.btn_menu =true;
            break;
            case 3:
                window.location.replace('../../views/facturacion/index.php');
            break;
            case 99:
                $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:104}).then(function(vResult){
                    window.location.reload();
                }); 
            break;
            default:
                return;
        }
        if(vM!=99){
            $("#wrapper").toggleClass("toggled");
        }
    }

    function getTiendas(){
        $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:101}).then(function(vResult){
            $scope.arrTiendas=vResult.data; 
        }); 
    }

    function getEmpleados(){
        $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:102, cargo:100}).then(function(vResult){
            $scope.arrEmpleados=vResult.data;
        }); 
    }

    function getCajas(){
        $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:103, tienda:'TGU001', estado:0}).then(function(vResult){
            $scope.arrCajas=vResult.data;
            //alert(vResult.data);
        });
        $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:103, tienda:'TGU001', estado:1}).then(function(vResult){
            $scope.arrCajasOpen=vResult.data;
            //alert(vResult.data);
        }); 
    }

    $scope.change_tab = function(vIndex){
        switch(vIndex){
            case 1:
                $scope.cApertura = true;
                $scope.cTrans = false;
                $scope.cCierre = false;
                $scope.cReports = false;               
                reset_apertura();
                reset_cierre();
            break;
            case 2:
                $scope.cApertura = false;
                $scope.cTrans = true;
                $scope.cCierre = false;                
                $scope.cReports = false;
                reset_apertura();
            break;
            case 3:
                $scope.cApertura = false;
                $scope.cTrans = false;
                $scope.cCierre = true;                 
                $scope.cReports = false;               
                reset_apertura();
                reset_cierre();
            break;
            case 4:
                $scope.cApertura = false;
                $scope.cTrans = false;
                $scope.cCierre = false;                 
                $scope.cReports = true;               
                reset_apertura();
                reset_cierre();
                fill_cierres();
            break;
        }
    }

    $scope.printCierre = function(vC){
        window.open("../reports/printCashCut.php?vC=" + vC.target.id  ,"","width=800, height=600");
    }

    $scope.f_limpiar= function(){
        reset_apertura();
    }

    $scope.f_limpiar2 = function(){
        reset_cierre();
    }

    $scope.f_save = function(){
        var msjR;

        var fech_open = "";

        fech_open = $scope.caja_f_apertura.getFullYear();
        fech_open += "-" + filldate($scope.caja_f_apertura.getMonth()+1);
        fech_open += "-" + filldate($scope.caja_f_apertura.getDate());

        fech_open += " " + filldate($scope.caja_f_apertura.getHours());
        fech_open += ":" + filldate($scope.caja_f_apertura.getMinutes());
        fech_open += ":" + filldate($scope.caja_f_apertura.getSeconds());

        if($scope.caja_tienda != "0" &&  $scope.caja_cajero != "0" &&  $scope.caja_numero != "0" && parseInt($scope.caja_monto) >= 0){
            $http.post('http://192.168.0.254/webropa/server/svrTransacciones.php', {op:201, tienda:$scope.caja_tienda, cajero:$scope.caja_cajero,
                                                                caja:$scope.caja_numero, monto:$scope.caja_monto, f_open:fech_open}).then(function(vResult){
                msjR = vResult.data.split(',');
                if(parseInt(msjR[0])==1){
                    reset_apertura();
                    window.location.reload();
                } 
                alert('Datos Guardados');               
            });
        }else{
            alert('Datos Inconclusos');
        }
       
    }

    $scope.f_detalle = function(){
        $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:105, tienda:'TGU001', caja:$scope.num_caja_c}).then(function(vResult){
            $scope.arrDetalleCaja=vResult.data.detalle;
            $scope.vCierre.vCaja = vResult.data.cierre[0].caja;
            $scope.vCierre.vCajero = vResult.data.cierre[0].cajero;
            $scope.vCierre.vFopen = vResult.data.cierre[0].fopen;
            $scope.vCierre.saldo_ini = vResult.data.cierre[0].saldo_ini;
            $scope.vCierre.saldo_fin = vResult.data.cierre[0].saldo_fin;
            alert($scope.vCierre.vCajero);
        }); 
    }

    $scope.f_save_cierre = function(){
        if($scope.arrDetalleCaja[0].factura.length >0)
        {
            $http.post('http://192.168.0.254/webropa/server/svrTransacciones.php', {op:203, cierre:$scope.vCierre}).then(function(vResult){
                    alert(vResult.data);
                    msjR = vResult.data.split(',');
                        if(parseInt(msjR[0])==1){
                            reset_cierre();
                            alert('Cierre Efectuado');
                            window.location.reload();
                        } 
            });
        }        
    }

    function reset_apertura(){
        $scope.caja_f_apertura = new Date();
        $scope.caja_monto = 0;
        $scope.caja_tienda = "0";
        $scope.caja_cajero = "0";
        $scope.caja_numero = "0";

        $scope.vArr_Cierres = {};

        getTiendas();
        getEmpleados();
        getCajas();
    }

    function reset_cierre(){
        $scope.arrDetalleCaja = [];
        $scope.vCierre = {"vCaja":"", "vCajero":"", "vFopen":"","devs":0,"egresos":0, "sob_fal":0, "saldo_ini":0, "saldo_fin":0};
        $scope.vArr_Cierres = {};
    }

    function fill_cierres(){
        $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:107}).then(function(vResult){
            //alert(vResult.data);
            $scope.vArr_Cierres = vResult.data;
        });
    }

    $(document).ready(function(){
		//alert('Document Ready');
		$("#btn_menu").click(function(e) {
     		e.preventDefault();
    		$("#wrapper").toggleClass("toggled");
		});
		$("#btn_close_menu").click(function(){
    		$("#wrapper").toggleClass("toggled"); 
 		});
	});

});
       

function getParams(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace( 
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;    
    }
    return vars;
}

function filldate(vNumber){
    var ret = "";
    if(vNumber < 10){
        ret = "0" + vNumber;
    }else{
        ret = vNumber
    }
    return ret;
}