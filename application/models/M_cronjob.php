<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Cronjob extends CI_Model
{
    
    public function getCurrencyName()
    {
        return $this->db->query("SELECT DISTINCT currency_name FROM currencies")->result_array();
    }
    public function getCurrencyPrice()
    {
        return $this->db->query("SELECT DISTINCT price FROM currencies")->result_array();
    }    
    public function updateLastPrice($name, $price)
    {
        $this->db->set('last_price', $price);
        $this->db->where('currency_name', $name);
        $this->db->update('currencies');
    }    
    public function updatePrice($name, $price)
    {
        $this->db->set('price', $price);
        $this->db->where('currency_name', $name);
        $this->db->update('currencies');
    }
    
    public function getCurrencyName2()
    {
        return $this->db->query("SELECT DISTINCT currency_name FROM currencies2")->result_array();
    }
    public function updatePrice2($name, $price)
    {
        $this->db->set('price', $price);
        $this->db->where('currency_name', $name);
        $this->db->update('currencies2');
    }    

    public function isYesterdayExist($date)
    {
        $check = $this->db->get_where('faucet_stats', ['date' => $date])->num_rows();
        return $check == 0;
    }

    public function checkYesterdayLog($date)
    {
        $check = $this->db->get_where('faucet_stats', ['date' => $date, 'is_done' => 0])->num_rows();
        return $check == 1;
    }

    public function countActiveUsers($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE last_active >= " . $yesterday)->result_array()[0]['cnt'];
    }

    public function countNewUsers($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE joined >= " . $yesterday . " AND joined <" . $today)->result_array()[0]['cnt'];
    }

    public function shortlinkStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM link_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function ptcStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM ptc_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function achievementStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM achievement_history WHERE claim_time >= " . $yesterday . " AND claim_time <" . $today)->result_array()[0];
    }

    public function depositStat($yesterday, $today)
    {
        return $this->db->query("SELECT COUNT(*) AS cnt, IFNULL(SUM(amount), 0) AS amount FROM deposit WHERE (type = 1 OR (type = 2 AND status = 'Confirmed')) AND create_time >= " . $yesterday . " AND create_time <" . $today)->result_array()[0];
    }

}
