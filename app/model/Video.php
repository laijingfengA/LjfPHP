<?php

namespace app\model;

use core\lib\Model;
use Medoo\Medoo;

class Video extends Model
{
    const STATUS_YES = 10;

    protected $table = "video";

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {

        $sql = "select count(*) as tatol from ". $this->table;
        $count = Model::query($sql)->fetchColumn();

        dump($count);
        exit;
    }

    /**
     * 分页
     * @param $condition
     * @param $page
     * @param $orderBy
     * @return array ['total', 'page', 'amount', 'list']
     */
    public function findPaginate($condition, $page, $orderBy = 'desc')
    {

        $where = '';
        $data = [];

        //判断是否有搜索
        if (count($condition) > 0) {
            $where = ' where ' . implode(' and ', $condition);
        }

        $itemCount = 2;                                                //每页设置数
        $sql = "select count(*) as tatol from ". $this->table . $where;
        $data['total'] = Model::query($sql)->fetchColumn();
        $data['amount'] = ceil($data['total'] / $itemCount);      //总页数
        $data['page'] = empty($page) ? 1 : $page;

        //判断页面范围，page最小只能为1
        $data['page'] = min($data['page'], $data['amount']);
        $data['page'] = max(1, $data['page']);

        $offset = ($data['page'] - 1) * $itemCount;                     //偏移量
        $sql = 'select * from ' . $this->table . $where . ' ORDER BY created_at ' . $orderBy . ' limit ' . $offset . ',' . $itemCount;
        $data['list'] = Model::query($sql)->fetchAll();
        return $data;
    }

    /**
     * 新增
     * @param $data
     * @return int   0||ID  返回新增纪录ID或失败返回0
     */
    public function create($data)
    {
//        $data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');    //新增时间和修改时间
        Model::insert($this->table, $data);
        return Model::id();
    }

    public function statusAlias()
    {
        return 10;
    }
}