<?php

return [
    'support_email' => env('PAY_IPROTEK_SUPPORT_EMAIL', ''),
    'manual_url' =>env('PAY_MANUAL_URL', '#'),
    'pay_message_url'=> env('PAY_MESSAGE_URL', ''),
    'to_type_list'=>env('SYS_NOTIFICATION_TO_TYPE_LIST', ''),
    'interval_sms_send_count'=>env('SYS_NOTIFICATION_INTERVAL_SMS_SEND_COUNT', 50),//SEND PER MINUTE
];