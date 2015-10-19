angular.module('yapp')

.controller("LoginCtrl", ["$scope", "$location", function(s, t) {
 
	$(function () {
		$('.ng-scope').css('backgroundImage','url(images/bar-min.jpg)');
		$('.ng-scope').css('backgroundSize',"100% auto");
		$('.login-page').css('background','rgba(0,0,0,0.5)');
	});
 		
    	
    s.submit = function() {
        return t.path("/dashboard"), !1
    }

}])

.controller("DashboardCtrl", ["$scope", "$state", function(s, t) {
    s.$state = t
}]);