"use strict";

angular

  .module("pmsystem", ["ngSanitize", "ngAnimate", "ui.mask", "ui.router", "ui.bootstrap", "oc.lazyLoad"])

  .service("LoginService", ["$rootScope", "$http", "$q", "$location", "UrlService", function LoginService($rootScope, $http, $q, $location, UrlService) {

    const api = UrlService.baseUri + "loginController.php";

    this.login = function login(datos) { var defer = $q.defer(); $http.post(api, datos).then(function (data) { defer.resolve(data); }); return defer.promise; };

    this.getAppData = function getAppData() { var defer = $q.defer(); defer.resolve({ "version": "2.0.0", "appname": "Project Management System", "autor": "ESPARZA GARZA", "year": 2021, "website": "https://esparzagarza.mx/", "company": "ESPARZA GARZA", "sufix": "EG", "fulladdress": { "address": "Your address here", "col": "", "city": "", "state": "", "zipcode": "", "country": "" }, "phone": "+52 (664) 174 3344" }); return defer.promise; };

    this.isActiveSession = function isActiveSession() { var defer = $q.defer(); $http.post(api, { "action": "isactivesession" }).then(function (data) { defer.resolve(data.data); }); return defer.promise; };

    this.getActiveSession = function getActiveSession() { var defer = $q.defer(); $http.post(api, { "action": "getactivesession" }).then(function (data) { defer.resolve(data.data); }); return defer.promise; };

    this.getLogout = function getLogout() { var defer = $q.defer(); $http.post(api, { "action": "logout" }).then(function () { defer.resolve(); }); return defer.promise; };

    this.validateLoginSession = function validateLoginSession() { var that = this; that.isActiveSession().then(function (isActiveSession) { if (isActiveSession) { that.getAppData().then(function (data) { $rootScope.config = data; that.getActiveSession().then(function (data) { $rootScope.user = data; $location.path("/"); }) }) } }) }

    this.validateCtrlSession = function validateCtrlSession() { this.isActiveSession().then(function (isActiveSession) { if (!isActiveSession) { $location.path("/login"); } else { if ($rootScope.user.role == 'admin' | $rootScope.user.role == 'root') $rootScope.sidebarAdmin = true; } }) }

  }]);