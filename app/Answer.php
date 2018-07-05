<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /*添加回答*/
    public function add(){
        
        /*判断用户是否登陆*/
        if(!new_any('User')->is_logined())
            return ['status' => 0,'msg' =>'you shoud login'];
        /*判断question_id和content是否存在*/
        if(!rq('question_id') || !rq('content'))
            return ['status' => 0,'msg' => 'question_id and content are not exist'];
        /*查找数据库*/
        $question = new_any('Question')->find(rq('question_id'));

        if(!$question)
            return ['status' => 0,'msg' =>'question not exist'];
        /*获取数据*/
        $this->content = rq('content');
        $this->question_id = rq('question_id');
        $this->user_id = session('user_id');
        
        /*数据插入*/
        return $this->save()?
        ['status' => 1,'msg' =>$this->id]:
        ['status' => 0,'msg' => 'db insert failed'];
    }

    /*更新回答*/
    public function change(){

         /*判断用户是否登陆*/
         if(!new_any('User')->is_logined())
            return ['status' => 0,'msg' =>'you shoud login'];
          /*id和content是否存在*/
        if(!rq('id') || !rq('content'))
            return ['status' => 0,'msg' => 'id and content are not exist'];

        /*查找id*/
        $answer = $this->find(rq('id'));

        /*判断id和user_id是否一致*/
        if($answer->user_id != session('user_id'))
            return ['status' => 0,'msg' => 'no power to change'];

        $answer ->content = rq('content');

        /*写入数据库*/

        return $answer->save()?
        ['status' => 1]:
        ['status' => 0,'msg' => 'db update failed'];
    }

    public function read_self($user_id){
        $user = new_any('User')->find($user_id);
        if(!$user){
            return err('user not exists');
        }else{
            $r = $this->with('question')->where('user_id',$user_id)->get()->keyBy('id');
            return suc($r->toArray());
        }
    }

    public function remove(){
        /*判断用户是否登陆*/
        if(!new_any('User')->is_logined())
        return['status' => 0,'msg' =>'you should login'];

        /*判断id存不存在*/
        if(!rq('id'))
           return ['status' => 0,'msg' =>'id is not exists'];

        $answer = $this->find(rq('id'));
        if(!$answer) return ['status' => 0,'msg' => 'answer is not exist'];

        if($answer->user_id != session('user_id'))
            return ['status' => 0,'msg' => 'not your answer'];
        
        return $answer->delete()?
            ['status' => 1]:
            ['status' => 0,'msg' =>'delete failed'];
    }

    /*查看回答*/
    public function read(){
        /*判断id和question_id是否存在*/
        if(!rq('id') && !rq('question_id') && !rq('user_id'))
            return ['status' => 0, 'msg' =>'id or qusetion_id or user_id are required'];

        if(rq('user_id')){
            $user_id = rq('user_id') === 'self'?
             session('user_id'):
             rq('user_id');
            return $this->read_self($user_id);
        }

        /*用户想查看问题的回答*/
        if(rq('id'))
        {
            $answer = $this
                ->with('user')
                ->with('users')
                ->find(rq('id'));
            if(!$answer)
                return ['status' => 0,'msg' => 'answer not exist'];
            
            $answer = $this->count_vote($answer);

            return ['status' => 1,'data' => $answer];

        }
        /*用户想查看自己的回答*/
        if(!new_any('Question')->find(rq('question_id')))
            return ['status' => 0,'msg' =>'question not exist'];
        $answer = $this
        ->where('question_id',rq('question_id'))
        ->get()
        ->keyBy('id');

        return ['status' => 1,'data' => $answer]; 
    }

    /*用户给answer投票*/
    public function  vote(){
        /*判断用户是否登陆*/
        if(!new_any('User')->is_logined())
            return ['status' => 0,'msg' =>'you shoud login'];

        if(!rq('id') || !rq('vote'))
            return ['status' => 0 ,'msg' => 'id and vote are request '];
        
        $answer = $this->find(rq('id'));
        if(!$answer) 
            return ['status' => 0,'msg' => 'answer not exists'];
        
        /*1赞同票 2反对票 3清空既不赞也不踩*/
        $vote = rq('vote');
        if($vote !=1 && $vote !=2 && $vote !=3)
            return ['status'=>0,'msg'=>'invalid vote'];

        /*检查此用户是否在相同问题下投票,如果投过票，删除投票*/
        $voted = $answer->users()
                ->newPivotStatement()
                ->where('user_id',session('user_id'))
                ->where('answer_id',rq('id'))
                ->delete();


        if($vote == 3)
            return['status'=>1];

        /*在连接表中增加数据*/
        $answer->users()
            ->attach(session('user_id'),['vote' => $vote]);

        return ['status' => 1];
    }

    public function count_vote($answer){
        $upvote_count = 0;
        $downvote_count = 0;
        foreach($answer->users as $user){
            if($user->pivot->vote == 1)
                $upvote_count++;
            else
                $downvote_count++;
        }
        $answer->upvote_count = $upvote_count;
        $answer->downvote_count = $downvote_count;
        return $answer;
    }

    /*answer和user表一对一连接*/
    public function user()
    {
        return $this->belongsTo('App\User');
    }
   /*answer和user表多对多连接*/
   public function users(){
       return $this->belongsToMany('App\User')->withPivot('vote')->withTimestamps();
   }
   /*answer和question表一对一连接*/
   public function question()
   {
       return $this->belongsTo('App\Question');
   }
   /*answer和comment表多对多连接*/
   public function comments(){
    return $this->belongsToMany('App\Comment');
   }
}
