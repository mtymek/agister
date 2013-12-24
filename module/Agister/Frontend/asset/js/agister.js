/**
 * Main Agister JS library
 */

'use strict';

var module = angular.module('agister-frontend', []);


module.controller('AgisterDashboard', ['$scope', '$http', function ($scope, $http) {
    var basePathHelper = function(url) {
        var basePath = angular.element('body').data('base-path');
        return basePath.replace(/\/$/, '') + '/' + url.replace(/^\//, '');
    };

    $http.get(basePathHelper('/api/tasks')).success(function (data) {
        console.dir(data);
        $scope.tasks = data._embedded.tasks;
    })
}]);