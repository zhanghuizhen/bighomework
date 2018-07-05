<!DOCTYPE html>
<html  ng-controller="BaseController" lang="zh" ng-app="xiaohu" user-id="{{session('user_id')}}">
<head>
    <meta charset="utf-8" />

    <title>大学生问答网站</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="\node_modules\normalize-css\normalize.css" />
    <link rel="stylesheet" href="\css\base.css">
    <script src="\node_modules\jquery\dist\jquery.js"></script>
    <script src="\node_modules\angular\angular.js"></script>
    <script src="\node_modules\angular-ui-router\release\angular-ui-router.js"></script>
    <script src="\js\base.js"></script>
    <script src="\js\common.js"></script>
    <script src="\js\user.js"></script>
    <script src="\js\question.js"></script>
    <script src="\js\answer.js"></script>
</head>
<body>
    <div class="navbar clearfix">
        <div class="container">
            <div class="fl">
                <div ui-sref="home" class="navbar_item brand">大学生问答网站 问吧</div>
                <form class="quick_ask"  ng-submit="Question.go_add_question()" ng-controller="QuestionAddController">                      
                    <div class="navbar_item">
                        <input ng-model="Question.new_question.title" type="text">                                
                    </div>
                    <div class="navbar_item">
                        <button type="submit">提交</button>                       
                    </div>
                </form>
            </div>
            <div class="fr">
                <a ui-sref="home" class="navbar_item">首页</a>
                @if(is_logined())
                    <a  ui-sref="user({id: {{session('user_id')}}})" class="navbar_item">
                        {{session('logineduser')}}
                    </a>
                    <a href="{{url('api/user/logout')}}" class="navbar_item">注销</a>                
                @else
                    <a ui-sref="login" class="navbar_item">登录</a>
                    <a ui-sref="signup" class="navbar_item">注册</a>
                @endif
            </div>
        </div>
    </div>
    <div class="page">
        <div ui-view></div>
    </div>

    {{-- <script type="text/ng-template" id="comment.tpl">
        <div class="comment-block">
            <div class="hr"></div>
            <div class="comment-item-set">
                <div class="rect"></div>
                <div class="gray tac well" ng-if="!helper.obj_length (data)">暂无评论</div>
                <div ng-if="helper.obj_length (data)" ng-repeat="item in data" class="comment-item clearfix">
                    <div class="user">[: item.user.username :] : </div>
                    <div class="comment-content">[: item.content :]</div>
                </div>
            </div>
            <div class="input-group">
                <form ng-submit="_.add_comment()" class="comment_form">
                    <input type="text"
                           ng-model="Answer.new_comment.content"
                           placeholder="说些什么....">
                    <button type="submit" class="primary">评论</button>
                </form>
            </div>
        </div>
    </script> --}}
    
</body>


</html>