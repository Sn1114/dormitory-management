<?php
	header('content-type:text/html;charset=utf-8');
	define('APP','itcast');
	session_start();
	//echo "111111";
	
	//如果用户已经登录,直接跳转
	if(isset($_SESSION['user_id'])&&isset($_SESSION['user_type'])){
		$user_type=$_SESSION['user_type'];
		header("Location: ../$user_type/home.php");
	}
	
	if($_POST){
		require './_share/_pdo.php';
		$account=$_POST['account'];   //账号
		$pwd=$_POST['pwd'];         //密码
		$captch=$_POST['captch'];   //验证码
		$type=$_POST['type'];      //登录类型
		//if(strtolower($captch)==strtolower($_SESSION['captcha'])){
		//	$type=$_POST['type'];
			if(!empty($account)&&!empty($pwd)&&!empty($type)){
				$sql="select * from t_$type where account='$account' and pwd='$pwd'";
				$result=$pdo->query($sql);
				$row=$result->fetch();
				$id=$row['id'];
				$name=$row['name'];
				$sex=$row['sex'];
				if(!empty($id)){
					$_SESSION['user_id']=$id;
					$_SESSION['user_account']=$account;
					$_SESSION['user_type']=$type;
					$_SESSION['user_name']=$name;
					$_SESSION['user_sex']=$sex;
					header("Location: ../$type/home.php");
				}else{
					$pwd=null;//清空密码
					$msg="您输入的账号或密码有误，请重试";
				}
			}
		//}else{
		//	$msg="您输入的验证码有误，请重试"; 													// 验证码图片生成有问题暂时注释
		//}
	}

	require './view/login_html.php';
?>