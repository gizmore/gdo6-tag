"use strict";
angular.module('gdo6').
controller('GDOTagCtrl', function($scope){
	$scope.init = function(id, config) {
		console.log('GDOTagCtrl.init()', id, config);
		$scope.tags = config.tags;
		$scope.allTags = config.all;
		$scope.hiddenId = id;
	};
	
	$scope.onChange = function() {
		$($scope.hiddenId).val(JSON.stringify($scope.tags));
	};
	
	$scope.completeTags = function(searchText) {
		var result = [];
		for (var i in $scope.allTags) {
			var tag = $scope.allTags[i];
			if (tag.toLowerCase().indexOf(searchText.toLowerCase()) >= 0) {
				result.push(tag);
			}
		}
		return result;
	};
	
});
