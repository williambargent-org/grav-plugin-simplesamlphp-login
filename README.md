# Simplesamlphp Login Plugin

The **SimpleSAMLphp-Login** Plugin for [Grav CMS](http://github.com/getgrav/grav) add the ability to point to a pre-configured [SimpleSAMLphp](https://github.com/simplesamlphp/simplesamlphp) SP to provide SAML authentication on your [Grav CMS](http://github.com/getgrav/grav) site or [Admin plugin](https://github.com/getgrav/grav-plugin-admin).

## Installation

Installing the SimpleSAMLphp-Login plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the [Admin plugin](https://github.com/getgrav/grav-plugin-admin).

### GPM Installation (Preferred)

To install the plugin via the [GPM](http://learn.getgrav.org/advanced/grav-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install simplesamlphp-login

This will install the SimpleSAMLphp-Login plugin into your `/user/plugins`-directory within [Grav CMS](http://github.com/getgrav/grav). Its files can be found under `/your/site/grav/user/plugins/simplesamlphp-login`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `simplesamlphp-login`. You can find these files on [GitHub](https://github.com/williambargentlimited/grav-plugin-simplesamlphp-login) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/simplesamlphp-login
	
> NOTE: This plugin is a modular component for [Grav CMS](http://github.com/getgrav/grav) and requires other plugins and software packages to operate, please see it's [blueprints.yaml-file on GitHub](https://github.com/williambargentlimited/grav-plugin-simplesamlphp-login/blob/master/blueprints.yaml).

### Admin Plugin

You can install the plugin directly by browsing the `Plugins` menu and clicking on the `Add` button.

## Configuration

Here is the default configuration and an explanation of available options:

```yaml
enabled: false                      - Plugin is disabled by default to allow configuration
saml_autoloader_path:               - Full system path to the SimpleSAMLphp autoloader file
saml_auth_source:                   - SimpleSAMLphp Auth source
saml_permissions_attribute:         - The attribute returned in the SAML response used for assigning permissions
permission_login:                   - The string contained in the attribute SAML returns to allow site login (mainly used when protecting the whole site)
permission_edit:                    - The string contained in the attribute SAML returns to allow editing
permission_admin:                   - The string contained in the attribute SAML returns to allow administrators
permission_redirect:                - The URL to redirect to if user isn't allowed to login (used when protecting the whole site)
save_user: false                    - Allowed users who login to be saved to the /users/accounts directory
full_site: false                    - Protects the whole Grav site not just the Admin plugin
```

Note that if you configure this plugin with the [Admin plugin](https://github.com/getgrav/grav-plugin-admin), a file with your configuration named simplesamlphp-login.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the Admin.

Note that if you configure this plugin manually, you should copy the `user/plugins/simplesamlphp-login/simplesamlphp-login.yaml` to `user/config/plugins/simplesamlphp-login.yaml` and only edit that copy.

## Usage

The installation instructions above assume you already have a working [SimpleSAMLphp](https://github.com/simplesamlphp/simplesamlphp) SP configuration on the same server as your [Grav CMS](http://github.com/getgrav/grav). Details on how to configure an SP can be found [here](https://simplesamlphp.org/docs/stable/simplesamlphp-sp). 

This SimpleSAMLphp-Login plugin loads the `lib/_autoload.php` file from your [SimpleSAMLphp](https://github.com/simplesamlphp/simplesamlphp) SP configuration and extends it's logic to enable SSO authentication into [Grav CMS](http://github.com/getgrav/grav).

## Credits

This plugin SimpleSAMLphp-Login heavily relies on the [SimpleSAMLphp](https://github.com/simplesamlphp/simplesamlphp) library.

This is also an extension of the [Login plugin](https://github.com/getgrav/grav-plugin-login).

## To Do

- N/A

## Known Issues
Please report issues relating to the SimpleSAMLphp-Login plugin on the [Github issue tracker](https://github.com/williambargentlimited/grav-plugin-simplesamlphp-login/issues). Please report issues relating to [SimpleSAMLphp](https://github.com/simplesamlphp/simplesamlphp) on their [Github issue tracker](https://github.com/simplesamlphp/simplesamlphp/issues). (I have no association to the [SimpleSAMLphp](https://github.com/simplesamlphp/simplesamlphp) project.

- N/A