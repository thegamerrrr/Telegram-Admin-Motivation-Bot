<?php

/*
    TGAdminMotivationBot
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

$content = file_get_contents("php://input");
$update = json_decode($content, true);
include 'sendRequest.php'; // Include the sendRequest file

$msg = $update['message']['text']; // Text of the sended message
$msgID = $update['message']['message_id']; // ID of the sended message
$caption = $update['message']['caption']; // Text in the media file
//$cbdata = $update["callback_query"]["data"]; // Message of the query

// User Vars
if (isset($update['message']['from'])) {
	$exists_user = true;
	$user_id = $update['message']['from']['id']; // ID of the user who sent the message
	$user_first_name = $update['message']['from']['first_name']; // First name of the user who sent the message
	$user_surname = $update['message']['from']['last_name']; // Last name of the user who sent the message
	$user_username = $update['message']['from']['username']; // Username of the user who sent the message
	$user_lang = $update['message']['from']['language_code']; // Language of the user who sent the message
}

// Chat Vars
$chat_id = $update['message']['chat']['id'];  // ID of the group/channel
$typechat = $update['message']['chat']['type']; // Type of the chat (group, supergroup, channel, private)
$title = $update['message']['chat']['title']; // Title of the chat

global $alias;
############# Telegram API Methods #############

// Invio messaggi | sendMessage
function sm($chatID, $text = "ᅠ", $rmf = false, $pm = 'def', $reply = false, $dislink = true, $inline = true) {
	global $api;
	global $config;

	if ($pm === 'def') {
		$pm = 'HTML';
	}
	
	$args = [
		'chat_id' => $chatID,
		'text' => $text,
		'disable_web_page_preview' => $dislink,
	];

	if (is_array($pm) and !empty($pm)) {
		$args['entities'] = json_encode($pm);
	} else {
		$args['parse_mode'] = $pm;
	}

	if ($rmf == 'replyme') {
		$rm = [
			'force_reply' => true,
			'selective' => true
		];
	} elseif ($rmf == 'hide') {
		$rm = [
			'hide_keyboard' => true
		];
	} elseif (!$inline) {
		$rm = [
			'keyboard' => $rmf,
			'resize_keyboard' => true
		];
	} else {
		$rm = [
			'inline_keyboard' => $rmf
		];
	}
	if ($rmf) {
		$args['reply_markup'] = json_encode($rm);
	}
	if ($reply) {
		$args['reply_to_message_id'] = $reply;
	}
	
	$rr = sendRequest("https://api.telegram.org/bot$api/sendMessage", $args);
	$ar = json_decode($rr, true);
	if (isset($ar["error_code"])) {
		sm($admin, "sendMessage \n<b>INPUT</b>: " . code(json_encode($args)) . " \n<b>OUTPUT:</b> " . $ar['description'],);
	}
	return $ar;
}

// Delete a message | deleteMessage Method
function dm($chatID, $msgID) {
	global $br, $hr, $api;
	$args = [
		'chat_id' => $chatID,
		'message_id' => $msgID,
	];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot$api/deleteMessage");
	curl_setopt($ch, CURLOPT_POST, 1);   
	curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
	curl_exec($ch);
	curl_close($ch);
	$ar = json_decode($ch, true);
	return $br;
}

# Commands
if (in_array($msg[0], $alias) and $msg) {
    $messageType = "command";
    $cmd = substr($msg, 1, strlen($msg));
}