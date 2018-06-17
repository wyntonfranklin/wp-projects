<?php
/**
 * Created by PhpStorm.
 * User: shady
 * Date: 5/5/2018
 * Time: 8:51 PM
 */

class WfModel {

    private $_db;
    private $_table;
    private $_data;

    public $limit = 5;
    public $offset =0;

    public function __construct($table_name='') {

        global $wpdb;
        $this->_db = $wpdb;
        $this->_table = $table_name;
    }

    public function findByPk( $value, $key ){
        $sql = 'SELECT * from '.$this->table() .' WHERE '.$key . '='.$value;
        $results = $this->db()->get_row($sql,ARRAY_A);
        $this->setData( $results );
        return $this->getData();
    }

    public function findAll($where=''){
        $sql = 'SELECT * from '.$this->table() . " " . $where;
        $results = $this->db()->get_results($sql,ARRAY_A);
        $this->setData( $results );
        return $this->getData();
    }

    public function getCount($where=''){
        $count = $this->db()->get_var( "SELECT COUNT(*) FROM ".$this->table() . " " . $where);
        return $count;
    }

    public function search(){
        $this->update_query_params();
        $sql = 'SELECT * from '.$this->table(). ' LIMIT '.$this->limit. ' OFFSET '.$this->offset;
        $countSql =  'SELECT count(*) FROM '.$this->table();
        $results = $this->db()->get_results($sql,ARRAY_A);
        $count = $this->db()->get_var($countSql);
        return [
            'data' => $results,
            'total' => $count,
            'limit' => $this->limit,
            'page' => isset($_GET['paged']) ? $_GET['paged'] : null
        ];
    }

    public function update_query_params(){
        if(isset($_GET['paged'])){
            $this->offset = $this->limit * $_GET['paged'];
        }
    }

    public function update( $values, $key, $value ){
        $this->db()->update($this->table(),$values,array($key=>$value));
        return true;
    }

    public function insert( $data=array() ){
        $this->db()->insert(
            $this->table(),$data);
    }

    public function db(){
        return $this->_db;
    }

    public static function wpdb(){
        global $wpdb;
        return $wpdb;
    }

    public function table(){
        return $this->_table;
    }

    public function setData( $data ){
        $this->_data = $data;
    }

    public function getData(){
        return $this->_data;
    }

    public function getKey( $value ){
        return $this->getData()[$value];
    }

    public function queryAll( $sql ){
        $results = $this->db()->get_results($sql,ARRAY_A);
        $this->setData( $results );
    }

    public function queryRow( $sql ){
        $results = $this->db()->get_row($sql,ARRAY_A);
        $this->setData( $results );
        return $this->getData();
    }

    public function query( $sql ){
        return $this->db()->query( $sql );
    }


}