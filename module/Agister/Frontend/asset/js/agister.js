/**
 * Main Agister JS library
 */

'use strict';

var basePathHelper = function(url) {
    var basePath = angular.element('body').data('base-path');
    return basePath.replace(/\/$/, '') + '/' + url.replace(/^\//, '');
};

var agisterModule = angular.module('agister', []);

agisterModule.factory('$agisterTimeline', ['$http', function ($http) {

    var apiUrl = basePathHelper('/api/timeline/1');
    return {
        "loadInto": loadInto
    }

    function loadInto($scope) {
        $http.get(apiUrl).success(function (data) {
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
        })
    }
}]);

agisterModule.controller('AgisterDashboardController',
    ['$scope', '$http', '$filter', '$agisterTimeline', function ($scope, $http, $filter, $agisterTimeline) {

        $scope.addTaskFormHidden = true;
        $scope.taskDetailsVisible = false;

        var task = {
            "title": "",
            "hoursMin": 1,
            "hoursMax": 1,
            "description": ""
        };

        var currentTask;

        $scope.newTask = angular.copy(task);

        $scope.addTask = function () {
            $scope.newTask.hoursMin = $scope.newTask.hoursMax;
            $http.post(basePathHelper('/api/tasks'), $scope.newTask)
                .success(function (data) {
                    $agisterTimeline.loadInto($scope);
                });
        }

        $scope.loadTaskDetails = function (id) {
            $http.get(basePathHelper('/api/tasks/' + id)).success(function (data) {
                currentTask = data;

                var startsAt = new Date(data.startsAt.date);
                var finishesAt = new Date(data.startsAt.date);
                finishesAt.setHours(finishesAt.getHours() + data.hoursMax);

                $scope.taskDetailsVisible = true;
                $scope.currentTask =  {
                    "id": currentTask.id,
                    "title": currentTask.title,
                    "details": currentTask.details,
                    "startsAt": $filter('date')(startsAt, "yyyy-MM-dd H:mm"),
                    "finishesAt": $filter('date')(finishesAt, "yyyy-MM-dd H:mm")
                };
            });
        }

        $scope.deleteTask = function (id) {
            $http.delete(basePathHelper('/api/tasks/' + id))
                .success(function () {
                    $agisterTimeline.loadInto($scope);
                });
        }

        $agisterTimeline.loadInto($scope);
    }]
);
