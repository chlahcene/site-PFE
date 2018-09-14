<?php
	const LIENFILE = __DIR__.'/';
	/**
	 * donne tous le pdf en chine de caractere
	 * @param $pathToPdf
	 *
	 * @return string
	 */
	function pdfToString($pathToPdf){
		if (is_string($pathToPdf)){
			$parser = new \Smalot\PdfParser\Parser();
			$pdf    = $parser->parseFile(LIENFILE.''.$pathToPdf);
			$text = $pdf->getText();
			return $text;
		}else null;

	}

	/**
	 * @param $pathToPdf
	 * @param $pathToFileTextToCreat
	 */
	function pdfToFichierText($pathToPdf,$pathToFileTextToCreat){
		if (is_string($pathToPdf) && is_string($pathToFileTextToCreat)){
			$parser = new \Smalot\PdfParser\Parser();
			$pdf    = $parser->parseFile(LIENFILE.''.$pathToPdf);
			$text = $pdf->getText();
			$file = fopen(LIENFILE.''.$pathToFileTextToCreat, "w");
			if ($file){
				if(fwrite($file, $text) === FALSE){
					fclose($file);
					return false;
				}
				fclose($file);
				return true;
			}

		}else false;
	}

	/**
	 * @param $pathToPdf
	 *
	 * @return array
	 * @throws Exception
	 */
	function pdfGetPageArray($pathToPdf){
		if (is_string($pathToPdf)){
			$parser = new \Smalot\PdfParser\Parser();
			$pdf    = $parser->parseFile(LIENFILE.''.$pathToPdf);
			$pages  = $pdf->getPages();
			$pagetext = [];
			foreach ($pages as $page) {
				$pagetext[] = $page->getText();
			}

			return $pagetext;
		}else null;

	}

	/**
	 * @return array
	 *             Author, Creator, CreationDate
	 *
	 * @param $pathToPdf
	 *
	 * @return array
	 */
	function pdfGetDetails($pathToPdf){
		if (is_string($pathToPdf)){
			$parser = new \Smalot\PdfParser\Parser();
			$pdf    = $parser->parseFile(LIENFILE.''.$pathToPdf);
			$details  = $pdf->getDetails();
			$textDetail = [];
			foreach ($details as $property => $value) {
				if (is_array($value)) {
					$value = implode(', ', $value);
				}
				$textDetail [$property] = $value ;
			}

			return $textDetail;
		}else null;

	}
	function entre2string($str,$str1,$str2 =null ){
		/*if (is_string($str) && is_string($str1) && is_string($str2)){
			$res = "";
			$i = 0;
			if (false !== $pos = strpos($str, $str1)) {	
				$i = $pos + strlen($str1);
		}
			$j = 0;
			if (false !== $pos = strpos($str, $str2)) {	
				echo "sffffffffff",$pos;
				$j = $pos;
				 $res = substr($str, $i, $j);
			}elseif ($i == 0) {
				return null;
		}else $res = substr($str, $i);
						var_dump($i,$j,$res);
				die();
			return $res;

		}
		return null;*/
		if (is_string($str) && is_string($str1)){			
			if ($str2 == null){
				if (false !== $pos = strpos($str, $str1)) {	
					$i = $pos + strlen($str1);
					return substr($str, $i);
				}else return null;
				/*$pieces = explode($str1, $str);
				echo "ffffffffffffffffffffffffff";
				var_dump($pieces);
				die();
				if (isset($pieces[-1]))
					return 	$pieces[-1];
				else return null;
				*/

			}elseif(is_string($str2)){

				$pieces = explode($str1, $str);
				if (isset($pieces[1])){

					$pieces = explode($str2, $pieces[1]);
					if (isset( $pieces[0])) {
					return $pieces[0];
					}
					
				}
			}
		}
		return null;
		
	}
	function stringToArraySujet($str){
		/**
		if (false !== $pos = strpos($uri, '?')) {
		$uri = substr($uri, 0, $pos);
}
		**/
		$str = strtolower($str);
		$res =array();
		if (is_string($str)){
			if (null !== $tmp = entre2string($str,"annee universitaire","code pfe")) {
				$res["ANNEE UNIVERSITAIRE"]=$tmp;
		}
			if (null !== $tmp = entre2string($str,"code pfe","titre")) {
				$res["CODE"]=$tmp;
				$res["isMaster"] = false;
			}
			if (null !== $tmp = entre2string($str,"code master","titre")) {
				$res["CODE"]=$tmp;
				$res["isMaster"] = true;
			}			
			if (null !== $tmp = entre2string($str,"titre","etudiant")) {
				$res["TITRE"]=$tmp;
			}
			if (null !== $tmp = entre2string($str,"mots clés")) {
				$res["MOTS CLES"]=$tmp;				
			}
	}
	//var_dump($res);
	//die();
	return $res;
}