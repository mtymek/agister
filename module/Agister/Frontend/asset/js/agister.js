/**
 * Main Agister JS library
 */

'use strict';

var basePathHelper = function(url) {
    var basePath = angular.element('body').data('base-path');
    return basePath.replace(/\/$/, '') + '/' + url.replace(/^\//, '');
};

var agisterModule = angular.module('agister', []);

agisterModule.controller('AgisterCommonController', ['$scope', '$http', function ($scope, $http) {
    $scope.addTaskFormHidden = true;

    var task = {
        "title": "",
        "hoursMin": 1,
        "hoursMax": 1,
        "description": ""
    };

    $scope.newTask = angular.copy($task);

    $scope.addTask = function () {
        $scope.newTask.hoursMin = $scope.newTask.hoursMax;
        $http.post(basePathHelper('/api/tasks'), $scope.newTask);
    }

}]);

agisterModule.controller('AgisterDashboardController', ['$scope', '$http', function ($scope, $http) {

    $http.get(basePathHelper('/api/timeline/1')).success(function (data) {
        var dateFrom = new Date(data.dateFrom);
        var dateTo = new Date(data.dateTo);

        for (var i in data.tasks) {
            var st = new Date(data.tasks[i].startsAt.date);
            data.tasks[i].scaledStart = Math.round((st.getTime() - dateFrom.getTime())/ 1000) * data.scale;
            data.tasks[i].scaledWidth = data.tasks[i].hoursMax*3600 * data.scale;
        }

        // date markers
        var dateMarkers = [];
        for (var i = dateFrom.getTime(); i < dateTo.getTime(); i += 1000 * 3600 * 24) {
            var d = new Date();
            d.setTime(i);
            dateMarkers.push({
                "seconds": Math.round((i - dateFrom.getTime()) / 1000),
                "date": d
            });
        }

        $scope.timeline = data;
        $scope.timeline.dateMarkers = dateMarkers;
        $scope.dateFrom = dateFrom;
        $scope.dateTo = dateTo;
    })
}]);
