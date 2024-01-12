<?php

$normalize = '';
// Header

$normalize .= '"HEADER"';

$normalize .= '"DATETIMEISSUED"';
$normalize .= '"2023-11-07T00:34:00Z"';

$normalize .= '"RECEIPTNUMBER"';
$normalize .= '"19"';

$normalize .= '"UUID"';
$normalize .= '""';

$normalize .= '"PREVIOUSUUID"';
$normalize .= '""';

$normalize .= '"CURRENCY"';
$normalize .= '"EGP"';

$normalize .= '"ORDERDELIVERYMODE"';
$normalize .= '"FC"';

// Document Type

$normalize .= '"DOCUMENTTYPE"';

$normalize .= '"RECEIPTTYPE"';
$normalize .= '"S"';

$normalize .= '"TYPEVERSION"';
$normalize .= '"1.2"';

// Seller

$normalize .= '"SELLER"';

$normalize .= '"RIN"';
$normalize .= '"668043024"';

$normalize .= '"COMPANYTRADENAME"';
$normalize .= '"بلاك بيرل للخدمات الغذائيه"';

$normalize .= '"BRANCHCODE"';
$normalize .= '"0"';

$normalize .= '"BRANCHADDRESS"';

$normalize .= '"COUNTRY"';
$normalize .= '"EG"';

$normalize .= '"GOVERNATE"';
$normalize .= '"cairo"';

$normalize .= '"REGIONCITY"';
$normalize .= '"new cairo"';

$normalize .= '"STREET"';
$normalize .= '"مول ون جولدن سكوير ش التسعين التجمع الخامس القاهره"';

$normalize .= '"BUILDINGNUMBER"';
$normalize .= '"0"';

$normalize .= '"DEVICESERIALNUMBER"';
$normalize .= '"F20MP2202002662"';

$normalize .= '"ACTIVITYCODE"';
$normalize .= '"5610"';

// Buyer

$normalize .= '"BUYER"';

$normalize .= '"TYPE"';
$normalize .= '"P"';

// Item Data

$normalize .= '"ITEMDATA"';

// Item 1
$normalize .= '"ITEMDATA"';

$normalize .= '"INTERNALCODE"';
$normalize .= '"880609"';

$normalize .= '"DESCRIPTION"';
$normalize .= '"Samsung A02 32GB_LTE_BLACK_DS_SM-A022FZKDMEB_A022 _ A022_SM-A022FZKDMEB"';

$normalize .= '"ITEMTYPE"';
$normalize .= '"GS1"';

$normalize .= '"ITEMCODE"';
$normalize .= '"037000401629"';

$normalize .= '"UNITTYPE"';
$normalize .= '"EA"';

$normalize .= '"QUANTITY"';
$normalize .= '"35"';

$normalize .= '"UNITPRICE"';
$normalize .= '"247.96000"';

$normalize .= '"NETSALE"';
$normalize .= '"7810.74000"';

$normalize .= '"TOTALSALE"';
$normalize .= '"8678.60000"';

$normalize .= '"TOTAL"';
$normalize .= '"8887.04360"';

// Commercial Discount

$normalize .= '"COMMERCIALDISCOUNTDATA"';

// Commercial Discount 1

$normalize .= '"COMMERCIALDISCOUNTDATA"';

$normalize .= '"AMOUNT"';
$normalize .= '"867.86000"';

$normalize .= '"DESCRIPTION"';
$normalize .= '"XYZ"';

$normalize .= '"RATE"';
$normalize .= '"2.3"';

// Item Discount

$normalize .= '"ITEMDISCOUNTDATA"';

// Item Discount 1

$normalize .= '"ITEMDISCOUNTDATA"';

$normalize .= '"AMOUNT"';
$normalize .= '"10"';

$normalize .= '"DESCRIPTION"';
$normalize .= '"ABC"';

$normalize .= '"RATE"';
$normalize .= '"2.3"';


// Taxable Items

$normalize .= '"TAXABLEITEMS"';

// Taxable Item 1

$normalize .= '"TAXABLEITEMS"';

$normalize .= '"TAXTYPE"';
$normalize .= '"T1"';

$normalize .= '"AMOUNT"';
$normalize .= '"1096.30360"';

$normalize .= '"SUBTYPE"';
$normalize .= '"V009"';

$normalize .= '"RATE"';
$normalize .= '"14"';

// Invoice Data

$normalize .= '"TOTALSALES"';
$normalize .= '"8678.60000"';

$normalize .= '"TOTALCOMMERCIALDISCOUNT"';
$normalize .= '"867.86000"';

$normalize .= '"TOTALITEMSDISCOUNT"';
$normalize .= '"20"';

$normalize .= '"NETAMOUNT"';
$normalize .= '"7810.74000"';

$normalize .= '"TOTALAMOUNT"';
$normalize .= '"8887.04360"';

// Tax Total

$normalize .= '"TAXTOTALS"';

// Tax Total 1

$normalize .= '"TAXTOTALS"';

$normalize .= '"TAXTYPE"';
$normalize .= '"T1"';

$normalize .= '"AMOUNT"';
$normalize .= '"1096.30360"';

// Payment Method

$normalize .= '"PAYMENTMETHOD"';
$normalize .= '"C"';



// $normalize = '"HEADER""DATETIMEISSUED""2023-11-07T00:34:00Z""RECEIPTNUMBER""14""UUID""""PREVIOUSUUID""""CURRENCY""EGP""ORDERDELIVERYMODE""FC""DOCUMENTTYPE""RECEIPTTYPE""S""TYPEVERSION""1.2""SELLER""RIN""668043024""COMPANYTRADENAME""بلاك بيرل للخدمات الغذائيه""BRANCHCODE""0""BRANCHADDRESS""COUNTRY""EG""GOVERNATE""cairo""REGIONCITY""new cairo""STREET""مول ون جولدن سكوير ش التسعين التجمع الخامس القاهره""BUILDINGNUMBER""0""DEVICESERIALNUMBER""F20MP2202002662""ACTIVITYCODE""5610""BUYER""TYPE""P""ITEMDATA""ITEMDATA""INTERNALCODE""EG-668043024-Packaging/Storage Services""DESCRIPTION""""ITEMTYPE""EGS""ITEMCODE""10007593""UNITTYPE""EA""QUANTITY""1""UNITPRICE""100.00""NETSALE""100.00""TOTALSALE""100.00""TOTAL""114.00""COMMERCIALDISCOUNTDATA""COMMERCIALDISCOUNTDATA""AMOUNT""0""DESCRIPTION""""ITEMDISCOUNTDATA""ITEMDISCOUNTDATA""AMOUNT""0""DESCRIPTION""""TAXABLEITEMS""TAXABLEITEMS""TAXTYPE""T1""AMOUNT""14.00""SUBTYPE""V009""TOTALSALES""100.00""TOTALCOMMERCIALDISCOUNT""0""TOTALITEMSDISCOUNT""0""NETAMOUNT""100.00""TOTALAMOUNT""114.00""TAXTOTALS""TAXTOTALS""TAXTYPE""T1""AMOUNT""14.00""PAYMENTMETHOD""C"';

$hashValue = hash('sha256', $normalize);
echo "<pre style='word-wrap: break-word;white-space: pre-wrap;'>";
echo $normalize . "<br>";
echo $hashValue;
echo "</pre>";
