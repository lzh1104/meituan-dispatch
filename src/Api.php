<?php

namespace EasyMeituan\MeituanDispath;

use Hanson\Foundation\AbstractAPI;

class Api extends AbstractAPI
{
    /**
     * @var string
     */
    private $appKey;

    /**
     * @var string
     */
    private $secret;

    const URL = 'https://peisongopen.meituan.com/api';

    /**
     * Api constructor.
     * @param string $appKey
     * @param string $secret
     */
    public function __construct($appKey, $secret)
    {
        $this->appKey = $appKey;
        $this->secret = $secret;
    }

    public function signature(array $params)
    {
        ksort($params);

        $waitSign = '';
        foreach ($params as $key => $item) {
            if ($item) {
                $waitSign .= $key.$item;
            }
        }

        return strtolower(sha1($this->secret.$waitSign));
    }


    public function request(string $method, array $params)
    {
        $params = array_merge($params, [
            'appkey' => $this->appKey,
            'timestamp' => time(),
            'version' => '1.0'
        ]);

        $params['sign'] = $this->signature($params);

        $response = $this->getHttp()->post(self::URL, $method, $params);

        $result = json_decode(strval($response->getBody()), true);

        $this->checkErrorAndThrow($result);

        return $result;
    }


    protected function checkErrorAndThrow($result)
    {
        if (!$result || 0 != $result['code']) {
            throw new MeituanDispatchException($result['message'], $result['code']);
        }
    }
}