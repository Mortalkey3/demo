<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

  function select_account($id){
    $query = 'select * from PN_EORDER_LOGIN pn left join HZ_CUST_ACCOUNTS hca on hca.ACCOUNT_NUMBER = pn.CUSTOMER_ID left join HZ_ORGANIZATION_PROFILES hop on hca.party_id = hop.party_id where pn.ID=?';
    return $this -> db-> query($query,array($id));
  }

  function select_all_account($id){
    $query = "select pn.ID,pn.USERNAME,pn.PASS,hop.ORGANIZATION_NAME,TO_CHAR(pn.CREATE_DATE,'dd-MM-YYYY HH24:MI:SS') as create_date,
        TO_CHAR(pn.UPDATE_DATE,'dd-MM-YYYY HH24:MI:SS') as update_date from PN_EORDER_LOGIN pn left join HZ_CUST_ACCOUNTS hca on hca.ACCOUNT_NUMBER = pn.CUSTOMER_ID "
        .'left join HZ_ORGANIZATION_PROFILES hop on hca.party_id = hop.party_id where pn.AUTH=? order by pn.update_date desc';
    return $this -> db-> query($query,array($id));
  }


  function select_customer(){
    return $this->db->query('select hca.ACCOUNT_NUMBER cust_id,hop.ORGANIZATION_NAME cust_name
	     from HZ_ORGANIZATION_PROFILES hop join HZ_CUST_ACCOUNTS hca on hca.party_id = hop.party_id order by cust_name');
  }

  function add_account($data)
  {
        return $this->db->insert('PN_EORDER_LOGIN', $data);
        //return $this->db->insert_id();
  }

  function edit_account($data,$id)
   {
      $this->db->where('ID',$id);
      $this->db->update('PN_EORDER_LOGIN',$data);
       return $this->db->affected_rows();
   }

   function delete_account($id)
   {
      $this->db->where('ID', $id);
      $this->db->delete('PN_EORDER_LOGIN');
   }

   function count_username($name){
     $this->db->like('USERNAME', $name);
     $this->db->from('PN_EORDER_LOGIN');
     return $this->db->count_all_results();
   }

   function select_so(){
     $query = "select DISTINCT pen.PO_NO,pen.DATE_ORDER,pen.FLAG,TO_DATE(pen.CREATE_DATE,'DD/MM/YYYY') CREATE_DATE,TO_DATE(pen.UPDATE_DATE,'DD/MM/YYYY') UPDATE_DATE,pen.IDENTIFICATION,pen.customer_id,hop.ORGANIZATION_NAME from PN_EORDER_NEW pen,HZ_CUST_ACCOUNTS hca,HZ_ORGANIZATION_PROFILES hop where hca.ACCOUNT_NUMBER = pen.CUSTOMER_ID and hca.party_id = hop.party_id and pen.category_order = 'order'  order by update_date desc";
     return $this -> db-> query($query,array())->result();
   }

   function select_retur(){
     $query = "select DISTINCT pen.PO_NO,pen.DATE_ORDER,pen.FLAG,TO_DATE(pen.CREATE_DATE,'DD/MM/YYYY') CREATE_DATE,TO_DATE(pen.UPDATE_DATE,'DD/MM/YYYY') UPDATE_DATE,pen.IDENTIFICATION,pen.customer_id,hop.ORGANIZATION_NAME from PN_EORDER_NEW pen,HZ_CUST_ACCOUNTS hca,HZ_ORGANIZATION_PROFILES hop where hca.ACCOUNT_NUMBER = pen.CUSTOMER_ID and hca.party_id = hop.party_id and pen.category_order = 'return'  order by update_date desc";
     return $this -> db-> query($query,array())->result();
   }

   function select_so_detail($po_no,$ide,$cust_id){
     $query = "select * from PN_EORDER_NEW where replace(po_no,'/')=? and identification=? and customer_id=? order by update_date desc";
     return $this -> db-> query($query,array($po_no,$ide,$cust_id));
   }

   function select_retur_detail($po_no,$ide,$cust_id){
     $query = "select * from PN_EORDER_NEW where replace(po_no,'/')=? and identification=? and customer_id=? order by update_date desc";
     return $this -> db-> query($query,array($po_no,$ide,$cust_id));
   }

}
