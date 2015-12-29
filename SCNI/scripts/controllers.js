angular.module('yapp')

.factory('globalservice', [ '$rootScope', "$http", "$cookieStore",  function (rs, h, cks) {
    
    rs.ClientID = 0;    

    return {
        setLogon: function(data) {
            cks.put('SyCON', JSON.stringify(data));
            return true;
        },
        getClientID: function() {
        	rs.ClientID = JSON.parse(cks.get('SyCON'));
        	rs.ClientID = rs.ClientID.Client_ID;
            return rs.ClientID;
        },
        registerCommand: function(ClientID, command, product, qtd){
        	var dataAtual = new Date();

        	rs.addZero = function(i) {
			    if (i < 10) {
			        i = "0" + i;
			    }
			    return i;
			}


        	h({
				method: 'POST',
				url: '/API/commandproduct.json',
				headers: {
					'Content-Type': 'application/json'
				},
				data: { 
					Client_ID: ClientID,
				    Commands_ID: command.Commands_ID,
				    Sale_ID: "0",
				    Product_ID: product.Product_ID,
				    Date: 
				    	dataAtual.getFullYear() + "-" +
				    	dataAtual.getMonth() + "-" +
				    	dataAtual.getDate(),
				    Quantity: qtd,
				    Flag: "O"
				 }
				}).then(function successCallback(response) {

					console.log(response);
					//gs.setLogon(response.data);
					//cks.get('CookieName');
					//return l.path("/dashboard");
					// this callback will be called asynchronously
					// when the response is available
				}, function errorCallback(response) {
					// console.log('Faiado');
					// called asynchronously if an error occurs
					// or server returns response with an error status.
				});
        	console.log(ClientID,command,product);
		}

    };
}])

.controller("LoginCtrl", ["$scope", "$http", "globalservice", "$location", function(s, h, gs, l) {
 
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
		    
		    gs.setLogon(response.data);
			return l.path("/dashboard");
		  }, function errorCallback(response) {
		  });
    }

}])
.controller('ModalInstanceCtrl', [ "$scope", "$uibModalInstance", "items", function (s, umi, i) {

  s.items = i;
  s.selected = {
    item: s.items[0]
  };

  s.ok = function () {
    alert('PEgaaa Entao Malandro');
    umi.close(s.selected.item);
  };

  s.cancel = function () {
    umi.dismiss('cancel');
  };

}])

.controller("CaixaCtrl", ["$scope", "$http", "$cookieStore", "$location", "$uibModal", "globalservice", function(s, h, cks, l, um, gs){
	
	s.product = {};

	s.cammandTable = [];

	s.pesquisarComanda = function(comanda){
		// Se a pesquisa for vazia
		if (comanda == ""){

			// Retira o autocomplete
			s.completing = false;

		}else{
			s.cammandTable = [];
			// Pesquisa no banco via AJAX
			h.get('/API/commandproduct/All.json/' + gs.getClientID() + '/'+comanda).
	        success(function(data) {
	        	if(Object.keys(data).length){
		        	angular.forEach(data, function(row) {
		        		console.log(row);
					  	s.cammandTable.push({	
							Cod: row.Product_ID, 
							Prod: row.Name,
							Qtd: row.Quantity,
							Val: row.Price,
							Command_Product_ID: row.Command_Product_ID
						});
					});
	        	}else{
	        		s.cammandTable = [];

	        	}
	        	//s.cammandTable = data;
				
	        })
	        .error(function(data) {
				// Se deu algum erro, mostro no log do console
				console.log("Ocorreu um erro no banco de dados ao trazer auto-ajuda da home");
	        });		
		}
	}
	

	s.pesquisarName = function(pesquisa){

		// Se a pesquisa for vazia
		if (pesquisa == ""){

			// Retira o autocomplete
			s.completing = false;

		}else{

			// Pesquisa no banco via AJAX
			h.get('/API/product/Search.json/' + gs.getClientID() + '/' + pesquisa).
	        success(function(data) {

				// Coloca o autocomplemento
				s.completing = true;	

				//console.log(data);
				// JSON retornado do banco
				s.dicas = data;     
	        })
	        .error(function(data) {
				// Se deu algum erro, mostro no log do console
				console.log("Ocorreu um erro no banco de dados ao trazer auto-ajuda da home");
	        });		
		}
	};

	s.pickItem = function(item){
		//console.log(item);
		s.search = item.Name;
		s.product = item;
		s.completing = false;
	}

	

	s.putIntoCommand = function() {

		h.get('/API/commands/getByRef.json/' + gs.getClientID() + '/'+s.comanda)
			.success(function(data) {
				s.command = data;
	        })
	        .error(function(data) {
				// Se deu algum erro, mostro no log do console
				console.log("Ocorreu um erro no banco de dados ao trazer auto-ajuda da home");
	        }).then(function(){	

				if(!Object.keys(s.product).length){
					alert('Iniciando Ajax');
					h.get('/API/product/' + gs.getClientID() + '/'+s.codprod).
			        success(function(data) {
						s.productCommand = data;	
			        })
			        .error(function(data) {
						// Se deu algum erro, mostro no log do console
						console.log("Ocorreu um erro no banco de dados ao trazer auto-ajuda da home");
			        }).then(function(){	
			    	    console.log(s.productCommand);
			    	    s.cammandTable.push({	
							Cod: s.productCommand.Product_ID, 
							Prod: s.productCommand.Name,
							Qtd: s.qtd,
							Val: s.productCommand.Quantity
						});
			    	    gs.registerCommand(gs.getClientID(), s.command, s.productCommand, s.qtd);
					});
				}else{
					s.productCommand = s.product;	
					//console.log(s.productCommand.Name);
					s.cammandTable.push({	
						Cod: s.productCommand.Product_ID, 
						Prod: s.productCommand.Name,
						Qtd: s.qtd,
						Val: s.productCommand.Quantity
					});
					gs.registerCommand(gs.getClientID(), s.command, s.productCommand, s.qtd);
				}
		
		});
		
	}

	s.delete = function(ido, idx){
		h({ url: '/API/commandproduct.json/' + gs.getClientID() + '/'+ido, 
                method: 'DELETE', 
                headers: {"Content-Type": "application/json;charset=utf-8"}
        }).then(function(res) {
            s.cammandTable.splice(idx, 1);
        }, function(error) {
            console.log(error);
        });
	}

	s.clear = function(){
		s.comanda = '';
		s.cammandTable = [];
	}

	s.items = ['item1', 'item2', 'item3'];

	s.animationsEnabled = true;

	s.checkout = function(size){

		    var modalInstance = um.open({
		      animation: s.animationsEnabled,
		      templateUrl: 'myModalContent.html',
		      controller: 'ModalInstanceCtrl',
		      size: size,
		      resolve: {
		        items: function () {
		          return s.items;
		        }
		      }
		    });

		    modalInstance.result.then(function (selectedItem) {
		      s.selected = selectedItem;
		    }, function () {
		      $log.info('Modal dismissed at: ' + new Date());
		    });

	}

	s.toggleAnimation = function () {
		    s.animationsEnabled = !s.animationsEnabled;
		  };

}])

.controller("DashboardCtrl", ["$scope", "$state", function(s, t) {
    s.$state = t
}]);