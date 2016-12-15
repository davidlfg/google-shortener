<?php

/**
 * @file
 * Contains \Drupal\google_shortener\Plugin\ShortenerURL\GoogleUrlApi
 */

namespace Drupal\google_shortener\Plugin\ShortenerURL;

/**
 * Google Shortener URL API.
 */
class GoogleUrlApi {
  protected $apiURL;

  function __construct($key,$apiURL = 'https://www.googleapis.com/urlshortener/v1/url') {
    // Keep the API Url
    $this->apiURL = $apiURL.'?key='.$key;
  }

  /**
   * {@inheritdoc}
   */
  public function shorten($url) {
    // Shorten a URL
    $response = $this->send($url);
    return isset($response['id']) ? $response['id'] : false;
  }

  /**
   * {@inheritdoc}
   */
  public function expand($url) {
    // Expand a URL
    $response = $this->send($url,false);
    return isset($response['longUrl']) ? $response['longUrl'] : false;
  }

  /**
   * {@inheritdoc}
   */
  public function send($url,$shorten = true) {
    // Send information to Google
    // Create cURL
    $ch = curl_init();
    // If we're shortening a URL...
    if($shorten) {
      curl_setopt($ch,CURLOPT_URL,$this->apiURL);
      curl_setopt($ch,CURLOPT_POST,1);
      curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode(array("longUrl"=>$url)));
      curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json"));
    }
    else {
      curl_setopt($ch,CURLOPT_URL,$this->apiURL.'&shortUrl='.$url);
    }
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    // Execute the post
    $result = curl_exec($ch);
    // Close the connection
    curl_close($ch);
    return json_decode($result,true);
  }
}
