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

    var apiUrl = basePathHelper('/api/tasks');
    return {
        "loadInto": loadInto
    }

    function loadInto($scope) {
        $http.get(apiUrl).success(function (data) {

            var tasks = data._embedded.tasks;

            var dateFrom = moment('2050-01-01 00:00:00');
            var dateTo = moment(0);

            // find how tasks are spread on timeline
            for (var i in tasks) {
                var start = moment(tasks[i].startsAt.date);
                var finish = moment(tasks[i].finishesAtMax.date);

                if (dateFrom > start) {
                    dateFrom = start;
                }
                if (dateTo < finish) {
                    dateTo = finish;
                }
            }

            dateFrom = angular.copy(dateFrom).day(-2);
            dateTo = angular.copy(dateTo).day(8);

            var scale = 100 / (dateTo.unix() - dateFrom.unix());

            for (var i in tasks) {
                var start = moment(tasks[i].startsAt.date);
                var finish = moment(tasks[i].finishesAtMax.date);
                tasks[i].scaledStart = Math.round((start.unix() - dateFrom.unix())) * scale;
                tasks[i].scaledWidth = Math.round((finish.unix() - dateFrom.unix())) * scale - tasks[i].scaledStart;
            }

            // date markers
            var dateMarkers = [];
            for (var i = dateFrom.unix(); i < dateTo.unix(); i += 3600 * 24) {
                var d = moment.unix(i);
                dateMarkers.push({
                    "seconds": Math.round((i - dateFrom.unix())),
                    "scale": scale,
                    "date": d.format("D/M")
                });
            }

            $scope.tasks = tasks;
            $scope.dateMarkers = dateMarkers;
        })
    }
}]);

agisterModule.controller('AgisterDashboardController',
    ['$scope', '$http', '$filter', '$agisterTimeline', function ($scope, $http, $filter, $agisterTimeline) {

        $scope.addTaskFormVisible = false;
        $scope.taskDetailsVisible = false;

        var task = {
            "title": "",
            "hoursMin": 1,
            "hoursMax": 1,
            "details": ""
        };

        var currentTask;

        $scope.newTask = angular.copy(task);

        $scope.addTask = function () {
            $scope.newTask.hoursMin = $scope.newTask.hoursMax;
            $http.post(basePathHelper('/api/tasks'), $scope.newTask)
                .success(function (data) {
                    $agisterTimeline.loadInto($scope);
                });
            $scope.newTask = angular.copy(task);
        }

        $scope.loadTaskDetails = function (id) {
            $http.get(basePathHelper('/api/tasks/' + id)).success(function (data) {
                currentTask = data;

                var startsAt = new Date(data.startsAt.date);
                var finishesAt = new Date(data.finishesAtMax.date);

                $scope.taskDetailsVisible = true;

                if (currentTask.hoursMin != currentTask.hoursMax) {
                    var estimate = currentTask.hoursMin + 'h - ' + currentTask.hoursMax + 'h'
                } else {
                    var estimate = currentTask.hoursMin + 'h';
                }

                $scope.currentTask =  currentTask;
                // "view model"
                $scope.currentTaskViewModel =  {
                    "estimate": estimate,
                    "startsAt": $filter('date')(startsAt, "yyyy-MM-dd"),
                    "finishesAt": $filter('date')(finishesAt, "yyyy-MM-dd")
                };
            });
        }

        $scope.deleteTask = function (id) {
            $http.delete(basePathHelper('/api/tasks/' + id))
                .success(function () {
                    $agisterTimeline.loadInto($scope);
                    $scope.taskDetailsVisible = false;
                });
        }

        $scope.completeTask = function (id) {
            $http.put(basePathHelper('/api/tasks/' + id), { "completed": 1 })
                .success(function () {
                    $agisterTimeline.loadInto($scope);
                });
        }

        $agisterTimeline.loadInto($scope);
    }]
);
