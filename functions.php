<?php

/*
    TelegramAdminMotivationBot
    Copyright (C) 2022  thegamerrr and BotsOfGamer
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

// Telegram Vars

$msg = $update['message']['text']; // Text of the sended message
$msgID = $update['message']['message_id']; // ID of the sended message
$caption = $update['message']['caption']; // Text in the media file

$userID = $update['message']['from']['id']; // ID of the user who sent the message
$chatID = $update['message']['chat']['id'];  // ID of the group/channel
$typechat = $update['message']['chat']['type']; // Type of the chat (group, supergroup, channel, private)
global $alias;
// Telegram API Methods

function sm($chatID, $text, $menu = 'def') {
	global $br, $hr, $api;
	$args = [
		'chat_id' => $chatID,
		'text' => $text,
		'parse_mode' => "HTML",
	];

	if($menu != 'def') {
		$rm = [
			'inline_keyboard' => $menu
		];
	}
	if ($menu) {
		$args['reply_markup'] = json_encode($rm);
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot$api/sendMessage");
	curl_setopt($ch, CURLOPT_POST, 1);   
	curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
	curl_exec($ch);
	curl_close($ch);
	$ar = json_decode($ch, true);
	return $br;
}

# Comandi
if (in_array($msg[0], $alias) and $msg) {
    $messageType = "command";
    $cmd = substr($msg, 1, strlen($msg));
}