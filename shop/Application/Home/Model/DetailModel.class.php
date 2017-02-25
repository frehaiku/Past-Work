<?php
namespace Home\Model;

use Think\Model\RelationModel;

header("Content-type:text/html;charset=utf-8");


class DetailModel extends RelationModel
{
    protected $_link = array(
        'ReStatus' => array(
            'mapping_type' => self::BELONGS_TO,//不能漏掉self
            'class_name' => 'status',//关联目标数据表名
            'foreign_key' => 'goodsstatus',//当前表的外键
            'as_fields' => 'statusdescribe',//字段别名
            'mapping_fields' => 'statusdescribe',
            //'parent_key'=>'goodsstatus',//自引用关联的关联字段
        ),
        'ReType' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'type',
            'foreign_key' => 'goodstype',
            'mapping_fields' => 'goodstype',
            'as_fields' => 'goodstype:type',//当两个字段相同时要用：分开
        ),
        'ReUser' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'user',
            'foreign_key' => 'useropenid',
            'mapping_fields' => 'id,user,zname,nname,sex,school',
            'as_fields' => 'id:orderid,user,zname,nname,sex,school',
        ),
    );
}