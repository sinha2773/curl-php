<?php
$email = isset($_POST['email']) ? $_POST['email'] : '';
$code = isset($_POST['code']) ? $_POST['code'] : '';
$domain = isset($_POST['domain']) ? $_POST['domain'] : '';
$licence = isset($_POST['licence']) ? $_POST['licence'] :  '';
$product_type = isset($_POST['product_type']) ? $_POST['product_type'] : '';

if($email != '' && $code!= '' && $domain!= '' && $licence != '' && $product_type != '' ){
	
	$data=array(		
		'email'=>$email,
		'code' =>$code,
		'domain'=>$domain,
		'licence'=>$licence,
		'product_type' => $product_type
	); 

	$verified=check_licence($data);

	if($verified){
		$jsondata = array(
			"status" => "success",
			'message' => "Your Key Verified Successfully!!",
			'code' => '200',
		);
		echo json_encode($jsondata);exit;
	}else{
		$jsondata = array(
			"status" => "error",
			'message' => "Not Verified User!!",
			'code' => '100'
		);	
		echo json_encode($jsondata);exit;
	}

}else{

	$jsondata = array(
		"status" => "error",
		'message' => "Insufficient parameter",
		'code' => '100'
	);
	echo json_encode($jsondata);exit;
}
	
function check_licence($data){
	$db = dbConnection();		
	$sql = "Select * from registration where email='{$data['email']}' and licence='{$data['licence']}' and code='{$data['code']}' and domain='{$data['domain']}' and product_type='{$data['product_type']}'";
	$result = $db->query($sql)->fetch_object();

	if(empty($result)) {
	     return false;
	}

    if( $result->expiry_date>date('Y-m-d', time()) ) {
        return true;

    } else {
    	return false;
    }       


}
function dbConnection(){
	$mysqli = new mysqli("localhost","root","","curl-php");
	if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  exit();
	}
	return $mysqli;
}
?>