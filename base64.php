<?php
class Base64 {
  
  private static $base = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

  public static function encode($plain) {
    $len = strlen($plain);
    $pad_len = (3 - ($len % 3)) % 3;
  
    $padded = str_pad($plain, $len + $pad_len, chr(0));
  
    $encoded = '';
  
    for ($i = 0; $i < $len; $i += 3) {
      $int = (ord($padded[$i]) << 16) + (ord($padded[$i+1]) << 8) + ord($padded[$i+2]);
      
      $bi[0] = ($int >> 18) & 0x3F;
      $bi[1] = ($int >> 12) & 0x3F;
      $bi[2] = ($int >> 6) & 0x3F;
      $bi[3] = $int & 0x3F;

      $encoded .= static::$base[$bi[0]].static::$base[$bi[1]].static::$base[$bi[2]].static::$base[$bi[3]];
    }
  
    return str_pad(substr($encoded, 0, strlen($encoded) - $pad_len), strlen($encoded), '=');
  }
  
  public static function decode($encode) {
    $len = strlen($encode);
    $pad_len = substr_count($encode, '=');
    $zeropad = str_pad($encode, $len + $pad_len, 'A');
  
    $decoded = '';
  
    for ($i = 0; $i < $len; $i += 4) {
      $n = (strpos(static::$base, $encode[$i]) << 18) + (strpos(static::$base, $encode[$i+1]) << 12) + (strpos(static::$base, $encode[$i+2]) << 6) + strpos(static::$base, $encode[$i+3]);

      $ni[0] = chr(($n >> 16) & 0xFF);
      $ni[1] = chr(($n >> 8) & 0xFF);
      $ni[2] = chr($n & 0xFF);

      $decoded .= $ni[0].$ni[1].$ni[2];
    }
  
    return substr($decoded, 0, strlen($decoded) - $pad_len);
  }
  
  public static function isValid($encode, $isfile = false) {
    if ($isfile)
      return preg_match('/[a-zA-Z0-9\/+]+={0,2}\|[a-zA-Z0-9\/+]+={0,2}/', $encode);
    return preg_match('/[a-zA-Z0-9\/+]+={0,2}/', $encode);
  }
}
