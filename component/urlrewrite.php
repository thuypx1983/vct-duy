<?php
$urlrewriteext='';
$urlrewrite = array(
'about-us.php' => 'about-us.html',
'testimonial.php' => 'testimonial.html',
'tour-customize.php' => 'tour-customize.html',
'contact-us.php' => 'contact-us.html',
'faq.php' => 'faqs.html',
'policy.php' => 'policy.html',
'payment.php' => 'payment.html',
'link-exchange.php' => 'link-exchanges/',
'tour.php'=>'tours/',
'term-condition.php'=>'term-condition.html',
'tour-list.php'=>'tours/',
'sub-tour-list.php'=>'tours/',
'tour-detail.php'=>'tours/',
'hotel.php'=>'hotels/',
'hotel-list.php'=>'hotels/',
'hotel-detail.php'=>'hotels/',
'service.php'=>'services/',
'service-list.php'=>'services/',
'service-detail.php'=>'services/',
'attraction.php'=>'attractions/',
'attraction-list.php'=>'attractions/',
'attraction-detail.php'=>'attractions/',
'news-events.php'=>'news_events/',
'news-events-detail.php'=>'news_events/',
'travel-conference.php'=>'travel_conferences/',
'travel-conference-detail.php'=>'travel_conferences/',
'useful-information.php'=>'useful_informations/',
'useful-information-list.php'=>'useful_informations/',
'useful-information-detail.php'=>'useful_informations/',
'tour-book.php'=>'tour_book/',
'hotel-book.php'=>'hotel_book/',
'service-book.php'=>'service_book/',
'service-print.php'=>'service_print/',
'tour-print.php'=>'tour_print/',
'hotel-print.php'=>'hotel_print/',
'news-print.php'=>'news_print/',
'gallery.php'=>'gallery.html',
'phone.php' => 'callback.html'
);
include(PATH_APPLICATION.'nonsign.php');
 function urlBuild($file,$a=NULL,$hint=NULL){
    global $urlrewrite;
	global $urlrewriteext;
	if($file=='info.php'){
		return '/about/'.$a['url'].'.html';	
	}
	if(in_array($file, array('travel-conference-detail.php','news-print.php','tour-print.php','hotel-print.php','service-print.php','service-detail.php','service-book.php','hotel-book.php','tour-book.php','hotel-detail.php','tour-detail.php','news-events-detail.php','attraction-detail.php','useful-information-detail.php'))) {$urlrewriteext='.html';} else {$urlrewriteext='/';}
    if($file == 'index.php')
        return URL_BASE;
	$catarray= array('CPid','PDid','CNid','NWid');	
    if($t=$urlrewrite[$file]){
		if($a==NULL){ return $t; }
		else 
		{
			$k=array_keys($a);$a1=array();
			for($i=0;$i<count($a);$i++) { if(!in_array($k[$i], $catarray)) $a1[]=$a[($k[$i])]; }
			$k=array_keys($a1); $v=array_values($a1);
			for($i=0;$i<count($a1);$i++)
			{
				$i2=$i+1;
				
				$value=$v[$i]; $key=$k[$i];
				$value2='abc'; $value2=@$v[$i2];
				if(is_numeric($value)) { $t = $t.'_'.nonsign($value).(count($a1)==$i2?$urlrewriteext:''); } else
					if(is_numeric($value2))
						{
							$t.=preg_replace('/\W+/','_',$value).(count($a1)==$i2?$urlrewriteext:''); 
						}else { $t = $t.preg_replace('/\W+/','_',nonsign($value)).(count($a1)==$i2?$urlrewriteext:'/'); }
			}
		}
		return $t;
    }
	//str_replace
	else{
		$i=0;
		if($a){
		foreach($a as $key=>$value) 
		{
		if($i==0) { $file = $file.'?'.$key.'='.nonsign($value); }
		else { $file = $file.'&'.$key.'='.nonsign($value); }
		$i++;
		}
		}
		return nonsign($file);
    }
}
function urlSet($file,$a){
    if($file{0} != '/') $file = URL_BASE.$file;
    foreach($_GET as $key=>$value)
        if(!array_key_exists($key,$a) && $value) $a[$key] = $value;
    if($t = http_build_query($a))    return $file.'?'.$t;
    else return $file;
}
?>