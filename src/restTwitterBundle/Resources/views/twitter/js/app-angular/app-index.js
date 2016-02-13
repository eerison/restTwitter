var restTwitterApp = angular.module('restTwitter', ['angular-loading-bar']);

restTwitterApp.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
}]);

restTwitterApp.controller('twitterCtrl', ['$scope', '$http','$timeout', function($scope, $http, $timeout){
    $scope.list = [];
    $scope.nome;
    $scope.enviada = false;
    buscar($scope, $http, true);

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
                    $scope.text     = null;
                    $scope.enviada  = true;
                    buscar($scope, $http,false);
                    $timeout(function () {$scope.enviada = false; }, 2000);
                }
            });
    }

    function buscar($scope, $http, autoload) {
        $http({
            mothod : 'get',
            url : 'twitter.json',
        }).then(function(response) {
            console.log('ok');
            $scope.list = angular.copy(response.data);
        });

        if(autoload)
            $timeout(function(){buscar($scope,$http, true)}, 3000);
    }


}]);