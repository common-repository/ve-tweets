<?php
/*
Plugin Name: VE Tweets
Plugin URI: 
Description: Display recent tweets from your twitter account.
Version: 1.1
Author: virtualemployee
Author URI: http://www.virtualemployee.com
Text Domain: ve-tweets
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
class VirtualAdminTweets{
	 
	 protected $pluginPath;
     protected $pluginUrl;
	
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_ve_tweets_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        // Add shortcode support for widgets
        add_filter('widget_text', 'do_shortcode');
    }

    /**
     * Add options page
     */
    public function add_ve_tweets_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'VE Tweets', 
            'VE Tweets', 
            'manage_options', 
            've-tweets-settings', 
            array( $this, 'create_ve_tweets_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_ve_tweets_admin_page()
    {
        // Set class property
        $this->options = get_option('ve_tweets_option' );
        ?>
        <div class="wrap">
            <h1>VE Tweets Settings</h1>
            
		   <form method="post" action="options.php">
			   
				<?php 
					settings_fields( 've_tweets_option_group' );
					//do_settings_sections( 've-tweets-setting-admin' );
					/*//username
					printf('username',$this->username_callback());
					//consumer key
					$this->consumerkey_callback();
					//consumer secret
					$this->consumersecret_callback();
					//access token
					$this->accesstoken_callback();
					//access toekn secret
					$this->accesstokensecret_callback();
					//number of tweets
					$this->notweets_callback();*/
					do_settings_sections( 've-tweets-settings' );
					submit_button();
				
				 ?>

			</form>
			<p>Shortcode : [vetweets limit="5"]</p>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            've_tweets_option_group', // Option group
            've_tweets_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            've_tweets_id', // ID
            'VE Tweets Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            've-tweets-settings' // Page
        );  

        add_settings_field(
            'username', // ID
            'Username', // Title 
            array( $this, 'username_callback' ), // Callback
            've-tweets-settings', // Page
            've_tweets_id' // Section           
        ); 
             
        add_settings_field(
            'consumerkey', // ID
            'Consumer Key', // Title 
            array( $this, 'consumerkey_callback' ), // Callback
            've-tweets-settings', // Page
            've_tweets_id' // Section           
        );  
        
        add_settings_field(
            'consumersecret', // ID
            'Consumer Secret', // Title 
            array( $this, 'consumersecret_callback' ), // Callback
            've-tweets-settings', // Page
            've_tweets_id' // Section           
        ); 
        
        add_settings_field(
            'accesstoken', // ID
            'Access Token', // Title 
            array( $this, 'accesstoken_callback' ), // Callback
            've-tweets-settings', // Page
            've_tweets_id' // Section           
        ); 
        
        add_settings_field(
            'accesstokensecret', // ID
            'Access Token Secret', // Title 
            array( $this, 'accesstokensecret_callback' ), // Callback
            've-tweets-settings', // Page
            've_tweets_id' // Section           
        );    
        
        add_settings_field(
            'notweets', // ID
            'Number of tweets', // Title 
            array( $this, 'notweets_callback' ), // Callback
            've-tweets-settings', // Page
            've_tweets_id' // Section           
        );    
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['username'] ) )
            $new_input['username'] = sanitize_text_field( $input['username'] );
            
        if( isset( $input['consumerkey'] ) )
            $new_input['consumerkey'] = sanitize_text_field( $input['consumerkey'] );
            
        if( isset( $input['consumersecret'] ) )
            $new_input['consumersecret'] = sanitize_text_field( $input['consumersecret'] );
            
        if( isset( $input['accesstoken'] ) )
            $new_input['accesstoken'] = sanitize_text_field( $input['accesstoken'] );
            
        if( isset( $input['accesstokensecret'] ) )
            $new_input['accesstokensecret'] = sanitize_text_field( $input['accesstokensecret'] );
            
        if( isset( $input['notweets'] ) )
            $new_input['notweets'] = sanitize_text_field( $input['notweets'] );

       

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function username_callback()
    {
        printf(
            '<input type="text" id="username" name="ve_tweets_option[username]" value="%s" size="40"/>',
            isset( $this->options['username'] ) ? esc_attr( $this->options['username']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function consumerkey_callback()
    {
        printf(
            '<input type="text" id="consumerkey" name="ve_tweets_option[consumerkey]" value="%s" size="40"/>',
            isset( $this->options['consumerkey'] ) ? esc_attr( $this->options['consumerkey']) : ''
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function consumersecret_callback()
    {
        printf(
            '<input type="text" id="consumersecret" name="ve_tweets_option[consumersecret]" value="%s" size="40"/>',
            isset( $this->options['consumersecret'] ) ? esc_attr( $this->options['consumersecret']) : ''
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function accesstoken_callback()
    {
        printf(
            '<input type="text" id="accesstoken" name="ve_tweets_option[accesstoken]" value="%s" size="40"/>',
            isset( $this->options['accesstoken'] ) ? esc_attr( $this->options['accesstoken']) : ''
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function accesstokensecret_callback()
    {
        printf(
            '<input type="text" id="accesstokensecret" name="ve_tweets_option[accesstokensecret]" value="%s" size="40"/>',
            isset( $this->options['accesstokensecret'] ) ? esc_attr( $this->options['accesstokensecret']) : ''
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function notweets_callback()
    {
        printf(
            '<input type="text" id="notweets" name="ve_tweets_option[notweets]" value="%s" size="40"/>',
            isset( $this->options['notweets'] ) ? esc_attr( $this->options['notweets']) : ''
        );
    }
}

if( is_admin() )
    $ve_tweets_settings_page = new VirtualAdminTweets();
    

/**------------------------------------------------------
				Start Twitter shortcode
------------------------------------------------------**/
if(!is_admin() ):
if(!function_exists('ts_add_link_on_url_func')):
function ts_add_link_on_url_func($content) {   
    return preg_replace('![^\'"=](((f|ht)tp(s)?://)[-a-zA-ZÐ°-ÑÐ-Ð¯()0-9@:%_+.~#?&;//=]+)!i', ' <a href="$1" target="_blank">$1</a> ', $content);
} 
endif;

if(!function_exists('getConnectionWithAccessToken')):
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
return $connection;
}
endif;

if(!function_exists('ve_get_tweets_func')):
	function ve_get_tweets_func( $attr ) 
	{
		/*
		 * Define plugin path
		 * */
		define( 'VE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
        include( VE_PLUGIN_PATH . 'lib/twitteroauth.php');
         //include( MY_PLUGIN_PATH . 'includes/classes.php');
        /** 
         * Access Twitter Lib Files
         * 
         * */
		//   require_once(plugins_url( 'lib/twitteroauth.php', __FILE__ ));
		
		 $options = get_option('ve_tweets_option' );

		 
		/** Define twitter access details  */
		
		/** Define twitter access details  */
		$twitteruser  		= $options['username'];
		$notweets 			= $attr['limit'] ? $attr['limit'] : ($options['notweets'] ? $options['notweets'] : 5);
		$consumerkey 		= $options['consumerkey'];
		$consumersecret 	= $options['consumersecret'];
		$accesstoken 		= $options['accesstoken'];
		$accesstokensecret 	= $options['accesstokensecret']; 
		
		$connection 		= getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		
		$tweets 			= $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
		
		$veTweetscontent='';
		$heading = isset($attr['heading']) ? $attr['heading'] :'';
		
		if($tweets)
			{
				$veTweetscontent.='<div id="ve_tweets_sec" class="bdr-top">';
				if($heading!='')$veTweetscontent.='<h3 class="ve_tweets_heading">'.$heading.'</h3>';
				$veTweetscontent.='<ul class="ve_tweets">';
				//echo '<pre>'; print_r($tweets):
				 foreach ( $tweets as $tweet ) : 
				  /* $mediaArypath=$tweet->entities->media;
				 
				     $imgPath= isset($mediaArypath[0]->media_url) ? $mediaArypath[0]->media_url:''; */
				 
					 $updatedcontent=ts_add_link_on_url_func($tweet->text);	
					 $veTweetscontent.='<li>';
									$veTweetscontent.='	<div class="post-holder">'.$updatedcontent.'</div>
									    <span class="ts-slide-date">'.date('F jS Y h:m:s',strtotime($tweet->created_at)).'</span>
										
									</li>';
				endforeach;
				 $veTweetscontent.='</ul></div>';
				}
		return $veTweetscontent;
	}
endif;
add_shortcode( 'vetweets', 've_get_tweets_func' );

endif; //end !is_admin
// Add shortcode support for widgets
add_filter('widget_text', 'do_shortcode');
?>
