<?php
$url = 'http://localhost/curl-php/curl-function.php';
$fields = array(
	'email' => 'test@localhost.com',
	'code' => '12345',
	'licence' => '12345',
	'domain' => 'localhost',
	'product_type' => 'test'
);
//prepare the parameters as string
$fields_string = '';
foreach ($fields as $key => $value) {
	$fields_string .= $key . '=' . $value . '&';
}
rtrim($fields_string, '&');
$ch = curl_init();
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//execute post
$response = curl_exec($ch);
//close connection
curl_close($ch);

$response = json_decode($response);
// print_r($response);

// after getting the response
// your todo
if ($response->status=='success'){
	echo "You can do your code here after success. STATUS IS {$response->status}";
} else {
	echo "You can do your code here once failed. STATUS IS {$response->status}";
}


?>