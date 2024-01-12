<?php

function edit_manufacturer_purchase()
{
  global $con;
  if (isset($_POST['order_id']) && isset($_POST['curr_total']) && isset($_POST['curr_due']) && isset($_POST['edit_order_purchase']) && isset($_POST['supplier_id']) && isset($_POST['due_to'])) {
    $supplier_id = trim($_POST['supplier_id']);
    $created_time = date("Y-m-d h:i A");
    $order_id = trim($_POST['order_id']);
    $orderI = $supplier_id;
    $transfer_id = get_transfer_order_number();
    $user_info = login_info();
    $resp_id = $user_info['id'];
    if (isset($_POST['old_paid']) && !empty($_POST['old_paid'])) {
      $old_paid = floatval(str_replace(',', '', $_POST['old_paid']));
    } else {
      $old_paid = 0;
    }
    if (isset($_POST['paid']) && !empty($_POST['paid']) && $_POST['paid'] !== 0) {
      $curr_paid = floatval(str_replace(',', '', $_POST['paid']));
    } else {
      $curr_paid = 0;
    }
    $due_to = floatval(str_replace(',', '', $_POST['due_to']));
    $curr_total = floatval(str_replace(',', '', $_POST['curr_total']));
    $curr_due = floatval(str_replace(',', '', $_POST['curr_due']));


    $total_paid = $old_paid + $curr_paid;
    if ($curr_due < 0) {
    } else {
      if ($curr_due == 0) {
        $status = "paid";
        if (isset($_POST['received'])) {
          $received = 1;
        } else {
          $received = 0;
        }
      } else {
        if (isset($_POST['received'])) {
          $received = 1;
          $givenTimestamp = strtotime($due_to);
          $currentTimestamp = time();
          if ($currentTimestamp > $givenTimestamp) {
            $status = "overdue";
          } else {
            $status = "due";
          }
        } else {
          $received = 0;
          $status = "due";
        }
      }


      if (isset($_POST['received'])) {
        $received = 1;
        $started = 1;
        $stmt8 = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$order_id'");
        $stmt8->execute();
        $count8 = $stmt8->rowCount();
        if ($count8 > 0) {
          while ($row8 = $stmt8->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row8 as $ord) {
              $prev_rec = $ord['received'];
              $payment_m = $ord['payment_m'];
              $bank_name = $ord['bank_name'];
              $bank_number = $ord['bank_number'];
              $items_total = $ord['total'];
              $total = $ord['order_total'];
              $item_id = $ord['item_id'];
              $item_quantity = $ord['quantity'];
              $item_amount = $ord['amount'];
              $item_desc = $ord['description'];
              $storable = $ord['storable'];
              $warehouse = $ord['warehouse_id'];
              $vat_perc = $ord['vat_perc'];
              $discount = $ord['discount'];
              $subtotal = $ord['subtotal'];
              $item_total = $ord['total'];
              $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);

              $item_total_vat_inc = (($item_total + $subtotal - $discount) / $item_quantity);

              $item_rate =  $item_amount + (($subtotal - $discount) / $item_quantity);


              $stmt98 = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
              $stmt98->execute();
              $row98 = $stmt98->fetch(PDO::FETCH_ASSOC);
              $item_name = $row98['name'];
              $item_unit = $row98['unit'];
              $item_img = $row98['img'];



              if ($prev_rec == 0) {

                $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
                $stmt3->execute();
                $count3 = $stmt3->rowCount();
                if ($count3 > 0) {
                  $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                  $sum = $row3['balance'];
                  $balance = $sum - $items_total;
                  $credit = $items_total + $total;
                  $last_balance =  $sum + $credit;
                } else {
                  $balance = -1 * $items_total;
                  $credit = $items_total + $total;
                  $last_balance = $balance + $credit;
                }

                $last_statement = "استلام منتج تام";
                $stmt3 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$credit','$last_balance','$created_time','','','$last_statement','')");
                $stmt3->execute();



                $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                    foreach ($row as $ite) {
                      $img = $ite['img'];





                      $stmt4 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `supplier_id` = '$supplier_id' AND `rate` = '$item_rate' AND `warehouse_id` = '$warehouse'");
                      $stmt4->execute();
                      $count4 = $stmt4->rowCount();
                      if ($count4 > 0) {
                        while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                          foreach ($row4 as $avitem_info) {
                            $new_quantity = $item_quantity + $avitem_info['quantity'];
                            $stmt5 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `item_id` = '$item_id' AND `supplier_id` = '$supplier_id' AND `rate` = '$item_rate' AND `warehouse_id` = '$warehouse' ");
                            $stmt5->execute();
                          }
                        }
                      } else {
                        $stmt5 = $con->prepare("INSERT INTO `av_items` (`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`item_id`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$item_rate','$storable','$warehouse','$created_time','$item_id','$item_img','0','0','$order_id')");
                        $stmt5->execute();
                      }





                      // New Code Here
                      $stmt4 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id'");
                      $stmt4->execute();
                      $count4 = $stmt4->rowCount();
                      if ($count4 > 0) {
                        $hosted_quantity = 0;
                        while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                          foreach ($row4 as $avitem_info) {
                            $hosted_quantity += $avitem_info['quantity'];
                            $avitem_info_rate = $avitem_info['rate'];
                          }
                        }
                        $new_average_rate = (($hosted_quantity * $avitem_info_rate) + ($item_quantity * $item_total_vat_inc)) / ($hosted_quantity + $item_quantity);


                        $stmt5 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse'");
                        $stmt5->execute();
                        $count5 = $stmt5->rowCount();
                        if ($count5 > 0) {
                          // HERE
                          while ($row5 = $stmt5->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                            foreach ($row5 as $avitem_info_warehouse) {
                              $new_quantity =  $avitem_info_warehouse['quantity'] + $item_quantity;
                              $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                              $stmt6->execute();
                              $stmt5 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse' ");
                              $stmt5->execute();
                            }
                          }
                        } else {
                          // HERE

                          $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                          $stmt6->execute();
                          $stmt77 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_id','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$new_average_rate','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                          $stmt77->execute();
                        }
                      } else {
                        $stmt2 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_id','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$item_total_vat_inc','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                        $stmt2->execute();
                      }
                      // End New Code Here






                      $stmt96 = $con->prepare("DELETE FROM `av_items` WHERE `supplier_id` = '$orderI' AND `warehouse_id` = '314' AND `order_id` = '$order_id'");
                      $stmt96->execute();
                    }
                  }
                }
              }
            }
          }
        }
      } else {
        if (isset($_POST['started'])) {
          $received = 0;
          $started = 1;
          $stmt8 = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$order_id'");
          $stmt8->execute();
          $count8 = $stmt8->rowCount();
          if ($count8 > 0) {
            while ($row8 = $stmt8->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              foreach ($row8 as $ord) {
                $prev_start = $ord['started'];
                $prev_rec = $ord['received'];
                $payment_m = $ord['payment_m'];
                $bank_name = $ord['bank_name'];
                $items_total = $ord['total'];
                $total = $ord['order_total'];
                $item_id = $ord['item_id'];
                $item_quantity = $ord['quantity'];
                $item_amount = $ord['amount'];
                $item_desc = $ord['description'];
                $storable = $ord['storable'];
                $warehouse = $ord['warehouse_id'];
                $vat_perc = $ord['vat_perc'];
                $subtotal = $ord['subtotal'];
                $discount = $ord['discount'];
                $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);
                $item_total_vat_inc = (($vat_perc / 100) * $item_amount) + $item_amount;
                $item_rate =  $item_amount + (($subtotal - $discount) / $item_quantity);
                if ($prev_start == 0) {
                  $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
                  $stmt3->execute();
                  $count3 = $stmt3->rowCount();
                  if ($count3 > 0) {
                    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                    $sum = $row3['balance'];
                    $balance = $sum - $items_total;
                  } else {
                    $balance = -1 * $items_total;
                  }
                  $statement = "تسليم خامات التصنيع";
                  $stmt33 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$items_total','0','$balance','$created_time','','','$statement','')");
                  $stmt33->execute();

                  $item_rate =  $item_amount + (($total) / $item_quantity);
                  $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);
                  $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
                  $stmt->execute();
                  $count = $stmt->rowCount();
                  if ($count > 0) {
                    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                      foreach ($row as $ite) {
                        $img = $ite['img'];
                        if ($ite['is_composite'] == 1) {
                          $subitems = $ite['sub_items'];
                          $exp_subitems = explode("-", $subitems);
                          $subquantity = $ite['sub_quantity'];
                          $exp_subquantity = explode("-", $subquantity);
                          $i = 0;
                          foreach ($exp_subitems as $subitem) {
                            // echo $subitem . "->" . $exp_subquantity[$i] . "<br>";
                            $stmt77 = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$subitem'");
                            $stmt77->execute();
                            $row77 = $stmt77->fetch(PDO::FETCH_ASSOC);
                            $real_item_id = $row77['item_id'];
                            $assm_quantity = ($exp_subquantity[$i] * $item_quantity);
                            $assm_quantity_2 = ($exp_subquantity[$i] * $item_quantity);
                            $available_quantities = array();
                            $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` != '314' ORDER BY `created_time` ASC");
                            $stmt2->execute();
                            $count2 = $stmt2->rowCount();
                            if ($count2 > 0) {
                              while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($row2 as $one) {
                                  array_push($available_quantities, $one);
                                }
                              }
                            }
                            foreach ($available_quantities as $quan) {
                              $old_quantity =  $quan["quantity"];
                              $old_rate =  $quan["rate"];
                              $tmp_id =  $quan["id"];
                              $name =  $quan["name"];
                              $unit =  $quan["unit"];
                              $img =  $quan["img"];
                              $unit =  $quan["unit"];
                              $item_sku = "622" . substr($quan['item_id'], 3, 4) . rand(10000, 99999);
                              $item_warehouse = $quan['warehouse_id'];
                              $total_quantity = ($exp_subquantity[$i] * $item_quantity);
                              $new_quantity = $old_quantity - $total_quantity;
                              $newtotal = $quan['quantity'] - $assm_quantity;
                              if ($newtotal < 0) {
                                $new_quantity = 0;
                                $trans_quantity = $quan['quantity'];
                              } else {
                                $new_quantity = $newtotal;
                                $trans_quantity = $assm_quantity;
                              }
                              $total_rate = $old_rate * $trans_quantity;
                              $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `id` = '$tmp_id'");
                              $stmt88->execute();
                              $stmt99 = $con->prepare("INSERT INTO `transfers` (`item_id`,`transfer_from`,`transfer_to`,`date`,`amount`,`quantity`,`total`,`unit`,`transfer_id`) VALUES ('$real_item_id','$item_warehouse','314','$created_time','$old_rate','$trans_quantity','$total_rate','$unit','$transfer_id')");
                              $stmt99->execute();

                              if ($newtotal < 0) {
                                $assm_quantity = -1 * $newtotal;
                                $new_quantity = 0;
                              } else {
                                $stmt75 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` = '314' AND `supplier_id` = '$supplier_id' AND `rate` = '$old_rate' ");
                                $stmt75->execute();
                                $count75 = $stmt75->rowCount();
                                if ($count75 > 0) {
                                  while ($row75 = $stmt75->fetchAll(PDO::FETCH_ASSOC)) {
                                    $old_quantity_2 =  $row75[0]["quantity"];
                                    $new_quantity_2 = $old_quantity_2 + $assm_quantity_2;
                                    $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity_2' WHERE `item_id` = '$real_item_id' AND `warehouse_id` = '314' AND `supplier_id` = '$supplier_id' AND `rate` = '$old_rate' ");
                                    $stmt88->execute();
                                  }
                                } else {
                                  $stmt99 = $con->prepare("INSERT INTO `av_items` (`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`item_id`,`img`,`margin`,`sell_rate`,`order_id`)  VALUES ('$orderI','$name','$item_sku','','$unit','$assm_quantity_2','$old_rate','1','314','$created_time','$real_item_id','$img','0','0','$order_id')");
                                  $stmt99->execute();
                                }
                                break;
                              }
                            }
                            $i++;
                          }
                        }
                      }
                      $stmt102 = $con->prepare("INSERT INTO `transfer_orders` (`id`,`date`,`resp`) VALUES ('$transfer_id','$created_time','$resp_id')");
                      $stmt102->execute();
                    }
                  }
                }
              }
            }
          }
        }
      }
      $stmt5 = $con->prepare("UPDATE `manufacturer_orders` SET `received`='$received',`started`='$started',`status`='$status' WHERE `order_id`='$order_id'");
      $stmt5->execute();
      header("location:manufacturerdetails.php?uid=$supplier_id");
      exit();
    }
  }
}

function edit_manufacturer_purchase()
{
  global $con;
  if (isset($_POST['order_id']) && isset($_POST['curr_total']) && isset($_POST['curr_due']) && isset($_POST['edit_order_purchase']) && isset($_POST['supplier_id']) && isset($_POST['due_to'])) {
    $supplier_id = trim($_POST['supplier_id']);
    $created_time = date("Y-m-d h:i A");
    $order_id = trim($_POST['order_id']);
    $orderI = $supplier_id;
    $transfer_id = get_transfer_order_number();
    $user_info = login_info();
    $resp_id = $user_info['id'];
    if (isset($_POST['old_paid']) && !empty($_POST['old_paid'])) {
      $old_paid = floatval(str_replace(',', '', $_POST['old_paid']));
    } else {
      $old_paid = 0;
    }
    if (isset($_POST['paid']) && !empty($_POST['paid']) && $_POST['paid'] !== 0) {
      $curr_paid = floatval(str_replace(',', '', $_POST['paid']));
    } else {
      $curr_paid = 0;
    }
    $due_to = floatval(str_replace(',', '', $_POST['due_to']));
    $curr_total = floatval(str_replace(',', '', $_POST['curr_total']));
    $curr_due = floatval(str_replace(',', '', $_POST['curr_due']));


    $total_paid = $old_paid + $curr_paid;
    if ($curr_due < 0) {
    } else {
      if ($curr_due == 0) {
        $status = "paid";
        if (isset($_POST['received'])) {
          $received = 1;
        } else {
          $received = 0;
        }
      } else {
        if (isset($_POST['received'])) {
          $received = 1;
          $givenTimestamp = strtotime($due_to);
          $currentTimestamp = time();
          if ($currentTimestamp > $givenTimestamp) {
            $status = "overdue";
          } else {
            $status = "due";
          }
        } else {
          $received = 0;
          $status = "due";
        }
      }


      if (isset($_POST['received'])) {
        $received = 1;
        $started = 1;
        $stmt8 = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$order_id'");
        $stmt8->execute();
        $count8 = $stmt8->rowCount();
        if ($count8 > 0) {
          while ($row8 = $stmt8->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row8 as $ord) {
              $prev_rec = $ord['received'];
              $payment_m = $ord['payment_m'];
              $bank_name = $ord['bank_name'];
              $bank_number = $ord['bank_number'];
              $items_total = $ord['total'];
              $total = $ord['order_total'];
              $item_id = $ord['item_id'];
              $item_quantity = $ord['quantity'];
              $item_amount = $ord['amount'];
              $item_desc = $ord['description'];
              $storable = $ord['storable'];
              $warehouse = $ord['warehouse_id'];
              $vat_perc = $ord['vat_perc'];
              $discount = $ord['discount'];
              $subtotal = $ord['subtotal'];
              $item_total = $ord['total'];
              $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);
              $item_total_vat_inc = $item_amount - ((($item_total / $subtotal) * $discount) / $item_quantity);
              $item_rate =  $item_amount + (($subtotal - $discount) / $item_quantity);


              $stmt98 = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
              $stmt98->execute();
              $row98 = $stmt98->fetch(PDO::FETCH_ASSOC);
              $item_name = $row98['name'];
              $item_unit = $row98['unit'];
              $item_img = $row98['img'];



              if ($prev_rec == 0) {

                $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
                $stmt3->execute();
                $count3 = $stmt3->rowCount();
                if ($count3 > 0) {
                  $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                  $sum = $row3['balance'];
                  $balance = $sum - $items_total;
                  $credit = $items_total + $total;
                  $last_balance =  $sum + $credit;
                } else {
                  $balance = -1 * $items_total;
                  $credit = $items_total + $total;
                  $last_balance = $balance + $credit;
                }

                $last_statement = "استلام منتج تام";
                $stmt3 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$credit','$last_balance','$created_time','','','$last_statement','')");
                $stmt3->execute();
                $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                    foreach ($row as $ite) {
                      $img = $ite['img'];

                      $stmt4 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `supplier_id` = '$supplier_id' AND `rate` = '$item_rate' AND `warehouse_id` = '$warehouse'");
                      $stmt4->execute();
                      $count4 = $stmt4->rowCount();
                      if ($count4 > 0) {
                        while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                          foreach ($row4 as $avitem_info) {
                            $new_quantity = $item_quantity + $avitem_info['quantity'];
                            $stmt5 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `item_id` = '$item_id' AND `supplier_id` = '$supplier_id' AND `rate` = '$item_rate' AND `warehouse_id` = '$warehouse' ");
                            $stmt5->execute();
                          }
                        }
                      } else {
                        $stmt5 = $con->prepare("INSERT INTO `av_items` (`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`item_id`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$item_rate','$storable','$warehouse','$created_time','$item_id','$item_img','0','0','$order_id')");
                        $stmt5->execute();
                      }
                      $stmt96 = $con->prepare("DELETE FROM `av_items` WHERE `supplier_id` = '$orderI' AND `warehouse_id` = '314' AND `order_id` = '$order_id'");
                      $stmt96->execute();
                    }
                  }
                }
              }
            }
          }
        }
      } else {
        if (isset($_POST['started'])) {
          $received = 0;
          $started = 1;
          $stmt8 = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$order_id'");
          $stmt8->execute();
          $count8 = $stmt8->rowCount();
          if ($count8 > 0) {
            while ($row8 = $stmt8->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              foreach ($row8 as $ord) {
                $prev_start = $ord['started'];
                $prev_rec = $ord['received'];
                $payment_m = $ord['payment_m'];
                $bank_name = $ord['bank_name'];
                $items_total = $ord['total'];
                $total = $ord['order_total'];
                $item_id = $ord['item_id'];
                $item_quantity = $ord['quantity'];
                $item_amount = $ord['amount'];
                $item_desc = $ord['description'];
                $storable = $ord['storable'];
                $warehouse = $ord['warehouse_id'];
                $vat_perc = $ord['vat_perc'];
                $subtotal = $ord['subtotal'];
                $discount = $ord['discount'];
                $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);
                $item_total_vat_inc = (($vat_perc / 100) * $item_amount) + $item_amount;
                $item_rate =  $item_amount + (($subtotal - $discount) / $item_quantity);
                if ($prev_start == 0) {
                  $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
                  $stmt3->execute();
                  $count3 = $stmt3->rowCount();
                  if ($count3 > 0) {
                    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                    $sum = $row3['balance'];
                    $balance = $sum - $items_total;
                  } else {
                    $balance = -1 * $items_total;
                  }
                  $statement = "تسليم خامات التصنيع";
                  $stmt33 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$items_total','0','$balance','$created_time','','','$statement','')");
                  $stmt33->execute();

                  $item_rate =  $item_amount + (($total) / $item_quantity);
                  $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);
                  $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
                  $stmt->execute();
                  $count = $stmt->rowCount();
                  if ($count > 0) {
                    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                      foreach ($row as $ite) {
                        $img = $ite['img'];
                        if ($ite['is_composite'] == 1) {
                          $subitems = $ite['sub_items'];
                          $exp_subitems = explode("-", $subitems);
                          $subquantity = $ite['sub_quantity'];
                          $exp_subquantity = explode("-", $subquantity);
                          $i = 0;
                          foreach ($exp_subitems as $subitem) {
                            // echo $subitem . "->" . $exp_subquantity[$i] . "<br>";
                            $stmt77 = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$subitem'");
                            $stmt77->execute();
                            $row77 = $stmt77->fetch(PDO::FETCH_ASSOC);
                            $real_item_id = $row77['item_id'];
                            $assm_quantity = ($exp_subquantity[$i] * $item_quantity);
                            $assm_quantity_2 = ($exp_subquantity[$i] * $item_quantity);
                            $available_quantities = array();
                            $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` != '314' ORDER BY `created_time` ASC");
                            $stmt2->execute();
                            $count2 = $stmt2->rowCount();
                            if ($count2 > 0) {
                              while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($row2 as $one) {
                                  array_push($available_quantities, $one);
                                }
                              }
                            }
                            foreach ($available_quantities as $quan) {
                              $old_quantity =  $quan["quantity"];
                              $old_rate =  $quan["rate"];
                              $tmp_id =  $quan["id"];
                              $name =  $quan["name"];
                              $unit =  $quan["unit"];
                              $img =  $quan["img"];
                              $unit =  $quan["unit"];
                              $item_sku = "622" . substr($quan['item_id'], 3, 4) . rand(10000, 99999);
                              $item_warehouse = $quan['warehouse_id'];
                              $total_quantity = ($exp_subquantity[$i] * $item_quantity);
                              $new_quantity = $old_quantity - $total_quantity;
                              $newtotal = $quan['quantity'] - $assm_quantity;
                              if ($newtotal < 0) {
                                $new_quantity = 0;
                                $trans_quantity = $quan['quantity'];
                              } else {
                                $new_quantity = $newtotal;
                                $trans_quantity = $assm_quantity;
                              }
                              $total_rate = $old_rate * $trans_quantity;
                              $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `id` = '$tmp_id'");
                              $stmt88->execute();
                              $stmt99 = $con->prepare("INSERT INTO `transfers` (`item_id`,`transfer_from`,`transfer_to`,`date`,`amount`,`quantity`,`total`,`unit`,`transfer_id`) VALUES ('$real_item_id','$item_warehouse','314','$created_time','$old_rate','$trans_quantity','$total_rate','$unit','$transfer_id')");
                              $stmt99->execute();

                              if ($newtotal < 0) {
                                $assm_quantity = -1 * $newtotal;
                                $new_quantity = 0;
                              } else {
                                $stmt75 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` = '314' AND `supplier_id` = '$supplier_id' AND `rate` = '$old_rate' ");
                                $stmt75->execute();
                                $count75 = $stmt75->rowCount();
                                if ($count75 > 0) {
                                  while ($row75 = $stmt75->fetchAll(PDO::FETCH_ASSOC)) {
                                    $old_quantity_2 =  $row75[0]["quantity"];
                                    $new_quantity_2 = $old_quantity_2 + $assm_quantity_2;
                                    $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity_2' WHERE `item_id` = '$real_item_id' AND `warehouse_id` = '314' AND `supplier_id` = '$supplier_id' AND `rate` = '$old_rate' ");
                                    $stmt88->execute();
                                  }
                                } else {
                                  $stmt99 = $con->prepare("INSERT INTO `av_items` (`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`item_id`,`img`,`margin`,`sell_rate`,`order_id`)  VALUES ('$orderI','$name','$item_sku','','$unit','$assm_quantity_2','$old_rate','1','314','$created_time','$real_item_id','$img','0','0','$order_id')");
                                  $stmt99->execute();
                                }
                                break;
                              }
                            }
                            $i++;
                          }
                        }
                      }
                      $stmt102 = $con->prepare("INSERT INTO `transfer_orders` (`id`,`date`,`resp`) VALUES ('$transfer_id','$created_time','$resp_id')");
                      $stmt102->execute();
                    }
                  }
                }
              }
            }
          }
        }
      }
      $stmt5 = $con->prepare("UPDATE `manufacturer_orders` SET `received`='$received',`started`='$started',`status`='$status' WHERE `order_id`='$order_id'");
      $stmt5->execute();
      header("location:manufacturerdetails.php?uid=$supplier_id");
      exit();
    }
  }
}
