<?php
declare(strict_types=1);

namespace App\Service;

class ContentWatchApi
{
    public function __construct(private readonly string $key)
    {

    }

    public function checkText(string $text): string
    {
        $post_data = [
            'key' => $this->key, // ваш ключ доступа (параметр key) со страницы https://content-watch.ru/api/request/
            'text' => $text,
            'test' => 0 // при значении 1 вы получите валидный фиктивный ответ (проверки не будет, деньги не будут списаны)
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_URL, 'https://content-watch.ru/public/api/');

        $data = json_decode(trim(curl_exec($curl)), true);

        curl_close($curl);

        return $data['percent'];
    }
}
