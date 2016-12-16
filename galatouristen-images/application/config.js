/* created by system configuration editor */
var URL_BASE="http://www.vietnam-cambodia-tours.com/";
var URL_ROOT="/";
var FORMAT_DATE="%d-%m-%Y";
var FORMAT_DATETIME="%d-%m-%Y %H:%M:%S";
var DATE_FORMAT="%d-%m-%Y";
var DATE_SEPERATOR="-";
var REGEX_EMAIL=/^[\w\.\-]@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,5}$/;
var REGEX_HREF=/href\=(['\"])([^'\"]+)\1/;
var REGEX_DATE=/^[^\d]*(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{4}|\d{2}).*$/;
var REGEX_DATETIME=/^[^\d]*(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{4}|\d{2})[^\d]+(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{0,3}).*$/;
var TIME_ZONE="TIME_ZONE";
var S_DB_DATETIME="$3-$2-$1 $4:$5:$6";
String.prototype.toDate = function(){	return eval("new Date(" + ((this + " 00:00:00:000").replace(REGEX_DATETIME,S_DB_DATETIME)).replace(/\D+/g,",").replace(/(\d{4})\,(\d{2})/,"$1,$2-1") + ")");}
String.prototype.trim = function(){  return this.replace(/(?:^\s*)|(?:\s*$)/g, "");}
/*@cc_on @if(1)	$=document.getElementById; @else@*/ function $(id){return document.getElementById(id);}/*@end@*/