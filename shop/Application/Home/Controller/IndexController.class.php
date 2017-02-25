<?php
namespace Home\Controller;

use Think\Controller;

header("Content-type:text/html;charset=utf-8");

class IndexController extends Controller
{
    const SUCCESS_CODE = 200;
    const FAIL_CODE = 100;

    public function index()
    {
        if (!empty(I('id')))
            cookie('id', I('id'), 7 * 24 * 60 * 60 * 60);
        //session('openid','xxx');
        $goodsuser = M('user');
        $goodstype = M("type");
        $goodsdetail = D('detail');

        $param_sch = I('get.school');


        //$User = M('User');  实例化User对象// 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取$list = $User->where('status=1')->order('create_time')->page($_GET['p'].',25')->select();$this->assign('list',$list);// 赋值数据集$count      = $User->where('status=1')->count();// 查询满足要求的总记录数$Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数$show       = $Page->show();// 分页显示输出$this->assign('page',$show);// 赋值分页输出


        //查找type表的id
        $this->empty = "<p style='text-align:center;'>木有记录哟。</p>";

        $block['goodstype'] = I('type', '', 'urldecode');
        $type_id = $goodstype->where($block)->find();

        //分type排列
        $order_type['goodstype'] = $type_id['typeid'];
        $order_type['goodsstatus'] = 1;//物品进行状态
        $order_type['deletestatus'] = 0;//物品是否被删除状态
        //从user表中获取学校
        // $mes_school=$goodsuser->where("user='%s'",cookie('id'))->find();
        //$order_type['userschool']=$mes_school['school'];
        //$this->block=$goodsdetail->where($order_type)->order('id desc')->select();

        //如果有school参数就根据参数去数据库取值判断
        if ($param_sch) {
            $order_type['userschool'] = $param_sch;
            $block = $goodsdetail->where($order_type)->order('id desc')->page($_GET['p'] . ',6')->select();
            $Count = $goodsdetail->where($order_type)->count();// 查询满足要求的总记录数
        } else {

            $block = $goodsdetail->where($order_type)->order('id desc')->page($_GET['p'] . ',6')->select();
            $Count = $goodsdetail->where($order_type)->count();// 查询满足要求的总记录数
        }


        $this->assign('block', $block);// 赋值数据集

        $Page = new \Think\Page($Count, 6);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('prev', '<span aria-hidden="true">上一页</span>');//上一页
        $Page->setConfig('next', '<span aria-hidden="true">下一页</span>');//下一页
        $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
        $Page->setConfig('last', '<span aria-hidden="true">尾页</span>');//最后一页
        //$AllPage->setConfig('theme','');设置你想显示的按钮，%XXXX%含义参照图示
        $Page->setConfig('theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %END%%DOWN_PAGE% ');
        $show = $Page->show();// 分页显示输出
        $this->assign('page', $show);// 赋值分页输出


        //从user表中获取学校
        $mes_school = $goodsuser->where("user='%s'", cookie('id'))->find();
        //学校名称！
        $this->assign("school_name", $mes_school['school']);


        $order_type1['goodsstatus'] = 1;
        $order_type1['deletestatus'] = 0;//物品是否被删除状态
        if ($param_sch) {
            //全部
            $order_type1['userschool'] = $param_sch;
            $Alllist = $goodsdetail->where($order_type1)->order('id desc')->page($_GET['p'] . ',6')->select();
            $AllCount = $goodsdetail->where($order_type1)->count();// 查询满足要求的总记录数
        } else {
            //全部
            $Alllist = $goodsdetail->where($order_type1)->order('id desc')->page($_GET['p'] . ',6')->select();
            $AllCount = $goodsdetail->where($order_type1)->count();// 查询满足要求的总记录数
        }

        $this->assign('alllist', $Alllist);// 赋值数据集

        $AllPage = new \Think\Page($AllCount, 6);
        $AllPage->setConfig('prev', '<span aria-hidden="true">上一页</span>');//上一页
        $AllPage->setConfig('next', '<span aria-hidden="true">下一页</span>');//下一页
        $AllPage->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
        $AllPage->setConfig('last', '<span aria-hidden="true">尾页</span>');//最后一页
        //$AllPage->setConfig('theme','');设置你想显示的按钮，%XXXX%含义参照图示
        $AllPage->setConfig('theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %END% %DOWN_PAGE% ');
        // 实例化分页类 传入总记录数和每页显示的记录数
        $AllShow = $AllPage->show();// 分页显示输出
        $this->assign('allpage', $AllShow);// 赋值分页输出

        $this->type = $goodstype->select();//导航栏
        //获取参数id
        $this->id = I(get . id);
        $this->id_detail = $goodsdetail->where('id=%d', I(get . id))->select();//获取id参数的一条数据
        $this->assign('index_param_type', I('type', '', 'urldecode'));
        //下拉框筛选学校
        $goodsschool = M("school");
        $select_school = $goodsschool->select();
        $this->assign("select_school", $select_school);
        $arr_jilv_count = array();
        foreach ($select_school as $value) {

            $eachc = $goodsdetail->where("userschool='%s' and goodsstatus=%d", $value['schoolname'], 1)->count();


            array_push($arr_jilv_count, $eachc);
        }
        $this->assign("arr_jilv_count", $arr_jilv_count);
        //共xxx件商品
        //$this->assign("count_goods",$goodsdetail->where("userschool='%s'",I('school')));
        //var_dump($arr_jilv_count);
        $this->display();
    }

    public function add()
    {
        redirectToSign();

        $this->assign('param_type', I('get.type', '', 'urldecode'));
        $this->display();
    }

    //将各字段写进数据库
    public function add_database()
    {
        $goodsuser = M('user');
        $school = $goodsuser->where('user=%s', cookie('id'))->find();

        $data['goodstype'] = urldecode(I("get.type", "", "urldecode"));
        $data['goodsname'] = I('post.GoodsName');
        $data['goodsprice'] = I('post.GoodsPrice');
        $data['contactsname'] = I('post.GoodsContacts');
        $data['contactsphone'] = I('post.GoodsPhone');
        $data['goodsdescibe'] = I('post.GoodsDescibe');
        $data['goodsimageurl'] = "/FleaMarket/" . $url;
        $data['goodstime'] = date("Y-m-d H:i:s");
        $data['userschool'] = $school['school'];

        //添加到数据库

        $AddResult = $detail->add($data);
        if ($AddResult) {
            //输出成功信息到view
            $status = SUCCESS_CODE;
            echo "发布成功";
            // $SuccessDetail="发布成功";
            header("Location:{:U('index')}");
        } else {
            //输出失败信息view
            $status = FAIL_CODE;
            //$ErrorDetail= "发布失败请重试";
            echo "发布失败请重试";
        }
        //$this->assign('status',$status);
        //$this->assign('SuccessDetail',$SuccessDetail);
        //$this->assign('ErrorDetail',$ErrorDetail);
        //$this->display('add');
    }

    public function upload()
    {
        redirectToSign();

        $file_path = "";//存放url
        $file_name = "";
        //检验字段合法性
        $rules = array(
            array('goodsname', 'require', '名字不能为空', 1),
            array('goodsprice', 'require', '价格不能为空', 1),
            // array('contactsname','require','联系人不能为空',1),
            // array('contactsphone','require','联系人电话不能为空',1),
            array('goodsdescribe', 'require', '描述不能为空', 1),
        );


        $detail = M('detail');
        //1.先判断文本框字段的合法性，再判断上传图片的合法性
        if (!$detail->validate($rules)->create()) {
            $status = FAIL_CODE;
            //$ErrorDetail = $detail -> getError();    //输出失败信息到前台
            $ErrorMes = $detail->getError();
            //echo $ErrorMes;
            echo "<script>window.history.go(-1);</script>";
            echo "<script>alert('$ErrorMes');</script>";
        } else {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 10485760;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './';
            $upload->saveName = "time";
            $upload->savePath = C('USER_IMAGE'); // 设置附件上传目录

            // 上传文件
            $info = $upload->upload();
            $upload_err = "";
            if (!$info) {
                // 上传错误提示错误信息        
                $status = FAIL_CODE;
                //$ErrorDetail = $upload->getError();

                $upload_err = $upload->getError();
                // echo "<script>window.history.go(-1);</script>";
                // echo "<script>alert('$ErrorMes');</script>";
                /*没有上传图片时，将默认图片作为图片*/
                if ($upload_err == '没有文件被上传！') {

                    $this->add_handle(C("DEFAULT_PIC_PATH"));

                } else {
                    $this->error($upload_err);
                }
            } else {
                // 上传成功
                //成功则拼出图片的路径，方便存进数据库，数组如下
                //Array ( [AddPic] => Array ( [name] => book_icon.png [type] => image/png [size] => 2988[savename] => 1445356295.png [savepath] => /Uploads/2015-10-20/ ) )

                foreach ($info as $file) {
                    $file_path = './' . $file['savepath'] . $file['savename'];
                    $file_name = $file['savename'];
                    $file_savepath = $file['savepath'];
                }
                //处理缩略图
                $image = new \Think\Image();
                // print_r($image);
                // print_r($file_path);
                $image->open($file_savepath . $file_name);
                $image->thumb(350, 1000)->save($file_savepath . $file_name);

                //$this->add_database();

                $this->add_handle($file_path);

            }
        }

    }

    public function add_handle($pic_path)
    {
        $detail = M('detail');
        //获取用户表的学校名称，方便写进数据表
        $goodsuser = M('user');
        $school = $goodsuser->where("user='%s'", cookie('id'))->find();
        //限制一天发三贴
        $record = $detail->where("useropenid='%s'", cookie('id'))->select();

        $currentTime = date("Y-m-d");
        $Dcount = 0;
        $Wcount = 0;
        //每周
        /*foreach ($record as $value) {

            $cYear = substr($currentTime, 0, 4);//当前年份
            $cMonth = substr($currentTime, 5, 2);//当前月份
            $cDay = substr($currentTime, 8, 2);//当前日
            $gYear = substr($value['goodstime'], 0, 4);//记录年份
            $gMonth = substr($value['goodstime'], 5, 2);//记录月份
            $gDay = substr($value['goodstime'], 8, 2);//记录日
            if ($cYear == $gYear && $cMonth == $gMonth && $cDay - $gDay <= 7) {
                $Wcount++;
                if ($Wcount >= 5) echo "<script>alert('每周不能超过五贴');window.history.back();</script>";
            }
        }
        //每天
        foreach ($record as $value) {

            $gTime = substr($value['goodstime'], 0, 10);
            if ($currentTime == $gTime) {
                $Dcount++;
                if ($Dcount >= 3) echo "<script>alert('每天不能超过三贴');window.history.back();</script>";

            }
        }*/
        if (cookie('id')) {
            if ($school['userstatus'] != 1) {

                if ($Dcount < 3 && $Wcount < 5) {
                    //添加到数据库
                    //把goodstype的id作为外键
                    //获取隐藏域中的value

                    $type['goodstype'] = I('post.param_type');

                    $GoodType = M('type');
                    $ForeignKey = $GoodType->where($type)->find();
                    //echo $ForeignKey['TypeId']."号";
                    $data = array();
                    $data['goodstype'] = $ForeignKey['typeid'];
                    $data['goodsname'] = I('post.goodsname');
                    $data['goodsprice'] = I('post.goodsprice');
                    //$data['contactsname']  =I('post.contactsname');
                    //$data['contactsphone'] =I('post.contactsphone');
                    $data['contactsname'] = $school['nname'];
                    $data['goodsdescribe'] = I('post.goodsdescribe');
                    $data['goodsimageurl'] = $pic_path;
                    $data['goodstime'] = date("Y-m-d H:i:s");
                    $data['useropenid'] = cookie('id');
                    $data['userschool'] = $school['school'];
                    $AddResult = $detail->add($data);

                    if ($AddResult) {
                        //输出成功信息到view
                        $status = SUCCESS_CODE;
                        $SuccessDetail = "发布成功";
                        echo "<script>window.location.href='" . U('index', 'p=1') . "'</script>";
                        echo "<script>alert('$SuccessDetail');</script>";

                        //header("Location:{:U('index')}");
                    } else {
                        //输出失败信息view
                        $status = FAIL_CODE;
                        //$ErrorDetail= "发布失败请重试";
                        echo "<script>alert('发布失败请重试')</script>";
                    }
                }
            } else {
                echo "<script>alert('你曾发违法信息，现已被封号，解封请联系管理员')</script>";
                echo "<script>window.history.back();</script>";
            }
        } else {
            echo "<script>alert('请在微信端发布，体验更多功能请到微信端')</script>";
            echo "<script>window.history.back();</script>";
        }

    }
    // public function claims(){
    //     $goodsuser = M('user');
    //     $this->assign("id",$goodsuser->where("user='%s'",cookie('id'))->find());
    //     $this->display();
    // }
    public function submit_claims()
    {
        redirectToSign();

        $goodsuser = M('user');
        $goodsclaims = M('claims');
        $goodsdetail = D('detail');
        $id = I('id');
        $cm_content = I('cm_content');
        //被举报人相关信息
        $res_detail = $goodsdetail->relation('ReUser')->where("id=%d", $id)->find();
        //获取举报人信息
        $claimer = $goodsuser->where("user='%s'", cookie('id'))->find();


        $data['claim'] = $claimer['user'];
        $data['claimzname'] = $claimer['zname'];
        $data['claimschool'] = $claimer['school'];
        $data['claimed'] = $res_detail['user'];
        $data['claimedzname'] = $res_detail['zname'];
        $data['claimedschool'] = $res_detail['school'];
        $data['claimcontent'] = $cm_content;
        $data['userid'] = $res_detail['orderid'];
        $data['recordid'] = $id;

        //每个帖子，每人只能举报一次
        $limit = $goodsclaims->where("recordid=%d and claim='%s' and kind=%d", $id, $claimer['user'], 0)->find();

        if (!$limit) {
            $add_res = $goodsclaims->add($data);
            if ($add_res) {
                $this->ajaxReturn("举报成功");
            } else {
                $this->ajaxReturn("服务器错误，请重试");
            }

        } else {
            $this->ajaxReturn("每张帖子每人只能举报一次");
        }

    }

}