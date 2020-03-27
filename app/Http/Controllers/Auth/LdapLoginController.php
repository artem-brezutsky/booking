<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Services\Ldap\Auth as LdapAuth;
use App\User as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//use App\Models\Moderator;

class LdapLoginController extends LoginController
{
    /**
     * LDAP auth service.
     *
     * @var \App\Services\Ldap\Auth
     */
    protected $auth;

//    /**
//     * Import service for users.
//     *
//     * @var \App\Services\Ldap\LdapUserImporter
//     */
//    protected $importer;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\Ldap\Auth $auth
     * //     * @param App\Contracts\UserImporter $importer
     *
     * @return void
     */
    public function __construct(LdapAuth $auth)
    {
        $this->auth = $auth;
//        $this->importer = $importer;

        parent::__construct();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {

        // For local development without ldap auth
        // "if" - for additional protect if forgot comment this lines
//        if (config('app.env') === 'local') {
//            $user = Moderator::where('id', 5)->first();
//            Auth::login($user);
//            return true;
//        }

        if (config('ldap.enabled')) {
            try {
                $credentials = $this->credentialsForLdap($request);
                $attempResult = $this->auth->login(
                    $credentials['login'],
                    $credentials['password'],
                    $rawUserData
                );

                if ($attempResult) {
                    $user = User::where('email', 'like', $credentials['login'] . '%')->first();
                    if (!$user) {
                        $userEmail = $rawUserData['mail'][0];
                        $userName = $rawUserData['givenname'][0] . ' ' . $rawUserData['sn'][0];
                        $user = new User();
                        $user->name = $userName;
                        $user->email = $userEmail;
                        $user->password = '';

                        $user->save();
                    }
                    Auth::login($user);

                    return true;
                }
            } catch (\Exception $e) {
                if (App::environment('local')) {
                    throw $e;
                }

                report($e);
                $attempResult = false;
            }

            // If we have only LDAP auth configured then we stop authorization
            // here without following to parent attemptLogin method.
            if (config('ldap.ldap_only')) {
                return $attempResult;
            }
        }

        return parent::attemptLogin($request);
    }

    /**
     * Get login and password for LDAP authorization.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentialsForLdap(Request $request): array
    {

        $credentials = $this->credentials($request);

        return [
            'login'    => $credentials['email'],
            'password' => $credentials['password'],
        ];
    }
}
