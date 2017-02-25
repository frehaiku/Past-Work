<?php
namespace Home\Controller;

use Think\Controller;

class DetailController extends Controller
{
    public function detail()
    {
        $goodsdetail = D('detail');
        //$goodscomment = D('comment');
        //$this->comment_name=$goodscomment->where("detailid=%d",I('id'))->select();
        //print_r($goodsdetail->relation("ReUser")->select());

        $this->id_detail = $goodsdetail->relation('ReUser')->where('id=%d', I('id'))->select();//获取id参数的一条数据
        $goodsuser = M('user');
        // $this->assign("id",$goodsuser->where("user='%s'",cookie('id'))->find());
        $goodscomment = M('comment');
        $this->assign("comment", $goodscomment->where("detailid=%d and deletestatus=%d", I('id'), 0)->order("id desc")->select());
        $this->display();
    }

    public function person()
    {
        if (!cookie('id')) {
            $this->error('更多功能体验，请登录微信端');
        }
        redirectToSign();

        $goodsuser = M('user');
        $goodstype = D('type');
        $goodsstatus = D('status');
        $Detail = D('Detail');

        $ParamStatus = I('status');
        $ParamType = I('type');

        //东西类别选择，1.代步工具2.xxx
        $goodstype = M('type');
        $this->assign('all_type', $goodstype->select());

        //获取当前已经选中的status参数
        $this->assign('already_status', $ParamStatus);
        //改变下拉框的字
        $this->assign('select_font', $goodstype->where('typeid=%d', $ParamType)->find());

        //获取当前已经选中的type参数
        $this->assign('already_type', $ParamType);
        //var_dump($Detail->relation(true)->select());
        //类别选择后->where('goodsstatus=%d and type=%s',array(I('status'),I('type')))

        //根据status显示订单
        //where()条件里面加个openid


        if ($ParamStatus && $ParamType) {
            $data['goodstype'] = $ParamType;
            $data['goodsstatus'] = $ParamStatus;
            $data['useropenid'] = cookie('id');
        } else if ($ParamStatus) {
            $data['goodsstatus'] = $ParamStatus;
            $data['useropenid'] = cookie('id');
        } else if ($ParamType) {
            $data['goodstype'] = $ParamType;
            $data['useropenid'] = cookie('id');

        } else {

            $data['useropenid'] = cookie('id');
        }

        // var_dump($data);
        //var_dump($Detail->relation(true)->order('id desc')->select());
        //$data['useropenid']=$session('openid');
        $this->assign('statusdetail', $Detail->relation(true)->where($data)->order('id desc')->select());
        //全部订单
        //$this->assign('all',$Detail->where('useropenid=%s',));
        $this->assign('status', $goodsstatus->select());
        $this->display();
    }

    public function confirm()
    {
        redirectToSign();
        $goodsstatus = M('status');
        $goodsdetail = M('detail');
        $data['statusdescribe'] = "已完成";
        $res_id = $goodsstatus->where($data)->find();

        $goodsdetail->goodsstatus = $res_id['statusid'];
        $goodsdetail->where('id=%d', I('id'))->save();
        if ($goodsdetail > 0) {
            $this->ajaxReturn("确定收货成功");
        } else {
            $this->ajaxReturn("服务器出错请重试");
        }
        //$this->ajaxReturn(I('id'));
    }

    public function search()
    {
        $word = I('sou');
        $input_mes['goodsname'] = array('like', "%$word%");
        $goodsdetail = D('detail');
        $search_res = $goodsdetail->relation('ReUser')->where($input_mes)->select();
        $this->empty = "<h4>没有搜索结果</h4>";
        $this->assign('search_res', $search_res);
        $this->display();
    }

    public function tipsearch()
    {
        $word = I('word');
        $input_mes['goodsname'] = array('like', "%$word%");
        $goodsdetail = M('detail');
        $search_res = $goodsdetail->where($input_mes)->select();

        $this->ajaxReturn($search_res);
    }
    // public function search_submit(){
    // 	$word = I('sou');
    // 	$input_mes['goodsname'] = array('like',"%$word%");
    // 	$goodsdetail = M('detail');
    // 	$search_res = $goodsdetail->where($input_mes)->select();

    // 	$this->ajaxReturn($search_res);
    // }
    public function register()
    {
        cookie('id', I('id'), time() + 7 * 24 * 60 * 60 * 60);
        $this->display();
    }

    public function saveuser()
    {
        $goodsuser = M('user');

        $rules = array(
            array('nname', 'require', '公开昵称必须！'), //默认情况下用正则进行验证
            array('zname', 'require', '真实姓名必须！'), //默认情况下用正则进行验证
            array('kaohao', 'require', '考号必须！'), //默认情况下用正则进行验证
        );
        if (!$goodsuser->validate($rules)->create()) {
            $this->ajaxReturn($goodsuser->getError());
        }
        $data['user'] = cookie('id');
        $data['nname'] = I('nname');
        $data['zname'] = I('zname');
        $data['sex'] = I('sex');
        $data['school'] = I('school');
        if ($goodsuser->add($data)) {
            $this->ajaxReturn("保存成功");
        } else {
            $this->ajaxReturn("保存失败，请重试");
        }

    }

    public function btn_comment()
    {
        $detailid = I('detailid');
        $commentedid = I('commentedid');
        $commentcontent = I('commentcontent');

        $goodscomment = M('comment');
        $goodsuser = M('user');

        $user_res = $goodsuser->where("user='%s'", cookie('id'))->find();
        if (cookie('id')) {
            if ($user_res['userstatus'] != 1) {
                $data['detailid'] = $detailid;
                $data['commentedid'] = $commentedid;
                $data['commentid'] = $user_res['id'];
                $data['commentcontent'] = $commentcontent;
                $data['commentnname'] = $user_res['nname'];
//                var_dump($data);
                if ($goodscomment->add($data)) {
                    $this->ajaxReturn("评论成功");
                } else {
                    $this->ajaxReturn("评论失败");
                }
            } else {
                $this->ajaxReturn("您已被封号,不能评论");
            }
        } else {
            $this->ajaxReturn("评论功能请到微信端体验");
        }

    }
}