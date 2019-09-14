"use strict";
angular.module('gdo6').
controller('GDOTagCtrl', function($scope){
	$scope.init = function(id, config) {
		console.log('GDOTagCtrl.init()', id, config);
		$scope.data = {
			tags: config.tags,
			allTags: config.all,
			hiddenId: id
		};
	};
	
	$scope.onChange = function() {
		$($scope.data.hiddenId).val(JSON.stringify($scope.tags));
	};
	
	$scope.completeTags = function(searchText) {
		var result = [];
		for (var i in $scope.data.allTags) {
			var tag = $scope.data.allTags[i];
			if (tag.toLowerCase().indexOf(searchText.toLowerCase()) >= 0) {
				result.push(tag);
			}
		}
		return result;
	};
	
});
