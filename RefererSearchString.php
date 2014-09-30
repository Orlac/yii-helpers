<?php
namespace application\helpers;

class RefererSearchString{
        
        private static $_instance = null;
        public static function instance(){
            if( !self::$_instance ){
                self::$_instance = new RefererSearchString();
            }
            return self::$_instance;
        }
        
        private function param( $name, $refer ){
            parse_str($refer, $output);
            if( $querystring = \CArray::element($name, $output) ){
                    $keywords = explode('+',$querystring);  
                    return $keywords; 	
            } 
        }
        
        public function getWords(){
            $url = \Yii::app()->request->urlReferrer;
            //$url = 'http://yandex.ru/yandsearch?text=салоны красоты&lr=193';
            //$url = 'http://yandex.ru/yandsearch?text=456464&lr=193';
            //$url = 'http://yandex.ru/yandsearch?text=салоны&lr=193&msid=22886.17849.1356447518.32082';
            //$url = 'http://bing.com/search?q=%D1%81%D0%B0%D0%BB%D0%BE%D0%BD%D1%8B&x=81&y=20&form=MSNH81&mkt=ru-ru';
                    //$url = 'http://go.mail.ru/search?mailru=1&q=%D1%81%D0%B0%D0%BB%D0%BE%D0%BD%D1%8B';
            if( $refer = parse_url($url) ){
                //print_r($refer);
                $host = \CArray::element( 'host', $refer );  
                $refer = \CArray::element( 'query', $refer ) ;

                switch($host){
                    case is_int( strpos($host,'google') ) :
                                            return $this->param('q', $refer);
                        break;
                    case is_int( strpos($host,'yahoo') ) :
                                            return $this->param('p', $refer);
                        break;
                    case is_int( strpos($host,'bing') ) :
                        return $this->param('q', $refer);
                        break;
                                    case is_int( strpos($host,'mail') ) :
                        return $this->param('q', $refer);
                        break;
                    case is_int( strpos( $host,'yandex') ) :
                                            return $this->param('text', $refer);
                        break;
                }
            }
            return null;
        }
    
}