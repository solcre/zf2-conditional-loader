Conditional Module Loader for Zend Framework 2
=======================

Introduction
------------
This simple package will allow you to load modules depending on some conditions.

Motivation: We use [AssetManager](https://github.com/RWOverdijk/AssetManager) for a project, and we wanted to load the module only when the request is for an asset.

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies using the `create-project` command:

    curl -s https://getcomposer.org/installer | php --
    php composer.phar create-project solcre/zf2-conditional-loader path/to/install

Alternately, clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/project/dir
    git clone git://github.com/solcre/zf2-conditional-loader.git
    cd zf2-conditional-loader
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

Another alternative for downloading the project is to grab it via `curl`, and
then pass it to `tar`:

    cd my/project/dir
    curl -#L https://github.com/solcre/zf2-conditional-loader/tarball/master | tar xz --strip-components=1

You would then invoke `composer` to install dependencies per the previous
example.


Using Git submodules
--------------------
Alternatively, you can install using native git submodules:

    git clone git://github.com/solcre/zf2-conditional-loader.git --recursive

Requirements
----------------

### Libraries Used

Zend Framework 2

Configuration
----------------

### In application.config.php add:

```
    'service_manager' => array(
        'factories' => array(
            'ModuleManager' => 'ConditionalLoader\Service\Factory\ModuleManagerFactory',
        )
    ),
    'modules_condition_resolvers' => array(
        '<module class here>' => '<condition resolver class here>',
    ),
);
```

*Remember to create a service for your condition resolver class or define it as an invokable. 

### Example config: 

```
'service_manager' => array(
    'factories' => array(
        'ModuleManager' => 'ConditionalLoader\Service\Factory\ModuleManagerFactory',
    ),
    'invokables' => array(
        'AssetManagerResolver' => 'ColumnisExpress\ConditionResolver\AssetManagerResolver'
    )
),
'modules' => array(
    'AssetManager',
    'Columnis'
),
'modules_condition_resolvers' => array(
    'AssetManager' => 'AssetManagerResolver'
),
```

### Example of a Condition Resolver Class (AssetManagerResolver)

```
<?php

namespace ColumnisExpress\ConditionResolver;

use ConditionalLoader\Resolver\ConditionResolverInterface;

class AssetManagerResolver implements ConditionResolverInterface
{
    public function resolve() {
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI']:'';
        return (preg_match('/^.+\.(js|css)$/', $uri) === 1);
    }
}
```
