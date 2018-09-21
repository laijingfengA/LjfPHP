<?php

namespace app\controller\admin;

use app\model\Video;

class VideoController extends BaseController
{
    public function index()
    {
        $condition = [];
        $url = [];

        $video_name = request('video_name');
        $page = request('page');

        $video_name = trim($video_name);

        if (strlen((string)$video_name) > 0) {
            $url[] = 'video_name=' . $video_name;
            $condition[] = "video_name like '%" . $video_name . "%'";
        }

        //不查询删除数据和只查询当前用户下
        $user = parent::getUserInfo();
        $condition[] = "status != 90 and user_id = {$user['user_id']}";

        //判断是否有搜索
        $urlString = '';
        if (count($condition) > 0 && count($url) > 0) {
            $urlString = '&' . implode('&', $url);
        }

        $video = new Video();
        $data = $video->findPaginate($condition, $page);

        //初始化分页
        $urlString = '?' . $urlString;
        $pages = parent::pages_ini($data['page'], $data['amount'], $urlString, $data['total']);

        $data['list'] = array_map(function ($val) {
            $val['protocol'] = 'rtmp';
            if (!strstr($val['video_link'], 'rtmp://')) {
                $val['protocol'] = 'hls';
            }
            return $val;
        }, $data['list']);

        $this->display('admin/video/index.twig', [
            'list' => $data['list'],
            'pages' => $pages,
            'video_name' => $video_name,
            'total' => $data['total'],
        ]);
    }

    public function createData()
    {
        $video = new Video();
        $video->create(
            [
                ['user_id' => 1001,
                    'video_name' => '视频名称3',
                    'video_link' => '视频链接',
                    'width' => '宽度',
                    'height' => '高度',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                ['user_id' => 1001,
                    'video_name' => '视频名称4',
                    'video_link' => '视频链接',
                    'width' => '宽度',
                    'height' => '高度',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                ['user_id' => 1001,
                    'video_name' => '视频名称5',
                    'video_link' => '视频链接',
                    'width' => '宽度',
                    'height' => '高度',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                ['user_id' => 1001,
                    'video_name' => '视频名称6',
                    'video_link' => '视频链接',
                    'width' => '宽度',
                    'height' => '高度',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                ['user_id' => 1001,
                    'video_name' => '视频名称7',
                    'video_link' => '视频链接',
                    'width' => '宽度',
                    'height' => '高度',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                ['user_id' => 1001,
                    'video_name' => '视频名称8',
                    'video_link' => '视频链接',
                    'width' => '宽度',
                    'height' => '高度',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                ['user_id' => 1001,
                    'video_name' => '视频名称9',
                    'video_link' => '视频链接',
                    'width' => '宽度',
                    'height' => '高度',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
    }
}