angular.module('yapp')

.controller("LoginCtrl", ["$scope", "$location", function(s, l) {
 
	$(function () {
		$('.ng-scope').css('backgroundImage','url(images/bar-min.jpg)');
		$('.ng-scope').css('backgroundSize',"100% auto");
		$('.login-page').css('background','rgba(0,0,0,0.5)');
	});
 		
    	
    s.submit = function() {
       console.log(s.login,s.pass);
       // return t.path("/dashboard");
    }

}])

.controller("DashboardCtrl", ["$scope", "$state", function(s, t) {
    s.$state = t
}]);