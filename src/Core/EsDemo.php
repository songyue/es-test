<?php

namespace Core;

use Elasticsearch\ClientBuilder;

class EsDemo
{
    private $client;

    public $hosts =  ['myaliyun:3529'];

    public function __construct()
    {
        // 创建es client 实例
        $this->client = ClientBuilder::create()->setHosts($this->hosts)->build();
    }


    public function actionIndex()
    {
        $class_methods = get_class_methods(self::class);
        $availableAction = array_filter($class_methods, function ($method) {
            return $method !== '__construct';
        });

        printf("%s \n", '可用功能');
        foreach ($availableAction as $action) {
            $name = lcfirst(str_replace('action', '', $action));
            printf(" %s \n", $name);
        }
    }

    /**
     * 要为文档建立索引，我们需要指定三项信息：索引，ID和文档主体。这是通过构造key：value对的关联数组来完成的。请求主体本身就是一个与key：value对对应的关联数组，该对对应于您文档中的数据：
     *
     * 输出结果
     * Array
     * (
     *     [_index] => my_index
     *     [_type] => _doc
     *     [_id] => my_id
     *     [_version] => 1
     *     [result] => created
     *     [_shards] => Array
     *         (
     *                     [total] => 2
     *                     [successful] => 1
     *                     [failed] => 0
     *                 )
     *
     *     [_seq_no] => 0
     *     [_primary_term] => 1
     * )
     */
    public function actionCreateIndex()
    {
        $params = [
            'index' => 'my_index',
            'id'    => 'my_id',
            'body'  => ['testField' => 'abc']
        ];

        $response = $this->client->index($params);
        print_r($response);
    }

    /**
     * 让我们获取我们刚刚建立索引的文档。这将简单地返回文档：
     *
     * 输出结果
     * Array
     * (
     *     [_index] => my_index
     *     [_type] => _doc
     *     [_id] => my_id
     *     [_version] => 1
     *     [_seq_no] => 0
     *     [_primary_term] => 1
     *     [found] => 1
     *     [_source] => Array
     *         (
     *                     [testField] => abc
     *                 )
     *
     * )
     */
    public function actionGet()
    {
        $params = [
            'index' => 'my_index',
            'id'    => 'my_id'
        ];

        $response = $this->client->get($params);
        print_r($response);
    }

    /**
     * 如果要直接检索_source字段，则有getSource方法：
     *
     * 输出结果
     * Array
     * (
     *     [testField] => abc
     *
     * )
     */
    public function actionGetSource()
    {
        $params = [
            'index' => 'my_index',
            'id'    => 'my_id'
        ];

        $source = $this->client->getSource($params);
        print_r($source);
    }


    /**
     * 搜索文件
     * 搜索是Elasticsearch的标志，因此让我们执行搜索。我们将使用Match查询作为演示：
     *
     * 输出结果
     */
    public function actionSearch()
    {
        $params = [
            'index' => 'my_index',
            'body'  => [
                'query' => [
                    'match' => [
                        'testField' => 'abc'
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);
        print_r($response);
    }
}
