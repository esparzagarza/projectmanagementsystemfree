var app = angular.module("pmsystem");

app.service("UserService", ["$q", "$http", "UrlService",

  function UserService($q, $http, UrlService) {

    const api = UrlService.baseUri + "userController.php";

    const apiFile = UrlService.baseUri + "uploadFileController.php";

    this.getUsers = function getUsers() { var defer = $q.defer(); $http.get(api).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.saveUser = function saveUser(datos) { var defer = $q.defer(); $http.post(api, datos).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.deleteUser = function saveUser(id) { var defer = $q.defer(); $http.delete(api, { data: { "id": id } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.uploadImage = function uploadImage(fd) { var defer = $q.defer(); $http({ method: 'post', url: apiFile, data: fd, headers: { 'Content-Type': undefined } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; }

  }

]);

app.controller("UsersCtrl", ["$scope", "LoginService", "UserService", function UsersCtrl($scope, LoginService, UserService) {

  LoginService.validateCtrlSession();

  $scope.userSel = {};

  $scope.alldata = {};

  $scope.getUsers = function () { UserService.getUsers().then(function (data) { $scope.alldata = data; }); }

  $scope.setuserSel = function setuserSel(data) { angular.copy(data, $scope.userSel); $scope.userSel.password = null; }

  $scope.newForm = function () {
    $scope.userSel = {};
    $scope.userSel.role = 'user';
  }

  $scope.saveUser = function saveUser(datos) {

    datos.action = (datos.id) ? 'edit' : 'add';

    UserService.saveUser(datos).then(function (lastid) {

      datos.id = datos.id ? datos.id : lastid;

      var files = document.getElementById('file').files[0];

      if (datos.password) { datos.action = 'editpassword'; UserService.saveUser(datos); }

      if (files && datos.id) {

        var fd = new FormData();

        fd.append('id', datos.id);

        fd.append('file', files);

        fd.append('module', 'user');

        UserService.uploadImage(fd).then(function (filename) {

          datos.image = filename;

          datos.action = 'editimage';

          UserService.saveUser(datos).then(function () { $scope.getUsers(); });

        });

      } else { $scope.getUsers(); }

    });

  }

  $scope.deleteUser = function deleteUser(datos) {

    datos.action = 'editstatus';

    datos.status = !datos.status ? 1 : 0;

    UserService.saveUser(datos);

    if ($scope.user.role == 'root') {

      swal({

        title: "Estas seguro?",

        text: "No podrás recuperarlo!",

        type: "warning",

        showCancelButton: true,

        confirmButtonColor: "#DD6B55",

        confirmButtonText: "Eliminalo, se lo que hago!",

        closeOnConfirm: false

      }, function () { UserService.deleteUser(datos.id).then(function (response) { if (response) swal("Eliminado!", "Ha sido borrado con éxito.", "success"); $scope.getUsers(); }); });

    }

  }

  $scope.getUsers();
  $scope.newForm();
}])