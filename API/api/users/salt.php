<?php
    /**************************************************************************
     *  接口:
     *      {
     *          auth_code: 验证码，
     *          user_email: 账户
     *      }
     *  返回:
     *      {
     *          data: {salt: xxxx},
     *          current_user: xxx
     *      }
     *  手机验证码验证用户，请求salt，返回salt；
     **************************************************************************/
    
    //会话ID
    session_id('');
    //开启会话
    session_start();
    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Type: text/plain');
    
    error_reporting(0);
    //连接数据库
    include "../../connection/connection.php";
    //导入相关方法
    include "../../common/utils.php";
    
    /* =================================================================
     *  更新数据库，添加用户手机号；
     *  需要注意，此方法需要传入连接数据库后返回的$conn对象, 否则方法内部的$conn只是一个局部定义的变量，
     *  并不是导入的 $conn 对象；
     *  @return: Boolean
    ================================================================= */
    function update_db($conn, $email, $phone){
        $sql = "update users set phone_num='$phone' where email='$email';";
        $result = $conn->query($sql);
        return $result;
    }

/* ========================================我是分割线======================================================= */
    
    //获取接口数据
    $DATA = get_post_data();
    $auth_code = $DATA['auth_code'];
    $email = $DATA['user_email'];
    
    $sql = "select phone_num, salt from users where email='$email';";
    //获取手机号
    $phone_num = $conn->query($sql)->fetch_array()[0];
    //获取salt
    $salt = $conn->query($sql)->fetch_array()[1];
    
    /* session过期，清除send-sms.php中设置的session数据 */
    if( isset($_SESSION['expireTime']) and $_SESSION['expireTime'] < time()){
        //清除session数据
        unset($_SESSION['code']);
        unset($_SESSION['expireTime']);
        unset($_SESSION['phone_num']);
        echo response_message("Session Expired. Please Send Verification Code Again.");
        exit(0);
    }
    
    /* 验证成功 */
    if( $auth_code == $_SESSION['code'] ){
        //清除session数据
        unset($_SESSION['code']);
        unset($_SESSION['expireTime']);
        //更新用户手机号
        if ($phone_num == '0'){
            update_db($conn, $email, $_SESSION['phone_num']);
            unset($_SESSION['phone_num']);
        }
        echo response_data(array('salt'=>$salt));
    }else{
        echo response_message("Session Expired. Please Send Verification Code Again.");
    }
    
    
?>