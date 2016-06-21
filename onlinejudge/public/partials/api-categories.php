<?php

$categories = get_cats_children($wp_query->query_vars['page']) ;

echo json_encode($categories) ;

function get_cats_children($parent) {

	global $wpdb ;

	$results = $wpdb->get_results('SELECT id,name,parent,permalink FROM '.$wpdb->prefix.
			'oj_categories WHERE parent='.$parent.' ORDER BY parent,listorder',ARRAY_A) ;

	$tmparray = array() ;
	foreach($results as $item) {
		array_push($tmparray,array(	'id'=>intval($item['id']),
						'name'=>$item['name'],
						'parent'=>intval($item['parent']),
						'permalink'=>$item['permalink'],
						'children'=>get_cats_children($item['id']))) ;
	}
	return $tmparray ;

}
?>
