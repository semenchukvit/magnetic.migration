<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopify extends Model
{
    protected $shopName;

    protected $shopKey;

    protected $shopPass;

    protected $errorsGuide = [
        '201' => 'The request has been fulfilled and a new resource has been created.',
        '202' => 'The request has been accepted, but not yet processed.',
        '303' => 'The response to the request can be found under a different URI in the Location header and can be retrieved using a GET method on that resource.',
        '400' => 'The request was not understood by the server, generally due to bad syntax or because the Content-Type header was not correctly set to application/json.',
        '401' => 'The necessary authentication credentials are not present in the request or are incorrect.',
        '402' => 'The requested shop is currently frozen.',
        '403' => 'The server is refusing to respond to the request. This is generally because you have not requested the appropriate scope for this action.',
        '404' => 'The requested resource was not found but could be available again in the future.',
        '406' => 'The requested resource is only capable of generating content not acceptable according to the Accept headers sent in the request.',
        '422' => 'The request body was well-formed but contains semantical errors. The response body will provide more details in the errors parameter.',
        '429' => 'The request was not accepted because the application has exceeded the rate limit. See the API Call Limit documentation for a breakdown of Shopify\'s rate-limiting mechanism.',
        '500' => 'An internal error occurred in Shopify. Please post to the API & Technology forum so that Shopify staff can investigate.',
        '501' => 'The requested endpoint is not available on that particular shop, e.g. requesting access to a Plus-specific API on a non-Plus shop. This response may also indicate that this endpoint is reserved for future use.',
        '503' => 'The server is currently unavailable. Check the status page for reported service outages.',
        '504' => 'The request could not complete in time. Try breaking it down in multiple smaller requests.',
    ];

    protected $currentUrl;

    protected $currentErrorMessage;


    public function getData(){
        return json_decode(file_get_contents($this->currentUrl));
    }

    public function setCredentials($name, $key, $pass)
    {
        $this->shopName = $name;
        $this->shopKey = $key;
        $this->shopPass = $pass;
    }

    protected function getHttpCode($url)
    {
        $headers = get_headers($url);
        $headers  = explode(' ',$headers [0]);

        return $headers [1];
    }

    protected function validateHttpCode($code)
    {
        if ($code !== '200') {
            return $this->errorsGuide[$code];
        }

        return false;
    }

    public function validateUrlFails()
    {
        $responseHasErrors = $this->validateHttpCode($this->getHttpCode($this->currentUrl));

        if ($responseHasErrors) {
            $this->currentErrorMessage = $responseHasErrors;

            return true;
        }

        return false;
    }

    public function setURL($table)
    {
        $this->currentUrl = 'https://'.$this->shopKey.':'.$this->shopPass.'@'.$this->shopName.'.myshopify.com/admin/'.$table.'.json';
    }

    public function getCurrentErrorMessage()
    {
        return $this->currentErrorMessage;
    }
}
