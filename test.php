<?php
	
	/**
	* @author: Okkey Sumiyoshi
	* @date: 30/July/2021
	* @assumption A band belong to a single and unique record label
	*/
	
	
	$labels = array();
	
	function do_cmp($a, $b){

		return strcasecmp($a[ 'name' ], $b[ 'name' ]);
	}
	
	function do_curl(){

		try {
			$c_index = curl_init();
			curl_setopt($c_index,CURLOPT_URL,'https://eacp.energyaustralia.com.au/codingtest/api/v1/festivals');
			curl_setopt($c_index,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($c_index, CURLOPT_HTTPHEADER, array(
					'Content-Type: text/plain'
			));			
			$res_index = curl_exec($c_index);
			$status_index = curl_getinfo($c_index,CURLINFO_HTTP_CODE);
			curl_close($c_index);
		}
		catch(Exception $e) {
			echo $e->getMessage();
			die();
		}

		return array(
			'response' => json_decode($res_index, true),
			'status' => $status_index
		);
	
	}
	
	/**
	* Check to see if a band has been already registered under the label
	* @return boolean true is already registered.
	*/
	$band_name_exist = function(  $name_label = null, $name_band = null ) use (&$labels) {
		$output = false;
		for ( $i = 0; $i < count($labels[$name_label][ 'bands' ]); $i++ ){
			if( $labels[$name_label][ 'bands' ][ $i ][ 'name' ] == $name_band ){
				$output = true;
			}
		}
		return $output;	
	};
	

	/**
	* Add the fetival name to the list of festivals that a band has attended
	* 
	*/	
	$add_festival = function ( $name_label = null, $band = null ) use (&$labels) {
		for ( $i = 0; $i < count($labels[$name_label][ 'bands' ]); $i++ ){
			if( $labels[$name_label][ 'bands' ][ $i ][ 'name' ] == $band[ 'name'] ){
				for ( $r = 0; $r<count( $band[ 'festival' ] ); $r++ ){
					$labels[$name_label][ 'bands' ][ $i ][ 'festival' ][] = $band[ 'festival' ][$r];
				}
			}
		}
	};
	
	
	
	$d = do_curl();
	
	if (( $d['status'] == 200 ) && (gettype($d['response']) == 'array')){
			
		$fest_data = $d['response'];

		// Standardise the data by removing discrapancy in field attributes
		for ( $i = 0; $i < count($fest_data); $i++ ){
			
			if (!array_key_exists('name', $fest_data[$i])) {
				$fest_data[$i][ 'name' ] = 'No festival';
			}
			
			for ( $r = 0; $r < count( $fest_data[$i]['bands'] ); $r++ ){
			
				if (!array_key_exists('recordLabel', $fest_data[$i]['bands'][ $r ])) {
					$fest_data[$i]['bands'][ $r ][ 'recordLabel' ] = 'No label';
				} else {
					if (empty($fest_data[$i]['bands'][ $r ][ 'recordLabel' ])){
						$fest_data[$i]['bands'][ $r ][ 'recordLabel' ] = 'No label';
					}
				}
				
				// Make festival field value to the property of each band
				$fest_data[$i]['bands'][ $r ][ 'festival' ] = array();
				$fest_data[$i]['bands'][ $r ][ 'festival' ][] = $fest_data[$i][ 'name' ];					

			}
			
						
		}
		

		// Reorganise bands by record labels
		for ( $i = 0; $i < count($fest_data); $i++ ){
		
			for ( $r = 0; $r < count( $fest_data[$i]['bands'] ); $r++ ){
			
				$key = strtoupper(str_replace(" ","_",$fest_data[$i]['bands'][ $r ][ 'recordLabel' ]));
			
				if (!array_key_exists($key, $labels)) {
					$labels[$key] = array('name' => $fest_data[$i]['bands'][ $r ][ 'recordLabel' ], 'bands' => array());
				}
				
				if (!$band_name_exist($key, $fest_data[$i]['bands'][ $r ][ 'name' ])){
					$labels[$key][ 'bands' ][] = $fest_data[$i]['bands'][ $r ];
				} else {
					$add_festival($key, $fest_data[$i]['bands'][ $r ]);
					}					
			}			
		}

		// Sort record labels by alphabetical order
		ksort($labels, SORT_STRING);
		

		foreach( $labels as $key => $label ){
		
			// Sort bands under each label by alphabetical order		
			usort($labels[$key][ 'bands' ], "do_cmp");

			// Write the record label name
			echo "Record Label ".$labels[$key]['name']."\n";
			for ( $i = 0; $i < count($labels[$key][ 'bands' ]); $i++ ) {
				
				// Write the band name
				echo "\t "."Band ".$labels[$key]['bands'][$i]['name']."\n";
				for ( $r = 0; $r < count($labels[$key]['bands'][$i]['festival']); $r++ ){
				
					// Write the festival name attended
					echo "\t\t "."Festival ".$labels[$key]['bands'][$i]['festival'][$r]."\n";
				}
				
			}
		}

		
	} else {
		echo "Malformed response returned from API end point.  try again"."\n";
	}
?>