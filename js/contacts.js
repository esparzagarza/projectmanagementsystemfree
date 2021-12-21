var app = angular.module("pmsystem");

app.service("ContactService", ["$q", "$http", "UrlService",

  function ContactService($q, $http, UrlService) {

    const apiEnte = UrlService.baseUri + "enteController.php";

    const apiImage = UrlService.baseUri + "uploadFileController.php";


    this.getContacts = function () { var defer = $q.defer(); $http.get(apiEnte).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.saveContact = function (data) { var defer = $q.defer(); $http.post(apiEnte, data).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.deleteContact = function (id) { var defer = $q.defer(); $http.delete(apiEnte, { data: { "id": id } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.uploadImage = function (fd) { var defer = $q.defer(); $http({ method: 'post', url: apiImage, data: fd, headers: { 'Content-Type': undefined } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; }

  }

]);

app.controller("ContactCtrl", ["$scope", "LoginService", "ContactService", function ContactCtrl($scope, LoginService, ContactService) {

  LoginService.validateCtrlSession();

  $scope.sidebar = {};

  $scope.allcontacts = {};

  $scope.contacts = {};

  $scope.groupedContacts = {};

  $scope.found = 0;

  $scope.sidebar.isActive = true;

  $scope.currentType = '';

  $scope.editForm = false;

  $scope.getContacts = function (type) {

    $scope.currentType = type;

    ContactService.getContacts().then(function (response) {

      let result;

      if (type) {

        result = response.filter(i => i.type == type);

        $scope.found = result.length;

        $scope.groupedContacts = _.groupBy(result, function (i) { return i.fullname.charAt(0); });

      }

      else { $scope.groupedContacts = _.groupBy(response, function (i) { return i.fullname.charAt(0); }); $scope.found = response.length; }

    });

  }

  $scope.showForm = function (type) {

    document.getElementById('contactForm').reset();

    document.getElementById('contactfullname').focus();

    $scope.currentContact = {};

    $scope.currentContact.type = type;

    $scope.currentContact.status = true;

    $scope.currentContact.country = 'Mexico';

    $scope.currentContact.level = 1;

    $scope.editForm = true;

  }

  $scope.show = function (contact) {

    $scope.editForm = false;

    $scope.currentContact = contact;

    $scope.setSidebarInactive().scrollTop();

  };

  $scope.setSidebarActive = function () { $scope.sidebar.isActive = true; return this; };

  $scope.setSidebarInactive = function () { $scope.sidebar.isActive = false; return this; };

  $scope.scrollTop = function () { window.scrollTo(0, 0); return this; };

  $scope.saveContact = function (datos) {

    datos.action = datos.id ? 'edit' : 'add';

    ContactService.saveContact(datos).then(function (data) {

      datos.id = datos.id ? datos.id : data;

      var fd = new FormData();

      var files = document.getElementById('file').files[0];

      if (files && datos.id) {

        fd.append('file', files);

        fd.append('id', datos.id);

        fd.append('module', 'ente');

        ContactService.uploadImage(fd).then(function (filename) {

          $scope.currentContact.image = filename;

          datos.image = filename;

          datos.action = 'editimage';

          ContactService.saveContact(datos).then(function () { $scope.getContacts($scope.currentType); });

        });

      } else { $scope.getContacts($scope.currentType); }

      document.getElementById('file').value = null;

    });

    $scope.editForm = false;

  }

  $scope.deleteContact = function (datos) {

    datos.action = 'edit';

    datos.status = !datos.status ? 1 : 0;

    ContactService.saveContact(datos);

    if ($scope.user.role == 'root') {

      swal({

        title: "Estas seguro?",

        text: "No podrás recuperarlo!",

        type: "warning",

        showCancelButton: true,

        confirmButtonColor: "#DD6B55",

        confirmButtonText: "Eliminalo, se lo que hago!",

        closeOnConfirm: false

      }, function () { ContactService.deleteContact(datos.id).then(function (data) { if (data) swal("Eliminado!", "Ha sido borrado con éxito.", "success"); $scope.getContacts($scope.currentType); }); });

    }

  };

  $scope.getContacts($scope.currentType);

}]);