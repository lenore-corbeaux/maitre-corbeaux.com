Maitre-corbeaux.com
===================

Maitre-corbeaux.com is my personal website project. It centralizes my personal internet activity and my technological watch... and maybe later some other projects.

The site is powered by Zend Framework and is entirely open-source.

Requirements
------------

The project simply needs PHP 5.3 and Zend Framework 1.11.5 to be in the PHP's include path or in the library dir.

The application is build to work with a MySQL database but SQLite should work too.

Phing, phpdoc and phpunit are also needed for, respectively, build the application, generate API doc and run the unit tests.

Installation
------------

The first thing to do is obviously to clone the repository :
_git clone https://github.com/lucascorbeaux/maitre-corbeaux.com.git_

Go to the repository root and initialize the application using phing :
_phing prepare_

If phing is not available on your environment, just take a look at the _build.xml_ file : try to reproduce every copy, mkdir and chmod tasks in the prepare target, it won't be very long to do this manually.

Use then your favorite editor to configure _application/configs/application.ini_ : for obvious reasons, private data like ReCAPTCHA's keys and DB access aren't versionned, and you need to change them.

You can then :
<ul>
<li>Check for PHP syntax with phing lint.</li>
<li>Run all unit tests with phing unittests.</li>
<li>Generate API docs with phing apidocs.</li>
<li>Do everything at once by just typing phing, or phing build.</li>
</ul>

Import items into database
--------------------------

Go to the scripts directory, then type :
_php importActivityItems.php -e environment_

It must then import all of my RSS feeds, but for Twitter import you must put a serialized _Zend_Oauth_Token_Access_ object in the _data/twitter/access.token_ file.