<?php

@$content = file_get_contents('http://localhost:4040/status');
$post = strpos($content, 'comand_line\":{\"URL\":\"', '', $content);
$content  = substr($content, $pos);
$pos = strpos($content, '\",\"Proto\":\"https');
$content = substr($content, 0, $pos);
$content = str_replace('comand_line\":{\"URL\":\"', '', $content);

$token = '546927564:AAFJzy7vHWAqzEmoyQeurKwNDwtggh2s23E';
$url = 'https://api.telegram.org/bot'.$token.'/setWebhook?url='.$content.'/bot.php';

@$data = file_get_contents($url);