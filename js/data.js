/*
   Deluxe Menu Data File
   Created by Deluxe Tuner v3.15
   http://deluxe-menu.com
*/



//--- Common
var menuIdentifier="deluxeMenu";
var isHorizontal=1;
var smColumns=1;
var smOrientation=0;
var dmRTL=0;
var pressedItem=-2;
var itemCursor="pointer";
var itemTarget="_self";
var statusString="link";
var blankImage="../images/blank.gif";
var pathPrefix_img="";
var pathPrefix_link="";

//--- Dimensions
var menuWidth="";
var menuHeight="";
var smWidth="";
var smHeight="";

//--- Positioning
var absolutePos=0;
var posX="";
var posY="";
var topDX=0;
var topDY=-1;
var DX=0;
var DY=0;
var subMenuAlign="";
var subMenuVAlign="";

//--- Font
var fontStyle=["normal 12px Arial","normal 12px Arial"];
var fontColor=["#FFFFFF","#FFFFFF"];
var fontDecoration=["none","underline"];
var fontTransform="none";
var fontColorDisabled="#494949";

//--- Appearance
var menuBackColor="transparent";
var menuBackImage="";
var menuBackRepeat="repeat-x";
var menuBorderColor="transparent";
var menuBorderWidth="0px";
var menuBorderStyle="none";
var smFrameImage="../images/sub4.png";
var smFrameWidth=10;

//--- Item Appearance
var itemBackColor=["#4e4e4e","#4e4e4e"];
var itemBackImage=["",""];
var itemSlideBack="";
var beforeItemImage=["",""];
var afterItemImage=["",""];
var beforeItemImageW="";
var afterItemImageW="";
var beforeItemImageH="";
var afterItemImageH="";
var itemBorderWidth="0px";
var itemBorderColor=["transparent","transparent"];
var itemBorderStyle=["none","none"];
var itemSpacing=0;
var itemPadding="0px 16px 0px 6px";
var itemAlignTop="center";
var itemAlign="left";

//--- Icons
var iconTopWidth="";
var iconTopHeight="";
var iconWidth="";
var iconHeight="";
var arrowWidth=2;
var arrowHeight=38;
var arrowImageMain=["../images/ver_menu_2x38.gif",""];
var arrowWidthSub=7;
var arrowHeightSub=7;
var arrowImageSub=["../images/arr_white_2.gif",""];

//--- Separators
var separatorImage="";
var separatorColor="";
var separatorWidth="100%";
var separatorHeight="0px";
var separatorAlignment="center";
var separatorVImage="";
var separatorVColor="";
var separatorVWidth="0px";
var separatorVHeight="100%";
var separatorPadding="0px";

//--- Floatable Menu
var floatable=0;
var floatIterations=6;
var floatableX=1;
var floatableY=1;
var floatableDX=15;
var floatableDY=15;

//--- Movable Menu
var movable=0;
var moveWidth=12;
var moveHeight=20;
var moveColor="#DECA9A";
var moveImage="";
var moveCursor="move";
var smMovable=0;
var closeBtnW=15;
var closeBtnH=15;
var closeBtn="";

//--- Transitional Effects & Filters
var transparency="100";
var transition=101;
var transOptions="";
var transDuration=350;
var transDuration2=200;
var shadowLen=0;
var shadowColor="#B1B1B1";
var shadowTop=0;

//--- CSS Support (CSS-based Menu)
var cssStyle=0;
var cssSubmenu="";
var cssItem=["",""];
var cssItemText=["",""];

//--- Advanced
var dmObjectsCheck=0;
var saveNavigationPath=1;
var showByClick=0;
var noWrap=1;
var smShowPause=200;
var smHidePause=1000;
var smSmartScroll=1;
var topSmartScroll=0;
var smHideOnClick=1;
var dm_writeAll=1;
var useIFRAME=0;
var dmSearch=0;

//--- AJAX-like Technology
var dmAJAX=0;
var dmAJAXCount=0;
var ajaxReload=0;

//--- Dynamic Menu
var dynamic=0;

//--- Popup Menu
var popupMode=0;

//--- Keystrokes Support
var keystrokes=0;
var dm_focus=1;
var dm_actKey=113;

//--- Sound
var onOverSnd="";
var onClickSnd="";

var itemStyles = [
    ["itemHeight=38px","itemBackColor=transparent,transparent","itemBackImage=../images/top.png,../images/top1.png","itemSlideBack=8","itemBorderWidth=0px","itemBorderStyle=none,none","itemBorderColor=transparent,transparent","fontStyle='bold 12px Arial','bold 12px Arial'","fontColor=#FFFFFF,#FFFFFF","fontDecoration=none,none","fontTransform=none"],
    ["itemHeight=38px","itemBackColor=transparent,transparent","itemBackImage=../images/first.png,../images/first1.png","itemSlideBack=8","itemBorderWidth=0px","itemBorderStyle=none,none","itemBorderColor=transparent,transparent","fontStyle='bold 12px Arial','bold 12px Arial'","fontColor=#FFFFFF,#FFFFFF","fontDecoration=none,none"],
    ["itemHeight=38px","itemBackColor=transparent,transparent","itemBackImage=../images/top.png,../images/top1.png","itemSlideBack=8","itemBorderWidth=0px","itemBorderStyle=none,none","itemBorderColor=transparent,transparent","fontStyle='bold 12px Arial','bold 12px Arial'","fontColor=#FFFFFF,#FFFFFF","fontDecoration=none,none"],
];
var menuStyles = [
    ["menuBackColor=transparent","menuBorderWidth=0px","menuBorderStyle=none","menuBorderColor=transparent","itemSpacing=0","itemPadding=3px","itemTransform=none"],
];
dm_init();