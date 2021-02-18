<?php

/**
 * @copyright  2021 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Sam Chen <samchen@opencart.cn>
 * @created    2021/2/8 2:23 PM
 * @modified   2021/2/8 2:23 PM
 */

namespace Guangda\Notifications;

use GuzzleHttp\Client;
use \Illuminate\Notifications\Notification as Notification;

class WeComChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $key = config('wecom-notification-channel.key');
        if (empty($key)) {
            throw new \Exception('No wecom.key specified');
        }

        $message = $notification->toWeCom($notifiable);
        $client = new Client();

        $res = $client->request('POST', 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=' . $key, [
            'json' => $message->getBody(),
        ]);
        echo $res->getStatusCode();
    }
}