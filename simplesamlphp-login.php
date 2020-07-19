<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use Grav\Common\User\User;
use Grav\Common\Config\Config;
use Grav\Plugin\Login\Login;
use Grav\Plugin\Login\Events\UserLoginEvent;

class SimplesamlphpLoginPlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 1],
            'onUserLoginAuthenticate' => ['userLoginAuthenticate', 2]
        ];
    }

    public function onPluginsInitialized()
    {
        // Check to ensure admin plugin is enabled.
        if (!$this->grav['config']->get('plugins.admin.enabled')) {
            throw new \RuntimeException('The Admin plugin needs to be installed and enabled');
        }
        // Check to ensure login plugin is enabled.
        if (!$this->grav['config']->get('plugins.login.enabled')) {
            throw new \RuntimeException('The Login plugin needs to be installed and enabled');
        }
        // Check to ensure sessions are enabled.
        if ($this->grav['config']->get('system.session.enabled') === false) {
            throw new \RuntimeException('The Login plugin requires "system.session" to be enabled');
        }
    }

    public function userLoginAuthenticate(UserLoginEvent $event)
    {
        // Plugin parameters
        $saml_autoloader = $this->config->get('plugins.simplesamlphp-login.saml_autoloader_path');
        $saml_auth_source = $this->config->get('plugins.simplesamlphp-login.saml_auth_source');
        $saml_permissions_attribute = $this->config->get('plugins.simplesamlphp-login.saml_permissions_attribute');
        $permission_login = $this->config->get('plugins.simplesamlphp-login.permission_login');
        $permission_edit = $this->config->get('plugins.simplesamlphp-login.permission_edit');
        $permission_admin = $this->config->get('plugins.simplesamlphp-login.permission_admin');
        $permission_redirect = $this->config->get('plugins.simplesamlphp-login.permission_redirect');
        $save_user = $this->config->get('plugins.simplesamlphp-login.save_user');
        $full_site = $this->config->get('plugins.simplesamlphp-login.full_site');

        // Protect full site or just admin
        if ($full_site === false) {
            if (!$this->isAdmin()) {
                return;
            }
        }

        // Require SimpleSAMLphp
        require_once($saml_autoloader);
        $as = new \SimpleSAML\Auth\Simple($saml_auth_source);
        $as->requireAuth();
        $attributes = $as->getAttributes();

        // Create Grav User
        $grav_user = User::load(strtolower($attributes['uid'][0]));

        // Set permissions
        $permissions = array();

        if (strpos($attributes[$saml_permissions_attribute][0], $permission_admin) !== false) {
            $permissions['site']['login'] = true;
            $permissions['admin']['login'] = true;
            $permissions['admin']['super'] = true;
        } else if (strpos($attributes[$saml_permissions_attribute][0], $permission_edit) !== false) {
            $permissions['site']['login'] = true;
            $permissions['admin']['login'] = true;
            $permissions['admin']['configuration_site'] = true;
            $permissions['admin']['cache'] = true;
            $permissions['admin']['pages'] = true;
            $permissions['admin']['statistics'] = true;
        } else if (strpos($attributes[$saml_permissions_attribute][0], $permission_login) !== false) {
            $permissions['site']['login'] = true;
        } else {
            header("Location: $permission_redirect");
            die();
        }

        // Set user
        $grav_user['login'] = $attributes['uid'][0];
        $grav_user['fullname'] = $attributes['displayName'][0];
        $grav_user['email'] = $attributes['mail'][0];
        $grav_user['access'] = $permissions;

        // Save user
        if ($save_user === true) {
            $grav_user->save();
        }

        // Login
        $event->setUser($grav_user);
        $event->setStatus($event::AUTHENTICATION_SUCCESS);
        $event->stopPropagation();

        return;
    }
}