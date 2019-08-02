<?php
/**
 * Sender
 * @package lib-sms-zenziva
 * @version 0.0.1
 */

namespace LibSmsZenziva\Library;

use LibCurl\Library\Curl;

class Sender
    implements 
        \LibSms\Iface\Sender
{

    static $last_error;
    static $last_errno;

    static function send(string $phone, string $message): bool {
        $conf = \Mim::$app->config->libSmsZenziva;

        $opts = [
            'url'       => 'https://reguler.zenziva.net/apps/smsapi.php',
            'method'    => 'GET',
            'agent'     => 'LibSmsZenziva v0.0.1',
            'headers'       => [
                'Accept' => 'application/json'
            ],
            'query'     => [
                'userkey'   => $conf->userkey,
                'passkey'   => $conf->passkey,
                'nohp'      => $phone,
                'pesan'     => $message,
                'res'       => 'json'
            ]
        ];

        $result = Curl::fetch($opts);

        if(!$result)
            return self::setError(100, 'Unknow error');

        if($result->status)
            return self::setError($result->status, $result->text);

        return true;
    }

    static function lastError(): ?string {
        return self::$last_error;
    }

    static function lastErrno(): ?int {
        return self::$last_errno;
    }

    static function setError(int $num, string $text): bool{
        self::$last_errno = $num;
        self::$last_error = $text;

        return false;
    }
}