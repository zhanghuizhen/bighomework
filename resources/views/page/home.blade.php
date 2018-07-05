<div ng-controller="HomeController" class="home card container">
        <h1>最近动态</h1>
        <div class="hr"></div>
        <div class="item-set">
   
            <div ng-repeat="row in Timeline.data track by $index" class="feed item clearfix" >
                <div ng-if="row.question_id" class="vote">
                    <div ng-click="Timeline.vote({id: row.id,vote:1})" class="up">赞[: row.upvote_count :]</div>
                    <div ng-click="Timeline.vote({id: row.id,vote:2})" class="down">踩[: row.downvote_count :]</div>
                </div>
                <div class="feed-item-content">
                    <div ng-if="row.question_id" class="content-act">[:row.user.username:]添加了回答</div>
                    <div ng-if="!row.question_id" class="content-act">[:row.user.username:]提出了问题</div>
                    <div>
                        <span class="question_title">
                           [: row.question.title :]
                        </span>
                    </div>
                    {{-- 问题的标题 --}}
                    <div ui-sref="question.detail({id:row.id})" class="title">[:row.title:]</div>
                    <div><a ui-sref="user({id: row.user.id})" class="content-owner">作者：[:row.user.username:]</a>
                        <span class="desc">[: row.user.intro || '暂无介绍':]</span>
                    </div>
                    {{-- 问题的描述 --}}
                    <div ng-if="row.question_id">
                        <a class="content-main" ui-sref="question.detail({id: row.question_id,answer_id: row.id})">
                            回答内容：[:row.content:]
                        </a>
                        <div class="gray">[: row.updated_at :]</div>
                    </div>

                    {{-- <div comment-block>
                        commentcommentcomment
                    </div> 
                    <div class="action-set">
                        <div class="comment">评论</div>
                    </div>
                    --}}
                </div>
                <div class="hr"></div>
            </div>

        </div>
    </div>
    


      {{--  <div ng-controller="HomeController" class="home card container">
        <h1>最近动态</h1>
        <div class="hr"></div>
        <div class="item-set">
            
            <div ng-repeat="row in Timeline.data" class="feed item clearfix" >
                <div ng-if="row.question_id" class="vote">
                    <div ng-click="Timeline.vote({id: row.id,vote:1})"
                         class="up">
                        赞[:row.upvote_count:]
                    </div>
                    <div ng-click="Timeline.vote({id: row.id,vote:2})"
                         class="down">
                        踩[:row.downvote_count:]
                    </div>
                </div>
                <div class="feed-item-content">
                    <div ng-if="row.question_id" class="content-act">
                        [:row.user.username:]添加了回答
                    </div>
                    <div ng-if="!row.question_id" class="content-act">
                        [:row.user.username:]提出了问题
                    </div>
                    <div ng_if="row.question_id"  class="title">
                        [:row.question.title:]
                    </div>
                    <div ui-sref="question.detail({id:row.id})" class="title">
                        [:row.title:]
                    </div>
                    <div class="content-owner">[:row.user.username:]
                        <span class="desc">用户描述</span>
                    </div>
                    <div class="content-main">
                        [:row.content:]
                    </div>
                    <div class="action-set">
                        <div class="comment">评论</div>
                    </div>
                    <div class="comment-block">
                        <div class="hr"></div>
                        <div class="comment-item-set">
                            <div class="rect"></div>
                            <div class="comment-item clearfix">
                                <div class="user">liming</div>
                                <div class="comment-content">
                                    pinglinneirong pinglinneirong pinglinneirong pinglinneirong pinglinneirong pinglinneirong pinglinneirong
                                </div>
                            </div>
                            <div class="comment-item clearfix">
                                <div class="user">liming</div>
                                <div class="comment-content">
                                    pinglinneirong pinglinneirong
                                </div>
                            </div>
                            <div class="comment-item clearfix">
                                <div class="user">liming</div>
                                <div class="comment-content">
                                    pinglinneirong pinglinneirong pinglinneirong pinglinneirong pinglinneirong
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr"></div>
            </div>
            <div ng-if="Timeline.no_more_data" class="tac">没有更多数据了</div>
        </div>
    </div>
      --}}