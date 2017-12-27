<?php

namespace App\Services\Middleware;

use App\Services\Core\View;
use App\Services\libraries\auth;
use App\Services\Models\UserModel;
use Closure;

class AdminCheck
{
    public function handle($request, Closure $next)
    {
        $uid = $request->session()->get('user_id');
        $userInfo = UserModel::find($uid);

        if (!$request->session()->has('user_id') || !$userInfo) {
            return redirect()->route('admin/login/index', ['url=' . urlencode($request->url())]);
        }

        $roleId = $userInfo['roleid'];
        if (!auth::check($roleId)) {
            $view = new View();
            $route_name = explode('\\', \Route::currentRouteName());
            $view->assign(array(
                'i' => 1,
                'msg' => lang('a-com-0', array('1' => $route_name[1], '2' => $route_name[2])),
                'url' => url('admin/index/'),
                'time' => 3,
                'result' => 0
            ));
            $tpl = 'admin/msg';

            return $view->display($tpl);
        }

        return $next($request);
    }
}

