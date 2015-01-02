(function(){
	var app = angular.module('store',[]);
	app.controller("PanelController", ['$http','$scope',function($http,$scope){
		//var pdata=this;
		$scope.search_key="";
		$scope.protocols=[];
		$scope.sections=[
			'Home',
			'Add protocol',
			'Import',
			'Advanced Search',
			'API'			
		];
		this.tab='Home';
		this.selectprotocols=function(modal,bodypart){
			//console.log(bodypart);
			this.tab='Protocols';			
			$http({
				url: 'ajax/get_protocol',
				method: "POST",
				data : {modality:modal,bodypart_full:bodypart}
			}).success(function (data) {
				//console.log(data);
				if (angular.isObject(data)){					
					$scope.protocols=data.slice(0);
				}
				else{
					//console.log(data);
					$scope.protocols=[];
				}
				//console.log($scope.protocols);
				//$scope.users = data;
			}).error(function (data) {
				console.log(data);				
			});
		};	
		this.searchprotocols=function(){
			console.log($scope.search_key);
			this.tab='Protocols';			
			$http({
				url: 'ajax/search_protocol',
				method: "POST",
				data : {content:$scope.search_key}
			}).success(function (data) {
				console.log(data);
				$scope.protocols=data.slice(0);
				//console.log($scope.protocols);				
			}).error(function (data) {
				console.log(data);				
			});	
		};	
		this.isSelected=function(selectTab){
			return this.tab===selectTab;
		};
		this.select=function(setTab){
			this.tab=setTab;
		};	
		
	}]);		
	app.controller("protocolController", ['$http','$scope',function($http,$scope){
		$scope.cred = {protocol_number:"",protocol_name: "",code: "",description: "",modality: "",bodypart: "",bodypart_full: "",approval_date: "",golive_date: "",approved_by: "",series: "",notes: "",indication:"",patient_orientation:"",landmark:"",intravenous_contrast:"",scout:""};
		
		$scope.addprotocol = function() {
			console.log($scope.cred);
			$http({
				url: 'ajax/add_protocol',
				method: "POST",
				data : $scope.cred
			}).success(function (data) {
				console.log(data);
				//$scope.users = data;
			}).error(function (data) {
				console.log(data);				
			});;			
		};
	}]);
	
	
	var base_url="radiology";
	
})();
