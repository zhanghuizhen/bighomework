;(function(){
    'user strict';

     window.his={
        id:parseInt($('html').attr('user-id'))
    };
    console.log('his',his);

    window.helper = {};
    helper.obj_length = function(obj){
        return Object.keys(obj).length;
    }

    angular.module('xiaohu',[
        'ui.router',
        'common',
        'question',
        'user',
        'answer',
    ])
    /*配置文件*/
        .config(function($interpolateProvider,
                         $stateProvider,
                         $urlRouterProvider)
        {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');

            //$urlRouterProvider.otherwise('/login');

            $stateProvider
                .state('home',{
                    url:'/home',
                    templateUrl:'/tpl/page/home',
                    cache:false,
                })
                .state('signup',{
                    url:'/signup',
                    templateUrl:'/tpl/page/signup'
                })
                .state('login',{
                    url:'/login',
                    templateUrl:'/tpl/page/login'
                })
                .state('question',{
                    abstract:true,
                    url:'/question',
                    template:'<div ui-view></div>',
                    controller:'QuestionController'
                })
                .state('question.detail',{
                    url:'/detail/:id?answer_id',
                    templateUrl:'/tpl/page/question_detail'
                })
                .state('question.add',{
                    url:'/add',
                    templateUrl:'/tpl/page/question_add',
                })
                .state('user',{
                    url:'/user/:id',
                    templateUrl:'/tpl/page/user'
                })

        })//config

        .controller('BaseController',[
            '$scope',
            function($scope){
                $scope.his = his;
                $scope.helper = helper;
            }
        ])
})();
