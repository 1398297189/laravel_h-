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
        //����id
        $id = 1;

        //��������ַ�����ʽ�� ����Ϊ��Աid��  ��Ϊ����id�ӹ̶�ǰ׺��
        //dd($redis->set('article_1','|2|,|5|,|18|,|9|,|55|,|550|,|555|'));

        //ѭ�� 1 - 999 �ĸ���ԱID
/*        for($member_id=1;$member_id<1000;$member_id++){

            //��ȡ���е����û�id�ַ���
            $str = $redis->get('article_'.$id);

            //ƴ�ӳ�Ϊ��Ҫ�� �ַ���
            $newStr = '|'.$member_id.'|';

            //�жϵ�ǰ�û��Ƿ����
            $position = strpos($str,$newStr);

            //���û�е��� �������û�id���뵽�����ַ���
            if($position === false){
                //�жϻ����Ƿ�Ϊ��Ϊ�� ǰ�治�� ��������
                if($str){
                    $redis->set('article_'.$id,$str.','.$newStr);
                }else{
                    $redis->set('article_'.$id,$newStr);
                }
            }else{ //������ڱ�ʾ �Ѿ����棨�Ѿ����ޣ�
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
