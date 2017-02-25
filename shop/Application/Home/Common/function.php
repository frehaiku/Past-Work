 <?php
 function redirectToSign()
 {
     $usersModel = M('user');
     $ret = $usersModel->where(array('user' => $_COOKIE['id']))->find();
     if (empty($ret)) {
         redirect(U('Home/Detail/register'));
     }
 }