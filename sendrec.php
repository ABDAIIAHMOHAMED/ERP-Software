<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new Client();
$base_url = 'https://api.preprod.invoicing.eta.gov.eg';
$headers = [
  'Content-Type' => 'application/json',
  'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6Ijk2RjNBNjU2OEFEQzY0MzZDNjVBNDg1MUQ5REM0NTlFQTlCM0I1NTQiLCJ0eXAiOiJhdCtqd3QiLCJ4NXQiOiJsdk9tVm9yY1pEYkdXa2hSMmR4Rm5xbXp0VlEifQ.eyJuYmYiOjE2OTkzODE4OTUsImV4cCI6MTY5OTM4NTQ5NSwiaXNzIjoiaHR0cHM6Ly9pZC5wcmVwcm9kLmV0YS5nb3YuZWciLCJhdWQiOiJJbnZvaWNpbmdBUEkiLCJjbGllbnRfaWQiOiJiYjY4MzU1ZS1lZjIyLTQ4ZjUtYjljYi1iZTk3ZGM2MmFlZDciLCJJc1RheFJlcHJlcyI6IjEiLCJJc0ludGVybWVkaWFyeSI6IjAiLCJJbnRlcm1lZElkIjoiMCIsIkludGVybWVkUklOIjoiIiwiSW50ZXJtZWRFbmZvcmNlZCI6IjIiLCJuYW1lIjoiNjY4MDQzMDI0OmJiNjgzNTVlLWVmMjItNDhmNS1iOWNiLWJlOTdkYzYyYWVkNyIsIlNTSWQiOiJiZWIyYmE1ZS1iY2IyLThlNTYtMDA4MS0yY2QwYTEyZjNmOTMiLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJ3b25kZXIiLCJUYXhJZCI6IjQyMTk4NiIsIlRheFJpbiI6IjY2ODA0MzAyNCIsIlByb2ZJZCI6IjM2NjY2NSIsIklzVGF4QWRtaW4iOiIwIiwiSXNTeXN0ZW0iOiIxIiwiTmF0SWQiOiIiLCJUYXhQcm9mVGFncyI6WyJCMkMiLCJCMkIiXSwic2NvcGUiOlsiSW52b2ljaW5nQVBJIl19.TsDxhUpTFFeh56Vtz2zEH-O0FCvvQ-_8lcwYFzDbUG05i9G3FQ9J6Ss8dMaS9f0gYLRrkqkh5k4lp1LIIpel0wJIBB2gAOQyNkiWn6d7JWt9j9Tb4jvw5-DLHREnr2s3pq41_2YUU1__dwnwHNnCYvPpAbHKeS_B1lITe6RTSov8DeoVNd7NaCctpzXdkFWhYli5vUDt2fbjrRtYODXNhb3yq33N1rJW1jj-Ib5CbvvyWXmJq4prT8Yx9vqJPnUU1p5QCc6XxfqXHB5rpmu-kLHmUG0Lj_xJyWuT2DvpwK1nY5D2I3sJwgSM8LiPxyob2NNxuoYHtuOpFE8cyteXbg'
];



$jsonData = '{
  "header": {
    "dateTimeIssued": "2023-11-04T00:34:00Z",
    "receiptNumber": "ZHFGG253",
    "previousUUID": "",
    "currency": "EGP",
    "orderdeliveryMode": "FC"
  },
  "documentType": {
    "receiptType": "s",
    "typeVersion": "1.0"
  },
  "issuer": {
    "rin": "668043024",
    "companyTradeName": "بلاك بيرل للخدمات الغذائيه",
    "branchCode": "0",
    "branchAddress": {
      "country": "EG",
      "governate": "Cairo Governorate",
      "regionCity": "التجمع الخامس",
      "street": "مول ون جولدن سكوير  ش التسعين",
      "buildingNumber": "0"
    },
    "deviceSerialNumber": "الدلتا للأنظمة الالكترونية | F20",
    "activityCode": "5610"
  },
  "buyer": {
    "type": "P"
  },
  "itemData": [
    {
      "internalCode": "EG-668043024-Packaging/Storage Services",
      "description": "",
      "itemType": "EGS",
      "itemCode": "Packaging",
      "unitType": "EA",
      "quantity": 35,
      "unitPrice": 247.96,
      "netSale": 7810.74,
      "totalSale": 8678.6,
      "total": 8887.0436,
      "taxableItems": [
        {
          "taxType": "T1",
          "amount": 1096.3036,
          "subType": "V009",
          "rate": 14
        }
      ]
    }
  ],
  "totalSales": 8678.6,
  "totalCommercialDiscount": 867.86,
  "totalItemsDiscount": 0,
  "netAmount": 7810.74,
  "feesAmount": 10,
  "totalAmount": 8887.0436,
  "taxTotals": [
    {
      "taxType": "T1",
      "amount": 1096.3036
    }
  ],
  "paymentMethod": "C"
}';
$data = json_decode($jsonData);

if (is_array($data) || is_object($data)) {
  // Function to convert the array into the desired format
  function convertToFlatArray($data, $parentKey = "")
  {
    $result = "";
    foreach ($data as $key => $value) {
      $newKey = $parentKey . '"' . $key . '"';
      if (is_array($value) || is_object($value)) {
        $result .= convertToFlatArray((array)$value, $newKey);
      } else {
        $result .= $newKey . '"' . $value . '"';
      }
    }
    return $result;
  }

  // Call the function with the JSON data
  $flatData = convertToFlatArray((array)$data);

  $normalizedText = utf8_encode($flatData);

  // Create a SHA-256 hash
  $hashValue = hash('sha256', $normalizedText);
  echo $hashValue;
} else {
  // Handle the case where JSON decoding failed
  echo "JSON decoding failed. <br>";
}











$body = '{
  "receipts": 
    [{
      "header": {
        "dateTimeIssued": "2023-11-04T00:34:00Z",
        "receiptNumber": "ZHFGG253",
        "uuid": "' . $hashValue . '", 
        "previousUUID": "",
        "currency": "EGP",
        "orderdeliveryMode": "FC"
      },
      "documentType": {
        "receiptType": "s",
        "typeVersion": "1.0"
      }
      ,"issuer": {
        "rin": "668043024",
        "companyTradeName": "بلاك بيرل للخدمات الغذائيه",
        "branchCode": "0",
        "branchAddress": {
          "country": "EG",
          "governate": "cairo",
          "regionCity": "التجمع الخامس",
          "street": "مول ون جولدن سكوير  ش التسعين",
          "buildingNumber": "0"
        },
        "deviceSerialNumber": "الدلتا للأنظمة الالكترونية | F20",
        "activityCode": "5610"
      },
      "buyer": {
        "type": "P"
      },
      "itemData": [
        {
          "internalCode": "EG-668043024-Packaging/Storage Services",
          "description": "",
          "itemType": "EGS",
          "itemCode": "Packaging",
          "unitType": "EA",
          "quantity": 35,
          "unitPrice": 247.96,
          "netSale": 7810.74,
          "totalSale": 8678.6,
          "total": 8887.0436,
          "taxableItems": [
            {
              "taxType": "T1",
              "amount": 1096.3036,
              "subType": "V009",
              "rate": 14
            }
          ]
        }
      ],
      "totalSales": 8678.6,
      "totalCommercialDiscount": 867.86,
      "totalItemsDiscount": 0,
      "netAmount": 7810.74,
      "feesAmount": 10,
      "totalAmount": 8887.0436,
      "taxTotals": [
        {
          "taxType": "T1",
          "amount": 1096.3036
        }
      ],
      "paymentMethod": "C"
  } 
  ]
}';
$request = new Request('POST', $base_url . '/api/v1/receiptsubmissions', $headers, $body);
try {
  $res = $client->sendAsync($request)->wait();
  echo "Status Code: " . $res->getStatusCode() . PHP_EOL;
  echo "Response Body: " . $res->getBody();
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
