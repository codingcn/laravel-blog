<?php

namespace App\Http\Controllers\Admin;

use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Http\Request;

class LinkController extends CommonController
{
    protected $link_repository;

    public function __construct(LinkRepository $link_repository)
    {
        $this->link_repository = $link_repository;
    }

    /**
     * 获取友链列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $list = $this->link_repository->selectAll();
        return $this->responseJson('OK', $list);
    }

    /**
     * 保存友链
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'uri' => 'required',
            'serial_number' => 'numeric',
            'description' => 'present',
        ]);
        if ($validator->fails()) {
            return $this->responseJson('INVALID_REQUEST', [], $validator->errors());
        }
        $data = $request->only([
            'name',
            'uri',
            'serial_number',
            'description',
        ]);
        $res = Link::create($data);
        return $this->responseJson('OK', $res);
    }

    /**
     * 更新友链
     * @param Link $link
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Link $link, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'uri' => 'required',
            'serial_number' => 'numeric',
            'description' => 'present',
        ]);
        if ($validator->fails()) {
            return $this->responseJson('INVALID_REQUEST', [], $validator->errors());
        }
        $data = $request->only([
            'name',
            'serial_number',
            'uri',
            'description',
        ]);
        $link->name = $data['name'];
        $link->uri = $data['uri'];
        $link->description = $data['description'];
        $link->serial_number = $data['serial_number'];
        $link->save();
        return $this->responseJson('OK', $link);
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return $this->responseJson('OK');
    }
}
