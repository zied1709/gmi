<?php
function uploadImages($file) {
    $name_file = $file;
    if(isset($_FILES[$file])){
        $tmpName = $_FILES[$file]['tmp_name'];
        $name = $_FILES[$file]['name'];
        $size = $_FILES[$file]['size'];
        $error = $_FILES[$file]['error'];
    
        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
    
        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $maxSize = 40000000;
    
        if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
    
            $uniqueName = uniqid('', true);
            //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
            $file = $uniqueName.".".$extension;
            //$file = 5f586bf96dcd38.73540086.jpg
            return array($file,$tmpName);
        }
    else{
        return null;
    }
        
    }
}
?>