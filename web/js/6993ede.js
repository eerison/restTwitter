var restTwitterApp = angular.module('restTwitter', ['angular-loading-bar'])
    .config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
}]);

restTwitterApp.controller('twitterCtrl', ['$scope', '$http', function($scope, $http){
    $scope.list = [];
    $scope.nome;
    buscar($scope, $http);

    $scope.submit = function() {
        $http({
            method: 'post',
            url: '/twitter/add.json',
            data: {
                text : this.text,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }
        }).then(function(response) {
                if(response.status == 200){
                    buscar($scope, $http);
                }
            });
    }

    function buscar($scope, $http) {
        $http({
            mothod : 'get',
            url : 'twitter.json',
        }).then(function(response) {
            console.log('ok');
            $scope.list = angular.copy(response.data);
        });
    }



}]);