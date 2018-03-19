<?php

class Features
{
	public function getCourse() 
	{

	    $json_daily_file = __DIR__.'/daily.json';
	    if (!is_file($json_daily_file) || filemtime($json_daily_file) < time() - 3600) {
	        if ($json_daily = file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js')) {
	            file_put_contents($json_daily_file, $json_daily);
	        }
	    }

    	$data = json_decode(file_get_contents($json_daily_file));

    	return "Обменный курс USD по ЦБ РФ на сегодня: {$data->Valute->USD->Value}";
	}

	public function setValues() 
	{	
		// connect to database
		$mysqli = new mysqli('localhost', 'root', '', 'telegram');
		if (!empty($mysqli->connect_errno)) {
		    throw new \Exception($mysqli->connect_error, $mysqli->connect_errno);
		}	 

		$query = "
		       INSERT INTO  `test` (`ID`, `MONEY`, `AMOUNT`)
		       VALUES (1, 777, 333)    
		";

		if($mysqli->query($query))
			return 'Данные успешно добавлены';
		return 'Данные не добавлены';
	}


	public function getUsers($bot) 
	{	
		$users = Array();

		$result = $telegram->getWebhookUpdates(); 

    	foreach ($result as $message) {
    		$user = $message['from']['username'];
    		array_push($users, $user);
    	}

		return $users;
	}

	public function translation() 
	{	
		$translator = new \Yandex\Translate\Translator;

	    $text = file_get_contents($message['text']);
		$message_response = $translator->yandexTranslate('ru', 'uk', $text);

	    $bot->sendMessage(377854547, $message_response);
	}
}