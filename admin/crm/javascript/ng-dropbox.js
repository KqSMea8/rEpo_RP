'use strict';

angular.module('DropboxControllers', ['dropbox-picker'])
    .controller('DropBoxCtrl', ['$scope', 'DropBoxSettings', function($scope, DropBoxSettings,$http) {
       //$scope.dpfiles = [];
        //console.log('dfdsf');
       // console.log($scope.dpfiles);
        /*var  data = {
                name: $scope.newFriend.name,
                phone: $scope.newFriend.phone,
                 age: $scope.newFriend.age
                };
        var res = $http.post('../ajax.php', $scope.dpfiles);
		res.success(function(data, status, headers, config) {
			$scope.message = data;
		});
		res.error(function(data, status, headers, config) {
			alert( "failure message: " + JSON.stringify({data: data}));
		});	*/
		
        $scope.remove = function(idx){
            $scope.dpfiles.splice(idx,1);
            }
        
    }]);
