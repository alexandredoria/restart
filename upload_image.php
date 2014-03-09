<?php
	$mimeExt = array();
	$mimeExt['image/jpeg'] ='.jpg';
	$mimeExt['image/pjpeg'] ='.jpg';
	$mimeExt['image/bmp'] ='.bmp';
	$mimeExt['image/gif'] ='.gif';
	$mimeExt['image/x-icon'] ='.ico';
	$mimeExt['image/png'] ='.png';
	//$error = $default_file = array();
	//$default_file["size"] = 106883; // Maximum file size (bytes)
	//$default_file["width"] = 350; // Maximum file width (pixels)
	//$default_file["height"] = 180; // Maximum file height (pixels)
	if(isset($_FILES["avatar"])) {
		/**if(array_intersect_key($mimeExt, $_FILES["avatar"]["type"])) { //Checks new file's type with the allowed mimetypes
			$error[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
		} else { //Checks new file's size with the default file's size
			if($_FILES["avatar"]["size"] > $default_file["size"]) {
				$error[] = "Arquivo em tamanho muito grande! A imagem deve ser de no máximo ".$default_file["size"]." bytes.
				Envie outro arquivo";
			} //Checks new file's dimensions with the default file's dimensions
			$sizes = getimagesize($_FILES["avatar"]["tmp_name"]);
			if($sizes[0] > $default_file["width"]) {
				$error[] = "Largura da imagem não deve ultrapassar ".$default_file["width"]." pixels";
			}
			if($sizes[1] > $default_file["height"]) {
				$error[] = "Altura da imagem não deve ultrapassar ".$default_file["height"]." pixels";
			}
		} //Print errors
		if(sizeof($error)) {
			foreach($error as $err) {
			echo " - ".$err."<br>";
		}
		} else { **///Begins image upload
			/*//---------REDIMMENSIONA IMAGENS------------------//
			require('wideimage/lib/WideImage.php');
			$avatar50 = md5(uniqid(time())).$mimeExt[$_FILES["avatar"]["type"]]; //Get image extension
			$avatar_dir50 = "img/".$avatar50; //Path file
			// Carrega a imagem a ser manipulada
			$image = wiImage::load($avatar_dir50);
			// Redimensiona a imagem
			$image = $image->resize(400, 300);
			// Salva a imagem em um arquivo (novo ou não)
			$image->saveToFile($avatar_dir50);*/
			/*//---------CORTA IMAGENS------------------//
			require('wideimage-11.02.19-full.zip/lib/WideImage.php');
			// Carrega a imagem a ser manipulada
			$image = wiImage::load('/caminho/foto.jpg');
			// Corta a imagem (Argumentos: X1, Y1, X2, Y2)
			$image = $image->crop(10, 20, 110, 120);
			// Faz um quadrado da posição [X1;Y1] até [X2;Y2]
			// Salva a imagem em um arquivo (novo ou não)
			$image->saveToFile('/caminho/nova_foto.jpg');
			//---------MUDADNDO A QUALIDADE DAS IMAGENS------------------//
			// Carrega a imagem a ser manipulada
			$image = wiImage::load('/caminho/foto.jpg');
			// Salva a imagem em um arquivo com 80% de qualidade
			$image->saveToFile('/caminho/nova_foto.jpg', null, 80);
			*/
			$avatar = md5(uniqid(time())).$mimeExt[$_FILES["avatar"]["type"]]; //Get image extension
			$avatar_dir = "img/".$avatar; //Path file
			move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatar_dir);
	 //}
	} else {
		$avatar = "default_130x130.png";
	}
?>