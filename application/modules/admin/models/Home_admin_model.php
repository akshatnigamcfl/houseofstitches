<?php

class Home_admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function loginCheck($values)
    {
        $arr = array(
            'username' => $values['username'],
            'password' => md5($values['password']),
        );
        $this->db->where($arr);
        $result = $this->db->get('users');
        $resultArray = $result->row_array();
        if ($result->num_rows() > 0) {
            $this->db->where('id', $resultArray['id']);
            $this->db->update('users', array('last_login' => time()));
        }
        return $resultArray;
    }

    /*
     * Some statistics methods for home page of
     * administration
     * START
     */

    public function countLowQuantityProducts()
    {
        $this->db->where('quantity <=', 5);
        return $this->db->count_all_results('products');
    }

    public function lastSubscribedEmailsCount()
    {
        $yesterday = strtotime('-1 day', time());
        $this->db->where('time > ', $yesterday);
        return $this->db->count_all_results('subscribed');
    }

    public function getMostSoldProducts($limit = 10)
    {
        $this->db->select('url, procurement');
        $this->db->order_by('procurement', 'desc');
        $this->db->where('procurement >', 0);
        $this->db->limit($limit);
        $queryResult = $this->db->get('products');
        return $queryResult->result_array();
    }

    public function getReferralOrders()
    {

        $this->db->select('count(id) as num, clean_referrer as referrer');
        $this->db->group_by('clean_referrer');
        $queryResult = $this->db->get('orders');
        return $queryResult->result_array();
    }

    public function getOrdersByPaymentType($limit = 10)
    {
        $this->db->select('count(id) as num, payment_type');
        $this->db->group_by('payment_type');
        $this->db->limit($limit);
        $queryResult = $this->db->get('orders');
        return $queryResult->result_array();
    }

    public function getOrdersByMonth()
    {
        $result = $this->db->query("SELECT YEAR(FROM_UNIXTIME(date)) as year, MONTH(FROM_UNIXTIME(date)) as month, COUNT(id) as num FROM orders GROUP BY YEAR(FROM_UNIXTIME(date)), MONTH(FROM_UNIXTIME(date))");
        $result = $result->result_array();
        $orders = array();
        $years = array();
        foreach ($result as $res) {
            if (!isset($orders[$res['year']])) {
                for ($i = 1; $i <= 12; $i++) {
                    $orders[$res['year']][$i] = 0;
                }
            }
            $years[] = $res['year'];
            $orders[$res['year']][$res['month']] = $res['num'];
        }
        return array(
            'years' => array_unique($years),
            'orders' => $orders
        );
    }

    public function getOutOfStockCount()
    {
        return $this->db->where('quantity', 0)->where('visibility', 1)->count_all_results('products');
    }

    public function getPendingOrdersCount()
    {
        return (int)$this->db->where('processed', 0)->count_all_results('orders');
    }

    public function getTotalUsersCount()
    {
        return (int)$this->db->where('status', 1)->count_all_results('users_public');
    }

    public function getRestockAlerts($limit = 15)
    {
        $this->db->select('products.id, products.quantity, products.article_number, products_translations.title');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $this->db->where('products.visibility', 1);
        $this->db->where('products.quantity <=', 10);
        $this->db->order_by('products.quantity', 'asc');
        $this->db->limit($limit);
        return $this->db->get('products')->result_array();
    }

    public function getMostOrderedProducts($limit = 10)
    {
        $sql = "SELECT p.id, p.url, p.article_number, pt.title,
                       COUNT(oi.product_id) AS order_count,
                       SUM(oi.quantity) AS total_qty
                FROM cart_items oi
                JOIN products p ON p.id = oi.product_id
                JOIN products_translations pt ON pt.for_id = p.id AND pt.abbr = ?
                GROUP BY oi.product_id, p.id, p.url, p.article_number, pt.title
                ORDER BY order_count DESC
                LIMIT ?";
        return $this->db->query($sql, [MY_DEFAULT_LANGUAGE_ABBR, $limit])->result_array();
    }

    public function getTotalRevenue()
    {
        $row = $this->db->select('SUM(billing_amount) as total')->where('processed >', 0)->get('orders')->row_array();
        return $row['total'] ?? 0;
    }

    /*
     * Some statistics methods for home page of
     * administration
     * END
     */

    public function setValueStore($key, $value)
    {
        $this->db->where('thekey', $key);
        $query = $this->db->get('value_store');
        if ($query->num_rows() > 0) {
            $this->db->where('thekey', $key);
            if (!$this->db->update('value_store', array('value' => $value))) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        } else {
            if (!$this->db->insert('value_store', array('value' => $value, 'thekey' => $key))) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        }
    }

    public function changePass($new_pass, $username)
    {
        $this->db->where('username', $username);
        $result = $this->db->update('users', array('password' => md5($new_pass)));
        return $result;
    }

    public function getValueStore($key)
    {
        $query = $this->db->query("SELECT value FROM value_store WHERE thekey = ? LIMIT 1", [$key]);
        $value = $query->row_array();
        if(!$value) {
            return null;
        }
        return $value['value'];
    }

    public function newOrdersCheck()
    {
        $result = $this->db->query("SELECT count(id) as num FROM `orders` WHERE viewed = 0");
        $row = $result->row_array();
        return $row['num'];
    }

    public function setCookieLaw($post)
    {
        $query = $this->db->query('SELECT id FROM cookie_law');
        if ($query->num_rows() == 0) {
            $update = false;
        } else {
            $result = $query->row_array();
            $update = $result['id'];
        }

        if ($update === false) {
            $this->db->trans_begin();
            if (!$this->db->insert('cookie_law', array(
                        'link' => $post['link'],
                        'theme' => $post['theme'],
                        'visibility' => $post['visibility']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $for_id = $this->db->insert_id();
            $i = 0;
            foreach ($post['translations'] as $translate) {
                if (!$this->db->insert('cookie_law_translations', array(
                            'message' => htmlspecialchars($post['message'][$i]),
                            'button_text' => htmlspecialchars($post['button_text'][$i]),
                            'learn_more' => htmlspecialchars($post['learn_more'][$i]),
                            'abbr' => $translate,
                            'for_id' => $for_id
                        ))) {
                    log_message('error', print_r($this->db->error(), true));
                }
                $i++;
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                show_error(lang('database_error'));
            } else {
                $this->db->trans_commit();
            }
        } else {
            $this->db->trans_begin();
            $this->db->where('id', $update);
            if (!$this->db->update('cookie_law', array(
                        'link' => $post['link'],
                        'theme' => $post['theme'],
                        'visibility' => $post['visibility']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $i = 0;
            foreach ($post['translations'] as $translate) {
                $this->db->where('for_id', $update);
                $this->db->where('abbr', $translate);
                if (!$this->db->update('cookie_law_translations', array(
                            'message' => htmlspecialchars($post['message'][$i]),
                            'button_text' => htmlspecialchars($post['button_text'][$i]),
                            'learn_more' => htmlspecialchars($post['learn_more'][$i])
                        ))) {
                    log_message('error', print_r($this->db->error(), true));
                }
                $i++;
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                show_error(lang('database_error'));
            } else {
                $this->db->trans_commit();
            }
        }
    }

    public function getCookieLaw()
    {
        $arr = array('cookieInfo' => null, 'cookieTranslate' => null);
        $query = $this->db->query('SELECT * FROM cookie_law');
        if ($query->num_rows() > 0) {
            $arr['cookieInfo'] = $query->row_array();
            $query = $this->db->query('SELECT * FROM cookie_law_translations');
            $arrTrans = $query->result_array();
            foreach ($arrTrans as $trans) {
                $arr['cookieTranslate'][$trans['abbr']] = array(
                    'message' => $trans['message'],
                    'button_text' => $trans['button_text'],
                    'learn_more' => $trans['learn_more']
                );
            }
        }
        return $arr;
    }

}
