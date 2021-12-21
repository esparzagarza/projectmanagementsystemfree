var app = angular.module("pmsystem");

app.service("TaskService", ["$q", "$http", "UrlService",

  function TaskService($q, $http, UrlService) {

    const api = UrlService.baseUri + "taskController.php";

    const apiEnte = UrlService.baseUri + "enteController.php";

    const apiProject = UrlService.baseUri + "projectController.php";

    const apiCategory = UrlService.baseUri + "categoryController.php";

    const apiUser = UrlService.baseUri + "userController.php";

    this.getTask = function () { var defer = $q.defer(); $http.get(api).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.saveTask = function (datos) { var defer = $q.defer(); $http.post(api, datos).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getEntes = function () { var defer = $q.defer(); $http.get(apiEnte).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getProjects = function () { var defer = $q.defer(); $http.get(apiProject).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getCategories = function () { var defer = $q.defer(); $http.get(apiCategory).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.getUsers = function () { var defer = $q.defer(); $http.get(apiUser).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

    this.saveProject = function (datos) { var defer = $q.defer(); $http.post(apiProject, datos).then(function (response) { defer.resolve(response.data); }); return defer.promise; };

  }

]);

app.controller("TaskCtrl", ["$scope", "LoginService", "TaskService", "$filter", "DTOptionsBuilder", "DTColumnBuilder", "$compile",

  function TaskCtrl($scope, LoginService, TaskService, $filter, DTOptionsBuilder, DTColumnBuilder, $compile) {

    LoginService.validateCtrlSession();

    $scope.taskSel = {};

    $scope.selectedItem = {};

    TaskService.getProjects().then(function (response) { $scope.allprojects = response; });

    TaskService.getCategories().then(function (response) { $scope.allcategories = response; });

    TaskService.getUsers().then(function (response) { $scope.allusers = response; });

    TaskService.getEntes().then(function (response) { $scope.allentes = response; if (!$scope.selectedItem) { response.map(function (i) { if (i.id === 1) { $scope.selectedItem = i; } }); } });

    var vm = this;

    vm.dtOptions = DTOptionsBuilder

      .fromFnPromise(function () { return TaskService.getTask(); })

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

      DTColumnBuilder.newColumn("type", "Tipo").withOption('class', 'text-center').renderWith(function (data) { return $filter('capitalize')(data) }),

      DTColumnBuilder.newColumn("duedate", "Fecha").withOption('class', 'text-center'),

      DTColumnBuilder.newColumn("pname", "Projecto"),

      DTColumnBuilder.newColumn(null, "Cliente").renderWith(function (data, type, full) { return '<img src="' + full.eimage + '" class="img-circle" width="50" height="50" /> ' + full.efullname; }),

      DTColumnBuilder.newColumn(null, "Responsable").renderWith(function (data, type, full) { return '<img src="' + full.uimage + '" class="img-circle" width="50" height="50" /> ' + full.ufullname; }),

      DTColumnBuilder.newColumn("cname", "Categoría"),

      DTColumnBuilder.newColumn("prio", "Prioridad").withOption('class', 'text-center').renderWith(function (data) { return data }),

      DTColumnBuilder.newColumn("status", "Estatus").withOption('class', 'text-center').renderWith(function (data) { return ' <a class="btn-link">' + $filter('capitalize')(data) + '</a>'; })

    ];

    vm.newSource = function () { return TaskService.getTask(); }

    vm.reloadData = reloadData;

    vm.dtInstance = {};

    function reloadData() { vm.dtInstance.reloadData(callback, false); }

    function callback(json) { console.log(json); }

    function rowCallback(nRow, aData, iDisplayIndex, iDisplayIndexFull) {

      $('td', nRow).unbind('click');

      $('td', nRow).bind('click', function () { $scope.$apply(function () { $scope.settaskSel(aData); $scope.showPrint('print'); }); });

      return nRow;

    }

    $scope.fillTextbox = function (obj) { $scope.selectedItem = obj; $scope.item = obj.fullname; $scope.filterItem = null; }

    $scope.complete = function (string) {

      if (string != null && string.length >= 2) {

        var output = []; $scope.selectedItem = null; angular.forEach($scope.allentes, function (response) { if (response.fullname.toLowerCase().indexOf(string.toLowerCase()) >= 0) { output.push(response); } }); $scope.filterItem = output;

      }

    }

    $scope.showPrint = function (div) { $scope.divPrint = div; }

    $scope.resetparams = function () {

      $scope.message = "Favor de completar los campos";

      $scope.showNewCustomer = false;

      $scope.newForm = true;

      $scope.taskSel = {};

      $scope.item = '';

      $scope.selectedItem = null;

      $scope.taskSel.type = 'tarea';

      $scope.taskSel.prio = 'media';

      $scope.taskSel.userid = $scope.user.id;

      $scope.taskSel.categoryid = 1;

      $scope.taskSel.projectid = 1;

      $scope.taskSel.status = 'creado';

      $scope.taskSel.duedatedate = $filter('date')(new Date(), "yyyy-MM-dd");

      $scope.taskSel.duedatehour = parseInt($filter('date')(new Date(), "HH")) + 1;

      $scope.taskSel.duedatemin = $filter('date')(00, "mm");

      angular.forEach($scope.allentes, function (response) { if (response.id === 1) { $scope.selectedItem = response; } });

      $scope.showPrint('newForm');

    }

    $scope.settaskSel = function (data) {

      data.duedatedate = data.duedate.split(' ')[0];

      data.duedatehour = data.duedate.split(' ')[1].split(':')[0];

      data.duedatemin = data.duedate.split(' ')[1].split(':')[1];

      angular.copy(data, $scope.taskSel);

      angular.forEach($scope.allentes, function (response) { if (response.id === data.enteid) { $scope.selectedItem = response; } });

    }

    $scope.saveTask = function (datos) {

      if ($scope.selectedItem != null) {

        datos.enteid = $scope.selectedItem.id;

        datos.action = (datos.id) ? 'edit' : 'add';

        if (datos.duedatedate) datos.duedate = $filter('date')(datos.duedatedate, "yyyy-MM-dd") + ' ' + datos.duedatehour + ':' + datos.duedatemin;

        TaskService.saveTask(datos).then(function () {

          vm.dtInstance.changeData(vm.newSource);

          let json = {};

          json.id = datos.projectid;

          json.action = 'projectsactive';

          $scope.newForm = false; $scope.showPrint('info');

          TaskService.saveTask(json).then(function (actives) { if (actives > 0) { json.action = 'projectsclosed'; TaskService.saveTask(json).then(function (closed) { json.progress = closed / actives * 100; json.action = 'editprogress'; TaskService.saveProject(json); }); } });

        });

      } else { $scope.message = "Mensaje: Favor de Seleccionar al Cliente"; }

    }

    $scope.showPrint('info');

  }])