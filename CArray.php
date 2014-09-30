<?php
class CArray{
    
    public static function element($key, array $arr, $default = null){
        return (isset( $arr[$key] ) )? $arr[$key] : $default;
    }

    public static function getFirstElementByParams(array $models, $params, $default=null){
        $element=$default;
        foreach($models as $item){
            $found=null;
            foreach($params as $pKey=>$pVal){
                if(!isset($item->$pKey) || $item->$pKey!=$pVal){
                    $found=false;
                    break;
//                    $found=false;
                } else {
                    $found=true;
//                    $element=$item;
//                    break 2;
                }
            }
            if($found===true){
                $element=$item;
                break;
            }
        }
        return $element;
    }
    
    public static function toAssoc(array $models, $key = 'id', $value = null, $callback = ''){
        $assoc = array();
        while( $item =  array_shift($models)){
            //echo $item->name;
            if($value !== null){
                $assoc[$item->$key] =  $item->$value;
            }elseif($callback !== ''){
                $assoc[$item->$key] =  $callback($item);
            }else{
                $assoc[$item->$key] = $item;
            }
            //$assoc[$item->$key] =  ($value !== null)? $item->$value : ($callback)? $callback($item) : $item;  
        }
        return $assoc;
    }

    public static function toAssocArray(array $items, $key = 'id', $value = null, $callback = ''){
        $assoc = array();
        while( $item =  array_shift($items)){
            //echo $item->name;
            if($value !== null){
                $assoc[$item[$key]] =  $item[$value];
            }elseif($callback !== ''){
                $assoc[$item[$key]] =  $callback($item);
            }else{
                $assoc[$item[$key]] =  $item;
            }
            //$assoc[$item->$key] =  ($value !== null)? $item->$value : ($callback)? $callback($item) : $item;
        }
        return $assoc;
    }

    public static function arrayRecursiveDiff($aArray1, $aArray2) {
        $aReturn = array();

        foreach ($aArray1 as $mKey => $mValue) {
            if (array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = self::arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                    if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
                } else {
                    if ($mValue != $aArray2[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {
                $aReturn[$mKey] = $mValue;
            }
        }
        return $aReturn;
    }
    
    public static function filterRecursive(Array $source, $fn=null){
        $result = array();
        foreach ($source as $key => $value) {
            if (is_array($value)) {
                $result[$key] = self::filterRecursive($value, $fn);
                continue;
            }
            if(is_callable($fn)){
                $res = call_user_func($fn, $key, $value);
                if ($res) {
                    $result[$key] = $value; // KEEP
                    continue;
                }
            }
        }
        if($fn){
            return array_filter( $result, $fn );
        }else{
            return array_filter( $result);
        }
        
    }
    
}
