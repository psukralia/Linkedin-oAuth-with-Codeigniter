<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ApiLinkedin extends CI_Controller {
	
    /**
     * this class is developed by psukralia with the help of linkedin api and  some user guide founded on internet
     * there is no need any type of license to use it and there is no issue to reclaim it
     * it is purly open source and free to use
  	 *
  	 *
  	 *
     * @return void Returns nothing
     */
    public function __construct() {
        parent::__construct();
		    $this->load->library("session");
		 
    }

    /**
     * Home page of this site
     * 
     * 
     * @return void Returns nothing
     */
    public function index($REFERRED_BY=0) { 
		$this->load->library('linkedin', array(
            'access' => "xxxxxxxxxxxx",//"<your Consumer Key / API Key goes here>",
            'secret' => "xxxxxxxxxxxxxxxxx",//"<your Consumer Secret / Secret Key goes here>",
            'callback' => "<siteurl-with-folder>index.php/apiLinkedin/receiver"//"<write here your site name>/receiver" 
        ));
		$this->linkedin->getRequestToken();
        $requestToken = serialize($this->linkedin->request_token);
        $this->session->set_userdata(array(
            'requestToken' => $requestToken
        ));
		header("Location: " . $this->linkedin->generateAuthorizeUrl());

    }
	public function receiver(){       
        if (isset($_GET['oauth_problem'])) {
            session_unset();
            $this->session->set_flashdata(
                'linkedinError', 
                array(
                    'type' => 'error',
                    'msg' => 'Sorry! Something went wrong this time. Please try again later.'
                )
            );
            redirect('.');
            exit;
        }

        $this->load->library('linkedin', array(
            'access' => "xxxxxxxxxx",//"<your Consumer Key / API Key goes here>",
            'secret' => "xxxxxxxxxxxxxx",//"<your Consumer Secret / Secret Key goes here>" 
        ));

        // get from session
        $requestToken = $this->session->userdata('requestToken');
        
        if (isset($_REQUEST['oauth_verifier'])) {
            $oauthVerifier = $_REQUEST['oauth_verifier'];
            $this->linkedin->request_token = unserialize($requestToken);
            $this->linkedin->oauth_verifier = $oauthVerifier;
            $this->linkedin->getAccessToken($oauthVerifier);
            // set in session
            $this->session->set_userdata(array(
                'oauth_verifier' => $oauthVerifier,
                'oauth_access_token' => serialize($this->linkedin->access_token)
            ));
        } else {
            $oauthVerifier = $this->session->userdata('oauth_verifier');
            $oauthAccessToken = $this->session->userdata('oauth_verifier');
            $this->linkedin->request_token = unserialize($requestToken);
            $this->linkedin->oauth_verifier = $oauthVerifier;
            $this->linkedin->access_token = unserialize($oauthAccessToken);
        }

        if (isset($_REQUEST['oauth_verifier'])) {
            $userData = $this->linkedin->getUserInfo(
                serialize($this->linkedin->request_token), 
                $this->session->userdata('oauth_verifier'), 
                $this->session->userdata('oauth_access_token')
            );
			 
        } else {
            $userData['status'] = 404;
        }
		echo "<pre>";
        print_r($userData);
	}
	public function linkedauth(){		//optional
 		$get	=	$this->input->get();
 		print_r($get);
 	}



}
