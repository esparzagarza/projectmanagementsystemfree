"use strict";
function config($stateProvider, $urlRouterProvider, $ocLazyLoadProvider) {

  $urlRouterProvider.otherwise("/resume");

  $ocLazyLoadProvider.config({

    debug: false,

    modules: [{

      name: "angular-peity",

      serie: true,

      files: [

        "js/vendor/peity/jquery.peity.min.js",

        "js/vendor/angular-peity/angular-peity.min.js"

      ]

    }, {

      name: "chart.js",

      serie: true,

      files: [

        "js/vendor/numeral/numeral.min.js",

        "js/vendor/numeral/locales.min.js",

        "js/vendor/chartjs/Chart.bundle.min.js",

        "js/vendor/angular-chart/angular-chart.min.js"

      ]

    }, {

      name: "ui.select",

      serie: true,

      files: [

        "css/vendor/angular-ui/angular-ui-select.min.css",

        "js/vendor/angular-ui/angular-ui-select.min.js"

      ]

    }, {

      name: "toast",

      serie: true,

      files: [

        "css/vendor/toast/toast.min.css",

        "js/vendor/toast/toast.min.js"

      ]

    }, {

      name: "ngCropper",

      serie: true,

      files: [

        "css/vendor/ngCropper/ngCropper.min.css",

        "js/vendor/ngCropper/ngCropper.min.js"

      ]

    }, {

      name: "ngSlider",

      serie: true,

      files: [

        "css/vendor/ngSlider/ngSlider.min.css",

        "js/vendor/ngSlider/ngSlider.min.js"

      ]

    }, {

      name: "blueimp.fileupload",

      serie: true,

      files: [

        "js/vendor/jquery-ui/jquery-ui.min.js",

        "js/vendor/load-image/load-image.all.min.js",

        "js/vendor/fileupload/jquery.iframe-transport.js",

        "js/vendor/fileupload/jquery.fileupload.js",

        "js/vendor/fileupload/jquery.fileupload-process.js",

        "js/vendor/fileupload/jquery.fileupload-image.js",

        "js/vendor/fileupload/jquery.fileupload-validate.js",

        "js/vendor/fileupload/jquery.fileupload-angular.js"

      ]

    }, {

      name: "datatables",

      serie: true,

      files: [

        "css/vendor/datatables/datatables.min.css",

        "css/vendor/datatables/datatables-responsive.min.css",

        "css/vendor/datatables/datatables-colreorder.min.css",

        "css/vendor/datatables/datatables-scroller.min.css",

        "js/vendor/datatables/jquery.dataTables.min.js",

        "js/vendor/datatables/dataTables.bootstrap.min.js",

        "js/vendor/datatables/dataTables.responsive.min.js",

        "js/vendor/datatables/responsive.bootstrap.min.js",

        "js/vendor/datatables/dataTables.colReorder.min.js",

        "js/vendor/datatables/dataTables.scroller.min.js",

        "js/vendor/angular-datatables/angular-datatables.min.js",

        "js/vendor/angular-datatables/angular-datatables.bootstrap.min.js",

        "js/vendor/angular-datatables/angular-datatables.colreorder.min.js",

        "js/vendor/angular-datatables/angular-datatables.scroller.min.js"

      ]

    }, {

      name: "uiGmapgoogle-maps",

      serie: true,

      files: [

        "js/vendor/angular-google-maps/angular-google-maps.min.js",

        "js/vendor/angular-simple-logger/angular-simple-logger.js"

      ]

    }, {

      name: "textAngular",

      serie: true,

      files: [

        "css/vendor/textAngular/textAngular.min.css",

        "js/vendor/textAngular/textAngular-sanitize.min.js",

        "js/vendor/textAngular/textAngular-rangy.min.js",

        "js/vendor/textAngular/textAngular.js",

        "js/vendor/textAngular/textAngularSetup.js",

      ]

    }, {

      name: "wu.masonry",

      serie: true,

      files: [

        "js/vendor/masonry/masonry.pkgd.min.js",

        "js/vendor/imagesloaded/imagesloaded.pkgd.min.js",

        "js/vendor/angular-masonry/angular-masonry.min.js"

      ]

    }, {

      name: "angular-flexslider",

      serie: true,

      files: [

        "css/vendor/flexslider/flexslider.min.css",

        "js/vendor/flexslider/flexslider.min.js",

        "js/vendor/angular-flexslider/angular-flexslider.min.js"

      ]

    }]

  });

  $stateProvider

    .state("root", { abstract: true, templateUrl: "views/app.tpl.html", })

    .state("forms", { abstract: true, templateUrl: "views/app.tpl.html", })

    .state("login", {

      url: "/login",

      data: { cssClasses: ["login-page"] },

      templateUrl: "views/login.tpl.html",

      resolve: { loadFiles: function ($ocLazyLoad) { return $ocLazyLoad.load(["css/login.min.css"]); } }

    })

    .state("root.contacts", {

      url: "/contacts",

      controller: "ContactCtrl",

      data: { title: "Administrar Directorio", cssClasses: ["layout", "layout-header-fixed", "layout-sidebar-fixed", "contacts-page"] },

      templateUrl: "views/contacts.tpl.html",

      resolve: { loadFiles: function ($ocLazyLoad) { return $ocLazyLoad.load(["css/contacts.min.css", "js/contacts.js"]); } }

    })

    .state("projects", { abstract: true, templateUrl: "views/app.tpl.html", })

    .state("projects.list", {

      url: "/projects",

      controller: "ProjectsCtrl as dt",

      templateUrl: "views/projects.tpl.html",

      data: { title: "Administrar Proyectos", cssClasses: ["layout", "layout-header-fixed",], },

      resolve: {

        loadDatatables: function ($ocLazyLoad) { return $ocLazyLoad.load("datatables"); },

        loadFiles: function ($ocLazyLoad) { return $ocLazyLoad.load(["js/projects.js"]); }

      }

    })

    .state("projects.task", {

      url: "/task",

      controller: "TaskCtrl as dt",

      templateUrl: "views/task.tpl.html",

      data: { title: "Asiganción de Tareas", cssClasses: ["layout", "layout-header-fixed",], },

      resolve: {

        loadDatatables: function ($ocLazyLoad) { return $ocLazyLoad.load("datatables"); },

        loadFiles: function ($ocLazyLoad) { return $ocLazyLoad.load(["js/task.js"]); }

      }

    })

    .state("report", { abstract: true, templateUrl: "views/app.tpl.html", })

    .state("report.resume", {

      url: "/resume",

      controller: "ResumeCtrl",

      templateUrl: "views/resume.tpl.html",

      data: { cssClasses: ["layout", "layout-header-fixed",], },

      resolve: {

        loadChartJS: function ($ocLazyLoad) { return $ocLazyLoad.load("chart.js"); },

        loadPlugins: function ($ocLazyLoad) { return $ocLazyLoad.load(["css/vendor/jqvmap/jqvmap.min.css", "js/vendor/jqvmap/jquery.vmap.min.js", "js/vendor/jqvmap/maps/jquery.vmap.world.js"]); },

        loadFiles: function ($ocLazyLoad) { return $ocLazyLoad.load(["js/resume.js"]); }

      }

    })

    .state("admin", { abstract: true, templateUrl: "views/app.tpl.html", })

    .state("admin.category", {

      url: "/category",

      controller: "CategoryCtrl",

      templateUrl: "views/category.tpl.html",

      data: { cssClasses: ["layout", "layout-header-fixed",], },

      resolve: { loadFiles: function ($ocLazyLoad) { return $ocLazyLoad.load(["js/category.js"]); } }

    })

    .state("admin.users", {

      url: "/users",

      controller: "UsersCtrl",

      templateUrl: "views/users.tpl.html",

      data: { title: "Gestionar Usuarios", cssClasses: ["layout", "layout-header-fixed",], },

      resolve: { loadFiles: function ($ocLazyLoad) { return $ocLazyLoad.load(["js/users.js"]); } }

    });

}

angular.module("pmsystem").config(config).run(["$rootScope", "$state", "$stateParams", function ($rootScope, $state, $stateParams) { $rootScope.$state = $state; $rootScope.$stateParams = $stateParams; }]);