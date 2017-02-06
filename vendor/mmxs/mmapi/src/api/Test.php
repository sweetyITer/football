<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/16
 * Time: 14:34
 */

namespace mmapi\api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

abstract class Test extends TestCase
{
    protected $url;//接口请求地址
    protected $params = [];
    protected $options = [];
    /** @var  Client */
    private $client;
    /** @var  ResponseInterface */
    protected $reponse;

    /**
     * @desc   testBase 基础测试
     * @author chenmingming
     */
    abstract public function testBase();

    /**
     * @desc   addParam 添加参数
     * @author chenmingming
     *
     * @param $k
     * @param $v
     *
     * @return $this
     */
    protected function addParam($k, $v)
    {
        $this->params[] = ['key' => $k, 'value' => $v];

        return $this;
    }

    /**
     * @desc   request
     * @author chenmingming
     */
    protected function request()
    {
        $this->reponse = $this->getClient()->post($this->url, $this->options);
    }

    /**
     * @desc   getClient
     * @author chenmingming
     * @return Client
     */
    protected function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client();
        }

        return $this->client;
    }
}