<div ng-controller="QuestionAddController" class="question-add container">
    <div class="card">
        <form name="question_add_form" ng-submit="Question.add()">
            <div class="input-group">
                <label>问题标题</label>
                <input type="text" name="title"
                       ng-minlength="1" ng-maxlength="255"
                       ng-model="Question.new_question.title" required>
            </div>
            <div class="input-group">
                <label>问题描述</label>
                <textarea type="text" name="desc" ng-model="Question.new_question.desc" required></textarea>
            </div>
            <div class="input-group">
                {{-- <button ng-disabled="question_add_form.title.$error.required" class="primary" type="submit">提交</button> --}}
                <button ng-disabled="question_add_form.$invalid" class="primary" type="submit">提交</button>
            </div>
        </form>
    </div>
</div>