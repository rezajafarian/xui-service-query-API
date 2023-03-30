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
        
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_POST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true
        ]);
        
        if (!is_null($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $result;
        
    }
    
    public function service_status($input, $type) {
        
        $url = "{$this->ssl}{$this->ip}:{$this->port}/xui/inbound/list";
        $object = self::request($url, true, $this->headers)['obj'];

        foreach($object as $item) {
            
            if (isset($item[$type]) && $input == $item[$type]) {
                return $item;
            } else {
                foreach ($item['clientStats'] as $stat) {
                    if (isset($stat['email']) && $input === $stat['email']) {
                        return $stat;
                    }
                }
            }
        }
    }
    
}
