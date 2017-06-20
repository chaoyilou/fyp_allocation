<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
  
class Login_model extends CI_Model{  
    function __construct(){
        parent::__construct();
    }

    public function verify_users($username, $password){  
        $password = sha1($password);
        // 查询账户、密码均匹配的数据,使用CI的数据库查询类
        // 获取数据：第一个参数为表名，第二个参数为获取条件，第三个参数为条数
        // => 数组带索引元素的key和value映射时使用的运算符； e.g status是键名（key），1是键值（value）
        $row = $this->db->get_where('students', array('account' => $username, 'password' => $password, 'status' => '1'),1)->row_array();
        // $row = $query->row_array();
        // row_array() 只返回一行数组
        if( $row['account'] != '' ){  
            $data = array(
                'member_id' => $row['id'],
                'memo' => 'Login Successfully'
            );
            // 添加登录日志
            // $this->db->insert('login_web_log', $data);
            // 更新登录次数和时间
            $this->db->set('update_time', date( 'Y-m-d H:i:s', time() ) );
            //$this->db->set('logined_count', 'logined_count+1',FALSE)->where('id', $row['id'])->update('students');
            return $row;
        }

        // 区分匹配失败的具体原因
        $query = $this->db->get_where('students',array( 'account' => $username, 'status' => '1' ),1);
        $row = $query->row_array();
        if( $row['account'] != '' ){
            $data = array(
                'member_id' => $row['id'],
                'memo' => 'Wrong Password'
            );
        }else{
            $data = array(
                'member_id' => $row['id'],
                'memo' => 'Wrong Username'
            );
        }
        //$this->db->insert('login_log', $data);
        return false;
    }

    public function get_login_info( $userid ){
        $data = $this->db->get_where( 'students', array('id' => $userid, 'status' => '1') )->row_array();
        return $data;

    }
}  