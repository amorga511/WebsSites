


var appM = angular.module('appMain', []);

appM.controller('appControl1', function($scope,$http) {
    $scope.btn_menu = false;
    $scope.dvInicio = true;
    $scope.dvCaja = false;
    $scope.dvFacturacion = false;
    $scope.user_name = "";


    $scope.apptitle = "Inportaciones y Llanticentro JIREH";
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
                window.location.replace('main.php');
            break;
            case 2:
                $scope.dvInicio = false;
                $scope.dvStaff = true;
                $scope.dvPersonalOp = false;              
                window.location.replace('views/caja/index.php');
            break;
            case 3:
                $scope.dvInicio = false;
                $scope.dvStaff = true;
                $scope.dvPersonalOp = false;                
                window.location.replace('views/facturacion/index.php');
            break;
            case 99:
                $http.post('http://192.168.0.254/webllantas/server/svrConsultas.php', {op:104}).then(function(vResult){
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


