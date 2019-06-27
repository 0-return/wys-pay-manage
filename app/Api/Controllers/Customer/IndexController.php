<?php

namespace App\Api\Controllers\Customer;
use App\Api\Controllers\BaseController;
use App\Models\Customer;
use Illuminate\Http\Request;

header('Access-Control-Allow-Origin:*');

class IndexController extends BaseController{

    public function add(Request $request)
    {
        try{
            $data['title'] = $request->post('title','加盟申请');
            $data['company'] = $request->post('company');
            $data['industry'] = $request->post('industry');
            $data['username'] = $request->post('username');
            $data['province'] = $request->post('province');
            $data['city'] = $request->post('city');
            $data['area'] = $request->post('area');
            $data['phone'] = $request->post('phone');
            $data['type'] = $request->post('type');
            $data['created_at'] = time();
            $data['status'] = 0;

            $check_data = array(
                'username' => '姓名',
                'phone' => '联系方式'
            );

            $check = $this->check_required($request->except(['token']), $check_data);
            if ($check) {
                return json_encode([
                    'status' => 2,
                    'message' => $check
                ]);
            }
            Customer::create($data);
            return json_encode([
                'status' => 1,
                'message' => '添加成功',
            ]);
        }catch (\Exception $exception)
        {
            return json_encode(['status' => -1, 'message' => $exception->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $info = $this->parseToken();
    }

    public function lists(Request $request)
    {
        $info = $this->parseToken();
    }

    public function del(Request $request)
    {
        $info = $this->parseToken();
    }
}