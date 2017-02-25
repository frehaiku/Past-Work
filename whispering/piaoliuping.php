<?php

/**
 * @param $wechat WechatSubscribedAccountSDK对象
 * @param $responseList 微信返回的xml数组，见https://mp.weixin.qq.com/wiki/17/f298879f8fb29ab98b2f2971d42552fd.html#.E6.96.87.E6.9C.AC.E6.B6.88.E6.81.AF
 */
function whisperRun($wechat, $responseList)
{
    //$message = $this->message;


//$ret = preg_match('/(?:扔瓶子|漂流瓶|查看|参与的瓶子|捡瓶子|回复+|我要说|我是|[0-9])(.*)/i', $this->message['content'], $matchs);

//-------------------------------初始化数据库--------------------
    $con = mysql_connect("localhost", "root", "");//连接数据库
    mysql_select_db("huizhougzs", $con);
    mysql_query("set character set 'utf8'");//读库
    mysql_query("set names 'utf8'");//写库
//---------------------------------------------------------------

    if (!$con) {
        die('Could not connect:' . mysql_error());
    }
    $fromUsername = $responseList['FromUserName'];

    $str = $responseList['Content'];


    $sql = "SELECT * FROM `user` WHERE `USERID` = '" . $fromUsername . "'";
    $row = mysql_query($sql, $con);//查询用户是否在列表中
    $rs = mysql_fetch_array($row);

    $USER = $rs['USERID'];

    $temp = 0;//标志量，为0时，不能操作某些操作

    if ($str == "扔瓶子") {
        if ($USER == $fromUsername) {
            $content = "请输入要发表的瓶子信息,以“我要说”，格式如：我要说惠州高中生真棒！";

        } else {
            respText($wechat, "你还没有加入漂流瓶,请发送“漂流瓶”加入吧");
        }
        respText($wechat, $content);
    }

    if ($str == "漂流瓶") {
        $content = "请输入你的昵称，真实学校，性别用逗号隔开
    格式如：我是海枯,惠州市第一中学,男";

        respText($wechat, $content);
    }

    $strIs = substr($str, 0, 6);

    if ($strIs == "我是") {
        $isContent = substr($str, 6);
        $arr_con = explode(",", $isContent);
        if (count($arr_con) != 3) { //验证输入字符的合法性
            $content = "请输入正确格式,格式如：我是海枯,惠州市第一中学,男";
        } else {
            $sql = "INSERT INTO user (USERID,NAME,SCHOOL,SEX) VALUES ('" . $fromUsername . "','" . $arr_con['0'] . "','" . $arr_con['1'] . "','" . $arr_con['2'] . "')";
            mysql_query($sql);
            $content = "保存信息成功！请输入要发表的瓶子信息,以“我要说”，格式如：我要说惠州高中生真棒！";
        }
        respText($wechat, $content);

    }


    $strISaid = substr($str, 0, 9);
    if ($strISaid == "我要说") {
        $saidContent = trim(substr($str, 9));
        if ($saidContent != "") {
            $sql = "SELECT * FROM `bottle` WHERE `PEOPLEID` = '" . $fromUsername . "'order by ID desc limit 1";
            $row1 = mysql_query($sql);
            $rs1 = mysql_fetch_array($row1);
            $limit_year = substr($rs1['CREATE_TIME'], 0, 4);//最近一条记录的年份
            $limit_month = substr($rs1['CREATE_TIME'], 5, 2);//最近一条记录的月份
            $limit_day = substr($rs1['CREATE_TIME'], 8, 2);//最近一条记录的天数
            $limit_hour = substr($rs1['CREATE_TIME'], 11, 2);//最近一条的hour


            $create_time = date('Y-m-d H:i:s');
            $p_year = substr($create_time, 0, 4);
            $p_month = substr($create_time, 5, 2);
            $p_day = substr($create_time, 8, 2);
            $p_hour = substr($create_time, 11, 2);
            //计算一个小时内该用户发了多少贴
            $likeh = $p_year . "-" . $p_month . "-" . $p_day . " " . $p_hour;
            $sql = "SELECT COUNT(*) FROM bottle where `PEOPLEID` = '" . $fromUsername . "' and `CREATE_TIME` like " . $likeh . '%';
            $rs2 = mysql_fetch_array(mysql_query($sql));
            $sum = $rs2[0];

            if ($p_year == $limit_year && $p_month == $limit_month && $limit_day == $p_day && $limit_hour == $p_hour) {
                if ($sum > 2) {
                    $content = "每小时只能扔3个瓶子，你已经达到上限了。";

                } else {
                    $sql = "INSERT INTO bottle (CONTENT,PEOPLEID,peoplenick,CREATE_TIME,peopleschool) VALUES ('" . $saidContent . "','" . $fromUsername . "','" . $rs['NAME'] . "','" . $create_time . "','" . $rs['SCHOOL'] . "')";
                    mysql_query($sql);
                    $content = "发布成功";
                }
            } else {
                $sql = "INSERT INTO bottle (CONTENT,PEOPLEID,peoplenick,CREATE_TIME,peopleschool) VALUES ('" . $saidContent . "','" . $fromUsername . "','" . $rs['NAME'] . "','" . $create_time . "','" . $rs['SCHOOL'] . "')";
                mysql_query($sql);
                $content = "发布成功";
            }
        } else {
            $content = "内容不能为空";
        }
        respText($wechat, $content);
    }


    if ($str == "捡瓶子") {
        if ($USER == $fromUsername) {

            $result = mysql_query("select ID from bottle where PEOPLEID!='$fromUsername'");
            while ($row = mysql_fetch_assoc($result)) {
                $arr[] = $row['ID'];
            }
            $randomId = array_rand($arr, 1);

            //setcookie("reply_num",$randomId,time()+600);
            $_SESSION['reply_num'] = $arr[$randomId];

            $reply_num = $randomId;//储存瓶子id
            $sql = "select * from bottle where ID = " . $arr[$randomId];
            //. "and PEOPLEID!=".$fromUsername
            $row = mysql_fetch_array(mysql_query($sql));

            if (empty($row)) {
                $content = "捡不到瓶子了，瓶子都被你捡完啦！";
            } else {

                $peoplenick = $row['peoplenick'];
                $peopleschool = $row['peopleschool'];
                $p = $row['CONTENT'];

                unset($arr[$randomId]);//去除自己拿到的瓶子
                $content = "你捡到的瓶子来自" . $peopleschool . "\n" . $peoplenick . "：\n" . $p;
                $content .= "\n你可以回复此瓶子，若要回复此瓶子，格式为：回复+回复内容";
            }

        } else {
            $content = "你还没有加入漂流瓶,请发送“漂流瓶”加入吧";
        }
        //$sql1 = "SELECT group_concat(ID) FROM bottle";
        //$row3=mysql_fetch_array(mysql_query($sql1));//所有瓶子的数组


        respText($wechat, $content);

    }
    $reply_font = substr($str, 0, 7);
    if ($reply_font == "回复+") {
        if ($USER != $fromUsername) {
            respText($wechat, "你还没有加入漂流瓶,请发送“漂流瓶”加入吧");
            exit(0);
        }
        $reply_content = substr($str, 7);
        $create_time = date('Y-m-d H:i:s');
        $uid = $_SESSION['reply_num'];
        $sql = "INSERT INTO bottle (CONTENT,parentid,PEOPLEID,peoplenick,CREATE_TIME,duifangid,peopleschool) VALUES 
    ('" . $reply_content . "','" . $uid . "','" . $fromUsername . "','" . $rs['NAME'] . "','" . $create_time . "','" . $rs['ID'] . "','" . $rs['SCHOOL'] . "')";

        mysql_query($sql);
        respText($wechat, "回复成功。如果你还要捡瓶子请回复“捡瓶子”");


    }

    if ($str == "参与的瓶子") {
        if ($USER != $fromUsername) {
            respText($wechat, "你还没有加入漂流瓶,请发送“漂流瓶”加入吧");
            exit(0);
        }
        $row = mysql_query("select * from bottle where PEOPLEID ='$fromUsername'");//找我的瓶子的相关信息

        $rowall = mysql_query("select * from bottle");//全部瓶子的信息
        $arr_id = array();
        $arr_con = array();
        while ($rs = mysql_fetch_array($row, MYSQL_ASSOC)) {//我的瓶子
            array_push($arr_id, $rs['ID']);
            array_push($arr_con, $rs['CONTENT']);
        }
        while ($rsall = mysql_fetch_assoc($rowall)) {
            for ($i = 0; $i < count($arr_id); $i++) {
                if ($arr_id[$i] == $rsall['parentid'] && $rsall['isread'] == 0) {
                    mysql_query("update bottle set isread = 1 where id='" . $rsall['ID'] . "'");
                    $content .= $rsall['ID'] . $rsall['peoplenick'] . "回复你" . $arr_con[$i] . "的瓶子:\n";
                    $content .= "内容为" . $rsall['CONTENT'] . "\n";
                }
            }
        }


        $content .= "回复相应的编号,回复对方,格式为：TO数字空格(空格后面是你要回复的内容)" . "\n";
        $content .= "==================================" . "\n";
        $row1 = mysql_query("select * from bottle where PEOPLEID ='$fromUsername'");//找我的瓶子的相关信息
        $temp = 1;
        $temp1 = 1;
        while ($rs = mysql_fetch_assoc($row1)) {

            //$content[]=$rs['ID'];
            if ($rs['parentid'] == 0) {   //自己扔的瓶子

                if ($temp == 1) {
                    $content .= "我扔的瓶子：\n";
                    $temp = 2;
                }
                $content .= "序号为  " . $rs['ID'] . " 主题为" . $rs['CONTENT'] . "\n";

            } else {  //我回复过的瓶子
                if ($temp1 == 1) {
                    $content .= "我回复过的瓶子：\n";
                    $temp1 = 2;
                }
                $content .= "序号为  " . $rs['ID'] . " 主题为" . $rs['CONTENT'] . "\n";
            }
        }
        //$content .= "回复瓶子的编号便可查看瓶子的全部内容";
        respText($wechat, $content);

    }
    $replybianhao = substr($str, 0, 2);
    if ($replybianhao == "TO") {
        $r_num = substr($str, 2);
        $arr_con = explode(" ", $r_num);
        $r_num = $arr_con[0];//获取编号
        $create_time = date('Y-m-d H:i:s');
        $r_content = substr($str, strlen($r_num) + 2 + 1);//获取输入内容

        $result = mysql_query("INSERT INTO bottle (CONTENT,parentid,PEOPLEID,peoplenick,CREATE_TIME,duifangid,peopleschool) VALUES 
    ('" . $r_content . "','" . $r_num . "','" . $fromUsername . "','" . $rs['NAME'] . "','" . $create_time . "','" . $rs['ID'] . "','" . $rs['SCHOOL'] . "')");
        if ($result) {
            $content = "回复对方成功";
        } else {
            $content = "回复失败,无此id";
        }
        respText($wechat, $content);
    }
// $look=substr($str,0,6);
// if($look == "查看"){
//     $detailId = substr($str,6);

//     $row=mysql_fetch_array(mysql_query("select CONTENT from bottle where ID='$detailId' or parentid='$detailId'"));
//     foreach($row as $value){

//     }
//     respText($wechat,$row['CONTENT']);
// }

}

/**
 * @param $wechat WechatSubscribedAccountSDK对象
 * @param $text 微信返回给用户的内容
 * @return bool
 */
function respText($wechat, $text)
{
    $wechat->text($text)->reply();
    return true;
}
