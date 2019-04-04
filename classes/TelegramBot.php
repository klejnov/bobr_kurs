<?php
/**
 * Telegram Bot
 */

class TelegramBot
{

    public function sendMessageTelegramBot($message)
    {
        $config = include __DIR__  . DS . '../admin/config_telegram.php';

        $arr_chat_id = $config['arr_chat_id'];
        $token = $config['token_telegram'];

        foreach ($arr_chat_id as $chat_id) {
            $this->sendMessages($chat_id, $message, $token);
        }
    }

    private function sendMessages($chatID, $message, $token)
    {
        //echo "sending message to " . $chatID . "\n";

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($message) . "&parse_mode=html";
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}