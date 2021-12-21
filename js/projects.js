var app = angular.module("pmsystem");

app.service("ProjectService", ["$q", "$http", "UrlService",

  function ProjectService($q, $http, UrlService) {

    const api = UrlService.baseUri + "projectController.php";

    const apiFile = UrlService.baseUri + "uploadFileController.php";

    const apiEnte = UrlService.baseUri + "enteController.php";

    const apiUser = UrlService.baseUri + "userController.php";

    const apiFiles = UrlService.baseUri + "projectfilesController.php";

    const apiTask = UrlService.baseUri + "taskController.php";

    this.getFiles = function (datos) { var defer = $q.defer(); $http.post(apiFiles, datos).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.saveFile = function (datos) { var defer = $q.defer(); $http.post(apiFiles, datos).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.deleteFile = function (id) { var defer = $q.defer(); $http.delete(apiFiles, { data: { "id": id } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getUsers = function () { var defer = $q.defer(); $http.get(apiUser).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getEntes = function () { var defer = $q.defer(); $http.get(apiEnte).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getProjects = function () { var defer = $q.defer(); $http.get(api).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.saveProject = function (datos) { var defer = $q.defer(); $http.post(api, datos).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.deleteProject = function (id) { var defer = $q.defer(); $http.delete(api, { data: { "id": id } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.uploadFile = function (fd) { var defer = $q.defer(); $http({ method: 'post', url: apiFile, data: fd, headers: { 'Content-Type': undefined } }).then(function (response) { defer.resolve(response.data); }); return defer.promise; }

    this.getTask = function (datos) { var defer = $q.defer(); $http.post(apiTask, datos).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

  }

]);

app.controller("ProjectsCtrl", ["$scope", "LoginService", "ProjectService", "DTOptionsBuilder", "DTColumnBuilder",

  function ProjectsCtrl($scope, LoginService, ProjectService, DTOptionsBuilder, DTColumnBuilder) {

    LoginService.validateCtrlSession();

    $scope.projectSel = {};

    $scope.selectedItem = {};

    ProjectService.getUsers().then(function (response) { $scope.allusers = response; });

    ProjectService.getEntes().then(function (response) { $scope.allentes = response; if (!$scope.selectedItem) { response.map(function (i) { if (i.id === 1) { $scope.selectedItem = i; } }); } });

    $scope.getFiles = function (data) { ProjectService.getFiles(data).then(function (response) { $scope.allfiles = response; }); }

    var vm = this;

    vm.dtOptions = DTOptionsBuilder

      .fromFnPromise(function () { return ProjectService.getProjects(); })

      .withDOM(`<"row"<"col-sm-6"i><"col-sm-6"f>><"table-responsive"tr><"row"<"col-sm-6"l><"col-sm-6"p>>`)

      .withBootstrap()

      .withLanguage({ paginate: { previous: "&laquo;", next: "&raquo;", }, search: "_INPUT_", searchPlaceholder: "Buscar ..." })

      .withDisplayLength(10)

      .withOption('order', [0, 'desc'])

      .withOption('lengthMenu', [10, 50, 100, 500])

      .withOption("responsive", true)

      .withOption('rowCallback', rowCallback);

    vm.dtColumns = [

      DTColumnBuilder.newColumn("id", "Folio").withOption('class', 'text-center'),

      DTColumnBuilder.newColumn("name", "Proyecto"),

      DTColumnBuilder.newColumn(null, "Cliente").renderWith(function (data, type, full) { return '<img src="' + full.eimage + '" class="img-circle" width="50" height="50" /> ' + full.efullname; }),

      DTColumnBuilder.newColumn(null, "Responsable").renderWith(function (data, type, full) { return '<img src="' + full.uimage + '" class="img-circle" width="50" height="50" /> ' + full.ufullname; }),

      DTColumnBuilder.newColumn("progress", "Progreso").withOption('class', 'text-center').renderWith(function (data) { return '<div class="progress progress-sm m-y-0"><div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + data + '%"><span class="sr-only">' + data + '% Complete</span></div></div>' + data + '%'; }),

      DTColumnBuilder.newColumn("status", "Estatus").withOption('class', 'text-center').renderWith(function (data) { return '<a class="btn-link">' + data + '</a>'; })

    ];

    vm.newSource = function () { return ProjectService.getProjects(); }

    vm.reloadData = reloadData;

    vm.dtInstance = {};

    function reloadData() { vm.dtInstance.reloadData(callback, false); }

    function callback(json) { console.log(json); }

    function rowCallback(nRow, aData, iDisplayIndex, iDisplayIndexFull) {

      $('td', nRow).unbind('click');

      $('td', nRow).bind('click', function () { $scope.$apply(function () { $scope.setprojectSel(aData); $scope.showPrint('print'); }); });

      return nRow;

    }

    $scope.fillTextbox = function (obj) { $scope.selectedItem = obj; $scope.item = obj.fullname; $scope.filterItem = null; }

    $scope.complete = function (string) {

      if (string != null && string.length >= 2) {

        var output = []; $scope.selectedItem = null; angular.forEach($scope.allentes, function (response) { if (response.fullname.toLowerCase().indexOf(string.toLowerCase()) >= 0) { output.push(response); } }); $scope.filterItem = output;

      }

    }

    $scope.showPrint = function (div) { $scope.divPrint = div; }

    $scope.resetprojectSel = function () {

      $scope.message = "Favor de completar los campos";

      $scope.ente = '';

      $scope.datos = {};

      $scope.allfiles = {};

      $scope.projectSel = {};

      $scope.selectedItem = null;

      $scope.filterEnte = null;

      $scope.projectSel.responsibleid = 1;

      angular.forEach($scope.allentes, function (response) { if (response.id === 1) { $scope.selectedItem = response; } });

      $scope.showPrint('newForm');

      document.getElementById('projectname').focus();

    }

    $scope.setprojectSel = function (data) {

      angular.copy(data, $scope.projectSel);

      angular.forEach($scope.allentes, function (response) { if (response.id === data.enteid) { $scope.selectedItem = response; } });

      data.action = 'projects';

      $scope.getFiles(data);

      ProjectService.getTask(data).then(function (response) { $scope.alltask = response; });

    }

    $scope.saveProject = function (datos) {

      if ($scope.selectedItem != null) {

        datos.action = (datos.id) ? 'edit' : 'add';

        datos.enteid = $scope.selectedItem.id;

        ProjectService.saveProject(datos).then(function (lastid) {

          datos.id = datos.id ? datos.id : lastid;

          var files = document.getElementById('file').files[0];

          if (files && datos.id) {

            var fd = new FormData();

            fd.append('id', datos.id);

            fd.append('file', files);

            fd.append('module', 'project');

            ProjectService.uploadFile(fd).then(function (filename) {

              datos.title = files.name;

              datos.src = filename;

              datos.action = 'add';

              ProjectService.saveFile(datos).then(function () { datos.action = 'projects'; $scope.getFiles(datos); });

            });

          } else { vm.dtInstance.changeData(vm.newSource); $scope.showPrint('info'); }

        });

      } else { $scope.message = "Mensaje: Favor de Seleccionar al Cliente"; }

    }

    $scope.deleteProject = function (datos, status) {

      datos.action = 'editstatus';

      datos.status = status;

      ProjectService.saveProject(datos);

      if ($scope.user.role == 'root') {

        swal({

          title: "Estas seguro?",

          text: "No podrás recuperarlo!",

          type: "warning",

          showCancelButton: true,

          confirmButtonColor: "#DD6B55",

          confirmButtonText: "Eliminalo, se lo que hago!",

          closeOnConfirm: false

        }, function () { ProjectService.deleteProject(datos.id).then(function (response) { if (response) swal("Eliminado!", "Ha sido borrado con éxito.", "success"); vm.dtInstance.changeData(vm.newSource); }); });

      }

    }

    $scope.deleteFile = function (datos) {

      datos.action = 'editstatus';

      datos.status = !datos.status ? 1 : 0;

      ProjectService.saveFile(datos);

      if ($scope.user.role == 'root') {

        swal({

          title: "Estas seguro?",

          text: "No podrás recuperarlo!",

          type: "warning",

          showCancelButton: true,

          confirmButtonColor: "#DD6B55",

          confirmButtonText: "Eliminalo, se lo que hago!",

          closeOnConfirm: false

        }, function () { ProjectService.deleteFile(datos.id).then(function (response) { if (response) { swal("Eliminado!", "Ha sido borrado con éxito.", "success"); datos.action = 'projects'; $scope.getFiles(datos); } }); });

      }

    }

    $scope.showPrint('info');

  }])