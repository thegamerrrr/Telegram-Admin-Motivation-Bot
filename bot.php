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

include 'functions.php'; // Include the functions file
$api = urldecode($_GET['key']); // Get the Token from the URL
$alias = ['/', '.']; // Array of characters to replace in the message
$error_log_chat = 535966623; // ID of the chat where to send the error log
$admin = [
    535966623 // Insert your Telegram ID here
];
$log_channel = 535966623; // ID of the chat where to send the report logs
$staff_group = 535966623; // ID of the staff chat where to send the report

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('ignore_repeated_errors', 1);

// COMMANDS //

if($cmd == 'start' and $typechat == 'private'){
    $menu[] = [['text' => '📣 Dev Channel','url' => 't.me/BotsOfGamer']];
    sm($chat_id, "Hi, with this bot, only when the @admin command have a reason will be sent", $menu);
}

if(in_array($typechat, ['group', 'supergroup'])){
    
    if(strpos($msg, '@admin')===0){
        if(isset(explode(' ', $msg, 2)[1])){
            $menu[] = [['text' => 'Delete Message','callback_data' => 'del']];
            $r = sm($chat_id, "<i>Report Sent</>", $menu);
            $m = sm($chat_id, "a ". json_encode($r, JSON_PRETTY_PRINT), $menu2);
            if($m['ok'] == false){
                sm($chat_id, "Error: " . json_encode($update, JSON_PRETTY_PRINT), $menu2);
            }
            if(isset($log_channel)) sm($log_channel, "🆘 Invoked method <b>*.Internal.AdminReport</>\n∟ chat_id: <code>$chat_id</>\n∟ user_id: <code>$user_id</>\n∟ to_user_id: <code>" . $update['message']['reply_to_message']['from']['id'] . "</>\n∟ reason: <code>" . explode(' ', $msg, 2)[1] . "</>");
            if(isset($staff_group)){
                sm($id, "⚠️ <b>ATTENTION</>\n\n<a href='tg://user?id=" . $user_id . "'>$user_id</> requested the intervention of the staff in the group " . $title ."\n\n📝 Reason: " . explode(' ', $msg, 2)[1] . "\n👀 <a href='https://t.me/c/" . str_replace('-100', '', $chat_id) . "/". $msgID ."'><i>Go to the message...</></>");
            }else{
                foreach($admin as $id){
                    sm($id, "⚠️ <b>ATTENTION</>\n\n<a href='tg://user?id=" . $user_id . "'>$user_id</> requested the intervention of the staff in the group " . $title ."\n\n📝 Reason: " . explode(' ', $msg, 2)[1] . "\n👀 <a href='https://t.me/c/" . str_replace('-100', '', $chat_id) . "/". $msgID ."'><i>Go to the message...</></>");
                }
            }
        }else{
            $r = sm($user_id, "❌ <i>You have to write the reason of the report</>", $menu);
            if($r['ok'] == false){
                sm($chat_id, "❌ <i>You have to write the reason of the report</>", $menu);
            }
        }
        die;
    }
    
    
    if($update['callback_query']){
        sm(535966623, "jj");
    }
    sm(535966623, "a: " . json_encode($update, JSON_PRETTY_PRINT), $menu2);
    
    if($cbdata == 'del' and in_array($user_id, $admin)){
        sm($chat_id, "si", $menu);
        dm($chat_id, $msgID);
    }
}