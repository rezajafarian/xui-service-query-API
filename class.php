<?php

class subscription_inquiry_xui{
    
    private $ip;
    private $port;
    private $ssl;
    private $session;
    private $headers;
    
    public function __construct($ip, $port, $ssl = 'http', $session) {
        
        $this->ip = $ip;
        $this->ssl = $ssl . '://';
        $this->port = $port;
        $this->session = $session;
        $this->headers = [
            "Accept-Encoding: gzip, deflate",
            "Accept-Language: en-US,en;q=0.5",
            "Connection: keep-alive",
            "Content-Length: 0",
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            "Cookie: session=" . $this->session,
            "Host: " . $this->ip . ':' . $this->port,
            "Origin: " . $this->ssl . $this->ip . ':' . $this->port,
            "Referer: " . $this->ssl .  $this->ip . ':' . $this->port . '/xui/inbounds',
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/109.0",
            "X-Requested-With: XMLHttpRequest",
        ];
        
    }
    
    private function request($url, $method = false, array $headers = null, $data = null) {
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_POST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true
        ]);
        
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $result;
        
    }
    
    public function service_status($value, $type){
        
        $url = $this->ssl . $this->ip . ':' . $this->port . '/xui/inbound/list';
        $result = self::request($url, true, $this->headers)['obj'];
        
        for($i=0;$i<=count($result) - 1;$i++){
            
            if($value == $result[$i][$type]){
                return $result[$i];
            }else{
                for($j=0;$j<=count($result[$i]['clientStats']) - 1;$j++){
                    if($$value == $result[$i]['clientStats'][$j]['email']){
                        return $result[$i]['clientStats'][$j];
                    }
                }
            }

        }

    }
    
}
