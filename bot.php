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

include 'functions.php'; // Include the functions file
$api = urldecode($_GET['key']); // Get the Token from the URL
$alias = ['/', '.']; // Array of characters to replace in the message
$admin = [
    535966623 // Insert your Telegram ID here
];
$log_channel = -100123456789; // ID of the chat where to send the report logs
$staff_group = -100123456789; // ID of the staff chat where to send the report


if($cmd == 'start' and $typechat == 'private'){
    $menu[] = [['text' => '📣 Dev Channel','url' => 't.me/BotsOfGamer']];
    sm($chat_id, "Hi, with this bot, only when the @admin command have a reason will be sent", $menu);
}

if(in_array($typechat, ['group', 'supergroup'])){

    if(strpos($msg, '@admin')===0 and !in_array($user_id, $admin)){
        if(isset(explode(' ', $msg, 2)[1])){
            sm($chat_id, "<i>Report Sent</>");
            if(isset($log_channel)) sm($log_channel, "🆘 Invoked method <b>*.Internal.AdminReport</>\n∟ chat_id: <code>$chat_id</>\n∟ user_id: <code>$user_id</>\n∟ reason: <code>" . explode(' ', $msg, 2)[1] . "</>");
            if(isset($staff_group)){
                sm($id, "⚠️ <b>ATTENTION</>\n\n<a href='tg://user?id=" . $user_id . "'>$user_id</> requested the intervention of the staff in the group " . $title ."\n\n📝 Reason: " . explode(' ', $msg, 2)[1] . "\n👀 <a href='https://t.me/c/" . str_replace('-100', '', $chat_id) . "/". $msgID ."'><i>Go to the message...</></>");
            }else{
                foreach($admin as $id){
                    sm($id, "⚠️ <b>ATTENTION</>\n\n<a href='tg://user?id=" . $user_id . "'>$user_id</> requested the intervention of the staff in the group " . $title ."\n\n📝 Reason: " . explode(' ', $msg, 2)[1] . "\n👀 <a href='https://t.me/c/" . str_replace('-100', '', $chat_id) . "/". $msgID ."'><i>Go to the message...</></>");
                }
            }
        }else{
            $r = sm($user_id, "❌ <i>You have to write the reason of the report</>");
            if($r['ok'] == false){
                sm($chat_id, "❌ <i>You have to write the reason of the report</>");
            }
        }
        die;
    }



}