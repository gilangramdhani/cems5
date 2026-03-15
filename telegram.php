<?php
function telegram($chat_id, $pesan) {
	$API = 'https://api.telegram.org/bot2117533667:AAGyJCz86_DfrBSkLZUpFccJwU6UhmN0rLE/sendmessage?chat_id='.$chat_id.'&text='.$pesan;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_URL, $API);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
telegram('1694206291', 'mas, ribut yuk mas.');
?>