<?php
namespace FahiPay;
class Gateway {
    private $shopId;
    private $secretKey;
    private $returnUrl;
    private $returnErrorUrl;
    private $cancelUrl;
    
    public function __construct($merchantId, $secretKey, $returnUrl, $returnErrorUrl, $cancelUrl)
    {
        $this->merchantId = $merchantId;
        $this->secretKey = $secretKey;
        $this->returnUrl = $returnUrl;
        $this->returnErrorUrl = $returnErrorUrl;
        $this->cancelUrl = $cancelUrl;
    }
    
    private function generateSignature($shoppingCartId, $totalAmount)
    {
        $dataToHash = $this->merchantId . $this->secretKey . $shoppingCartId . $this->secretKey . $totalAmount . $this->secretKey;
        return base64_encode(sha1($dataToHash, true));
    }

    public function validateSignature($signature,$transactionId,$success,$approvalCode)
    { 
        $sig = base64_encode(sha1($this->merchantId.$this->secretKey.$transactionId.$this->secretKey.$success.$this->secretKey.$approvalCode.$this->secretKey, true));
        return ($sig==$signature);
    }
    
    public function createTransaction($transactionId, $totalAmount)
    {
        $totalAmount         = round($totalAmount * 100,0);
        $signature           = $this->generateSignature($transactionId, $totalAmount);
        $postData = [
            'ShopID'         => $this->merchantId,
            'ShoppingCartID' => $transactionId,
            'TotalAmount'    => $totalAmount,
            'Signature'      => $signature,
            'ReturnURL'      => $this->returnUrl,
            'ReturnErrorURL' => $this->returnErrorUrl,
            'CancelURL'      => $this->cancelUrl
        ];
        
        $response = $this->sendApiRequest('https://fahipay.mv/api/merchants/createTxn/', $postData);
        return json_decode($response, true);
    }
    
    public function getTransaction($transactionId)
    {
        $url = 'https://fahipay.mv/api/merchants/getTxn/?mref='.$transactionId;
        
        $headers = [
            'X-Api-Key: '.$this->secretKey,
            'Accept: application/json',
            'Content-Type: application/json'
        ];
        
        $response = $this->sendApiRequest($url, [], $headers);
        
        return json_decode($response, true);
    }
    
    private function sendApiRequest($url, $data, $headers = [])
    {
        $ch = curl_init($url);
        
        if (!empty($headers)) 
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if (!empty($data)) 
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
}
