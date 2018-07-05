<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /*用户增加问题*/
    public function add(){
        /*判断是否登录*/
        if(!new_any('User')->is_logined())
            return ['status' => 0,'msg' =>'you shoud login'];
        /*判断是否有title*/
        if(!rq('title'))
            return ['status' => 0,'msg' => 'request title'];
        /*取出数据*/
        $this->title = rq('title');
        $this->user_id = session('user_id');
        if(rq('desc'))
            $this->desc = rq('desc');
        /*存入数据*/    
        return $this->save()?
        ['status' => 1,'id' => $this ->id]:
        ['status' => 0,'msg' => 'insert failed'];
    }

    /*用户修改问题*/
    public function change(){

        /*判断用户是否登陆*/
        if(!new_any('User')->is_logined())
            return ['status' => 0,'msg' =>'you shoud login'];
        /*判断是否有id*/
        if(!rq('id'))
            return ['status' => 0,'msg' => 'id is not exist'];
        /*查找id=$id的数据*/
        $question = $this->find(rq('id'));

        /*取出数据和session数据做匹配*/
        if($question->user_id != session('user_id'))
            return ['status' => 0,'msg' => '取出数据不符'];
        
            if(rq('title'))
            $question ->title =  rq('title');
        if(rq('desc'))
            $question ->desc =  rq('desc');

        /*存入更新后的数据*/
        return $question ->save()?
        ['status' => 1,'msg' => '更新成功']:
        ['stauts' => 2,'msg' =>'更新失败'];

    }
    public function read_self($user_id){
        $user = new_any('User')->find($user_id);
        if(!$user){
            return err('user not exists');
        }else{
            $r = $this->where('user_id',$user_id)->get()->keyBy('id');
            return suc($r->toArray());
        }
    }


/*查看问题api*/
    public function read(){
        /*是否有id*/
        if(rq('id')) {
            $r = $this
                ->with('answers_with_user_info')
                ->find(rq('id'));
            return ['status' => 1,'data' => $r];
        }


        if(rq('user_id')){
            $user_id = rq('user_id') === 'self'?
                session('user_id'):
                rq('user_id');
            return $this->read_self($user_id);
        }
        /*问题分页展示*/
        /*skip条件，用于分页*/
        // $limit = rq('limit') ?:15;
        // $skip = (rq('page')?rq('page') - 1 : 0) * $limit;
        list($limit,$skip) = paginate(rq('page'),rq('limit'));
        /*排序 展示内容 数据格式*/
        $r = $this
            ->orderBy('created_at')
            ->limit($limit)
            ->skip($skip)
            ->get(['id','title','desc','created_at','updated_at'])
            ->keyby('id')
        ;
        return ['status' => 1,'data' => $r];

    }
    /*删除问题api*/
    public function del(){
        /*判断用户是否登陆*/
        if(!new_any('User')->is_logined())
            return ['status' => 0,'msg' =>'you shoud login'];
        /*是否有id*/
        if(!rq('id'))
            return ['status' => 0,'msg' => 'id is not requested'];
        
        $question = $this->find(rq('id'));
        /*是否查找到id的记录*/
        if(!$question)
            return ['status' => 0,'msg' => 'not found question'];
        /*判断登陆user_id与表中的user_id是否一致*/
        if(session('user_id') != $question->user_id)
            return ['status' => 0,'msg' => 'no power'];
        return $question->delete()?
            ['status' => 1]:
            ['status' => 0,'msg' =>'delete failed'];
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
   public  function answers_with_user_info()
   {
    return $this->answers()->with('user')->with('users');
   }
}
