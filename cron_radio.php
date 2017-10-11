<?php

$curl = curl_init();

$opts = [
    CURLOPT_URL            => 'http://localhost/R-zik/web/auth-tokens',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_CONNECTTIMEOUT => 30,
    CURLOPT_POSTFIELDS     => ['login' => 'admin_radio','password' => 'humhum94']
];

curl_setopt_array($curl, $opts);
$response = curl_exec($curl);
$token = json_decode($response)->value;
//echo $token;
curl_close($curl);

$curl2 = curl_init();
$headers = [
    'X-Auth-Token: '.$token,
    'Content-Type: 143444,12',
    'Accept: application/json'
];
$opts = [
    CURLOPT_URL            => 'http://localhost/R-zik/web/users',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_CONNECTTIMEOUT => 30
];
curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
curl_setopt_array($curl2, $opts);
$response = curl_exec($curl2);
//var_dump(json_decode($response)[0]);
$nb_user=count(json_decode($response));
curl_close($curl2);
$file = "/etc/icecast2/icecast.xml";
$content = "";
$content .= "<icecast>\n";
$content .= "    <location>Paris, France</location>\n";
$content .= "    <admin>temmpus@localhost</admin>\n";
$content .= "    <limits>\n";
$content .= "        <clients>100</clients>\n";
$content .= "        <sources>2</sources>\n";
$content .= "        <queue-size>524288</queue-size>\n";
$content .= "        <client-timeout>30</client-timeout>\n";
$content .= "        <header-timeout>15</header-timeout>\n";
$content .= "        <source-timeout>10</source-timeout>\n";
$content .= "        <burst-on-connect>1</burst-on-connect>\n";
$content .= "        <burst-size>65535</burst-size>\n";
$content .= "    </limits>\n";
$content .= "    <authentication>\n";
$content .= "        <source-password>password_hack</source-password>\n";
$content .= "        <relay-password>password_hack</relay-password>\n";
$content .= "        <admin-user>admin</admin-user>\n";
$content .= "        <admin-password>password_hack</admin-password>\n";
$content .= "    </authentication>\n";
$content .= "    <hostname>127.0.0.1</hostname>\n";
$content .= "    <listen-socket>\n";
$content .= "        <port>8000</port>\n";
$content .= "    </listen-socket>\n";
$content .= "    <http-headers>\n";
$content .= "        <header name=\"Access-Control-Allow-Origin\" value=\"*\" />\n";
$content .= "    </http-headers>\n";
$content .= "    <paths>\n";
$content .= "        <basedir>/usr/share/icecast2</basedir>\n";
$content .= "        <logdir>/var/log/icecast2</logdir>\n";
$content .= "        <webroot>/usr/share/icecast2/web</webroot>\n";
$content .= "        <adminroot>/usr/share/icecast2/admin</adminroot>\n";
$content .= "        <alias source=\"/\" destination=\"/status.xsl\"/>\n";
$content .= "    </paths>\n";
$content .= "    <logging>\n";
$content .= "        <accesslog>access.log</accesslog>\n";
$content .= "        <errorlog>error.log</errorlog>\n";
$content .= "        <loglevel>3</loglevel>\n";
$content .= "        <logsize>10000</logsize>\n";
$content .= "    </logging>\n";
$content .= "    <security>\n";
$content .= "        <chroot>0</chroot>\n";
$content .= "    </security>\n";
for($i=0;$i<$nb_user;$i++){
    if((json_decode($response)[$i]->password_live)!= ""){
        $content .= "<mount>\n";
        $content .= "    <mount-name>/user-".json_decode($response)[$i]->id."</mount-name>\n";
        $content .= "    <username>".json_decode($response)[$i]->firstname."</username>\n";
        $content .= "    <password>".json_decode($response)[$i]->password_live."</password>\n";
        $content .= "</mount>\n";
    }
}
$content .= "</icecast>";
file_put_contents($file,$content);

