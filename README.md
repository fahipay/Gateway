# FahiPay Gateway Client

The FahiPay Payment Gateway Client is a PHP library that provides an interface to interact with the FahiPay payment gateway API. It allows you to easily create transactions and query specific transactions using the API provided by FahiPay.

## Features

- Create transactions with ease using the API provided by FahiPay.
- Query specific transactions by transaction ID.
- Automatically calculates and generates the required digital signature.

## Installation

You can install the FahiPay Gateway Client using Composer:

```sh
composer require fahipay/gateway
```
## Usage

### Creating a Transaction

To create a transaction, initialize the FPG client with your FahiPay credentials and URLs, and then call the `createTransaction` method. Here's an example:

```php
$merchantId     = 'your_merchant_id';
$secretKey      = 'your_secret_key';
$returnUrl      = 'https://example.com/success';
$returnErrorUrl = 'https://example.com/error';
$cancelUrl      = 'https://example.com/cancel';

$apiClient      = new FahiPay\Gateway($merchantId, $secretKey, $returnUrl, $returnErrorUrl, $cancelUrl);
$response       = $apiClient->createTransaction('TXN001', 10.03); // Unique transaction id, Amount in MVR (2dp)
print_r($response);
/*
{
  "type": "success",
  "link": "https://fahipay.mv/pay/L2XXXXXXXXXXXXXXXXXX"
}
*/

```
### Querying a Specific Transaction
To query a specific transaction, provide the transaction ID to the `getTransaction` method. Here's an example:

```php
$transactionId = 'TXN001'; // Replace with the actual transaction ID
$queryResponse = $apiClient->getTransaction($transactionId);

print_r($queryResponse);
/*
{
  "type": "success",
  "data": {
    "time": "2023-08-15 21:29:05",
    "method": "gateway",
    "mref": "TXN006",
    "amount": "10.04",
    "fee": "0.00",
    "link": "https://fahipay.mv/pay/L2XXXXXXXXXXXXXXXXXX",
    "extras": null,
    "status": null,
    "ApprovalCode": null
  }
}
*/
```
