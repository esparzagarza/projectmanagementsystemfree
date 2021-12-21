const REGEX_ALL = /([^\W_]+[^\s-]*) */g;
const REGEX_FIRST = /([^\W_]+[^\s-]*)/;

const capitalize = (input, all) => { if (!input) return ''; const regex = (all) ? REGEX_ALL : REGEX_FIRST; return input.replace(regex, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()); }

angular.module("pmsystem")

  .factory('UrlService', function () { return { baseUri: 'api/controllers/' }; })

  .controller("AppCtrl", ["$rootScope", "LoginService", "$location", function AppCtrl($rootScope, LoginService, $location) {

    LoginService.validateLoginSession();

    var app = this, def = ["layout", "layout-header-fixed"];

    app.navbar = {};

    app.navbar.isCollapsed = true;

    app.navbar.toggle = function toggle() { this.isCollapsed = !this.isCollapsed; };

    app.sidebar = {};

    app.sidebar.isCollapsed = true;

    app.sidebar.toggle = function toggle() { this.isCollapsed = !this.isCollapsed; };

    app.sidebar.xs = {};

    app.sidebar.xs.isCollapsed = true;

    app.sidebar.xs.toggle = function toggle() { this.isCollapsed = !this.isCollapsed; };

    $rootScope.$on("$stateChangeStart", function (evt, toState) {

      app.cssClasses = _.join(_.get(toState, "data.cssClasses", def), " ");

      app.sidebar.isFixed = _.includes(app.cssClasses, "layout-sidebar-fixed");

    });

    $rootScope.$on("$stateChangeStart", function (evt, toState) { app.title = _.get(toState, "data.title", $rootScope.config.appname); app.cssClasses = _.join(_.get(toState, "data.cssClasses", def), " "); app.sidebar.isFixed = _.includes(app.cssClasses, "layout-sidebar-fixed"); });


    $rootScope.payAmountMask = "0-9";

    $rootScope.phoneMask = "(999) 999-9999";

    $rootScope.dateMask = "9999-99-99";

    $rootScope.timeMask = "99";

    $rootScope.user = {};

    $rootScope.datos = {};

    $rootScope.config = {};

    $rootScope.mensaje = 'Bienvenido';

    $rootScope.allstatus = [{ "id": "", "name": "Todos" }, { "id": "creado", "name": "Creado" }, { "id": "atendiendo", "name": "Atendiendo" }, { "id": "en demora", "name": "En demora" }, { "id": "cancelado", "name": "Cancelado" }];

    $rootScope.validateSession = function validateSession() { LoginService.isActiveSession().then(function (isActiveSession) { if (isActiveSession) { LoginService.getAppData().then(function (data) { $rootScope.config = data; LoginService.getActiveSession().then(function (data) { $rootScope.user = data; $location.path("/"); }); }); } }); }

    $rootScope.ingresar = function ingresar(datos) { datos.action = 'login'; LoginService.login(datos).then(function (data) { if (data.data) { $rootScope.validateSession(); } else $rootScope.mensaje = 'correo / contraseña no coincide'; }) }

    $rootScope.logout = function logout() { LoginService.getLogout(); }

  }])

  .filter('capitalize', function () { return capitalize });;

