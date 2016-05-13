<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Predis;
class RedisController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function index(){
        $redis = new Predis\Client();

        //$redis->llen('lists');
        $redis->lrange('lists',0,$redis->llen('lists'));
        //文章id
        $id = 1;

        //缓存点赞字符串格式， 数字为会员id，  键为文章id加固定前缀。
        //dd($redis->set('article_1','|2|,|5|,|18|,|9|,|55|,|550|,|555|'));

        //循环 1 - 999 的个会员ID
/*        for($member_id=1;$member_id<1000;$member_id++){

            //获取所有点赞用户id字符串
            $str = $redis->get('article_'.$id);

            //拼接成为需要的 字符串
            $newStr = '|'.$member_id.'|';

            //判断当前用户是否点赞
            $position = strpos($str,$newStr);

            //如果没有点赞 将点赞用户id加入到点赞字符串
            if($position === false){
                //判断缓存是否为空为空 前面不加 ‘，’；
                if($str){
                    $redis->set('article_'.$id,$str.','.$newStr);
                }else{
                    $redis->set('article_'.$id,$newStr);
                }
            }else{ //如果存在表示 已经缓存（已经点赞）
                echo $member_id.'<br>';
            }
        }*/



/*        dd(substr($str,$position,1));
        dd(strpos($str,(string)$member_id));*/

        //dd($redis->lpush('lists',array('1-2','2-2','3-2','4-2')));
        //dd($redis->rpop('lists'));

        //dd($ExamQuestionType->get());
        //$ExamQuestionType->append(['name'=>'dfdfdf']);
        /*        $i = 0;
                while($i<10){
                    $redis->lpush('lists',[rand(1,10),rand(1,10)]);
                    $i++;
                }*/


//set_time_limit(0);
        /*        $redis->subscribe(array('channel-1'), function ($redis, $chan, $msg) {
                    // do something
                    echo $msg;
                });*/
        /*        if($list =  $redis->brpop('lists',0)) {
                    $ExamQuestionType->name = $list[1];
                    $ExamQuestionType->save();
                    sleep(5);
                }*/

        //$redis->lpush('lists',array('1','2'));

        //$list =  $redis->brpop('lists',30);

        return  view('index');
        //dd($client);
    }
}
