"use strict";
angular.module("yapp", ["ui.router", "ui.bootstrap", "ngAnimate", "ngCookies"]).config(["$stateProvider", "$urlRouterProvider", function(r, t) {
    t.when("/dashboard", "/dashboard/overview"), t.otherwise("/login"), r.state("base", {
        "abstract": !0,
        url: "",
        templateUrl: "views/base.html"
    })
    .state("login", {
        url: "/login",
        parent: "base",
        templateUrl: "views/login.html",
        controller: "LoginCtrl"
    })
    .state("dashboard", {
        url: "/dashboard",
        parent: "base",
        templateUrl: "views/dashboard.html",
        controller: "DashboardCtrl"
    })
    .state("overview", {
        url: "/overview",
        parent: "dashboard",
        templateUrl: "views/dashboard/overview.html"
    })
    .state("caixa", {
        url: "/caixa",
        parent: "dashboard",
        templateUrl: "views/dashboard/caixa.html",
        controller: "CaixaCtrl"
    })
    .state("copa", {
        url: "/copa",
        parent: "dashboard",
        templateUrl: "views/dashboard/copa.html"
    })
    .state("cozinha", {
        url: "/cozinha",
        parent: "dashboard",
        templateUrl: "views/dashboard/cozinha.html"
    })
    .state("padaria", {
        url: "/padaria",
        parent: "dashboard",
        templateUrl: "views/dashboard/padaria.html"
    })
    .state("reports", {
        url: "/reports",
        parent: "dashboard",
        templateUrl: "views/dashboard/reports.html"
    })
}]);