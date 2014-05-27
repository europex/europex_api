<?php
/*
 * @author Europex < https://www.europex.eu/ >
 * This little source code will help tu use the Europex's API
 */
class europex {
  private static $url = "https://api.europex.eu/v1/";
  private $publicKey = "";
  private $privateKey = "";

  function __construct($publicKey,$privateKey) {
    $this->publicKey = $publicKey;
    $this->privateKey = $privateKey;
  }

  /*
    @param string $method
  */
  function get($method) {
    return $this->q($method);
  }

  /*
    @param string $method (Example : "order/22817")
    @param array $post (Example : array("nature"=>"sell","quantity"=>"0.03","price"=>"0.5"))
  */
  function post($method,array $post) {
    return $this->q($method,"POST",$post);
  }

  /*
    @param string $method
  */
  function delete($method) {
    return $this->q($method,"DELETE");
  }

  function q($method,$type=NULL,$post=NULL) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    if ($type=="DELETE") {
      curl_setopt($c, CURLOPT_CUSTOMREQUEST, $type);
    }
    if (is_array($post)) {
      curl_setopt($c, CURLOPT_POST, 1);
      curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($post));
    }

    $get["t"] = time();
    $get["k"] = $this->publicKey;
    $requestURL = self::$url.$method.'/?'.http_build_query($get);
    $hash = hash_hmac("sha256", $requestURL, $this->privateKey);
    curl_setopt($c, CURLOPT_URL, $requestURL."&h=".$hash);
    $result = curl_exec($c);
    curl_close($c);
    return $result;
  }
}

