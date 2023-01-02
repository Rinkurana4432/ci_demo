<?php 
function getNameById($table='',$id='',$field=''){
	$qry="select * from $table where $field='$id'";
	$CI =& get_instance();
	$qryy = $CI->db->query($qry);	
	$result = $qryy->row();	
	return $result;	
}



function getStarRatingCount($table='',$id='',$field=''){
	$qry="SELECT COUNT(IF(reviews.rating=5,1, NULL)) AS fivestar, COUNT(IF(reviews.rating=4,1, NULL)) AS fourstar, COUNT(IF(reviews.rating=3,1, NULL)) AS threestar, COUNT(IF(reviews.rating=2,1, NULL)) AS twostar, COUNT(IF(reviews.rating=1,1, NULL)) AS onestar , ROUND(AVG(reviews.rating),1) as average FROM $table WHERE $field='$id'";	
	$CI =& get_instance();
	$qryy = $CI->db->query($qry);
	//pre($CI->db->last_query());die;
	$result = $qryy->result_array();

	return $result;	
}



/*function getTopSellingProducts(){
	$qry = "SELECT material.* ,(1 * COUNT(IF(reviews.rating=1,1, NULL))) as rate1,(2 * COUNT(IF(reviews.rating=2,1, NULL))) as rate2,(3 * COUNT(IF(reviews.rating=3,1, NULL))) as rate3,(4 * COUNT(IF(reviews.rating=4,1, NULL))) as rate4,(5 * COUNT(IF(reviews.rating=5,1, NULL))) as rate5, (COUNT(IF(reviews.rating=1,1, NULL)) + COUNT(IF(reviews.rating=2,1, NULL)) + COUNT(IF(reviews.rating=3,1, NULL)) + COUNT(IF(reviews.rating=4,1, NULL)) + COUNT(IF(reviews.rating=5,1, NULL))) as total_reviews,((1 * COUNT(IF(reviews.rating=1,1, NULL))) + (2 * COUNT(IF(reviews.rating=2,1, NULL))) + (3 * COUNT(IF(reviews.rating=3,1, NULL))) + (4 * COUNT(IF(reviews.rating=4,1, NULL))) +(5 * COUNT(IF(reviews.rating=5,1, NULL)))) as total_average_rating FROM  `reviews` inner join material on reviews.material_id = material.id   group by reviews.material_id";
	$CI =& get_instance();
	$qryy = $CI->db->query($qry);
	$ratingResult = $qryy->result_array();
	$i =0;
	$averageRatingArray = array();
	foreach($ratingResult as $res){
		$averageRatingArray[$i]['material_id'] =  $res['id'];
		$averageRatingArray[$i]['material_name'] =  $res['material_name'];
		$averageRatingArray[$i]['featured_image'] =  $res['featured_image'];
		$averageRatingArray[$i]['created_by_cid'] =  $res['created_by_cid'];
		$averageRatingArray[$i]['sales_price'] =  $res['sales_price'];
		$averageRatingArray[$i]['min_order'] =  $res['min_order'];
		if($res['total_reviews'] == 0)
			$averageMean = 0;	
		else
		$averageMean = $res['total_average_rating'] / $res['total_reviews'];						
		$averageMeanByRating = (-$averageMean) / 20;		
		$logValue = pow(2.718,$averageMeanByRating);		
		$averageRatingArray[$i]['averageRating'] = $averageMean + 5*(1 - $logValue);
		$i++;
	}
		$averageRatingArray = sortArray($averageRatingArray,'averageRating','DESC');	
		$ratedProductCount = count($averageRatingArray);
		$remainingRatingResult  = array();
		if($ratedProductCount < 10){
			$remainingCount = 10 - $ratedProductCount;
			$remainingQry = "SELECT id as material_id,material_name,featured_image ,created_by_cid ,sales_price , min_order , 0 as averageRating FROM material WHERE id NOT IN (SELECT material_id FROM reviews) ORDER BY `material`.`created_date` ASC LIMIT $remainingCount";
			$remainingQryy = $CI->db->query($remainingQry);
			$remainingRatingResult = $remainingQryy->result_array();		
		}
		
		$averageRatingArray = (array_merge($averageRatingArray , $remainingRatingResult));
		return $averageRatingArray;
}*/

function getTopSellingProducts(){
    $likeSalePurchase = '%"Sale"%';
    $qry = "SELECT material.* ,(1 * COUNT(IF(reviews.rating=1,1, NULL))) as rate1,(2 * COUNT(IF(reviews.rating=2,1, NULL))) as rate2,(3 * COUNT(IF(reviews.rating=3,1, NULL))) as rate3,(4 * COUNT(IF(reviews.rating=4,1, NULL))) as rate4,(5 * COUNT(IF(reviews.rating=5,1, NULL))) as rate5, (COUNT(IF(reviews.rating=1,1, NULL)) + COUNT(IF(reviews.rating=2,1, NULL)) + COUNT(IF(reviews.rating=3,1, NULL)) + COUNT(IF(reviews.rating=4,1, NULL)) + COUNT(IF(reviews.rating=5,1, NULL))) as total_reviews,((1 * COUNT(IF(reviews.rating=1,1, NULL))) + (2 * COUNT(IF(reviews.rating=2,1, NULL))) + (3 * COUNT(IF(reviews.rating=3,1, NULL))) + (4 * COUNT(IF(reviews.rating=4,1, NULL))) +(5 * COUNT(IF(reviews.rating=5,1, NULL)))) as total_average_rating FROM  reviews inner join material on reviews.material_id = material.id WHERE material.created_by_cid !=1 AND material.sale_purchase LIKE '$likeSalePurchase' group by reviews.material_id";    
    $CI =& get_instance();
    $qryy = $CI->db->query($qry);    
    $ratingResult = $qryy->result_array();
    
    $i =0;
    $averageRatingArray = array();
	$limitProducts =0 ;
    foreach($ratingResult as $res){
		$limitProducts++;
		if($limitProducts >=10){
			$averageRatingArray[$i]['material_id'] =  $res['id'];
			$averageRatingArray[$i]['material_name'] =  $res['material_name'];
			$averageRatingArray[$i]['featured_image'] =  $res['featured_image'];
			$averageRatingArray[$i]['created_by_cid'] =  $res['created_by_cid'];
			$averageRatingArray[$i]['sales_price'] =  $res['sales_price'];
			$averageRatingArray[$i]['min_order'] =  $res['min_order'];
			if($res['total_reviews'] == 0)
				$averageMean = 0;    
			else
			$averageMean = $res['total_average_rating'] / $res['total_reviews'];                        
			$averageMeanByRating = (-$averageMean) / 20;        
			$logValue = pow(2.718,$averageMeanByRating);        
			$averageRatingArray[$i]['averageRating'] = $averageMean + 5*(1 - $logValue);
			$i++;
		}
    }
        $averageRatingArray = sortArray($averageRatingArray,'averageRating','DESC');    
        $ratedProductCount = count($averageRatingArray);
        $remainingRatingResult  = array();
        if($ratedProductCount < 10){
            $remainingCount = 10 - $ratedProductCount;
            //$remainingQry = "SELECT id as material_id,material_name,featured_image ,created_by_cid ,sales_price , min_order , 0 as averageRating FROM material WHERE id NOT IN (SELECT material_id FROM reviews)  ORDER BY material.created_date ASC LIMIT $remainingCount";
            
            
            
            $remainingQry = "SELECT id as material_id,material_name,featured_image ,created_by_cid ,sales_price , min_order , 0 as averageRating FROM material WHERE id NOT IN (SELECT material_id FROM reviews) AND material.sale_purchase LIKE '$likeSalePurchase' ORDER BY material.created_date ASC LIMIT $remainingCount";
            
            $remainingQryy = $CI->db->query($remainingQry);
        
            $remainingRatingResult = $remainingQryy->result_array();        
        }
        
        $averageRatingArray = (array_merge($averageRatingArray , $remainingRatingResult));
    
        return $averageRatingArray;
}

function sortArray($array, $sortByKey, $sortDirection) {
    $sortArray = array();
    $tempArray = array();
    foreach ( $array as $key => $value ) {
        $tempArray[] = strtolower( $value[ $sortByKey ] );
    }
    if($sortDirection=='ASC'){ asort($tempArray ); }
        else{ arsort($tempArray ); }
    foreach ( $tempArray as $key => $temp ){
        $sortArray[] = $array[ $key ];
    }
    return $sortArray;
}
?>