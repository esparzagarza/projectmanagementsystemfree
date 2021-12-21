var app = angular.module("pmsystem");

app.service("ResumeService", ["$q", "$http",

  function ResumeService($q, $http) {

    const apiCategory = "api/controllers/categoryController.php";

    const apiUser = "api/controllers/userController.php";

    const apiProjects = "api/controllers/projectController.php";

    const apiTask = "api/controllers/taskController.php";

    const apiEntes = "api/controllers/enteController.php";

    this.getCountallCategory = function () { const data = { "action": "countall" }; var defer = $q.defer(); $http.post(apiCategory, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getCountallUsers = function () { const data = { "action": "countall" }; var defer = $q.defer(); $http.post(apiUser, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getCountallProjects = function () { const data = { "action": "countall" }; var defer = $q.defer(); $http.post(apiProjects, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getCountperiodProjects = function (days) { const data = { "action": "countperiod", "days": days }; var defer = $q.defer(); $http.post(apiProjects, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getCountallTask = function (days) { const data = { "action": "countall" }; var defer = $q.defer(); $http.post(apiTask, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getCountperiodTask = function (days) { const data = { "action": "countperiod", "days": days }; var defer = $q.defer(); $http.post(apiTask, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getRecentlyaddedtographProjects = function (days) { const data = { "action": "recentlyaddedtograph", "days": days }; var defer = $q.defer(); $http.post(apiProjects, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getRecentlyaddedtographTask = function (days) { const data = { "action": "recentlyaddedtograph", "days": days }; var defer = $q.defer(); $http.post(apiTask, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getCountallContacts = function () { const data = { "action": "countall" }; var defer = $q.defer(); $http.post(apiEntes, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getCountperiodContacts = function (days) { const data = { "action": "countperiod", "days": days }; var defer = $q.defer(); $http.post(apiEntes, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

  }

]);

app.controller("ResumeCtrl", ["$scope", "LoginService", "ResumeService", function ResumeCtrl($scope, LoginService, ResumeService) {

  LoginService.validateCtrlSession();

  $scope.defaultDays = 90;

  $scope.calculate = function calculate(days) {

    $scope.defaultDays = days;

    ResumeService.getCountallCategory().then(function (response) { $scope.CountallCategory = response; });

    ResumeService.getCountperiodProjects(days).then(function (response) { $scope.countperiodProjects = response; });

    ResumeService.getCountallProjects().then(function (response) { $scope.countallProjects = response; });

    ResumeService.getCountperiodTask(days).then(function (response) { $scope.countperiodTask = response; });

    ResumeService.getCountallTask().then(function (response) { $scope.countallTask = response; });

    ResumeService.getCountperiodContacts(days).then(function (response) { $scope.countperiodContacts = response; });

    ResumeService.getCountallContacts().then(function (response) { $scope.countallContacts = response; });

    ResumeService.getRecentlyaddedtographProjects(days).then(function (response) {

      var data = [];

      var labels = [];

      angular.forEach(response, function (item) { data.push(item.total); });

      angular.forEach(response, function (item) { labels.push(item.month + '/' + item.day); });

      $scope.audienceOverview = {

        data: [data],

        labels: labels,

        colors: [{ backgroundColor: "rgba(0, 0, 0, 0)", borderColor: "#27ae60", pointBackgroundColor: "#27ae60" }],

        options: { animation: false, responsive: true, legend: { display: false }, scales: { xAxes: [{ gridLines: { display: false } }] }, tooltips: { mode: "label" } }

      };

    });

    ResumeService.getRecentlyaddedtographTask(days).then(function (response) {

      var data = [];

      var labels = [];

      angular.forEach(response, function (item) { data.push(item.total); });

      angular.forEach(response, function (item) { labels.push(item.month + '/' + item.day); });

      $scope.signups = {

        data: [data],

        labels: labels,

        colors: [{ backgroundColor: "#27ae60", borderColor: "#27ae60" }],

        options: { animation: false, responsive: true, legend: { display: false }, scales: { xAxes: [{ gridLines: { display: false } }] }, tooltips: { mode: "label" } }

      };

    });

  }

  $scope.calculate($scope.defaultDays);

}])