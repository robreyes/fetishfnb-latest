<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BTC Transaction Model
 *
 * This model handles btc_transaction module data
 *
 * @package     starcoders
 * @author      robreyes
*/

class Btc_model extends CI_Model {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @vars
     */
    private $table     = 'btc_transaction';
    private $addresses = 'btc_addresses';

    public function count_transactions()
    {
        return $this->db->count_all_results($this->table);
    }

    public function get_user_transaction($id = NULL)
    {
        return $this->db->select(array('id','user_id','event_id','amount','date','txn_id','txn_type','txn_hash'))
                         ->where(array('user_id'=>$id))
                         ->get($this->table)
                         ->result_array();
    }

    public function get_txn_by_hash($txn_hash = NULL)
    {
        return $this->db->select(array('id','user_id','event_id','amount','date','txn_id','txn_type','txn_hash'))
                         ->where(array('txn_hash'=>$txn_hash))
                         ->get($this->table)
                         ->result_array();
    }

    public function add_btc_transaction($data = array(), $id = NULL)
    {
      $this->db->insert($this->table, $data);
      return $this->db->insert_id();
    }

    public function get_transaction_by_id($id = NULL)
    {
      return $this->db->select(array('id','address','invoice','redeem_code','user_id','amount'))
                       ->where(array('id'=>$id))
                       ->get($this->addresses)
                       ->result_array();
    }

    public function get_transaction_by_user($user_id = NULL)
    {
      return $this->db->select(array('id','address','invoice','redeem_code','user_id','amount'))
                       ->where(array('user_id'=>$user_id))
                       ->get($this->addresses)
                       ->result_array();
    }

    public function get_transaction_by_address($address = NULL, $user_id = NULL)
    {
      return $this->db->select(array('id','address','invoice','redeem_code','user_id','amount','status'))
                       ->where(array('address' => $address, 'user_id' => $user_id))
                       ->get($this->addresses)
                       ->result_array();
    }

    public function get_user_addresses($user_id = NULL)
    {
      return $this->db->select(array('id','address','status','amount','status','date'))
                       ->where(array('user_id'=>$user_id))
                       ->get($this->addresses)
                       ->result_array();
    }

    public function add_btc_address($data = array(), $id = NULL)
    {
      if($id)
      {
        $this->db->where(array('id'=>$id))
                 ->update($this->addresses, $data);
        return $id;
      }
      else
      {
        $this->db->insert($this->addresses, $data);
        return $this->db->insert_id();
      }
    }
    function get_txn_by_aid($address_id)
    {
      return $this->db->select(array('id','user_id','event_id','amount','date','txn_id','txn_type','txn_hash','address_id'))
                       ->where(array('address_id'=>$address_id))
                       ->get($this->table)
                       ->result_array();
    }
}
