<div ng-controller="UserController">
    <div class="user card container">
        <h1>用户详情</h1>
        <div class="hr"></div>
        <div class="basic">
            <div class="info_item clearfix">
                <div>用户名：</div>
                <div>[: User.current_user.username :]</div>
            </div>  
            <div class="info_item clearfix">
                <div>用户简介：</div>
                <div>[: User.current_user.intro || '暂无介绍':]</div>
            </div>         
        </div>        
                <h2>用户提问 
                    <span class="question_count"> 
                        提问数：[: User.current_user.question_count :]
                    </span>                      
                </h2>                               
        <div ng-repeat="(key,value) in User.his_questions">
            <a class="tc_question" ui-sref="question.detail({id:value.id})">
                [: value.title :]
            </a>
        </div>
        <div class="hr"></div>
        <h2>用户回答</h2>
        <div class="feed item" ng-repeat="(key,value) in User.his_answers">           
            <div>
                <a class="user_question_title" ui-sref="question.detail({id:value.question.id})">
                    问题标题：[: value.question.title :]
                </a>
            </div>
            回答：[: value.content :]
            <div class="action-set">
                <div class="comment">更新时间：[: value.updated_at :]</div>
            </div>
        </div>
    </div>
    
    
</div>