<?php 

date_default_timezone_set('Asia/Shanghai');


$domainArray = array("test.in");
$username='wubiao239-ote';
$api_token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhcGl0Ijo1NjE4NjgsImV4cCI6MTc4NTg1NzUzNiwianRpIjoxfQ.bMwNLDloRoOuhYPGvpGwl3dIYPkokIzU_FZrMgEmIL8';
// $username='wubiao239';
// $api_token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhcGl0IjoxMjg2ODYyLCJleHAiOjE3ODU4NTc1NDQsImp0aSI6MX0.0LxzVX1mUa9Tg6i296mk80RtO047jaL6mgRyV9316bY';
$nameservers = array('ns1.name.com', 'ns2.name.com', 'ns3.name.com', 'ns4.name.com');
$contacts = array(array('type' => array('registrant', 'administrative', 'technical', 'billing'),
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'organization' => 'Name.com',
            'address_1' => '100 Main St.',
                        'address_2' => 'Suite 300',
                        'city' => 'Denver',
            'state' => 'CO',
                        'zip' => '80230',
                        'country' => 'US',
                        'phone' => '+1.3035555555',
            'fax' => '+1.3035555556',
                        'email' => 'john@example.net',
                        ));

while (true) {
    //起始时间
    $bTime =strtotime(date("Y-m-d ",time())."03:56:00");
    //终止时间
    $eTime = strtotime(date("Y-m-d ",time())."21:05:00");
  
    
    if (time() >= $bTime && time() <= $eTime) {
        
        require_once("namecom_api.php");

        $api = new NameComApi();
        $api->login($username,$api_token);
        $response = $api->hello();
        //print_r($response);
        $i=1;
        while(true){
            if($i>200) break;
            if(count($domainArray)==0) break;
            if(time() >= $eTime) break;
            foreach ($domainArray as $key=> $value) {
                // $index=stripos($value, ".");
                // $main=substr($value, 0,$index);
                // $tld=substr($value,$index);
                //$response = $api->check_domain($main, array($tld), array('availability','suggested'));
                $response = $api->create_domain($value, 1, $nameservers, $contacts);
                //print_r($response);
                if($response->result->code==100){
                    echo $value." register success ".PHP_EOL;
                    unset($domainArray[$key]);
                    continue;

                }
                echo date("Y-m-d H:i:s",time()).$value." register ".$i." times fail".PHP_EOL;
                
            }

            //sleep(1.3);
            $i++; 

        }
        
     
        
    } else {
        echo "Now time: " . date("Y-m-d H:i:s",time()).PHP_EOL;
        sleep(60);
    }
}



?>