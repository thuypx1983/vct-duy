var CSS_EVENT_SELECTOR_RULE=new Array(
"DIV.tab_name_item:click:clickHandler" ,
"DIV.tab_name_item_active:click:clickHandler"
);
function clickHandler(evt){ 
	var tab_name_item = null;
	i=0;stop=false;
	do{
    	tab_name_item = document.getElementById('tab_name_item_' + i);
		if(tab_name_item!=null){
			tab_name_item.className = tab_name_item.className.replace('_active','');
			i++;
		}else{
			stop = true;
		}
	}while(!stop);
	i=0;stop=false;
	do{
    	tab_content_item = document.getElementById('tab_content_item_' + i);
		if(tab_content_item!=null){
			tab_content_item.className = tab_content_item.className.replace('_active','');
			i++;
		}else{
			stop = true;
		}
	}while(!stop);
	tab_content_item = document.getElementById(this.id.replace('name','content'));
	if(tab_content_item!=null)	
		tab_content_item.className = tab_content_item.className + '_active';
	this.className = this.className + '_active';
}
