;(function (){
 'use strict';
 angular.module('common',[])
    .service('TimelineService',[
        '$http',
        'AnswerService',
        function($http,AnswerService){
            var me = this;
            me.data = [];
            // 获取首页数据
            me.get = function(conf){
                $http.post('/api/timeline',conf)
                    .then(function(r){
                        if(r.data.status){
                            me.data = me.data.concat(r.data.data);
                            // 统计每一条回答的票数
                            me.data = AnswerService.count_vote(me.data);
                        }else
                            console.error('network error')
                    },function(){
                        console.error('network error')
                    })
            }
            // 在时间线中投票
            me.vote = function(conf){
                // 调用核心投票功能
                AnswerService.vote(conf)
                    .then(function(r){
                        // 如果投票成功就更新AnswerService的数据
                        if(r)
                            AnswerService.update_data(conf.id);
                    })
            }
        }])

    .controller('HomeController',[
        '$scope',
        'TimelineService',
        'AnswerService',
        function ($scope,TimelineService,AnswerService) {
            var $win;
            $scope.Timeline=TimelineService;
            TimelineService.get();
    
            // $win=$(window);
            // $win.on('scroll',function () {
            //     if($win.scrollTop()-($(document).height()-$win.height())>-30){
            //         TimelineService.get();
            //     }
            // });
            //监控回答数据得变化 如果回答数据有变化同时更新其他模块中的回答数据
            $scope.$watch(function () {
                return AnswerService.data;
            },function(new_data,old_data){
                var timeline_data=TimelineService.data;
                // 更新时间线中的数据
                for(var k in new_data){
                    for(var i=0;i<timeline_data.length;i++){
                        if(k == timeline_data[i].id){
                            timeline_data[i]=new_data[k];
                        }
                    }
                }
                TimelineService.data=AnswerService.count_vote(TimelineService.data)
            },true)
    
    
        }
    ])
})();
