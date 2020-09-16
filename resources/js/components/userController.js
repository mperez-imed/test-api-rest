import '../bootstrap';
import 'angular';

var app = angular.module('Test', [], ['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
}]);

app.controller('userController', ['$scope', '$http', function ($scope, $http) {
    $scope.error = '';
    $scope.users = [];
    $scope.user = {
        rut: '',
        name: '',
        email: '',
        phone: ''
    }

    $scope.loadUsers = function () {
        $http.get('/api/users')
            .then(function success(e) {
                $scope.users = e.data;
            });
    }

    $scope.createUser = function () {
        $http.post('/api/users', {
            rut: $scope.user.rut,
            name: $scope.user.name,
            email: $scope.user.email,
            phone: $scope.user.phone
        }).then(function success(e) {
            window.location = '/';
        }, function error(error) {
            $scope.error = error.data.message;
        });
    }
}]);
