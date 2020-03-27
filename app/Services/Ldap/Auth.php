<?php


namespace App\Services\Ldap;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\App;

class Auth
{
    /**
     * Filter string for LDAP search to identify user.
     *
     * @var string
     */
    protected $filter;

    /**
     * Reader user distinguished name.
     *
     * @var string
     */
    protected $readerDN;

    /**
     * Reader user password.
     *
     * @var string
     */
    protected $readerPassword;

    /**
     * Distinguished name of users group.
     *
     * @var string
     */
    protected $usersGroupDN;

    /**
     * Auth's constructor.
     *
     * @param \App\Services\Ldap\Connection $connection
     * @param string $baseDN
     * @param string $readerDN
     * @param string $readerPassword
     * @param string $usersGroupDN
     * @param string $filter
     */
    public function __construct(
        string $readerDN,
        string $readerPassword,
        string $usersGroupDN,
        string $filter
    ) {
        $this->readerDN = $readerDN;
        $this->readerPassword = $readerPassword;
        $this->usersGroupDN = $usersGroupDN;
        $this->filter = $filter;
    }

    /**
     * Rebind LDAP when following referrals.
     *
     * @param mixed $ldap
     * @param mixed $referral
     *
     * @return int
     */
    public function rebind($ldap, $referral)
    {
        $this->setOptions($ldap);

        if (!ldap_bind($ldap, $this->readerDN, $this->readerPassword)) {
            return 1; // 1 means failure.
        }

        return 0; // No mistake here, 0 means success.
    }

    /**
     * Init LDAP options for given resource link.
     *
     * @param mixed $link
     *
     * @return void
     */
    protected function setOptions($link)
    {
        ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($link, LDAP_OPT_REFERRALS, true);
        ldap_set_rebind_proc($link, [$this, 'rebind']);
    }

    /**
     * Try to login user by specified credentials. Returns true if it was
     * successfull.
     *
     * Sets LDAP user raw data response to $raw array.
     *
     * @param string $uid
     * @param string $password
     * @param array &$raw
     *
     * @return bool
     */
    public function login(string $uid, string $password, ?array &$raw): bool
    {
        $aServers = [' ', ' ']; // Host
        $usersGroupDN = 'DC=,DC='; // Base DN
        $corpPrefix = ' \\';
        $sDN = "CN=,OU=,DC=,DC=,DC=";
        //@TODO Переделать для фильтра через конфги
        $filter = '(&(objectClass=user)(memberof=' . $sDN . ')(samaccountname=' . $uid . '))';

        $link = ldap_connect(implode(" ", $aServers)); //Делаем коннект

        ldap_set_rebind_proc($link, [$this, 'rebind']);
        ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, config('ldap.protocol_version'));
        ldap_set_option($link, LDAP_OPT_TIMELIMIT, 5);
        ldap_set_option($link, LDAP_OPT_NETWORK_TIMEOUT, 3);
        ldap_set_option($link, LDAP_OPT_REFERRALS, true);

        // Using reader account to bind to LDAP server.
        ldap_bind($link, $this->readerDN, $this->readerPassword);

        // Trying to identify user by specified login (uid) among users on LDAP server.
        $searchResult = ldap_search($link, $usersGroupDN, $filter);
        // Checking if something is found.
        if (($count = ldap_count_entries($link, $searchResult)) == 0) {
            // No object is found by filter meaning auth should fail.
            return false;
        }

        // Reading what is found.
        $rawResult = ldap_get_entries($link, $searchResult);

        // Transforming result to indexed 0..n array of records.
        $result = [];
        for ($i = 0; $i < $count; $i++) {
            $result[] = $rawResult[$i];
        }

        // Returning data of first user found.
        $raw = $result[0];

        // Lastly we try to auth using user credentials via LDAP. If it's
        // successfull then authorization via LDAP is successfull.
        return ldap_bind($link, $corpPrefix . array_get($raw, config('ldap.login_field'), $uid), $password);
    }

    /**
     * Get filter string for LDAP user identification search.
     *
     * @param string $uid
     *
     * @return string
     */
    protected function getFilterString(string $uid): string
    {
        return str_replace(':uid', $uid, $this->filter);
    }
}