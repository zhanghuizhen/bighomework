<div ng-controller="QuestionDetailController" class="container question-detail">
        <div class="card">
            <h1>[:Question.current_question.title:]</h1>
            <div class="desc">[: Question.current_question.desc :]</div>
            <span ng-if="his.id==Question.current_question.user_id"
                  ng-click="Question.show_update_form=!Question.show_update_form"
                  class="gray anchor"><span ng-if="Question.show_update_form">取消</span>修改问题
            </span>
            <form ng-if="Question.show_update_form" name="question_add_form"
                  class="well gray_card" ng-submit="Question.update()">
                <div class="input-group">
                    <label>问题标题</label>
                    <input type="text" name="title"
                     ng-minlength="1" ng-maxlength="255"
                    ng-model="Question.current_question.title" required>
                </div>
                <div class="input-group">
                    <label>问题描述</label>
                    <textarea type="text" name="desc" ng-model="Question.current_question.desc" required></textarea>
                </div>
                <div class="input-group">
                    {{-- <button ng-disabled="question_add_form.title.$error.required" class="primary" type="submit">提交</button> --}}
                    <button ng-disabled="question_add_form.$invalid" class="primary" type="submit">提交</button>
                </div>
            </form>
            
            <div>    
                <span class="gray">
                   回答数: [: Question.current_question.answers_with_user_info.length:]
                </span>
            </div>
            <div class="hr"></div>
            <div class="answer-block">
               <div ng-if="!Question.current_answer_id || Question.current_answer_id == item.id" 
               ng-repeat="item in Question.current_question.answers_with_user_info">
               <div class="vote">
                    <div ng-click="Question.vote({id: item.id,vote:1})" class="up">
                        赞[: item.upvote_count :]
                    </div>
                    <div ng-click="Question.vote({id: item.id,vote:2})" class="down">
                        踩[: item.downvote_count :]
                    </div>
                </div>

                    <div class="feed-item-content">
                        <span ui-sref="user({id: item.user.id})">
                            [:item.user.username:]
                        </span>
                    </div>
                    <div>
                        <a class="comment_content" ui-sref="question.detail({id: Question.current_question.id,answer_id: item.id})">
                            [: item.content :]
                        </a>
                        <div class="action-set">
                            <span ng-click="item.show_comment=!item.show_comment">
                               <span ng-if="item.show_comment">取消</span>评论
                            </span>
                            <span class="gray">
                                    <a ng-click="Answer.answer_form = item" 
                                        ng-if="item.user_id == his.id" class="anchor">编辑</a>
                                    <a ng-click="Answer.delete(item.id)" 
                                        ng-if="item.user_id == his.id" class="anchor">删除</a>
                                    <a>
                                        [: item.updated_at :]
                                    </a>
                            </span>    
                        </div>
                                           
                    </div>
                    <div ng-if="item.show_comment" comment-block answer-id="item.id">
                       
                    </div>

                    <div class="hr"></div>
               </div>
            </div>
            <div>
         
                <form ng-submit="Answer.add_or_update(Question.current_question.id)" 
                name="answer_form" class="answer_form">
                    <div class="input-group">
                        <textarea type="text" name="content"       
                        ng-model="Answer.answer_form.content" required>
                        </textarea>
                    </div>
                    <div class="input-group">
                        <button ng-disabled="answer_form.$invalid" type="submit" class="primary">提交</button>       
                    </div>
                </form>
            </div>
       </div>
</div>

<script type="text/ng-template" id="comment.tpl">
    <div class="comment-block">
        <div class="hr"></div>
        <div class="comment-item-set">
            <div class="rect"></div>
            <div class="gray tac well" ng-if="!helper.obj_length (data)">暂无评论</div>
            <div ng-if="helper.obj_length (data)" ng-repeat="item in data" class="comment-item clearfix">
                <div class="user">[: item.user.username :] : </div>
                <div class="comment-content">[: item.content :]</div>
                <div class="del">
                    {{--  @if(is_logined())
                        <a ng-click="Question.delete(item.id)" class="anchor">删除</a>
                    @endif  --}}
                </div>
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
</script>