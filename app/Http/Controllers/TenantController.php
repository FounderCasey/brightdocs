<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Tenant;

class TenantController extends Controller
{
    function show()
    {
        return view('static.createTenant');
    }

    function createTenant(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $company = $request->company;
        $companyURL = preg_replace('/\s+/', '', $company);

        $tenant = Tenant::new()
            ->withDomains([$companyURL . '.brightdocs.test'])
            ->withData(['plan' => 'trial', 'name' => $user->name, 'email' => $user->email, 'company' => $company, 'password' => $user->password])
            ->save();
        return response()->redirectTo('http://' . $companyURL . '.brightdocs.test'); // TODO fix domain
    }
}
