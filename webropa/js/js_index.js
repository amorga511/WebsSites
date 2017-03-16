

var appM = angular.module('appMain', []);

appM.controller('appControl1', function($scope,$http) {
   $scope.msj_login = '';
   $scope.user = '';
   $scope.pwd = '';

   $scope.login = function(){
        if($scope.user.length >0 && $scope.pwd.length>0){
            $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:100, usr:$scope.user, pwd:$scope.pwd}).then(function(vResult){
                //alert(vResult.data);
                if(vResult.data.cod==1){
                    //setTimeout(function () { window.location.replace("main.php");}, 2000);
                    window.location.reload();
                    
                }else{
                    //alert(vResult.data);
                    $scope.msj_login = "Error de Usuario o Contraseña";
                }
            });
        }        
   }
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


