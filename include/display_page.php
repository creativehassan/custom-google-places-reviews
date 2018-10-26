<?php
if($pid){
	$google_palce_id = get_post_meta( $pid , 'google_palce_id' , true );
	$api_key = get_post_meta( $pid , 'google_api_key' , true );
	
	if(!$google_palce_id) wp_die(__( 'Please Add Google Place ID', 'custom_googlepalcereviews' ));
	if(!$api_key) wp_die(__( 'Please Add Google API Key in settings', 'custom_googlepalcereviews' ));
	
	
	$response = array();
	$transients = get_transient( 'custom_cgpr_google_palce_reviews_'.$pid );
	
	if( ! empty( $transients ) ) {
		$data = $transients;
	} else {
		$file="https://maps.googleapis.com/maps/api/place/details/json?placeid=".$google_palce_id."&key=".$api_key;
		$data =  json_decode(file_get_contents($file));
		$res = wp_remote_post( $file, array() );
		$body_file = wp_remote_retrieve_body( $res );
		$response = json_decode( $body_file, true );
		if($data->status == "OK"){
			set_transient( 'custom_cgpr_google_palce_reviews_'.$pid , $data, 43200 );
		}
	}
	$transient_url = get_transient( 'custom_google_palce_photo_'.$pid );
	if( ! empty( $transient_url ) ) {
		$request_url = $transient_url;
	} else if(isset($response['status']) && $response['status'] == "OK") {
		$request_url = add_query_arg(
			array(
				'photoreference' => $response['result']['photos'][0]['photo_reference'],
				'key'            => $api_key,
				'maxwidth'       => '300',
				'maxheight'      => '300',
			),
			'https://maps.googleapis.com/maps/api/place/photo'
		);
		set_transient( 'custom_google_palce_photo_'.$pid , $request_url, 43200 );
	}
	
	if(isset($response['status']) && $response['status'] == "OK") {
		include_once( 'content_place.php' );
	} else {
		echo "<strong>". __( 'Status', 'custom_googlepalcereviews' ). "</strong> : " . $response['status'];
		echo "<br />";
		echo "<strong>". __( 'API Message', 'custom_googlepalcereviews' ). "</strong> : " . $response['error_message'];
	}
}



?>