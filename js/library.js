//hongnt viet
function checkContact(f){
//name
	if(f.ct_name_2.value=="" || f.ct_name_2.value==null){
		window.alert(T_NAME_REQUIRED);
		f.ct_name_2.focus();
		return false;
	}
	if (isNaN(f.ct_name_2.value)==false){
		window.alert(T_NAME_TYPE);
		f.ct_name_2.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.ct_email_2.value=="" || f.ct_email_2.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.ct_email_2.focus();
		return false;
	}
	if (!regex.test(f.ct_email_2.value)){
		window.alert(T_EMAIL_TYPE);
		f.ct_email_2.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
	// subject
	if(f.ct_subject.value=="" || f.ct_subject.value==null){
		window.alert(T_TITLE_REQUIRED);
		f.ct_subject.focus();
		return false;
	}
	if(f.ct_content_2.value=="" || f.ct_content_2.value==null){
		window.alert(T_CONTENT_REQUIRED);
		f.ct_content_2.focus();
		return false;
	}
//code spam
	//window.alert('==='+f.ct_content.value+'==');
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SPAM_REQUIRED);
		f.scode.focus();
		return false;
	}
	return true;
}

function checkContact_2(f){	
//name
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
	//date
	if(f.txtdate.value=="" || f.txtdate.value==null){
		window.alert(T_DATE_REQUIRED);
		f.txtdate.focus();
		return false;
	}
}

function checkContact_3(f){	
//date
	if(f.txtdate.value=="" || f.txtdate.value==null){
		window.alert(T_DATE_REQUIRED);
		f.txtdate.focus();
		return false;
	}
//number
	if(f.txtnumber.value=="" || f.txtnumber.value==null){
		window.alert(T_NUMBER_REQUIRED);
		f.txtnumber.focus();
		return false;
	}
	if (isNaN(f.txtnumber.value)){
		window.alert(T_NUMBER_TYPE);
		f.txtnumber.focus();
		return false;
	}
}
function checkContact_4(f){	
//date
	if(f.txtdate_2.value=="" || f.txtdate_2.value==null){
		window.alert(T_DATE_REQUIRED);
		f.txtdate_2.focus();
		return false;
	}
//number
	if(f.txtnumber_2.value=="" || f.txtnumber_2.value==null){
		window.alert(T_NUMBER_REQUIRED);
		f.txtnumber_2.focus();
		return false;
	}
	if (isNaN(f.txtnumber_2.value)){
		window.alert(T_NUMBER_TYPE);
		f.txtnumber_2.focus();
		return false;
	}
}

function checkContact_5(f){	
//name
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
//date 1
	if(f.txtdate_1.value=="" || f.txtdate_1.value==null){
		window.alert(T_ARRIVAL_DATE_REQUIRED);
		f.txtdate_1.focus();
		return false;
	}
//date 2
	if(f.txtdate_2.value=="" || f.txtdate_2.value==null){
		window.alert(T_EXIT_DATE_REQUIRED);
		f.txtdate_2.focus();
		return false;
	}
//Port of Arrival
	if(f.txtport_ariival.value=="" || f.txtport_ariival.value==null){
		window.alert(T_PORT_OF_ARRIVAL_REQUIRED);
		f.txtport_ariival.focus();
		return false;
	}
}


function checkContact_6(f){	
//name
	//alert("dfdfdf");
	//return false;
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
//date 
	if(f.txtdate.value=="" || f.txtdate.value==null){
		window.alert(T_ARRIVAL_DATE_REQUIRED);
		f.txtdate.focus();
		return false;
	}
	
//scode 
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SCODE_REQUIRED);
		f.scode.focus();
		return false;
	} 
}
function checkcustomize_tour(f)
{
	
	//calender
	if(f.txtcalender.value=="" || f.txtcalender.value==null){
		window.alert(T_CALENDER);
		f.txtcalender.focus();
		return false;
	}
	//number of adult
	if(f.txtadult.value=="" || f.txtadult.value==null){
		window.alert(T_NUMBER_ADULT);
		f.txtadult.focus();
		return false;
	}
	if (isNaN(f.txtadult.value)==true){
		window.alert(T_NUMBER_ADULT_TYPE);
		f.txtadult.focus();
		return false;
	}	
	//number of under 2 years old
	if(f.txtunder2.value=="" || f.txtunder2.value==null){
		window.alert(T_NUMBER_UNDER_2);
		f.txtunder2.focus();
		return false;
	}
	if (isNaN(f.txtunder2.value)==true){
		window.alert(T_NUMBER_UNDER_2_TYPE);
		f.txtunder2.focus();
		return false;
	}	
	//number person
	if(f.txtover2.value=="" || f.txtover2.value==null){
		window.alert(T_NUMBER_OVER_2);
		f.txtover2.focus();
		return false;
	}
	if (isNaN(f.txtover2.value)==true){
		window.alert(T_NUMBER_OVER_2_TYPE);
		f.txtover2.focus();
		return false;
	}	
}
function checkCustomizeTour(f)
{
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
}
function checkPostQuestion(f){	
//name
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
//Question
	if(f.txtquestion.value== null || f.txtquestion.value==''){
		window.alert(T_QUESTION_REQUIRED);
		f.txtquestion.focus();
		return false;
	}
//scode 
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SCODE_REQUIRED);
		f.scode.focus();
		return false;
	} 
}
function checkHotelBook(f)

{
	//calender1
	if(f.ht_calender.value=="" || f.ht_calender.value==null){
		window.alert(T_CALENDER_CHECK_IN);
		f.ht_calender.focus();
		return false;
	}	
	//calender1
	if(f.ht_calender2.value=="" || f.ht_calender2.value==null){
		window.alert(T_CALENDER_CHECK_OUT);
		f.ht_calender2.focus();
		return false;
	}
	//number room
	if(f.ht_room.value=="" || f.ht_room.value==null){
		window.alert("Enter number of room.");
		f.ht_room.focus();
		return false;
	}
	if (isNaN(f.ht_room.value)==true){
		window.alert("Please check number of room.");
		f.ht_room.focus();
		return false;
	}	
	//number extra
	if(f.ht_extra.value=="" || f.ht_extra.value==null){
		window.alert("Enter number of extra.");
		f.ht_extra.focus();
		return false;
	}
	if (isNaN(f.ht_extra.value)==true){
		window.alert("Please check number of extra.");
		f.ht_extra.focus();
		return false;
	}
}






function checkContact_7(f){	
//name
	//alert("dfdfdf");
	//return false;
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
//date 
	if(f.txtdate.value=="" || f.txtdate.value==null){
		window.alert(T_ARRIVAL_DATE_REQUIRED);
		f.txtdate.focus();
		return false;
	}
	
//scode 
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SCODE_REQUIRED);
		f.scode.focus();
		return false;
	} 
}



function checkContact_8(f){	
//name
	//alert("dfdfdf");
	//return false;
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
//scode 
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SCODE_REQUIRED);
		f.scode.focus();
		return false;
	} 
}



function checkShoppingCart(f){	
//name
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
	
//date 
	if(f.txtdate.value=="" || f.txtdate.value==null){
		window.alert(T_ARRIVAL_DATE_REQUIRED);
		f.txtdate.focus();
		return false;
	}
	
}




function checkSendComment(f){	
//name
	if(f.txtname.value=="" || f.txtname.value==null){
		window.alert(T_NAME_REQUIRED);
		f.txtname.focus();
		return false;
	}

	if (isNaN(f.txtname.value)==false){
		window.alert(T_NAME_TYPE);
		f.txtname.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.txtemail.value=="" || f.txtemail.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.txtemail.focus();
		return false;
	}	
	if (!regex.test(f.txtemail.value)){
		window.alert(T_EMAIL_TYPE);
		f.txtemail.focus();
		return false;
	}
//content
	if(f.txtcontent.value== null || f.txtcontent.value==''){
		window.alert(T_CONTENT_REQUIRED);
		f.txtcontent.focus();
		return false;
	}
//scode 
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SCODE_REQUIRED);
		f.scode.focus();
		return false;
	} 
}



function checkSendEmail(f){	
//email2
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.send_email_2.value=="" || f.send_email_2.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.send_email_2.focus();
		return false;
	}
	if (!regex.test(f.send_email_2.value)){
		window.alert(T_EMAIL_TYPE);
		f.send_email_2.focus();
		return false;
	}
//email recipients
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.send_email_1.value=="" || f.send_email_1.value==null){
		window.alert(T_EMAIL_RECIPITENS); 	
		f.send_email_1.focus();
		return false;
	}
	if (!regex.test(f.send_email_1.value)){
		window.alert(T_EMAIL_RECIPITENS_NULL);
		f.send_email_1.focus();
		return false;
	}
//code spam
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SCODE); 	
		f.scode.focus();
		return false;
	}
	return true;
}


function checkContactForm_4(f){	
//name
	if(f.ct_name_2.value=="" || f.ct_name_2.value==null){
		window.alert(T_NAME_REQUIRED);
		f.ct_name_2.focus();
		return false;
	}
	if (isNaN(f.ct_name_2.value)==false){
		window.alert(T_NAME_TYPE);
		f.ct_name_2.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.ct_email_2.value=="" || f.ct_email_2.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.ct_email_2.focus();
		return false;
	}
	if (!regex.test(f.ct_email_2.value)){
		window.alert(T_EMAIL_TYPE);
		f.ct_email_2.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
// city
	if(f.ct_city.value=="" || f.ct_city.value==null){
		window.alert(T_CITY_REQUIRED);
		f.ct_city.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
// adult
	if(f.num_adult.value=="" || f.num_adult.value==null){
		window.alert(T_ADULTS_REQUIRED);
		f.num_adult.focus();
		return false;
	}
	if (isNaN(f.num_adult.value)==true){
		window.alert(T_ADULTS_TYPE);
		f.num_adult.focus();
		return false;
	}
// departdate
	if(f.departdate.value=="" || f.departdate.value==null){
		window.alert(T_DATE_REQUIRED);
		f.departdate.focus();
		return false;
	}
// duration
	if(f.duration.value=="" || f.duration.value==null){
		window.alert(T_DURATION_REQUIRED);
		f.duration.focus();
		return false;
	}
// hotel type
	if(f.star_hotel.value=="" || f.star_hotel.value==null){
		window.alert(T_HOTEL_TYPE_REQUIRED);
		f.star_hotel.focus();
		return false;
	}
// subject
	if(f.ct_subject.value=="" || f.ct_subject.value==null){
		window.alert(T_TITLE_REQUIRED);
		f.ct_subject.focus();
		return false;
	}
	// subject
	if(f.ct_content_2.value=="" || f.ct_content_2.value==null){
		window.alert(T_CONTENT_REQUIRED);
		f.ct_content_2.focus();
		return false;
	}
//code spam
	//window.alert('==='+f.ct_content.value+'==');
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SPAM_REQUIRED);
		f.scode.focus();
		return false;
	}
return true;
}
function checkRadio (name) {
 var radios = document.getElementsByName(name);
 for (var i=0; i <radios.length; i++) {
  if (radios[i].checked) {
   return true;
  }
 }
 return false;
}

// check book hotel
function checkBookHotel(f){	
//name
	if(f.ct_name_2.value=="" || f.ct_name_2.value==null){
		window.alert(T_NAME_REQUIRED);
		f.ct_name_2.focus();
		return false;
	}
	if (isNaN(f.ct_name_2.value)==false){
		window.alert(T_NAME_TYPE);
		f.ct_name_2.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.ct_email_2.value=="" || f.ct_email_2.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.ct_email_2.focus();
		return false;
	}
	if (!regex.test(f.ct_email_2.value)){
		window.alert(T_EMAIL_TYPE);
		f.ct_email_2.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
// city
	if(f.ct_city.value=="" || f.ct_city.value==null){
		window.alert(T_CITY_REQUIRED);
		f.ct_city.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
// adult
	if(f.num_adult.value=="" || f.num_adult.value==null){
		window.alert(T_ADULTS_REQUIRED);
		f.num_adult.focus();
		return false;
	}
	if (isNaN(f.num_adult.value)==true){
		window.alert(T_ADULTS_TYPE);
		f.num_adult.focus();
		return false;
	}
// arrival date
	if(f.arriva_date.value=="" || f.arriva_date.value==null){
		window.alert(T_ARRIVAL_DATE);
		f.arriva_date.focus();
		return false;
	}
// arrival date
	if(f.depart_date.value=="" || f.depart_date.value==null){
		window.alert(T_DEPART_DATE);
		f.depart_date.focus();
		return false;
	}
// hotel type
	if(!checkRadio('hoteltype')){
		window.alert(T_HOTEL_TYPE_REQUIRED);
		return false;
	}	
// subject
	if(f.num_room.value=="" || f.num_room.value==null){
		window.alert(T_NUMROOM_HOTEL);
		f.num_room.focus();
		return false;
	}
// subject
	if(f.ct_subject.value=="" || f.ct_subject.value==null){
		window.alert(T_TITLE_REQUIRED);
		f.ct_subject.focus();
		return false;
	}
	if(f.ct_content_2.value=="" || f.ct_content_2.value==null){
		window.alert(T_CONTENT_REQUIRED);
		f.ct_content_2.focus();
		return false;
	}
//code spam
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SPAM_REQUIRED);
		f.scode.focus();
		return false;
	}
	return true;
}
// check book service
function checkBookService(f){	
//name
	if(f.ct_name_2.value=="" || f.ct_name_2.value==null){
		window.alert(T_NAME_REQUIRED);
		f.ct_name_2.focus();
		return false;
	}
	if (isNaN(f.ct_name_2.value)==false){
		window.alert(T_NAME_TYPE);
		f.ct_name_2.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.ct_email_2.value=="" || f.ct_email_2.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.ct_email_2.focus();
		return false;
	}
	if (!regex.test(f.ct_email_2.value)){
		window.alert(T_EMAIL_TYPE);
		f.ct_email_2.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
// city
	if(f.ct_city.value=="" || f.ct_city.value==null){
		window.alert(T_CITY_REQUIRED);
		f.ct_city.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
// departdate
	if(f.departdate.value=="" || f.departdate.value==null){
		window.alert(T_DATE_REQUIRED);
		f.departdate.focus();
		return false;
	}
// subject
	if(f.ct_subject.value=="" || f.ct_subject.value==null){
		window.alert(T_TITLE_REQUIRED);
		f.ct_subject.focus();
		return false;
	}
	// subject
	if(f.ct_content_2.value=="" || f.ct_content_2.value==null){
		window.alert(T_CONTENT_REQUIRED);
		f.ct_content_2.focus();
		return false;
	}
//code spam
	//window.alert('==='+f.ct_content.value+'==');
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SPAM_REQUIRED);
		f.scode.focus();
		return false;
	}
return true;
}



function checkContactForm_10(f){	
//name
	if(f.ct_name_2.value=="" || f.ct_name_2.value==null){
		window.alert(T_NAME_REQUIRED);
		f.ct_name_2.focus();
		return false;
	}
	if (isNaN(f.ct_name_2.value)==false){
		window.alert(T_NAME_TYPE);
		f.ct_name_2.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.ct_email_2.value=="" || f.ct_email_2.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.ct_email_2.focus();
		return false;
	}
	if (!regex.test(f.ct_email_2.value)){
		window.alert(T_EMAIL_TYPE);
		f.ct_email_2.focus();
		return false;
	}
// subject
	if(f.ct_subject.value=="" || f.ct_subject.value==null){
		window.alert(T_TITLE_REQUIRED);
		f.ct_subject.focus();
		return false;
	}
	// subject
	if(f.ct_content_2.value=="" || f.ct_content_2.value==null){
		window.alert(T_CONTENT_REQUIRED);
		f.ct_content_2.focus();
		return false;
	}
//code spam
	//window.alert('==='+f.ct_content.value+'==');
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SPAM_REQUIRED);
		f.scode.focus();
		return false;
	}
	return true;
}
	
// check testimonial
function checkTestimonial(f){
//name
	if(f.ct_name_2.value=="" || f.ct_name_2.value==null){
		window.alert(T_NAME_REQUIRED);
		f.ct_name_2.focus();
		return false;
	}
	if (isNaN(f.ct_name_2.value)==false){
		window.alert(T_NAME_TYPE);
		f.ct_name_2.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.ct_email_2.value=="" || f.ct_email_2.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.ct_email_2.focus();
		return false;
	}
	if (!regex.test(f.ct_email_2.value)){
		window.alert(T_EMAIL_TYPE);
		f.ct_email_2.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
// country
	if(f.ct_country.value=="" || f.ct_country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.ct_country.focus();
		return false;
	}
	if(f.ct_content_2.value=="" || f.ct_content_2.value==null){
		window.alert(T_CONTENT_REQUIRED);
		f.ct_content_2.focus();
		return false;
	}
//code spam
	//window.alert('==='+f.ct_content.value+'==');
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SPAM_REQUIRED);
		f.scode.focus();
		return false;
	}
	return true;
}


// check testimonial
function checkReviewForm(f){
//name
	if(f.name.value=="" || f.name.value==null){
		window.alert(T_NAME_REQUIRED);
		f.name.focus();
		return false;
	}
	if (isNaN(f.name.value)==false){
		window.alert(T_NAME_TYPE);
		f.name.focus();
		return false;
	}

	if(f.content.value=="" || f.content.value==null){
		window.alert(T_CONTENT_REQUIRED);
		f.content.focus();
		return false;
	}

	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SPAM_REQUIRED);
		f.scode.focus();
		return false;
	}
	return true;
}

function checkPhone(f){
//name
	if(f.gender.value=="" || f.gender.value==null){
		window.alert(T_GENDER_REQUIRED);
		f.gender.focus();
		return false;
	}
	if(f.first_name.value=="" || f.first_name.value==null){
		window.alert(T_FIRSTNAME_REQUIRED);
		f.first_name.focus();
		return false;
	}
	if(f.last_name.value=="" || f.last_name.value==null){
		window.alert(T_LASTNAME_REQUIRED);
		f.last_name.focus();
		return false;
	}
//email
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
	if(f.email.value=="" || f.email.value==null){
		window.alert(T_EMAIL_REQUIRED);
		f.email.focus();
		return false;
	}
	if (!regex.test(f.email.value)){
		window.alert(T_EMAIL_TYPE);
		f.email.focus();
		return false;
	}
// country
	if(f.country.value=="" || f.country.value==null){
		window.alert(T_CONTRY_REQUIRED);
		f.country.focus();
		return false;
	}
// country
	if(f.code_country.value=="" || f.code_country.value==null){
		window.alert(T_CODE_PHONE_CONTRY_REQUIRED);
		f.code_country.focus();
		return false;
	}
	if(f.phone.value=="" || f.phone.value==null){
		window.alert(T_PHONE_REQUIRED);
		f.phone.focus();
		return false;
	}
	if(f.hour.value=="" || f.hour.value==null){
		window.alert(T_HOUR_REQUIRED);
		f.hour.focus();
		return false;
	}
	if(f.date.value=="" || f.date.value==null){
		window.alert(T_DATE_REQUIRED);
		f.date.focus();
		return false;
	}
	if(f.scode.value=="" || f.scode.value==null){
		window.alert(T_SPAM_REQUIRED);
		f.scode.focus();
		return false;
	}
	return true;
}