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

$api = urldecode($_GET['key']); // Get the Token from the URL
$alias = ['/', '.']; // Array of characters to replace in the message

include 'functions.php'; // Include the functions file

if($cmd == 'start' and $typechat == 'private'){
    $menu[] = [['text' => '📣 Dev Channel','url' => 't.me/BotsOfGamer']];
    sm($chatID, "Hi, with this bot, only when the @admin command have a reason will be sent", $menu);
}

if(strpos($msg, '@admin')===false and in_array($typechat, ['group', 'supergroup'])){
    if(isset(explode(' ', $msg)[1])){
        sm($chatID, "<i>Report Sent</>");
    }else{
        $r = sm($userID, "❌ <i>You have to write the reason of the report</>");
        if($r['ok'] == false){
            sm($chatID, "❌ <i>You have to write the reason of the report</>");
        }
    }
}
