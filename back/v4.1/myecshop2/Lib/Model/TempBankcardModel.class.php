<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2015/12/22
 * Time: 16:26
 */
class TempBankcardModel extends BaseModel
{
    protected $fields = array('temp_bankcard_id','temp_buyers_id','bank_icon','bank_type','bank_name','bank_code','bank_no','bind_mobile','user_name','user_card_no','card_type','bank_sign','time','_pk'=>'temp_bankcard_id', '_autoinc' => true );
    //获取快捷支付银行卡列表
    public function getBankcardInfos()
    {
        $condition['temp_buyers_id'] = $_SESSION['temp_buyers_id'];

        $res =  $this -> where($condition) -> field('temp_bankcard_id,bank_name,bank_type,bind_mobile,bank_no,bank_icon,card_type,bank_sign') -> select();
        if(!$res)
        {
            return array();
        }

        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $res[$i]['bank_no'] = '**** **** **** '.iconv_substr($res[$i]['bank_no'], -4);
            $res[$i]['bind_mobile'] = iconv_substr($res[$i]['bind_mobile'],0,3).' **** '.iconv_substr($res[$i]['bind_mobile'], -4);
        }
        return $res;
    }
    //银行卡号是否已经添加
    public function bankNoIsExist($bank_no)
    {
        $condition['bank_no'] = $bank_no;

        $res = $this -> where($condition) -> field('temp_bankcard_id') -> select();
        if($res)
        {
            $response = array("success"=>"false","error"=>array("msg"=>'该银行卡已经被绑定','code'=>4147));
            $response = ch_json_encode($response);
            exit($response);
        }else{
            return true;
        }
    }
    
    //通过银行卡 id 获取所需要的信息
    public function getInfoById($id)
    {

        $condition['temp_bankcard_id'] = $id;
        $condition['temp_buyers_id'] = $_SESSION['temp_buyers_id'];
        $res = $this -> where($condition) -> field('bank_type,bank_name,bank_code,bank_no,bind_mobile,user_name,user_card_no,bank_sign') ->find();
        if(!$res)
        {
            $response = array("success"=>"false","error"=>array("msg"=>'无效的银行卡','code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
        }
        return $res;
    }

    //add 和 info 接口都会调用这个函数
    //通过bank_name取出银行机构代码和银行图标 并判断第三方是否支持的银行卡
    public function getCodeAndIf($bank_name,$card_type)
    {
        //后面修改
        $data = array();
        if($card_type)
        {
            $banktype = ($card_type == '借记卡')?'DR':'CR';
            //获取麦网支付的储蓄卡信息
            $bankinfos = getMaiWangBankList($banktype);
            for($i=0,$len=count($bankinfos); $i<$len;$i++)
            {
                if($bankinfos[$i]->bankName == $bank_name)
                {
                    $data['bank_name'] = $bank_name;
                    $data['bank_icon'] = $banktype=='DR'?getDrCodeAndImg2($bank_name):getCrCodeAndImg2($bank_name);
                    $data['bank_code'] = $bankinfos[$i]->bankCode;
                    $data['bank_type'] = ($card_type == '借记卡')?0:1;
                    break;
                }
            }
        }
        else
        {
            $response = array("success"=>"false","error"=>array("msg"=>'该银行卡暂不支持','code'=>4145));
            $response = ch_json_encode($response);
            exit($response);
        }

        if(!$data)
        {
            $response = array("success"=>"false","error"=>array("msg"=>'该银行卡暂不支持','code'=>4146));
            $response = ch_json_encode($response);
            exit($response);
        }
        return $data;
    }

    //添加的银行卡不能超过5张
    public function bankNumLimit()
    {
        $condition['temp_buyers_id'] = $_SESSION['temp_buyers_id'];
        $num = $this ->where($condition)-> count();
        if($num>5)
        {
            $response = array("success"=>"false","error"=>array("msg"=>'最多添加5张银行卡','code'=>4152));
            $response = ch_json_encode($response);
            exit($response);
        }
        return true;

    }

}