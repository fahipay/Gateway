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

$apiClient = new \FahiPay\Gateway($merchantId, $secretKey, $returnUrl, $returnErrorUrl, $cancelUrl);
$response = $apiClient->createTransaction('unique_transaction_id', 19); // Amount in MVR
print_r($response);
```
### Querying a Specific Transaction
To query a specific transaction, provide the transaction ID to the `getTransaction` method. Here's an example:

```php
$transactionIdToQuery = 'ABCD1234'; // Replace with the actual transaction ID

$queryResponse = $apiClient->getTransaction($transactionIdToQuery);

print_r($queryResponse);
```