<?php
function my_smart_search( $search, $wp_query ) {
    global $wpdb; 
    if ( empty( $search ))
        return $search;
 
    $terms = $wp_query->query_vars[ 's' ];
    $exploded = explode( ' ', $terms );
    if( $exploded === FALSE || count( $exploded ) == 0 )
        $exploded = array( 0 => $terms );
         
    $search = '';
    foreach( $exploded as $tag ) {
        $search .= " AND (
            ($wpdb->posts.post_title LIKE '%$tag%')
            OR ($wpdb->posts.post_content LIKE '%$tag%')
            OR EXISTS
            (
                SELECT * FROM $wpdb->comments
                WHERE comment_post_ID = $wpdb->posts.ID
                    AND comment_content LIKE '%$tag%'
            )
            OR EXISTS
            (
                SELECT * FROM $wpdb->terms
                INNER JOIN $wpdb->term_taxonomy
                    ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
                INNER JOIN $wpdb->term_relationships
                    ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
                WHERE taxonomy = 'post_tag'
                    AND object_id = $wpdb->posts.ID
                    AND $wpdb->terms.name LIKE '%$tag%'
            )
        )";
    }
 
    return $search;
} 
add_filter( 'posts_search', 'my_smart_search', 500, 2 );
function classiera_CF_search_Query($custom_fields){
	$searchQueryCustomFields = array();
	$value = array_filter($custom_fields, function($value) { return $value !== ''; });		
	$value = array_values($value);
	if(!empty($value)){
		foreach ($value as $val) {				
			$searchQueryCustomFields[] = array(
				'key' => 'custom_field',
				'value' => $val,
				'compare' => 'LIKE',
			);
		}			
	}
	return $searchQueryCustomFields;
}
function classiera_Price_search_Query($priceArray){
	$searchQueryPrice = array(
		'key' => 'post_price',
		'value' => $priceArray,
		'compare' => 'BETWEEN',
		'type' => 'NUMERIC'
	);
	return $searchQueryPrice;
}
function classiera_Country_search_Query($country){
	if (is_numeric($country)){
		$countryArgs = array(
			'post__in' => array($country),
			'post_per_page' => -1,
			'post_type' => 'countries',
		);
		$countryPosts = get_posts($countryArgs);		
		foreach ($countryPosts as $p) :		
		$search_country = $p->post_title;
		endforeach;
	}else{
		$search_country = $country;
	}		
	$SearchQueryCountry = array(
		'key' => 'post_location',
		'value' => $search_country,
		'compare' => 'LIKE',
	);
	return $SearchQueryCountry;
}
function classiera_State_search_Query($state){
	if($state != 'All' && !empty($state)){
		$search_state = $state;
	}
	$searchQueryState = array(
		'key' => 'post_state',
		'value' => $search_state,
		'compare' => 'LIKE',
	);
	return $searchQueryState;
}
function classiera_City_search_Query($city){
	if($city != 'All' && !empty($city)){
		$search_city = $city;
	}
	$SearchQueryCity = array(
		'key' => 'post_city',
		'value' => $search_city,
		'compare' => 'LIKE',
	);
	return $searchQueryCity;
}
function classiera_Condition_search_Query($search_condition){
	$searchCondition = array(
		'key' => 'item-condition',
		'value' => $search_condition,
		'compare' => 'LIKE',
	);
	return $searchCondition;
}
?>