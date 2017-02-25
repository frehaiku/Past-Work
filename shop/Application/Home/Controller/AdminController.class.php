<?php
namespace Home\Controller;

use Think\Controller;

class AdminController extends Controller
{
    public function admin()
    {
        if (!cookie('lalala')) {
            $this->redirect("Admin/login");
        }
        $goodsclaims = M('claims');
        $this->assign("claims", $goodsclaims->where('claimstatus=%d and kind=%d', 0, 0)->select());
        $this->display();
    }

    public function comment_manage()
    {
        $goodsclaims = M('claims');
        $this->assign("comment_claims", $goodsclaims->where('kind=1 and claimstatus=0')->select());
        $this->display();
    }

    public function login()
    {
        if (cookie('lalala')) {
            $this->redirect("admin");
        }
        $this->display();
    }

    public function login_verify()
    {

        $goodsadmin = M('admin');
        $data['username'] = I('username');
        $data['password'] = I('password');

        $correct = $goodsadmin->where($data)->find();
        if ($correct) {
            cookie("lalala", sha1(I('username')), 60 * 60 * 24);
            $status['num'] = 200;
            $status['tip'] = "登录成功";
            $this->ajaxReturn($status);
        } else {
            $status['num'] = 100;
            $status['tip'] = "账号密码错误";
            $this->ajaxReturn($status);
        }

    }

    public function fenghao()
    {
        $goodsuser = M('user');
        $goodsclaims = M('claims');
        $claims_id = I('claims_id');
        $userid = I("userid");

        $data['userstatus'] = 1;
        $save_res = $goodsuser->where("id=%d", $userid)->save($data);
        if ($save_res) {


            $this->ajaxReturn("已封用户id为" . $userid . "的用户");
        }

    }

    public function claims_com()
    {
        //$id = I('id');
        $comid = I('comid');
        $goodscomment = M('comment');
        $goodsuser = M('user');
        //$user_res = $goodsuser->where("user='%s'",cookie('id'))->find();
        //获取该条评论的详细信息
        $com_res = $goodscomment->where("id=%d", $comid)->find();

        //被举报人相关信息
        //$res_detail = $goodsdetail->relation('ReUser')->where("id=%d",$id)->find();
        //获取举报人信息
        $claimer = $goodsuser->where("user='%s'", cookie('id'))->find();
        $data['claimed'] = $com_res['commentid'];//将评论者的id增加到数据库
        $data['claimcontent'] = $com_res['commentcontent'];//将评论内容增加到内容
        $data['recordid'] = $comid;//将评论id```
        //$data['claim']=$user_res['id'];//将用户id序号

        $data['userid'] = $com_res['commentid'];

        $data['claim'] = $claimer['user'];
        $data['claimzname'] = $claimer['zname'];
        $data['claimschool'] = $claimer['school'];

        $id['id'] = $com_res['commentid'];
        $user_detail = $goodsuser->where($id)->find();

        $data['claimed'] = $user_detail['user'];
        $data['claimedzname'] = $user_detail['zname'];
        $data['claimedschool'] = $user_detail['school'];
        $data['kind'] = 1;


        $goodsclaims = M('claims');

        if (!$goodsclaims->where("claim='%s' and recordid=%d", cookie('id'), $comid)->find()) {

            if ($goodsclaims->add($data)) {
                $this->ajaxReturn("该评论举报成功");
            } else {
                $this->ajaxReturn("评论失败");
            }

        } else {
            $this->ajaxReturn("你已举报过此评论");
        }

    }

    public function delete_tie()
    {
        $claims_id = I('claims_id');
        $goodsclaims = M('claims');
        $recordid = I("recordid");
        $goodsdetail = M('detail');

        $data['deletestatus'] = 1;
        $delete_res = $goodsdetail->where("id=%d", $recordid)->save($data);
        if ($delete_res) {
            //不显示已处理的消息
            $bian_status['claimstatus'] = 1;
            $goodsclaims->where("id=%d", $claims_id)->save($bian_status);
            $this->ajaxReturn("删除成功");
        } else {
            $this->ajaxReturn("删除失败,此帖已被删除");
        }
    }

    public function delete_com()
    {
        $claims_id = I('claims_id');
        $recordid = I("recordid");
        $goodscomment = M('comment');
        $goodsclaims = M('claims');

        $data['deletestatus'] = 1;
        $delete_res = $goodscomment->where("id=%d", $recordid)->save($data);
        if ($delete_res) {
            //不显示已处理的消息
            $bian_status['claimstatus'] = 1;
            $goodsclaims->where("id=%d", $claims_id)->save($bian_status);
            $this->ajaxReturn("删除成功");
        } else {
            $this->ajaxReturn("删除失败,此评论已被删除");
        }
    }
}