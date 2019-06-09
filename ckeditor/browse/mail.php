<?php  
header("Content-Type: text/html; charset=utf-8\n");  
header("Cache-Control: no-cache, must-revalidate\n");  
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");  
$dim = 150;
$cols = 4;
$folder = '';
if(isset($_GET['folder'])){
	$folder = filter_input(INPUT_GET, "folder", FILTER_SANITIZE_STRING);
}
?>  
<!DOCTYPE html>  
<html>  
<head>  
    <title>browse file</title>  
    <meta charset="utf-8">
    <style>  
        html,  
        body {padding:0; margin:0; background:black; }  
        table {width:100%; border-spacing:15px; }  
        td {text-align:center; padding:5px; background:#181818; }  
        img {border:5px solid #303030; padding:0; verticle-align: middle;}  
        img:hover { border-color:blue; cursor:pointer; }  
    </style>  
</head>  
<body>  
<table>  
<?php   
$dir = $_SERVER['DOCUMENT_ROOT'].'/media/pages'.$folder;  
$files = scandir($dir, 1);  
$images = array(); 
if ($folder != ''){
	$images[] = '<img src="/static/img/back.png" width=150 alt="back">';
}
foreach($files as $file){

	if( !preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)){
		
		if($file != '..' && $file != '.'){

			$images[] = '<img src="/static/img/folder.png" width=150 alt="folder" title="'.$file.'">';
		}
		
	}
	else{
		$thumbSrc =$_SERVER['DOCUMENT_ROOT'].'/media/mkamzina/' .$folder.'/'. $file;  
		$fileBaseName = str_replace('_th.','.',$file);  
		$imgSrc = '/media/mkamzina' .$folder.'/'. $file; 
		$image_info = getimagesize($thumbSrc);  
		$_w = $image_info[0];  
		$_h = $image_info[1]; 
		if( $_w > $_h ) { 
			$a = $_w;  
			$b = $_h;  
		} else {  
			$a = $_h;  
			$b = $_w;  
		} 
		$pct = $b / $a;
		if( $a > $dim )   
			$a = $dim;
		$b = (int)($a * $pct);
		$width =    $_w > $_h ? $a : $b;  
		$height =   $_w > $_h ? $b : $a; 
		$str =  sprintf('<img src="%s" width="%d" height="%d" title="%s" alt="image">',   
			$imgSrc,  
			$width,  
			$height,  
			$fileBaseName  
		);  
		$images[] = str_replace("'", "\\'", $str);
	}  

}
$numRows = floor( count($images) / $cols );  
if( count($images) % $cols != 0 )  
    $numRows++;  
for($i=0; $i<$numRows; $i++)
    echo "\t<tr>" . implode('', array_fill(0, $cols, '<td></td>')) . "</tr>\n\n";  
?>  
</table>  
<script>  
images = [  
<?php   
foreach( $images as $v)  
    echo sprintf("\t'%s',\n", $v);  
?>];  
folder = "<?php echo $folder;?>";
tbl = document.getElementsByTagName('table')[0];  
td = tbl.getElementsByTagName('td');  
for(var i=0; i < images.length; i++)  
    td[i].innerHTML = images[i];  
tbl.onclick =   
    function(e) {  
        var tgt = e.target || event.srcElement,  
            url;  
        if( tgt.nodeName != 'IMG' )  
            return;  
		if(tgt.alt == "image"){
			url = 'http://yoga.loc/media/' + folder + tgt.title;  
			this.onclick = null;  
			window.opener.CKEDITOR.tools.callFunction(<?php echo $_GET['CKEditorFuncNum']; ?>, url);  
			window.close(); 
		}
		else if(tgt.alt == "folder"){
			if(location.href.indexOf("&folder") > 0){
				url = location.href.substring(0, location.href.indexOf("&folder"));				
			}
			else{
				url = location.href;
			}			
			url = url+"&folder="+folder+"/"+tgt.title;			
			location.href = url;
		}
		else if(tgt.alt == "back"){
			folder = folder.substring(0, folder.lastIndexOf("/"));
			if(location.href.indexOf("&folder") > 0){
				url = location.href.substring(0, location.href.indexOf("&folder"));				
			}
			else{
				url = location.href;
			}			
			url = url+"&folder="+folder;			
			location.href = url;
		}
    }  
</script>  
</body>  
</html>     