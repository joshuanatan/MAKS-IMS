<?php
class M_database extends CI_Model{
    public function getDataTable($where,$field,$or_like = "",$order_by,$direction,$limit,$offset){
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->select($field);

        $this->db->group_start();
        $this->db->where($where);
        $this->db->group_end();
        if($or_like != ""){
            $this->db->group_start();
            $this->db->or_like($or_like);
            $this->db->group_end();
        }
        $this->db->order_by($order_by,$direction);
        return $this->db->get("v_master_db_connection");
    }
}