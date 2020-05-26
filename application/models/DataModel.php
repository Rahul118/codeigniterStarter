<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DataModel extends MY_Model
{
    // public function get_invoices()
    // {
    //     return $this->db
    //         ->select('a.*, b.*, c.*')
    //         ->from('ts_invoices as a')
    //         ->join('ts_users as b', 'a.client_id=b.id', 'left')
    //         ->join('ts_coupons as c', 'a.coupon_id=c.id', 'left')
    //         ->get()->result()
    //     ;
    // }
}