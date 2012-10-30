<?php
 class oper {
  public function left($id,$id_tenant) {
    
    $adr = $my->query("select * from `service_for_house` sfh where $id=sfh.id_house");
    while (@$num = $adr->fetch_assoc()) {
      $q=$my->query("insert into leftover values ('',".$id_tenant.",".$num['id_service'].", 0 , 'создано ".date('d.m.y').")");
    } 
  }
  public function sfh($id,$id_tenant) {
    $my = new mysqli("localhost", "root", "dadmin1", "jkh");
    $adr = $my->query("select * from `service_for_house` sfh where $id=sfh.id_house");
    $q1=$my->query("select square,quantity_of_lodger from the_tenant where id_tenant=$id_tenant");
    $num =$q1->fetch_assoc();
    $s=$num['square'];
    $ql=$num['quantity_of_lodger'];
    while (@$num = $adr->fetch_assoc()) {
      $service=$my->query("select price_for_1_sqr_metre_k1,price_for_1_sqr_metre_k2,
      price_for_1_people_k1,price_for_1_people_k2 from service where id_service=".$num['id_service']);
      $ser=$service->fetch_assoc();
      $summ=$s*$ser['price_for_1_sqr_metre_k1']*$ser['price_for_1_sqr_metre_k2']+$ql*$ser['price_for_1_people_k1']*$ser['price_for_1_people_k2'] ;
      $q=$my->query("insert into tenant_card values ('',".$num['id_service'].",".$id_tenant.",".$summ.")");
    } 
  }
  public function service_edit($id,$kvm1,$kvm2,$kvc1,$kvc2) {
    $my = new mysqli("localhost", "root", "dadmin1", "jkh");
    $adr = $my -> query("select * from tenant_card where id_service=$id");
    while (@$num = $adr->fetch_assoc()) {
      $id_tenant=$my->query("select * from the_tenant where id_tenant=".$num['id_tenant']);
      $data_tenant=$id_tenant->fetch_assoc();
      $summ=$data_tenant['square']*$kvm1*$kvm2+$data_tenant['quantity_of_lodger']*$kvc1*$kvc2;
      $update_tc=$my->query("update tenant_card set amount=".$summ." where id_card =".$num['id_card']);
    }
  }  
}
?>