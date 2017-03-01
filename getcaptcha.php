<?php

define('COOKIELOCAL', str_replace('\\', '/', realpath('./')).'/'.'cookies_cnpj/');
@session_start();
        
$cookieFile = COOKIELOCAL.session_id();
// cria arquivo onde será salva a sessão com a receita
if(!file_exists($cookieFile))
{
	$file = fopen($cookieFile, 'w');
	fclose($file);
}
	
$url = 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/captcha/gerarCaptcha.asp';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
// não utilizar returntransfer , este script replica imagem captcha da receita
$imgsource = curl_exec($ch);
curl_close($ch);

if(!empty($imgsource))
{
	$img = imagecreatefromstring($imgsource);
	header('Content-type: image/jpg');
	imagejpeg($img);
}

?>