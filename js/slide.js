function verifyOtherMedias(){displayMap(urls);
displayTabs()
}function displayMap(A){if(A.mapForTravel==""){verifyMapIsAvailable(A.mapForCity,"ville",A)
}else{verifyMapIsAvailable(A.mapForTravel,"circuit",A)
}}function verifyMapIsAvailable(A,C,B){isResourceAvailable(A,function(){if(C=="circuit"){displayMapInGallery(B.mapForTravel,B.mapForTravelH)
}else{if(C=="ville"){displayMapInGallery(B.mapForCity,B.mapForCityH)
}else{if(C=="pays"){displayMapInGallery(B.mapForCountry,B.mapForCountryH)
}}}},function(){if(C=="circuit"){verifyMapIsAvailable(B.mapForCity,"ville",B)
}else{if(C=="ville"){verifyMapIsAvailable(B.mapForCountry,"pays",B)
}}})
}function displayTabs(){if(jQuery("#lien360").attr("class")==""){jQuery("#onglet360").show()
}if(jQuery("#lienVideo").attr("class")==""){jQuery("#ongletVideo").show()
}}function displayMapInGallery(B,A){jQuery("#thumbs li:last a img").attr("src",B);
jQuery("#thumbs li:last a").attr("href",A);
jQuery("#thumbs li:last a").click(function(){loadZoom("#zoomCarte",this.href);
return false
});
jQuery("#thumbs li:last").removeClass("empty")
}function changeImage(B,C,D){jQuery("#zoomGalleryVideo360").hide();
jQuery("#zoomGallery").css("display","inline");
jQuery("#photo").attr("src",B);
jQuery("#photo").attr("alt",C); 
jQuery("#description").html(D); 
try{sendDataToOmnitureForThumbnail()
}catch(A){}}function gotoPreviousPicture(){gotoNextOrPreviousPicture(true)
}function gotoNextPicture(){gotoNextOrPreviousPicture(false)
}function gotoNextOrPreviousPicture(F){var C= num_image;
var B=jQuery("#photo").attr("src");
for(var E=0;
E<jQuery("#thumbs li").size();
E++){var D=jQuery("#thumbs li:eq("+E+") a").attr("href");
if(D&&B.match(D+"$")==D){var A=E;
if(F){A=(A==0)?(C-1):(A-1);
while(jQuery("#thumbs li:eq("+A+")").hasClass("empty")){A=(A==0)?(C-1):(A-1)
}}else{A=(A==C-1)?0:(A+1);
while(jQuery("#thumbs li:eq("+A+")").hasClass("empty")){A=(A==C-1)?0:(A+1)
}}jQuery("#thumbs li:eq("+A+") a").trigger("onclick");
break
}}}function closeMediaWindows(){jQuery("#zoomGallery").show();
if(jQuery("#zoomGalleryVideo360").size()!=0){jQuery("#zoomGalleryVideo360").hide();
jQuery("#jqueryflash-video").empty();
jQuery("#jqueryflash-360").empty()
}}function loadPanorama(){window.scrollTo(0,0);
changePanorama(jQuery("#panoramas").val());
jQuery("#zoomGalleryVideo360 #panorama").show();
jQuery("#zoomGalleryVideo360 #video").hide();
jQuery("#zoomGalleryVideo360").show();
jQuery("#zoomGallery").hide();
try{sendDataToOmnitureForPanorama()
}catch(A){}}function changePanorama(A){jQuery("#jqueryflash-video").empty();
jQuery("#jqueryflash-360").empty();
jQuery("#jqueryflash-360").flash({src:A,width:464,height:262})
}function loadVideo(){window.scrollTo(0,0);
jQuery("#jqueryflash-video").empty();
jQuery("#jqueryflash-360").empty();
jQuery("#jqueryflash-video").flash({src:resourceLink("/static/images/multimedia/mediaplayer.swf"),width:430,height:315,bgcolor:"#ffffff",allowfullscreen:"true",flashvars:{file:videoLocation,hotel:accommodationName,width:430,height:315,backcolor:0,frontcolor:16777215,lightcolor:16737792,logo:resourceLink("/static/images/multimedia/logo-rfo.png"),image:jQuery("#thumbs li:eq(0) a").attr("href")}});
jQuery("#zoomGalleryVideo360 #video").show();
jQuery("#zoomGalleryVideo360 #panorama").hide();
jQuery("#zoomGalleryVideo360").show();
jQuery("#zoomGallery").hide();
try{sendDataToOmnitureForVideo()
}catch(A){}}function loadZoom(C,A){jQuery(C).empty();
jQuery(C).image(A,function(){});
jQuery("#multimedia").hide();
jQuery("#zoom").show();
try{sendDataToOmnitureForMap()
}catch(B){}}function showMultimedia(){jQuery("#zoom").hide();
jQuery("#multimedia").show()
}function loadFirstImage(){jQuery("#thumbs li:first a").trigger("onclick");
showMultimedia()
}function sendPanoramaDataToGoogle(){try{pageTracker._trackPageview("/offre/VisiteVirtuelle")
}catch(A){}}function sendVideoDataToGoogle(){try{pageTracker._trackPageview("/offre/Video")
}catch(A){}};