<?php
$test = (object) [
  "firstObject" => (object) [
    "firstChild" => "my name is abdallah",
    "secondChild" => "my age is 24"
  ],
  "secondObject" => [
    (object) [
      "thirdChild" => "i am from jordan",
      "fourthChild" => "i love programming"
    ],
    (object) [
      "fifthChild" => "i like swimming",
      "sixthChild" => "i hate cooking"
    ]
  ]
];


$test = (object) [
  "header" => (object) [
    "dateTimeIssued" => "2023-11-06T00:34:00Z",
    "receiptNumber" => "7",
    "uuid" => "",
    "previousUUID" => "",
    "currency" => "EGP",
    "orderdeliveryMode" => "FC",
  ],
  "documentType" => (object) [
    "receiptType" => "S",
    "typeVersion" => "1.2"
  ],
  "seller" => (object) [
    "rin" => "668043024",
    "companyTradeName" => "بلاك بيرل للخدمات الغذائيه",
    "branchCode" => "0",
    "branchAddress" => (object)[
      "country" => "EG",
      "governate" => "cairo",
      "regionCity" => "new cairo",
      "street" => "مول ون جولدن سكوير  ش التسعين التجمع الخامس القاهره",
      "buildingNumber" => "0"
    ],
    "deviceSerialNumber" => "F20MP2202002662",
    "activityCode" => "5610"
  ],
  "buyer" => (object) [
    "type" => "P"
  ],
  "itemData" => [
    (object)[
      "internalCode" => "880609",
      "description" => "Samsung A02 32GB_LTE_BLACK_DS_SM-A022FZKDMEB_A022 _ A022_SM-A022FZKDMEB",
      "itemType" => "GS1",
      "itemCode" => "037000401629",
      "unitType" => "EA",
      "quantity" => 35,
      "unitPrice" =>  247.96000,
      "netSale" =>  7810.74000,
      "totalSale" =>  8678.60000,
      "total" =>  8887.04360,
      "commercialDiscountData" => [
        (object)[
          "amount" => 867.86000,
          "description" => "XYZ",
          "rate" => 2.3
        ]
      ]
    ]
  ],
  [
    (object)[
      "internalCode" => "880609",
      "description" => "Samsung A02 32GB_LTE_BLACK_DS_SM-A022FZKDMEB_A022 _ A022_SM-A022FZKDMEB",
      "itemType" => "GS1",
      "itemCode" => "037000401629",
      "unitType" => "EA",
      "quantity" => 35,
      "unitPrice" =>  247.96000,
      "netSale" =>  7810.74000,
      "totalSale" =>  8678.60000,
      "total" =>  8887.04360,
      "commercialDiscountData" => [
        (object)[
          "amount" => 867.86000,
          "description" => "XYZ",
          "rate" => 2.3
        ]
      ]
    ]
  ]
];
//                   "commercialDiscountData": [
//                        {
//                            "amount": 867.86000, 
//                            "description": "XYZ",
//                            "rate":2.3
//                        }
//                   ],
//                   "itemDiscountData": [
//                       {
//                           "amount": 10,
//                           "description":"ABC",
//                            "rate":2.3
//                       },
//                       {
//                           "amount": 10,
//                           "description": "XYZ",
//                            "rate":4.0
//                       }
//                   ],
//                    "additionalCommercialDiscount": {
//                           "amount": 9456.1404,
//                           "description": "ABC",
//                           "rate": 10.0
//                       },
//                       "additionalItemDiscount": {
//                           "amount": 9456.1404,
//                           "description": "XYZ",
//                           "rate": 10.0
//                       },
//                   "valueDifference": 20,
//                   "taxableItems": [
//                       {
//                               "taxType": "T1",
//                               "amount":  1096.30360 ,
//                               "subType": "V009",
//                               "rate": 14
//                       }
//                   ]
//               }
//           ],
//           "totalSales": 8678.60000,
//           "totalCommercialDiscount": 867.86000,
//           "totalItemsDiscount": 20,
//           "extraReceiptDiscountData": [
//              {
//                  "amount": 0,
//                  "description": "ABC",
//                   "rate":10
//              }
//           ],
//           "netAmount": 7810.74000,
//           "feesAmount": 0,
//           "totalAmount": 8887.04360,
//           "taxTotals": [
//                   {
//                       "taxType": "T1",
//                       "amount": 1096.30360
//                   }
//           ],
//           "paymentMethod": "C"
//       }
//   ]

// }
// ';

// echo "<pre style='word-wrap: break-word; white-space: pre-wrap;'>";
// print_r($test);
// echo "</pre>";

$flattenData = '';
function serializeDocument($obj)
{
  global $flattenData;
  foreach ($obj as $key => $value) {
    if (is_array($value)) {
      foreach ($value as $k => $v) {
        $flattenData .= '"' . strtoupper($k) . '"';
        if (is_array($v)) {
        } else if (is_object($v)) {
          $flattenData .= '"' . strtoupper($k) . '"';
          serializeDocument($v);
        } else {
          $flattenData .= '"' . strtoupper($k) . '"';
          $flattenData .= '"' . $v . '"';
        }
      }
    } else if (is_object($value)) {
      $flattenData .= '"' . strtoupper($key) . '"';
      serializeDocument($value);
    } else {
      $flattenData .= '"' . strtoupper($key) . '"';
      $flattenData .= '"' . $value . '"';
    }
  }
  return $flattenData;
}

$serializedString = serializeDocument($test);

echo "<pre style='word-wrap: break-word; white-space: pre-wrap;'>";
echo $serializedString;
echo "</pre>";
