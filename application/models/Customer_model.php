<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {



   function count_login($name,$password){
     $query = 'select username from PN_EORDER_LOGIN where username=? and pass =?';
     $res = $this-> db->query($query,array($name,$password));
     return count($res->result());
   }

   function select_auth($id){
     $query = 'select auth from PN_EORDER_LOGIN where id=?';
     $res = $this-> db->query($query,array($id));
     $row = $res->result();
     return $row[0]->AUTH;
   }

   function select_id($name,$password){
     $query = 'select id from PN_EORDER_LOGIN where username=? and pass =?';
     $res = $this-> db->query($query,array($name,$password));
     $row = $res->result();
     return $row[0]->ID;
   }

   function select_customer_id($id){
     $query = 'select customer_id from PN_EORDER_LOGIN where id=?';
     $res = $this-> db->query($query,array($id));
     $row = $res->result();
     return $row[0]->CUSTOMER_ID;
   }


   function select_account($id){
     $query = 'select * from PN_EORDER_LOGIN pn left join HZ_CUST_ACCOUNTS hca on hca.ACCOUNT_NUMBER = pn.CUSTOMER_ID left join HZ_ORGANIZATION_PROFILES hop on hca.party_id = hop.party_id where pn.ID=?';
     return $this -> db-> query($query,array($id));
   }




   function select_customer(){
     return $this->db->query('select hca.ACCOUNT_NUMBER cust_id,hop.ORGANIZATION_NAME cust_name
 	     from HZ_ORGANIZATION_PROFILES hop join HZ_CUST_ACCOUNTS hca on hca.party_id = hop.party_id order by cust_name');
   }

   function select_all_account($id,$cust_id){
     $query = "select pn.ID,pn.USERNAME,pn.PASS,hop.ORGANIZATION_NAME,TO_CHAR(pn.CREATE_DATE,'dd-MM-YYYY HH24:MI:SS') as create_date,
         TO_CHAR(pn.UPDATE_DATE,'dd-MM-YYYY HH24:MI:SS') as update_date from PN_EORDER_LOGIN pn left join HZ_CUST_ACCOUNTS hca on hca.ACCOUNT_NUMBER = pn.CUSTOMER_ID "
         .'left join HZ_ORGANIZATION_PROFILES hop on hca.party_id = hop.party_id where pn.AUTH=? and pn.customer_id=? order by pn.update_date desc';
     return $this -> db-> query($query,array($id,$cust_id));
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


    function select_cust_name($id){
      $query = 'select hop.ORGANIZATION_NAME from PN_EORDER_LOGIN pn left join HZ_CUST_ACCOUNTS hca on hca.ACCOUNT_NUMBER = pn.CUSTOMER_ID left join HZ_ORGANIZATION_PROFILES hop on hca.party_id = hop.party_id
      where pn.ID=?';
      $res = $this -> db-> query($query,array($id))->result();
      return $res[0]->ORGANIZATION_NAME;
    }


	function select_rekapFaktur(){


      $query = "
      select rac_bill_to_customer_name name, nvl(sum(cat1),0) cat1,nvl(sum(cat2),0) cat2,nvl(sum(cat3),0) cat3,nvl(sum(cat4),0) cat4,nvl(sum(cat1),0)+nvl(sum(cat2),0)+nvl(sum(cat3),0)+nvl(sum(cat4),0) total
      from(
      SELECT   rac_bill_to_customer_name, apst.trx_number, rctpv.trx_date,rctpv.ATTRIBUTE5 as ttop,TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')) as tempo,
               term_due_date, TRUNC (SYSDATE) - NVL (TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')),TRUNC (term_due_date)) hari,
               CASE
                  WHEN TRUNC (SYSDATE) - NVL (TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')),TRUNC (term_due_date)) <= 0
                     THEN NVL (rctpv.exchange_rate, 1) * amount_due_remaining
               END cat1,
               CASE
                  WHEN TRUNC (SYSDATE) - NVL (TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')),TRUNC (term_due_date)) > 0
                  AND TRUNC (SYSDATE) - NVL (TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')),TRUNC (term_due_date)) < 31
                     THEN NVL (rctpv.exchange_rate, 1) * amount_due_remaining
               END cat2,
               CASE
                  WHEN TRUNC (SYSDATE) - NVL (TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')),TRUNC (term_due_date)) > 30
                  AND TRUNC (SYSDATE) - NVL (TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')),TRUNC (term_due_date)) < 61
                     THEN NVL (rctpv.exchange_rate, 1) * amount_due_remaining
               END cat3,
               CASE
                  WHEN TRUNC (SYSDATE) - NVL (TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')),TRUNC (term_due_date)) > 60
                     THEN NVL (rctpv.exchange_rate, 1) * amount_due_remaining
               END cat4
          FROM ar_payment_schedules_trx2_v apst JOIN ra_customer_trx_partial_v rctpv
               ON apst.customer_trx_id = rctpv.customer_trx_id
         WHERE amount_due_remaining > 0
      ORDER BY 1,
               TRUNC (SYSDATE) - NVL (TRUNC(TO_DATE(TO_CHAR(
               TO_DATE(rctpv.ATTRIBUTE6
                      ,'YYYY/MM/DD HH24:mi:ss')
             ,'DD-MM-YY'),'DD-MM-YY')),TRUNC (term_due_date)) DESC,
               NVL (rctpv.exchange_rate, 1) * amount_due_remaining DESC
      )
      where rac_bill_to_customer_name not in ('DOS NI ROHA, PT',
      'RAJAWALI NUSINDO, PT',
      'KIMIA FARMA, PT',
      'SYDNA FARMA, PT')
      group by rac_bill_to_customer_name
      order by 1";
      $res1 = $this->db->query("call mo_global.set_policy_context('S',81)");
      $res = $this -> db-> query($query)->result();


      return $res;
    }

    function select_orderType($id){
      $query = 'select order_type from PN_EORDER_TYPE where customer_id=? group by order_type';
      $res = $this -> db-> query($query,array($id))->result();
      return $res;
    }

    function select_keterangan(){
      $query = 'select keterangan from PN_EORDER_KET';
      $res = $this -> db-> query($query)->result();
      return $res;
    }

    function select_TypeRetur(){
      $query = "select UPPER(ott.name) name from oe_transaction_types_tl ott,oe_transaction_types_all otta where ott.TRANSACTION_TYPE_ID = otta.TRANSACTION_TYPE_ID and name like 'Retur%'
and otta.END_DATE_ACTIVE is null";
      $res = $this -> db-> query($query)->result();
      return $res;
    }

    function select_priceList($id){
      $query = 'select description,PRICE_LIST from PN_EORDER_TYPE where customer_id=? group by description,PRICE_LIST';
      $res = $this -> db-> query($query,array($id))->result();
      return $res;
    }


    function check_import($product,$order_type,$pricelist,$cust_id,$no_po){
      $status = TRUE;

      $query3 = 'select PO_NO
        from PN_EORDER_NEW where customer_id=? and PO_NO like ? and FLAG = 2';
      $res3= $this->db-> query($query3,array($cust_id,$no_po));
      if($res3->num_rows()!=0){
        $status = FALSE;
      }

      $query2 = 'select PRICE_LIST
        from PN_EORDER_TYPE where order_type= ? and description = ? and customer_id=?';
      $res2 = $this->db-> query($query2,array($order_type,$pricelist,$cust_id));
      $price;
      if($res2->num_rows()!=0){
        $price = $res2->row()->PRICE_LIST;
      }
      if(!empty($price)){
          $query = 'select count(qll.row_id) jumlah
            from qp_list_lines_v qll,qp_list_headers_v qlh,MTL_CUSTOMER_ITEM_XREFS_V mci
              where mci.INVENTORY_ITEM_ID = qll.PRODUCT_ATTR_VALUE
              and mci.CUSTOMER_ITEM_NUMBER like ?
              and qlh.name like ?
              and qlh.LIST_HEADER_ID = qll.LIST_HEADER_ID';
          $res = $this->db-> query($query,array($product,$price));
          $row = $res->result();
          $query1 = 'select count(id)  jumlah
            from PN_EORDER_TYPE where order_type= ? and description = ? and customer_id=?';
          $res1 = $this->db-> query($query1,array($order_type,$pricelist,$cust_id))->result();

          $jumlah = $row[0]->JUMLAH;
          $jumlah1 = $res1[0]->JUMLAH;
          if($jumlah<=0){
            $status = FALSE;
          }
          if($jumlah1<=0){
            $status = FALSE;
          }
      }
      else{
          $status = FALSE;
      }
      return $status;
    }

    function check_import2($product,$order_type,$pricelist,$cust_id){
      $status = TRUE;


      $price = $pricelist;
      if(!empty($price)){
          $query = 'select count(qll.row_id) jumlah
            from qp_list_lines_v qll,qp_list_headers_v qlh,MTL_CUSTOMER_ITEM_XREFS_V mci
              where mci.INVENTORY_ITEM_ID = qll.PRODUCT_ATTR_VALUE
              and mci.CUSTOMER_ITEM_NUMBER like ?
              and qlh.name like ?
              and qlh.LIST_HEADER_ID = qll.LIST_HEADER_ID';
          $res = $this->db-> query($query,array($product,$price));
          $row = $res->result();
          $query1 = 'select count(id)  jumlah
            from PN_EORDER_TYPE where order_type= ? and price_list = ? and customer_id=?';
          $res1 = $this->db-> query($query1,array($order_type,$pricelist,$cust_id))->result();

          $jumlah = $row[0]->JUMLAH;
          $jumlah1 = $res1[0]->JUMLAH;
          if($jumlah<=0){
            $status = FALSE;
          }
          if($jumlah1<=0){
            $status = FALSE;
          }
      }
      else{
          $status = FALSE;
      }
      return $status;
    }

    function check_line($cust_id,$noPO,$ide){
      $status = TRUE;
      $query3 = "select PO_NO
        from PN_EORDER_NEW where customer_id=? and PO_NO = ? and FLAG = 2 and identification not in ?";
      $res3= $this->db-> query($query3,array($cust_id,$noPO,$ide));
      if($res3->num_rows()!=0){
        $status = FALSE;
      }
      return $status;
    }

    function insert_import($data)
    {
          return $this->db->insert('PN_EORDER_NEW', $data);
          //$this->db->insert_id();
    }

    function select_ship($order_type,$pricelist,$cust_id){
      $query = 'select ship_id from PN_EORDER_TYPE where order_type=? and price_list = ? and customer_id=? ';
      $res = $this -> db-> query($query,array($order_type,$pricelist,$cust_id))->row();
      $ship = $res->SHIP_ID;
      return $ship;
    }

    function select_ship_retur($product){
      $que = 'select  mci.INVENTORY_ITEM_ID from MTL_CUSTOMER_ITEM_XREFS_V mci where  mci.customer_item_number = ?';
      if($this -> db-> query($que,array($product))->num_rows()!=0){
        $pro =  $this -> db-> query($que,array($product))->row()->INVENTORY_ITEM_ID;
        $query = 'select organization_id from mtl_transaction_lot_numbers where INVENTORY_ITEM_ID like ? and rownum =1
          ';
          if($this -> db-> query($query,array($pro))->num_rows()!=0){
            return $this -> db-> query($query,array($pro))->row()->ORGANIZATION_ID;
          }
          else{
              return NULL;
          }
      }
      else{
          return NULL;
      }
    }


    function select_so_admin($id){
      $query = "select DISTINCT PO_NO,DATE_ORDER,FLAG,TO_DATE(CREATE_DATE,'DD/MM/YYYY') CREATE_DATE,TO_DATE(UPDATE_DATE,'DD/MM/YYYY') UPDATE_DATE,IDENTIFICATION from PN_EORDER_NEW where usernm=? and category_order = 'order' and hidden = 0  order by UPDATE_DATE desc,create_date desc,PO_NO";
      return $this -> db-> query($query,array($id))->result();
    }

    function select_so_mgr($cust_id){
      $query = "select DISTINCT pen.PO_NO,pen.DATE_ORDER,pen.FLAG,TO_DATE(pen.CREATE_DATE,'DD/MM/YYYY') CREATE_DATE,TO_DATE(pen.UPDATE_DATE,'DD/MM/YYYY') UPDATE_DATE,pen.IDENTIFICATION,pel.USERNAME from PN_EORDER_NEW pen,PN_EORDER_LOGIN pel where pen.usernm = pel.ID and pen.customer_id=? and pen.category_order = 'order' and hidden = 0  order by UPDATE_DATE desc,CREATE_DATE DESC,pen.PO_NO";
      return $this -> db-> query($query,array($cust_id))->result();
    }

    function select_so_detail($po_no,$ide,$cust_id){
      $query = "select * from PN_EORDER_NEW where replace(po_no,'/') like ? and identification=? and customer_id=? order by product ";
      return $this -> db-> query($query,array($po_no,$ide,$cust_id));
    }


    function delete_so($po_no,$ide,$cust_id){
      $query = "PO_NO like '" . $po_no ."' and IDENTIFICATION=" . $ide . ' and CUSTOMER_ID = ' .$cust_id;
      $this->db->set('HIDDEN',1);
      $this->db->where($query);
      $this->db->update('PN_EORDER_NEW');
      return true;
    }

    function select_retur_detail($po_no,$ide,$cust_id){
      $query = "select * from PN_EORDER_NEW where replace(replace(replace(replace(po_no,'/'),' '),'-'),'&') like ? and identification=? and customer_id=? order by product,batch_no ";
      return $this -> db-> query($query,array($po_no,$ide,$cust_id));
    }

    function accept_so($po_no,$ide,$cust_id){
      $array =
        " FLAG = 0 and REGEXP_REPLACE(PO_NO,'(&|/|-| )','') like '" .$po_no.
        "' and IDENTIFICATION = " .$ide .
        " and CUSTOMER_ID = " .$cust_id;
      $this->db->set('FLAG', 1);
      $this->db->where($array);
      $this->db->update('PN_EORDER_NEW');
      return true;
    }

    function cancel_so($po_no,$ide,$cust_id){
      $array =
        "FLAG = 0 and  REGEXP_REPLACE(PO_NO,'(&|/|-| )','') like '" .$po_no.
        "' and IDENTIFICATION = " . $ide .
        " and CUSTOMER_ID = " .$cust_id;
      $this->db->set('FLAG', 3);
      $this->db->where($array);
      $this->db->update('PN_EORDER_NEW');
      return true;
    }


    function accept_retur($po_no,$ide,$cust_id){

        $array =
        "CATEGORY_ORDER = 'return'".
		    " and FLAG = 0".
        " and IDENTIFICATION = " .$ide.
        ' and CUSTOMER_ID = ' .$cust_id;

      $this->db->set('FLAG', 1);
      $this->db->where($array);
      $this->db->update('PN_EORDER_NEW');
      return true;
    }

    function cancel_retur($po_no,$ide,$cust_id){

        $array =
        "CATEGORY_ORDER = 'return'".
		    " and FLAG = 0".
        " and IDENTIFICATION = " .$ide.
        ' and CUSTOMER_ID = ' .$cust_id;

      $this->db->set('FLAG', 3);
      $this->db->where($array);
      $this->db->update('PN_EORDER_NEW');
      return true;
    }

    function error_so($po_no,$ide,$cust_id){
      $array = array(
        "PO_NO" => $po_no,
        'IDENTIFICATION' => $ide,
        'CUSTOMER_ID' => $cust_id
      );
      $this->db->set('FLAG', 4);
      $this->db->where($array);
      $this->db->update('PN_EORDER_NEW');
      return true;
    }

    function error_retur($po_no,$ide,$cust_id){
      $array = array(
        "PO_NO" => $po_no,
        'IDENTIFICATION' => $ide,
        'CUSTOMER_ID' => $cust_id
      );
      $this->db->set('FLAG', 4);
      $this->db->where($array);
      $this->db->update('PN_EORDER_NEW');
      return true;
    }

    function error_retur_ppg($ide,$cust_id){
      $array = array(
        "CATEGORY_ORDER" => 'return',
        'IDENTIFICATION' => $ide,
        'CUSTOMER_ID' => $cust_id
      );
      $this->db->set('FLAG', 4);
      $this->db->where($array);
      $this->db->update('PN_EORDER_NEW');
      return true;
    }


    function count_so(){
      $query = "select IDENTIFICATION from PN_EORDER_NEW where category_order = 'order' group by IDENTIFICATION order by IDENTIFICATION ";
      if($this -> db-> query($query)->num_rows()!=0){
        return $this -> db-> query($query)->last_row()->IDENTIFICATION;
      }
      else{
        return 0;
      }

    }

    function count_retur(){
      $query = "select IDENTIFICATION from PN_EORDER_NEW where category_order = 'return' group by IDENTIFICATION order by IDENTIFICATION  ";
      if($this -> db-> query($query)->num_rows()!=0){
        return $this -> db-> query($query)->last_row()->IDENTIFICATION;
      }
      else{
        return 0;
      }
    }

    function select_price($product,$batch){
      $que = 'select  mci.INVENTORY_ITEM_ID
from MTL_CUSTOMER_ITEM_XREFS_V mci,mtl_transaction_lot_numbers mtln
where  mci.customer_item_number = ? and mtln.lot_number like ? and  mtln.INVENTORY_ITEM_ID = mci.INVENTORY_ITEM_ID';
      if($this -> db-> query($que,array($product,$batch.'%'))->num_rows()!=0){
        $pro =  $this -> db-> query($que,array($product,$batch.'%'))->row()->INVENTORY_ITEM_ID;
        $query = 'select DISTINCT qlht.NAME,ooha.ORDERED_DATE
        from mtl_transaction_lot_numbers mtln,mtl_material_transactions mmt,
        mtl_transaction_types mtt,mtl_system_items_b msib,OE_ORDER_LINES_ALL oola,OE_ORDER_HEADERS_ALL ooha,qp_list_headers_tl qlht
        where
               mtln.transaction_id = mmt.transaction_id
               AND mtln.organization_id = mmt.organization_id
               AND mmt.transaction_type_id = mtt.transaction_type_id
               AND mmt.transaction_action_id = mtt.transaction_action_id
               AND mmt.transaction_action_id = 1
               AND mmt.organization_id IN (84, 170)
               and msib.inventory_item_id = mmt.inventory_item_id
               AND msib.organization_id = mmt.organization_id
               and qlht.LIST_HEADER_ID = ooha.PRICE_LIST_ID
               and oola.HEADER_ID = ooha.HEADER_ID
               and oola.LINE_ID = mmt.TRX_SOURCE_LINE_ID
               and mtln.LOT_NUMBER like ?
               and mtln.INVENTORY_ITEM_ID like ?
           order by ooha.ORDERED_DATE desc
          ';
          if($this -> db-> query($query,array($batch.'%',$pro))->num_rows()!=0){
            return $this -> db-> query($query,array($batch.'%',$pro))->row()->NAME;
          }
          else{
              return NULL;
          }
      }
      else{
          return NULL;
      }
    }

    function select_name_product($product){
      $que = 'select  mci.ITEM_DESCRIPTION from MTL_CUSTOMER_ITEM_XREFS_V mci where  mci.customer_item_number = ?';
      if($this -> db-> query($que,array($product))->num_rows()!=0){
        $pro =  $this -> db-> query($que,array($product))->row()->ITEM_DESCRIPTION;
        return $pro;
      }
      else{
        return NULL;
      }
    }


    function select_city($branch,$cust_id){
      $query = 'select city
    from PN_EORDER_CITY    where
               city_id = ?
               and customer_id = ?
          ';
          if($this -> db-> query($query,array($branch,$cust_id))->num_rows()!=0){
            return $this -> db-> query($query,array($branch,$cust_id))->row()->CITY;
          }
          else{
            return NULL;
          }
    }

    function select_retur_admin($id){
      $query = "select DISTINCT PO_NO,DATE_ORDER,FLAG,TO_DATE(CREATE_DATE,'DD/MM/YYYY') CREATE_DATE,TO_DATE(UPDATE_DATE,'DD/MM/YYYY') UPDATE_DATE,IDENTIFICATION from PN_EORDER_NEW where usernm=? and category_order = 'return' and hidden = 0 order by update_date desc,create_date desc,PO_NO";
      return $this -> db-> query($query,array($id))->result();
    }

    function select_retur_mgr($cust_id){
      $query = "select DISTINCT pen.PO_NO,pen.DATE_ORDER,pen.file_name,pen.FLAG,TO_DATE(pen.CREATE_DATE,'DD/MM/YYYY') CREATE_DATE,TO_DATE(pen.UPDATE_DATE,'DD/MM/YYYY') UPDATE_DATE,pen.IDENTIFICATION,pel.USERNAME from PN_EORDER_NEW pen,PN_EORDER_LOGIN pel where pen.usernm = pel.ID and pen.customer_id=? and pen.category_order = 'return' and pen.hidden = 0 order by update_date desc,create_date desc";
      return $this -> db-> query($query,array($cust_id))->result();
    }


    function select_invoice($cust_id){
      $query = "select rcta.PURCHASE_ORDER,rcta.TRX_DATE,rcta.TRX_NUMBER,apsa.AMOUNT_DUE_REMAINING  as amount
    ,rctl.SALES_ORDER,rctl.INTERFACE_LINE_ATTRIBUTE3 as nomor_do,apsa.DUE_DATE,trunc(sysdate) - apsa.DUE_DATE as telat
    from ra_customer_trx_all rcta,AR_PAYMENT_SCHEDULES_ALL apsa,HZ_ORGANIZATION_PROFILES hop,
        hz_cust_accounts hca,RA_CUSTOMER_TRX_LINES_ALL rctl
    where apsa.trx_number = rcta.trx_number
        and rcta.CUSTOMER_TRX_ID = rctl.CUSTOMER_TRX_ID
        and rcta.sold_to_customer_id=hca.cust_account_id
        AND hca.party_id = hop.party_id
        and hca.ACCOUNT_NUMBER = ?
        and apsa.CLASS = 'INV'
        and apsa.STATUS = 'OP'
        and rcta.ORG_ID = 81
        and rcta.CUST_TRX_TYPE_ID = 1002
        and rctl.SALES_ORDER is not null
        and apsa.AMOUNT_DUE_REMAINING > 1
    group by  rcta.PURCHASE_ORDER,rcta.TRX_DATE,rcta.TRX_NUMBER,apsa.AMOUNT_DUE_REMAINING
        ,rctl.SALES_ORDER,rcta.PURCHASE_ORDER,rctl.INTERFACE_LINE_ATTRIBUTE3,apsa.AMOUNT_DUE_ORIGINAL,rcta.customer_trx_id,apsa.DUE_DATE order by apsa.DUE_DATE
 ";
      return $this -> db-> query($query,array($cust_id))->result();
    }


    function select_tujuan(){
      $query = "select flex.FLEX_VALUE name from FND_FLEX_VALUES_VL flex where flex.FLEX_VALUE_SET_ID = 1013784 order by flex.FLEX_VALUE";
      $res = $this -> db-> query($query)->result();
      return $res;
    }

    function select_uom($product,$customer_id){
      $query = "select qll.PRODUCT_UOM_CODE uom
            from
                qp_list_lines_v qll,qp_list_headers_v qlh ,
                (select  mci.INVENTORY_ITEM_ID,customer_item_number from MTL_CUSTOMER_ITEM_XREFS_V mci where  mci.CUSTOMER_NUMBER = ?) mcix
            where
                qlh.LIST_HEADER_ID = qll.LIST_HEADER_ID
                and qll.PRODUCT_ATTR_VALUE = mcix.INVENTORY_ITEM_ID
                and qll.END_DATE_ACTIVE is null
                and mcix.customer_item_number like ?
                and rownum = 1
            group by qlh.name,mcix.INVENTORY_ITEM_ID,mcix.customer_item_number,qll.OPERAND,qll.PRODUCT_UOM_CODE
            order by mcix.customer_item_number";
      if($this -> db-> query($query,array($customer_id,$product))->num_rows()!=0){
        return $this -> db-> query($query,array($customer_id,$product))->row()->UOM;
      }
      else{
        return NULL;
      }
    }


    function select_price_item($customer_id){
      if($customer_id==1301){
        $query = "select qlh.name pricelist,mcix.customer_item_number product,mcix.customer_item_desc name,pn.ORDER_TYPE order_type,qll.OPERAND harga,qll.PRODUCT_UOM_CODE uom
              from
                  qp_list_lines_v qll,qp_list_headers_v qlh ,
                  (select  mci.INVENTORY_ITEM_ID,customer_item_number,mci.customer_item_desc from MTL_CUSTOMER_ITEM_XREFS_V mci where  mci.CUSTOMER_NUMBER = ?) mcix,
                  (select price_list,order_type from pn_eorder_type where customer_id = ?) pn
              where
                  qlh.LIST_HEADER_ID = qll.LIST_HEADER_ID
                  and qll.PRODUCT_ATTR_VALUE = mcix.INVENTORY_ITEM_ID
                  and qll.END_DATE_ACTIVE is null
                  and pn.price_list = qlh.name
                  and mcix.customer_item_number like 'H%'
              group by qlh.name,mcix.INVENTORY_ITEM_ID,mcix.customer_item_number,pn.ORDER_TYPE,qll.OPERAND,qll.PRODUCT_UOM_CODE,mcix.customer_item_desc
              order by mcix.customer_item_number";
        return $this -> db-> query($query,array($customer_id,$customer_id))->result();

      }
      else{
      $query = "select qlh.name pricelist,mcix.customer_item_number product,mcix.customer_item_desc name,pn.ORDER_TYPE order_type,qll.OPERAND harga,qll.PRODUCT_UOM_CODE uom
            from
                qp_list_lines_v qll,qp_list_headers_v qlh ,
                (select  mci.INVENTORY_ITEM_ID,customer_item_number,mci.customer_item_desc from MTL_CUSTOMER_ITEM_XREFS_V mci where  mci.CUSTOMER_NUMBER = ?) mcix,
                (select price_list,order_type from pn_eorder_type where customer_id = ?) pn
            where
                qlh.LIST_HEADER_ID = qll.LIST_HEADER_ID
                and qll.PRODUCT_ATTR_VALUE = mcix.INVENTORY_ITEM_ID
                and qll.END_DATE_ACTIVE is null
                and pn.price_list = qlh.name
            group by qlh.name,mcix.INVENTORY_ITEM_ID,mcix.customer_item_number,pn.ORDER_TYPE,qll.OPERAND,qll.PRODUCT_UOM_CODE,mcix.customer_item_desc
            order by mcix.customer_item_number";
      return $this -> db-> query($query,array($customer_id,$customer_id))->result();
      }
    }


    function select_price_item_id($customer_id,$product_id){
      $query = "select pn.description
            from
                qp_list_lines_v qll,qp_list_headers_v qlh ,
                (select  mci.INVENTORY_ITEM_ID,customer_item_number from MTL_CUSTOMER_ITEM_XREFS_V mci where  mci.CUSTOMER_NUMBER = ?) mcix,
                (select price_list,order_type,description from pn_eorder_type where customer_id = ?) pn
            where
                qlh.LIST_HEADER_ID = qll.LIST_HEADER_ID
                and qll.PRODUCT_ATTR_VALUE = mcix.INVENTORY_ITEM_ID
                and qll.END_DATE_ACTIVE is null
                and pn.price_list = qlh.name
                and mcix.customer_item_number = ?
            group by pn.description
            order by mcix.customer_item_number";
      if($this -> db-> query($query,array($customer_id,$customer_id,$product_id))->num_rows()!=0){
        return $this -> db-> query($query,array($customer_id,$customer_id,$product_id))->last_row()->DESCRIPTION;
      }
      else{
        return null;
      }

    }


    function select_order_type_id($customer_id,$pricelist){
      $query = "select order_type from pn_eorder_type where customer_id = ? and description = ?";

      if($this -> db-> query($query,array($customer_id,$pricelist))->num_rows()!=0){
        return $this -> db-> query($query,array($customer_id,$pricelist))->last_row()->ORDER_TYPE;
      }
      else{
        return null;
      }

    }



}
