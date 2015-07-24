<?

function SobeImagem($nomeimg, $nomeimg_temp, $pasta){
	
	$imagem 		= $nomeimg; 		//$_FILES['txtimagem']['name'];
	$imgtemp 		= $nomeimg_temp; 	//$_FILES['txtimagem']['tmp_name'];
	
	$file_info = pathinfo($imagem);
	$novonome = md5($imagem . date('G:i:s')) .'.'. $file_info['extension'];
	$destino = $pasta . $novonome;
	
	
	if(move_uploaded_file($imgtemp, $destino)){
		return $novonome;
	}else{
		return null;
	};
	
	
}
function RemoveImagem($nomeimg){
	if(file_exists($nomeimg)){
		if(unlink($nomeimg)){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

?>