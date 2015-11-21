angular.module('yapp')

.controller("LoginCtrl", ["$scope", "$http", "$cookieStore", "$location", function(s, h, cks, l) {
 
	$(function () {
		$('.ng-scope').css('backgroundImage','url(images/bar-min.jpg)');
		$('.ng-scope').css('backgroundSize',"100% auto");
		$('.login-page').css('background','rgba(0,0,0,0.5)');
	});
 		
    	
    s.submit = function() {
       //console.log(s.login,s.pass);
       h({
		 method: 'POST',
		 url: '/API/authentication.json',
		 headers: {
		   'Content-Type': 'application/json'
		 },
		 data: { Email: s.login, Password: s.pass }
		}).then(function successCallback(response) {
		    
		    cks.put('SyCON', JSON.stringify(response.data));
		    //cks.get('CookieName');
			return l.path("/dashboard");
		    // this callback will be called asynchronously
		    // when the response is available
		  }, function errorCallback(response) {
		  	console.log('Faiado');
		    // called asynchronously if an error occurs
		    // or server returns response with an error status.
		  });
    }

}])

.controller("DashboardCtrl", ["$scope", "$state", function(s, t) {
    s.$state = t
}]);