<?php

require_once 'vendor/autoload.php';
require_once 'Features.php';

	// create a bot
	$bot = new \TelegramBot\Api\Client('546927564:AAFJzy7vHWAqzEmoyQeurKwNDwtggh2s23E');
	// run, bot, run!

	$features = new Features();

	$bot->command('course', function ($message) use ($bot) {
	    $message_response = $features->getCourse();
	    $bot->sendMessage(377854547, $message_response);
	});

	$bot->command('set', function ($message) use ($bot) {
	    $message_response = $features->setValues();
	    $bot->sendMessage(377854547, $message_response);
	});

	$bot->command('users', function ($message) use ($bot) {
	    $users = $features->getUsers($bot);

	    $message_response = null;

	    foreach ($users as $user) {
	    	$message_response = $message_response.'username: '.$user.'\n';
	    }

	    $bot->sendMessage(377854547, $message_response);
	});

	$bot->command('translation', function ($message) use ($bot) {
		$message_response = $features->translation($bot);

		$bot->sendMessage(377854547, $message_response);
	});

	$bot->run();