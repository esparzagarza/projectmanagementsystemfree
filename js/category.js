var app = angular.module("pmsystem");

app.service("CategoryService", ["$q", "$http", "UrlService",

  function CategoryService($q, $http, UrlService) {

    const api = UrlService.baseUri + "categoryController.php";

    const apiFile = UrlService.baseUri + "uploadFileController.php";

    this.getCategory = function () { var defer = $q.defer(); $http.get(api).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.saveCategory = function (datos) { var defer = $q.defer(); $http.post(api, datos).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.deleteCategory = function (id) { var defer = $q.defer(); $http.delete(api, { data: { "id": id } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.uploadImage = function (fd) { var defer = $q.defer(); $http({ method: 'post', url: apiFile, data: fd, headers: { 'Content-Type': undefined } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; }

  }

]);

app.controller("CategoryCtrl", ["$scope", "LoginService", "CategoryService", function CategoryCtrl($scope, LoginService, CategoryService) {

  LoginService.validateCtrlSession();

  $scope.categorySel = {};

  $scope.getCategory = function () { CategoryService.getCategory().then(function (response) { $scope.alldata = response; }); }

  $scope.getCategory();

  $scope.setcategorySel = function setcategorySel(data) { angular.copy(data, $scope.categorySel); }

  $scope.saveCategory = function saveCategory(datos) {

    datos.action = (datos.id) ? 'edit' : 'add';

    CategoryService.saveCategory(datos).then(function (lastid) {

      datos.id = datos.id ? datos.id : lastid;

      var files = document.getElementById('file').files[0];

      if (files && datos.id) {

        var fd = new FormData();

        fd.append('id', datos.id);

        fd.append('file', files);

        fd.append('module', 'category');

        CategoryService.uploadImage(fd).then(function (filename) {

          datos.image = filename;

          datos.action = 'editimage';

          CategoryService.saveCategory(datos).then(function () { $scope.getCategory(); });

        });

      } else { $scope.getCategory(); }

    });

  }

  $scope.deleteCategory = function deleteCategory(datos) {

    datos.action = 'editstatus';

    datos.status = !datos.status ? 1 : 0; CategoryService.saveCategory(datos);

    if ($scope.user.role == 'root') {

      swal({

        title: "Estas seguro?",

        text: "No podrás recuperarlo!",

        type: "warning",

        showCancelButton: true,

        confirmButtonColor: "#DD6B55",

        confirmButtonText: "Eliminalo, se lo que hago!",

        closeOnConfirm: false

      }, function () { CategoryService.deleteCategory(datos.id).then(function (response) { if (response) swal("Eliminado!", "Ha sido borrado con éxito.", "success"); $scope.getCategory(); }); });

    }

  }

}])