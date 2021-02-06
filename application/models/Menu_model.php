<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function user_menu($role){
        $query = array();
        $query = $this->db->query("
            SELECT
            id AS MENU_ID,
            label AS MENU_NAMA,
            controller AS MENU_CONTROLLER,
            nama_function AS FUNC,
            icon AS MENU_ICON,
            GROUP_CONCAT(IFNULL(sub.SUBMENU_ID,'') ORDER BY SUBMENU_ORDER ASC SEPARATOR '|') AS SUB_ID,
            GROUP_CONCAT(IFNULL(sub.SUBMENU_NAMA,'') ORDER BY SUBMENU_ORDER ASC SEPARATOR '|') AS SUB_NAMA,
            GROUP_CONCAT(IFNULL(sub.SUBMENU_CONTROLLER,'') ORDER BY SUBMENU_ORDER ASC SEPARATOR '|') AS SUBMENU_CONTROLLER,
            GROUP_CONCAT(IFNULL(sub.SUBMENU_FUNCTION,'') ORDER BY SUBMENU_ORDER ASC SEPARATOR '|') AS SUBMENU_FUNCTION
            FROM modul
            LEFT JOIN(
                SELECT id AS SUBMENU_ID,
                parent_id AS SUBMENU_PARENT_ID,
                label AS SUBMENU_NAMA,
                controller AS SUBMENU_CONTROLLER,
                menu_order AS SUBMENU_ORDER,
                nama_function AS SUBMENU_FUNCTION
                FROM modul
                WHERE id IN (
                    SELECT DISTINCT(modul) FROM kategori_user_modul
                    WHERE kategori_user = '$role'
                )
                ORDER BY id ASC
            ) sub ON sub.SUBMENU_PARENT_ID = id
            WHERE parent_id = '0'
            AND id IN (
                SELECT DISTINCT(modul) FROM kategori_user_modul
                WHERE kategori_user = '$role'
            )
            GROUP BY id ORDER BY menu_order ASC ")->result_array();
        return $query;
    }

}
