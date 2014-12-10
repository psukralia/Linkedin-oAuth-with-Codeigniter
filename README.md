Linkedin-oAuth-with-Codeigniter
===============================
Codeigniter Library for working with Linkedin API ver 1.1
Please read information before user

This repository contains the open source PHP SDK that allows you to
access Linkedin Platform from your PHP code.

-----

Codeigniter Library for Linkedin (v 1.1)

The basic and require [Step 1. Register your application](https://www.linkedin.com/secure/developer).
Note down your API Key and Secret Key, choose maximize scope for better testing.


Usage
=====

- Download .zip of Linkedin-oAuth-with-Codeigniter
- This folder contain application folder only with require files
- copy apiLinkedin controller to your controller folder carefully make sure you have setup your codeigniter carefully with encryption key for session, you may require to load session library.
- Load linkedin library `with three parameter` in index function, you may also load it when parent contructor invoke. But load only when require for better understanding (I know, it's not optimize way)

```php
<?php
// Intilize controller class
public function index($REFERRED_BY=0) { 
		$this->load->library('linkedin', array(
            'access' => "API key",
            'secret' => "Secret Key",
            'callback' => "Redirect code" 
        ));
		$this->linkedin->getRequestToken();
        $requestToken = serialize($this->linkedin->request_token);
        $this->session->set_userdata(array(
            'requestToken' => $requestToken
        ));
		header("Location: " . $this->linkedin->generateAuthorizeUrl());
    }

```





- Pass your API key, Secret Key and Redirect url `see below for more for redirect url` while loading.
- Great! Upto this, you have finish 50% of your Job. Test it By calling your controller `<siteurl><folder-where-you-set-up-for-test-it>index.php/apiLinkedin/`.
- Now copy Library file and oAuth folder to your `application/libraries` folder.



Fetch User Data
===============
- Find receiver function in `controllers/apiLinkedin.php file` modify it carefully this function is `Redirect url` for index function.
- Load linkedin library `with two parameter` in reveiver function 
- Pass your API key and Secret key then call getUserInfo function (already called in file) and user it in your manner (I am just printing it).
- Great! You done.

Now call your controller and enjoy!


Report Issues/Bugs
------------------
[write me for any question](mailto:psukralia@gmail.com)
