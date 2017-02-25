<?php
namespace Home\Model;

use Think\Model;

class UserModel extends Model
{
    protected $_validate = array(
        array('GoodsName', 'require', '不能为空', 1),
        array('GoodsPrice', 'require', '不能为空', 1),
        array('GoodsContacts', 'require', '不能为空', 1),
        array('GoodsPhone', 'require', '不能为空', 1),
        array('GoodsDescibe', 'require', '不能为空', 1)
    );
}