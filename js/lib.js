// JavaScript Document
function showTab(o){
	var tab1 = document.getElementById("toursearch");
	var tab2 = document.getElementById("hotelsearch");
	if(o.id == "tour"){
		tab1.style.display = "block";
		tab2.style.display="none";	
	}
	if(o.id == "hotel"){
		tab1.style.display = "none";
		tab2.style.display="block";	
	} 
}



function showTab_(o){
	var tab1 = document.getElementById("vietnamhotel");
	var tab2 = document.getElementById("laohotel");
	var tab3 = document.getElementById("cambodgehotel");
	var tab4 = document.getElementById("thailandehotel");
	if(o.id == "vietnam"){
		tab1.style.display = "block";
		tab2.style.display="none";	
		tab3.style.display="none";
		tab4.style.display="none";
	}
	if(o.id == "lao"){
		tab1.style.display = "none";
		tab2.style.display="block";	
		tab3.style.display = "none";
		tab4.style.display = "none";
	} 
	if(o.id == "cambodge"){
		tab1.style.display = "none";
		tab2.style.display="none";	
		tab3.style.display = "block";
		tab4.style.display = "none";
	} 
	if(o.id == "thailande"){
		tab1.style.display = "none";
		tab2.style.display="none";	
		tab3.style.display = "none";
		tab4.style.display = "block";
	} 
}
function showTabHotel(tab,name){
	var x = document.getElementsByName(name);
	var y = document.getElementById(tab);
	for(var i=0;i<x.length;i++){
		if(x[i].id==tab){
			x[i].style.display="block";
		}
		else x[i].style.display="none"
	}
}

// JavaScript Document
var current_id="default";
function showItem(id) {
    var prev_obj = document.getElementById("item_"+current_id);
    var obj = document.getElementById("item_"+id);
    if (prev_obj) {
        prev_obj.style.display = "none";
    }
    if (obj) {
        obj.style.display = "block";
        current_id = id;
    }
}

var current_id_1="default1";
function showItem1(id_1) {
    var prev_obj = document.getElementById("item_"+current_id_1);
    var obj = document.getElementById("item_"+id_1);
    if (prev_obj) {
        prev_obj.style.display = "none";
    }
    if (obj) {
        obj.style.display = "block";
        current_id_1 = id_1;
    }
}

var current_id_2="default2";
function showItem2(id_2) {
    var prev_obj = document.getElementById("item_"+current_id_2);
    var obj = document.getElementById("item_"+id_2);
    if (prev_obj) {
        prev_obj.style.display = "none";
    }
    if (obj) {
        obj.style.display = "block";
        current_id_2 = id_2;
    }
}
var current_id_3="default3";
function showItem3(id_3) {
    var prev_obj = document.getElementById("item_"+current_id_3);
    var obj = document.getElementById("item_"+id_3);
    if (prev_obj) {
        prev_obj.style.display = "none";
    }
    if (obj) {
        obj.style.display = "block";
        current_id_3 = id_3;
    }
}




