<?php    
    define('LM_APP_ID',         'd81af49996');
    define('LM_APP_SECRET',     'bde679a47b39d5da653027834d89be4223c08e5c');
    define('LM_URL',            'http://www.vietnam-cambodia-tours.com/');   

    class LinkMarket{
        var $debug=false;
        var $current_path;
        var $db_path;
        var $db_file;
        var $db_name='db';
        var $results=''; 
        var $curent_page_code;         
        function __construct($debug_mode=false){
            $this->current_path = rtrim (dirname (__FILE__), DIRECTORY_SEPARATOR);
            $this->db_path = $this->current_path.DIRECTORY_SEPARATOR.$this->db_name;
            $this->debug=$debug_mode;
            if($this->debug){
                $this->disableMagicQuotes();                
                if(isset($_POST['lm_page_code'])){
                    $this->db_file=$this->db_path.DIRECTORY_SEPARATOR.$this->clearnData($_POST['lm_page_code']).'.txt';    
                }
                $this->isAuthenticate();
                $this->isDbAllow();                
            }else{
                $this->curent_page_code=$this->getCurentPageCode();     
            }

        }

        function __error ($action, $code) {
            $this->results .= sprintf ("%s:error:%s\n", $action, $code);
            return false;
        }

        function checkconnect(){
            echo LM_APP_ID;
        }

        function isAuthenticate(){
            if (empty($_POST) || !isset($_POST['lm_app_id']) || !isset($_POST['lm_app_secret']))
            {
                $this->__error('authenticate','app_id or app_secret is empty');
                return false;
            }
            if($_POST['lm_app_id']!=LM_APP_ID OR !$this->isOtp($_POST['lm_app_secret'])){
                $this->__error('authenticate','app_id or app_secret not bad');
                return false;
            }
            return true;
        }

        function isDbAllow () {
            $db = new LinkMarketDb();
            $db->db_dir=$this->db_path;
            $db->db_file=$this->db_file;
            if(!$db->checkDbPermissions()){
                $this->__error('dbpermission','data file not permission for read or write');    
                return false;
            }
            return true;
        }

        function addlink(){
            $db=new LinkMarketDb();
            $db->db_dir=$this->db_path; 
            $db->db_file=$this->db_file;            
            $db->open();
            $db->insert($this->clearnData($_POST['lm_link_id']),$this->clearnData($_POST['lm_link_json']));
            $db->save();            
        }

        function removelink(){
            $db=new LinkMarketDb();
            $db->db_dir=$this->db_path; 
            $db->db_file=$this->db_path.'/'.$this->clearnData($_POST['lm_page_code']).'.txt';   
            $db->open();
            $db->delete($this->clearnData($_POST['lm_link_id']));
            $db->save();            
        } 

        function savedisplay(){
            $db=new LinkMarketDb();
            $db->db_dir=$this->db_path; 
            $db->db_file=$this->db_path.DIRECTORY_SEPARATOR.'lm_'.LM_APP_ID.'_display.txt';            
            $db->saveDisplayFormat($this->clearnData($_POST['lm_json_display']));            
        }

        function getCurentPageCode(){

            $uri=@$_SERVER['REQUEST_URI'];
            if(empty($uri) || $uri[0]!='/'){
                $url='/'.$uri;
            }else{
                $url=$uri;
            }
            $code= sha1(base64_encode($url));
            /*            if(!is_file($this->db_path.'/'.$code.'.txt')){
            $redirect_code=@$_SERVER['REDIRECT_STATUS'];
            $redirect_url=@$_SERVER['REDIRECT_URL'];
            $redirect_query_string=@$_SERVER['REDIRECT_QUERY_STRING']; 
            if($redirect_code==200){ 
            if(empty($redirect_url) || $redirect_url[0]!='/'){
            $url = '/' . $redirect_url;    
            }else{
            $url=$redirect_url;
            if(empty($redirect_query_string) OR $redirect_query_string=''){

            }else{
            $url.='?'.$redirect_query_string;
            }    
            }
            $code= sha1(base64_encode($url));    
            }   
            }  */
            return $code;
        }

        function display(){                                                    
            $db=new LinkMarketDb();
            $db->db_dir=$this->db_path;
            $db->db_file=$this->db_path.DIRECTORY_SEPARATOR.$this->curent_page_code.'.txt'; 
            $db->open();
            $result=''; 

            $file=$this->db_path.DIRECTORY_SEPARATOR.'lm_'.LM_APP_ID.'_display.txt';  
            $config=json_decode(file_get_contents($file),true);
            $layout='';
            if(count($db->links)){
                if($config['display']=='left' ){
                    $layout_size_item=100;
                }else{
                    $layout_size_item=$config['width']-3;
                }
                $layout.= '<div id="linkmarket" style="width:'.$config['width'].'px; border: 1px solid '.$config['colorBorder'].'; padding:0 0 8px 8px; background: '.$config['colorLayout'].'; margin: left; text-align: left;">';
                foreach($db->links as $link){
                    $l='<a target="_blank" style="color:'.$config['colorAnchortext'].';font-size:'.$config['fontsize'].'px; line-height:18px;" href="'.$link['link_url'].'">'.$link['link_anchortext'].'</a>';

                    $desc=($config['advert']?$link['link_desc']:'');   
                    if($desc!=''){
                        $d=strtolower($desc);
                        if(strpos($d,'@@link')!==false){
                            $layout.='
                            <div style="background: transparent; border: none; width: '.$layout_size_item.'px; float:'.$config['display'].'; font-family:'.$config['font'].', sans-serif; font-size:'.$config['fontsize'].'px; line-height:18px; margin:0 10px 0 0; padding: 0; overflow:hidden; color: '.$config['colorDesc'].'">                            
                            '.preg_replace('/@@Link/i',$l,$desc).'
                            </div>
                            ';      
                        }else{
                            $layout.='
                            <div style="background: transparent; border: none; width: '.$layout_size_item.'px; float:'.$config['display'].'; font-family:'.$config['font'].', sans-serif; font-size:'.$config['fontsize'].'px; line-height:18px; margin:0 10px 0 0; padding: 0; overflow:hidden; color: '.$config['colorDesc'].'">
                            '.$l.'
                            <br/>
                            '.$desc.'
                            </div>
                            ';
                        }  
                    }else{
                        $layout.='
                        <div style="background: transparent; border: none; width: '.$layout_size_item.'px; float:'.$config['display'].'; font-family:'.$config['font'].', sans-serif; font-size:'.$config['fontsize'].'px; line-height:18px; margin:0 10px 0 0; padding: 0; overflow:hidden; color: '.$config['colorDesc'].'">
                        '.$l.'  
                        </div>';
                    }

                }            
                $layout.='<div style="clear: both;"></div>
                </div>';
            }
            if(isset($_POST['lm_checkdisplay']) && isset($_POST['lm_link_anchortext']) && isset($_POST['lm_link_url'])){
                if($this->getCurentPageCode()==$_POST['lm_page_code']) $layout.='<a href="'.$this->clearnData($_POST['lm_link_url']).'">'.$this->clearnData($_POST['lm_link_anchortext']).'</a>';
            }
            return $layout;
        }

        function superentities( $str ){
            $str2='';
            // get rid of existing entities else double-escape
            $str = html_entity_decode(stripslashes($str),ENT_QUOTES,'UTF-8');
            $ar = preg_split('/(?<!^)(?!$)/u', $str );  // return array of every multi-byte character
            foreach ($ar as $c){
                $o = ord($c);
                if ( (strlen($c) > 1) || /* multi-byte [unicode] */
                ($o <32 || $o > 126) || /* <- control / latin weirdos -> */
                ($o >33 && $o < 40) ||/* quotes + ambersand */
                ($o >59 && $o < 63) /* html */
                ) {
                    // convert to numeric entity
                    $c = mb_encode_numericentity($c,array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
                }
                $str2 .= $c;
            }
            return $str2;
        }

        function disableMagicQuotes () {
            if (get_magic_quotes_runtime () && !set_magic_quotes_runtime (false)) {
                @ini_set ('magic_quotes_runtime', 0);
            }
        }

        function getrootdir(){
            echo realpath(dirname(__FILE__));
        }

        function clearnData($source){
            if(!is_array($source)){ 
                return (get_magic_quotes_gpc()?stripslashes($source):$source);}
            else {
                return $source;
            }
        }

        private function isOtp($token){
            $t=time();          
            $time= substr($t,0,8);
            if(MD5(LM_APP_SECRET.$time)==$token){
                return true;
            }   
            $time= substr($t-100,0,8);
            if(MD5(LM_APP_SECRET.$time)==$token){
                return true;
            }
            $time= substr($t+100,0,8);
            if(MD5(LM_APP_SECRET.$time)==$token){
                return true;
            }

            return false;
        }

    }

    class LinkMarketDb{
        var $db_dir;
        var $db_file;
        var $page_code;
        var $links=array();

        function open(){
            $result=array();   
            if(file_exists($this->db_file)){       
                $handle = fopen($this->db_file, 'r');
                $i=1;
                while ( ($line = fgets($handle)) !== false) { 
                    $link=json_decode($line,true); 
                    if($link)
                        $result[$link['link_id']]=array(
                        'line_content'=>$line,
                        'line'=>$i,
                        'link_id'=>$link['link_id'],
                        'link_url'=>$link['link_url'],
                        'link_anchortext'=>$link['link_anchortext'],
                        'link_title'=>$link['link_title'],
                        'link_desc'=>$link['link_desc'],
                        );                   
                    $i++;
                };


                fclose($handle);
            }else{

            }
            $this->links=$result;     
        }

        function getData(){
            return $this->links;
        }

        function delete($link_id){
            $link_id=(int)$link_id;      
            if(isset($this->links[$link_id])){
                unset($this->links[$link_id]);            
            }

        } 

        function insert($link_id,$link_json){
            $link_id=(int)$link_id;    
            $this->links[$link_id]['line_content']=$link_json;  
        } 

        function save(){ 
            $handle = fopen($this->db_file,'w+');            
            foreach($this->links as $key=>$link){
                if($key){
                    fwrite($handle,$link['line_content']."\n"); 
                } 
            }                 
            fclose($handle);
            chmod ($this->db_file, 0666);
        }

        function saveDisplayFormat($json_conf){
            if($handle = fopen($this->db_file,'w+')){
                fwrite($handle,$json_conf);  
                fclose($handle);
                chmod ($this->db_file, 0666);
                return true;
            }
            return false;
        }        

        function checkDbPermissions(){

            $result = true;
            if(file_exists($this->db_file)){
                if (!is_writable ($this->db_file) || !is_readable ($this->db_file)) {
                    $result = chmod ($this->db_file, 0666);
                    clearstatcache ();
                }
            }

            if (!is_writable ($this->db_dir) || !is_readable ($this->db_dir)) {
                if(is_dir($this->db_dir)){                    
                    $result = chmod ($this->db_dir, 0774);
                    clearstatcache ();
                }else{
                    $result=false;
                }

            }
            #echo var_dump($result);
            return $result;    
        }

    }
?>