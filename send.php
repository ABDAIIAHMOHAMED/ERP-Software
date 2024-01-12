<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new Client();
$base_url = 'https://api.preprod.invoicing.eta.gov.eg';
$headers = [
  'Content-Type' => 'application/json',
  'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6Ijk2RjNBNjU2OEFEQzY0MzZDNjVBNDg1MUQ5REM0NTlFQTlCM0I1NTQiLCJ0eXAiOiJhdCtqd3QiLCJ4NXQiOiJsdk9tVm9yY1pEYkdXa2hSMmR4Rm5xbXp0VlEifQ.eyJuYmYiOjE2OTgxNjc5NjQsImV4cCI6MTY5ODE3MTU2NCwiaXNzIjoiaHR0cHM6Ly9pZC5wcmVwcm9kLmV0YS5nb3YuZWciLCJhdWQiOiJJbnZvaWNpbmdBUEkiLCJjbGllbnRfaWQiOiJiYjY4MzU1ZS1lZjIyLTQ4ZjUtYjljYi1iZTk3ZGM2MmFlZDciLCJJc1RheFJlcHJlcyI6IjEiLCJJc0ludGVybWVkaWFyeSI6IjAiLCJJbnRlcm1lZElkIjoiMCIsIkludGVybWVkUklOIjoiIiwiSW50ZXJtZWRFbmZvcmNlZCI6IjIiLCJuYW1lIjoiNjY4MDQzMDI0OmJiNjgzNTVlLWVmMjItNDhmNS1iOWNiLWJlOTdkYzYyYWVkNyIsIlNTSWQiOiIwMmNiNjlmNy02ZDFmLTk0ZGYtNjBiYi0zNWRlOWExY2U3YmQiLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJ3b25kZXIiLCJUYXhJZCI6IjQyMTk4NiIsIlRheFJpbiI6IjY2ODA0MzAyNCIsIlByb2ZJZCI6IjM2NjY2NSIsIklzVGF4QWRtaW4iOiIwIiwiSXNTeXN0ZW0iOiIxIiwiTmF0SWQiOiIiLCJUYXhQcm9mVGFncyI6WyJCMkMiLCJCMkIiXSwic2NvcGUiOlsiSW52b2ljaW5nQVBJIl19.I6UhQhmKNPjM5Q_3X58LN3gvP78N2-rqVO2ECHzDRouKJcmY_z8RnuwTlzgExTYlZKuvfzxBPSF9i1WBPUh-cRu3HM5jtcd1kNOQhGu4BKp6bqA0FIyCJhA7EKdkN0sAGqhLj4WkqjLpAS__3XevBu17A9gnfPyeHsUYWhEEHsQlG38YTfOL3CBZHNsUJqoalx7Rj-BRwfjSgdIM7LSHonYP2jgZmxfKHZXp0-Zs4Lyc3lUwOzQbvlj25uBexkt22KcgfXDa_UVSFsucpbFGQQ5vXEeou0DtoALeYRUXBhDTovyWsBcAXA_5kRg18yADaNomcUfyVXm1gi7AtYFizg'
];
$body = '{
  "documents": [
    {
      "issuer": {
        "address": {
          "branchID": "0",
          "country": "EG",
          "governate": "Cairo",
          "regionCity": "Nasr City",
          "street": "580 Clementina Key",
          "buildingNumber": "Bldg. 0",
          "postalCode": "68030",
          "floor": "1",
          "room": "123",
          "landmark": "7660 Melody Trail",
          "additionalInformation": "beside Townhall"
        },
        "type": "B",
        "id": "668043024",
        "name": "Issuer Company"
      },
      "receiver": {
        "address": {
          "country": "EG",
          "governate": "Egypt",
          "regionCity": "Mufazat al Ismlyah",
          "street": "580 Clementina Key",
          "buildingNumber": "Bldg. 0",
          "postalCode": "68030",
          "floor": "1",
          "room": "123",
          "landmark": "7660 Melody Trail",
          "additionalInformation": "beside Townhall"
        },
        "type": "B",
        "id": "313717919",
        "name": "Receiver"
      },
      "documentType": "I",
      "documentTypeVersion": "0.9",
      "dateTimeIssued": "2023-09-26T01:31:13Z",
      "taxpayerActivityCode": "4620",
      "internalID": "314",
      "purchaseOrderReference": "P-233-A6375",
      "purchaseOrderDescription": "purchase Order description",
      "salesOrderReference": "1231",
      "salesOrderDescription": "Sales Order description",
      "proformaInvoiceNumber": "SomeValue",
      "payment": {
        "bankName": "SomeValue",
        "bankAddress": "SomeValue",
        "bankAccountNo": "SomeValue",
        "bankAccountIBAN": "",
        "swiftCode": "",
        "terms": "SomeValue"
      },
      "invoiceLines": [
        {
          "description": "Computer1",
          "itemType": "EGS",
          "itemCode": "EG-113317713-123456",
          "unitType": "EA",
          "quantity": 1,
          "internalCode": "IC0",
          "salesTotal": 111111111111,
          "total": 111111111111,
          "valueDifference": 0,
          "totalTaxableFees": 0,
          "netTotal": 111111111111,
          "itemsDiscount": 0,
          "unitValue": {
            "currencySold": "EGP",
            "amountEGP": 111111111111
          },
          "discount": {
            "rate": 0,
            "amount": 0
          },
          "taxableItems": [
            {
              "taxType": "T1",
              "amount": 0,
              "subType": "V001",
              "rate": 0
            }
          ]
        },
        {
          "description": "Computer1",
          "itemType": "EGS",
          "itemCode": "EG-113317713-123456",
          "unitType": "EA",
          "quantity": 1,
          "internalCode": "IC0",
          "salesTotal": 111111111111,
          "total": 111111111111,
          "valueDifference": 0,
          "totalTaxableFees": 0,
          "netTotal": 111111111111,
          "itemsDiscount": 0,
          "unitValue": {
            "currencySold": "EGP",
            "amountEGP": 111111111111
          },
          "discount": {
            "rate": 0,
            "amount": 0
          },
          "taxableItems": [
            {
              "taxType": "T1",
              "amount": 0,
              "subType": "V001",
              "rate": 0
            }
          ]
        },
        {
          "description": "Computer1",
          "itemType": "EGS",
          "itemCode": "EG-113317713-123456",
          "unitType": "EA",
          "quantity": 1,
          "internalCode": "IC0",
          "salesTotal": 111111111111,
          "total": 111111111111,
          "valueDifference": 0,
          "totalTaxableFees": 0,
          "netTotal": 111111111111,
          "itemsDiscount": 0,
          "unitValue": {
            "currencySold": "EGP",
            "amountEGP": 111111111111
          },
          "discount": {
            "rate": 0,
            "amount": 0
          },
          "taxableItems": [
            {
              "taxType": "T1",
              "amount": 0,
              "subType": "V001",
              "rate": 0
            }
          ]
        },
        {
          "description": "Computer1",
          "itemType": "EGS",
          "itemCode": "EG-113317713-123456",
          "unitType": "EA",
          "quantity": 1,
          "internalCode": "IC0",
          "salesTotal": 111111111111,
          "total": 111111111111,
          "valueDifference": 0,
          "totalTaxableFees": 0,
          "netTotal": 111111111111,
          "itemsDiscount": 0,
          "unitValue": {
            "currencySold": "EGP",
            "amountEGP": 111111111111
          },
          "discount": {
            "rate": 0,
            "amount": 0
          },
          "taxableItems": [
            {
              "taxType": "T1",
              "amount": 0,
              "subType": "V001",
              "rate": 0
            }
          ]
        },
        {
          "description": "Computer1",
          "itemType": "EGS",
          "itemCode": "EG-113317713-123456",
          "unitType": "EA",
          "quantity": 1,
          "internalCode": "IC0",
          "salesTotal": 111111111111,
          "total": 111111111111,
          "valueDifference": 0,
          "totalTaxableFees": 0,
          "netTotal": 111111111111,
          "itemsDiscount": 0,
          "unitValue": {
            "currencySold": "EGP",
            "amountEGP": 111111111111
          },
          "discount": {
            "rate": 0,
            "amount": 0
          },
          "taxableItems": [
            {
              "taxType": "T1",
              "amount": 0,
              "subType": "V001",
              "rate": 0
            }
          ]
        }
      ],
      "totalDiscountAmount": 0,
      "totalSalesAmount": 555555555555,
      "netAmount": 555555555555,
      "taxTotals": [
        {
          "taxType": "T1",
          "amount": 0
        }
      ],
      "totalAmount": 555555555555,
      "extraDiscountAmount": 0,
      "totalItemsDiscountAmount": 0,
      "signatures": [
        {
          "signatureType": "I",
          "value": "<Signature Value>"
        }
      ]
    }
  ]
}';
$request = new Request('POST', $base_url . '/api/v1/documentsubmissions', $headers, $body);
$res = $client->sendAsync($request)->wait();
echo $res->getBody();
