<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
  
class Login_model extends CI_Model{  
    function __construct(){
        parent::__construct();
    }

    public function verify_users($username, $password){  
        $password = sha1($password);
        // 查询账户、密码均匹配的数据,使用CI的数据库查询类
        $row = $this->db->get_where('operator', array('account' => $username, 'password' => $password, 'status' => '1'),1)->row_array();
        // $row = $query->row_array();
        if( $row['account'] != '' ){  
            $data = array(
                'member_id' => $row['id'],
                'memo' => '登录成功'
            );
            // 添加登录日志
            // $this->db->insert('login_log', $data);
            // 更新登录次数和时间
             $this->db->set('update_time', date( 'Y-m-d H:i:s', time() ) );
            $this->db->update('operator');
            return $row;
        }

        // 区分匹配失败的具体原因
        $query = $this->db->get_where('operator',array( 'account' => $username, 'status' => '1' ),1);
        $row = $query->row_array();
        if( $row['account'] != '' ){
            $data = array(
                'member_id' => $row['id'],
                'memo' => '密码有误'
            );
        }else{
            $data = array(
                'member_id' => $row['id'],
                'memo' => '账户有误'
            );
        }
        // $this->db->insert('login_log', $data);
        return false;
    }

    public function get_login_info( $userid ){
        $data = $this->db->get_where( 'operator', array('id' => $userid, 'status' => '1') )->row_array();
        return $data;

    }
}  