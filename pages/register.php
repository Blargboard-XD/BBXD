<?php
//  Blargboard XD - User account registration page
//  Access: any, but meant for guests.
//  Extra security by Super-toad 65 
if (!defined('BLARG')) die();

$title = __("Register");

echo "<script src=\"".resourceLink('js/register.js')."\"></script>
<script src=\"".resourceLink('js/zxcvbn.js')."\"></script>";

class StopForumSpam {
    /**
    * The API key.
    *
    * @var string
    */
    private $api_key;
    /**
    * The base url, for tha API/
    *
    * @var string
    */
    private $endpoint = 'http://www.stopforumspam.com/';
    /**
    * Constructor.
    *
    * @param string $api_key Your API Key, optional (unless adding to database).
    */
    public function __construct( $api_key = null ) {
        // store variables
        $this->api_key = $api_key;
    }
    /**
    * Add to the database
    *
    * @param array $args associative array containing email, ip, username and optionally, evidence
    * e.g. $args = array('email' => 'user@example.com', 'ip_addr' => '8.8.8.8', 'username' => 'Spammer?', 'evidence' => 'My favourite website http://www.example.com' );
    * @return boolean Was the update succesfull or not.
    */
    public function add( $args ) {
        // check for mandatory arguments
        if (empty($args['username']) || empty($args['ip_addr']) || empty($args['email']) ) {
            return false;
        }
        // known?
        $is_spammer = $this->is_spammer($args);
        if (!$is_spammer || $is_spammer['known']) {
            return false;
        }
        // add api key
        $args['api_key'] = $this->api_key;
        // url to poll
        $url = $this->endpoint.'add.php?'.http_build_query($args, '', '&');
        // execute
        $response = file_get_contents($url);
        return (false == $response ? false : true);
    }
    /**
    * Get record from spammers database.
    *
    * @param array $args associative array containing either one (or all) of these: username / email / ip.
    * e.g. $args = array('email' => 'user@example.com', 'ip' => '8.8.8.8', 'username' => 'Spammer?' );
    * @return object Response.
    */
    public function get( $args ) {
        // should check first if not already in database
        // url to poll
        $url = $this->endpoint.'api?f=json&'.http_build_query($args, '', '&');
        //
        return $this->poll_json( $url );
    }
    /**
    * Check if either details correspond to a known spammer. Checking for username is discouraged.
    *
    * @param array $args associative array containing either one (or all) of these: username / email / ip
    * e.g. $args = array('email' => 'user@example.com', 'ip' => '8.8.8.8', 'username' => 'Spammer?' );
    * @return boolean
    */
    public function is_spammer( $args ) {
        // poll database
        $record = $this->get( $args );
        if ( !isset($record->success) ) {
            return false;
        }
        // give the benefit of the doubt
        $spammer = false;
        // are all datapoints on SFS?
        $known = true;
        // parse database record
        $datapoint_count = 0;
        $known_datapoints = 0;
        foreach( $record as $datapoint ) {
            // not 'success'
            if ( isset($datapoint->appears) && $datapoint->appears ) {
                $datapoint_count++;
                // are ANY of the datapoints on SFS?
                if ( $datapoint->appears == true)
                {
                    $known_datapoints++;
                    $spammer = true;
                }
            }
        }
        // are ANY of the datapoints not on SFS
        if ( $datapoint_count > $known_datapoints) {
            $known = false;
        }
		return $spammer;
        return array(
            'spammer' => $spammer,
            'known' => $known
        );
    }
    /**
    * Get json and decode. Currently used for polling the database, but hoping for future
    * json response support, when adding.
    *
    * @param string $url The url to get
    * @return object Response.
    */
    protected static function poll_json( $url )
    {
        $json = file_get_contents( $url );
        $object = json_decode($json);
        return $object;
    }
}
function IsTorExitPoint(){
    if (gethostbyname(ReverseIPOctets($_SERVER['REMOTE_ADDR']).".".$_SERVER['SERVER_PORT'].".".ReverseIPOctets($_SERVER['SERVER_ADDR']).".ip-port.exitlist.torproject.org")=="127.0.0.2") {
        return true;
    } else {
       return false;
    }
}
function ReverseIPOctets($inputip){
    $ipoc = explode(".",$inputip);
    return $ipoc[3].".".$ipoc[2].".".$ipoc[1].".".$ipoc[0];
}

MakeCrumbs(array('' => __('Register')));

$sexes = array(__("Male"), __("Female"), __("N/A"));

if($_POST['register']) {
	if (IsProxy()) {
		$adminemail = Settings::get('ownerEmail');
		if ($adminemail) $halp = '<br><br>If you aren\'t using a proxy, contact the board owner at: '.$adminemail;
		else $halp = '';
		
		$err = __('Registrations from proxies are not allowed. Turn off your proxy and try again.'.$halp);
	} else {
		$name = trim($_POST['name']);
		$cname = str_replace(" ","", strtolower($name));

		$rUsers = Query("select name, displayname from {users}");
		while($user = Fetch($rUsers)) {
			$uname = trim(str_replace(" ", "", strtolower($user['name'])));
			if($uname == $cname)
				break;
			$uname = trim(str_replace(" ", "", strtolower($user['displayname'])));
			if($uname == $cname)
				break;
		}

		$ipKnown = FetchResult("select COUNT(*) from {users} where lastip={0}", $_SERVER['REMOTE_ADDR']);

		if (stripos($_POST['email'], '@dispostable.com') !== FALSE)
			$err = __('Registration failed. Try again later.');
		else if (!$cname)
			$err = __('Enter a username and try again.');
		elseif($uname == $cname)
			$err = __("This user name is already taken. Please choose another.");
		elseif($ipKnown >= 1)
			$err = __("Another user is already using this IP address.");
		else if(!$_POST['readFaq'])
			$err = format(__("You really should {0}read the FAQ{1}&hellip;"), "<a href=\"".actionLink("faq")."\">", "</a>");
		else if ($_POST['likesCake'])
			$err = __("Robots not allowed.");
		else if(strlen($_POST['pass']) < 8)
			$err = __("Your password must be at least eight characters long.");
		else if ($_POST['pass'] !== $_POST['pass2'])
			$err = __("The passwords you entered don't match.");
		else if(!$_POST['email'])
			$err = __("You need to specify an email.");
            
		$reasons = array();
		if(IsTorExitPoint()) {
			$reasons[] = 'tor';
		}
		$s = new StopForumSpam($stopForumSpamKey);
		if($s->is_spammer(array('email' => $_POST['email'], 'ip' => $_SERVER['REMOTE_ADDR'] ))) {
			$reasons[] = 'sfs';
		}
		if(count($reasons)) {
			$reason = implode(',', $reasons);
			$bucket = "regfail"; include("lib/pluginloader.php");
			$err = 'An unknown error occured, please try again.';
		}
	}

	if($err)
		Alert($err, __('Error'));
	else {
		$newsalt = Shake();
		$sha = doHash($_POST['pass'].SALT.$newsalt);
		$uid = FetchResult("SELECT id+1 FROM {users} WHERE (SELECT COUNT(*) FROM {users} u2 WHERE u2.id={users}.id+1)=0 ORDER BY id ASC LIMIT 1");
		if($uid < 1) $uid = 1;

		$rUsers = Query("insert into {users} (id, name, password, pss, primarygroup, regdate, lastactivity, lastip, email, sex, theme) values ({0}, {1}, {2}, {3}, {4}, {5}, {5}, {6}, {7}, {8}, {9})", 
			$uid, $_POST['name'], $sha, $newsalt, Settings::get('defaultGroup'), time(), $_SERVER['REMOTE_ADDR'], $_POST['email'], (int)$_POST['sex'], Settings::get("defaultTheme"));

		Report("New user: [b]".$_POST['name']."[/] (#".$uid.") -> [g]#HERE#?uid=".$uid);

		$user = Fetch(Query("select * from {users} where id={0}", $uid));
		$user['rawpass'] = $_POST['pass'];

		$bucket = "newuser"; include(BOARD_ROOT."lib/pluginloader.php");


		$rLogUser = Query("select id, pss, password from {users} where 1");
		$matches = array();

		while($testuser = Fetch($rLogUser)) {
			if($testuser['id'] == $user['id'])
				continue;

			$sha = doHash($_POST['pass'].SALT.$testuser['pss']);
			if($testuser['password'] === $sha)
				$matches[] = $testuser['id'];
		}

		if (count($matches) > 0)
			Query("INSERT INTO {passmatches} (date,ip,user,matches) VALUES (UNIX_TIMESTAMP(),{0},{1},{2})", $_SERVER['REMOTE_ADDR'], $user['id'], implode(',',$matches));

		// mark threads older than 15min as read
		Query("INSERT INTO {threadsread} (id,thread,date) SELECT {0}, id, {1} FROM {threads} WHERE lastpostdate<={2} ON DUPLICATE KEY UPDATE date={1}", $uid, time(), time()-900);


		if($_POST['autologin']) {
			$sessionID = Shake();
			setcookie("logsession", $sessionID, 0, URL_ROOT, "", false, true);
			Query("INSERT INTO {sessions} (id, user, autoexpire) VALUES ({0}, {1}, {2})", doHash($sessionID.SALT), $user['id'], 0);
			die(header("Location: ".actionLink('profile', $user['id'], '', $user['name'])));
		} else
			die(header("Location: ".actionLink("login")));
	}
} else {
	$_POST['name'] = '';
	$_POST['email'] = '';
	$_POST['sex'] = 2;
	$_POST['autologin'] = 0;
}

$fields = array(
	'username' => "<input type=\"text\" id=\"un\" name=\"name\" maxlength=20 size=24 autocorrect=off autocapitalize=words value=\"".htmlspecialchars($_POST['name'])."\" class=\"required\">",
	'password' => "<input type=\"password\" id=\"pw\" name=\"pass\" size=24 class=\"required\">",
	'password2' => "<input type=\"password\" id=\"pw2\" name=\"pass2\" size=24 class=\"required\">",
	'email' => "<input type=\"email\" id=\"email\" type=email name=\"email\" value=\"".htmlspecialchars($_POST['email'])."\" maxlength=\"60\" size=24 class=\"required\">",
	'sex' => MakeOptions("sex",$_POST['sex'],$sexes),
	'readfaq' => "<label><input type=\"checkbox\" name=\"readFaq\">".format(__("I have read the {0}FAQ{1}"), "<a href=\"".actionLink("faq")."\">", "</a>")."</label>",
	'autologin' => "<label><input type=\"checkbox\" checked=\"checked\" name=\"autologin\"".($_POST['autologin']?' checked="checked"':'').">".__("Log in afterwards")."</label>",
	
	'btnRegister' => "<input type=\"submit\" name=\"register\" value=\"".__("Register")."\">",
);

echo "<form action=\"".htmlentities(actionLink("register"))."\" method=\"post\">";

RenderTemplate('form_register', array('fields' => $fields));

echo "<span style=\"display : none;\"><input type=\"checkbox\" name=\"likesCake\"> I am a robot</span></form>";


function MakeOptions($fieldName, $checkedIndex, $choicesList) {
	$checks[$checkedIndex] = " checked=\"checked\"";
	foreach($choicesList as $key=>$val)
		$result .= format("
					<label>
						<input type=\"radio\" name=\"{1}\" value=\"{0}\"{2}>
						{3}
					</label>", $key, $fieldName, $checks[$key], $val);
	return $result;
}

function IsProxy() {
	if ($_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR'] != $_SERVER['REMOTE_ADDR'])
		return true;
		
	$result = QueryURL('http://www.stopforumspam.com/api?ip='.urlencode($_SERVER['REMOTE_ADDR']));
	if (!$result)
		return false;

	if (stripos($result, '<appears>yes</appears>') !== FALSE)
		return true;
		
	return false;
}

?>
