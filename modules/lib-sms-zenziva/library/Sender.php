<?php
/**
 * Sender
 * @package lib-sms-zenziva
 * @version 0.0.1
 */

namespace LibSmsZenziva\Library;

use LibCurl\Library\Curl;
use LibSms\Iface\Sender as IfaceSender;

class Sender implements IfaceSender
{

    private static $last_error;
    private static $last_errno;

    protected static function exec(string $method, string $path, array $body = [])
    {
        if ($path != '/api/balance/') {
            $file = BASEPATH . '/zenziva-text.txt';
            if (is_file($file)) {
                $f = fopen($file, 'w');
                fwrite($f, json_encode($body, JSON_PRETTY_PRINT));
                fclose($f);

                return true;
            }
        }

        $conf = \Mim::$app->config->libSmsZenziva;
        $body['userkey'] = $conf->userkey;
        $body['passkey'] = $conf->passkey;

        $opts = [
            'url' => 'https://console.zenziva.net' . $path,
            'method' => $method,
            'agent' => 'LibSmsZenziva v1.0.0',
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ];

        if ($method == 'POST') {
            $opts['body'] = $body;
        } else {
            $opts['query'] = $body;
        }

        $result = Curl::fetch($opts);
        if (!$result) {
            return self::setError(100, 'Unknow Error');
        }

        if ($result->status !== '1') {
            return self::setError($result->status, $result->text);
        }

        return $result;
    }

    public static function balance(): ?string
    {
        $result = self::exec('GET', '/api/balance/');
        if (!$result) {
            return null;
        }

        return str_replace(',', '', $result->balance);
    }

    public static function otp(string $phone, string $message): bool
    {
        $body = [
            'to' => $phone,
            'message' => $message
        ];
        return !!self::exec('POST', '/masking/api/sendOTP/', $body);
    }

    public static function send(string $phone, string $message): bool
    {
        $body = [
            'to' => $phone,
            'message' => $message
        ];
        return !!self::exec('POST', '/masking/api/sendsms/', $body);
    }

    public static function voice(string $phone, string $message): bool
    {
        $body = [
            'to' => $phone,
            'message' => $message
        ];
        return !!self::exec('POST', '/voice/api/sendvoice/', $body);
    }

    public static function wa(string $phone, string $otp, string $brand): bool
    {
        $body = [
            'to' => $phone,
            'brand' => $brand,
            'otp' => $otp
        ];

        return !!self::exec('POST', '/waofficial/api/sendWAOfficial/', $body);
    }

    public static function lastError(): ?string
    {
        return self::$last_error;
    }

    public static function lastErrno(): ?int
    {
        return self::$last_errno;
    }

    public static function setError(int $num, string $text): bool
    {
        self::$last_errno = $num;
        self::$last_error = $text;

        return false;
    }
}
