<?php

class Lop
{
    const domain = 'plays.gg';
    const webname = 'PLAYS.GG';
    const version = '1.0';
    const trailer_id = 'dmERWWjCJl0';
    
    const default_theme = 'theme1';
    const contest_rewards = 'level1';
    const development = true;
    
    public static function when($date)
    {
        $datetoday = date('F jS', strtotime(Server::getDate()));
        $playdate = date('F jS', strtotime($date));
        $msyesterday = time() - 86400;
        $msplay = strtotime($playdate);
        if ($datetoday == $playdate) 
        {
            return "Today, " . date('g:ia', strtotime($date));
        } 
        elseif ($msplay < $msyesterday && $msplay > (time() - (86400 * 2))) 
        {
            return "Yesterday, " . date('g:ia', strtotime($date));
        } 
        else 
        {
            return date('F jS, g:ia', strtotime($date));
        }
    }
    
    public static function time_elapsed_string($ptime)
    {
        $etime = time() - $ptime;

        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
                    );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }
    
    public static function toAscii($str) 
    {
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

	return $clean;
    }
    
    public static function globalXssClean()
    {
        $sanitized = static::arrayStripTags(Input::except('description', 'editor', 'data', 'sdata'));
        Input::merge($sanitized);
    }

    public static function arrayStripTags($array)
    {
        $result = array();

        foreach ($array as $key => $value) {
            $key = strip_tags($key);
            
            if (is_array($value)) {
                $result[$key] = static::arrayStripTags($value);
            } else {
                $result[$key] = /*trim(*/strip_tags($value)/*)*/;
            }
        }

        return $result;
    }
    
    public static function toRoman($n)
    {
        if($n==5) {
            return 'V';
        } elseif($n==4) {
            return 'IV';
        } elseif($n==3) {
            return 'III';
        } elseif($n==2) {
            return 'II';
        } elseif($n==1) {
            return 'I';
        } elseif($n==0) {
            return '?';
        }
    }
    
    public static function toArabic($n)
    {
        if($n=='V') {
            return 5;
        } elseif($n=='IV') {
            return 4;
        } elseif($n=='III') {
            return 3;
        } elseif($n=='II') {
            return 2;
        } elseif($n=='I') {
            return 1;
        }
    }
    
    public static function getbetween($var1 = "", $var2 = "", $pool) 
    {
        $temp1 = strpos($pool, $var1) + strlen($var1);
        $result = substr($pool, $temp1, strlen($pool));
        $dd = strpos($result, $var2);
        if ($dd == 0) 
        {
            $dd = strlen($result);
        }

        return substr($result, 0, $dd);
    }
    
    public static function getChampImg($champion)
    {
        $chars = array("'", ".", " ");
        $x = str_replace($chars, '', $champion);
        
        return $x;
    }
    
    public static function cover()
    {
        $total_covers = 32;
        //Session::forget('cover');
        if(!Session::has('cover'))
        {
            Session::put('cover', rand(1, $total_covers));
        }
    }
    
    // medal constats
    const playmaster1 = 100;
    const playmaster2 = 50;
    const playmaster3 = 15;
    
    const votemaniac1 = 1500;
    const votemaniac2 = 750;
    const votemaniac3 = 250;
    
    const commentator1 = 850;
    const commentator2 = 350;
    const commentator3 = 100;
}

class Server
{
    const laravel_version = '4.1.10';

    public static function getLaravelVersion()
    {
        return self::laravel_version;
    }
    
    public static function getApacheAndPHPVersion()
    {
        $version = apache_get_version();
        return $version;
    }
    
    public static function getClientIP()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
    
    public static function getDate()
    {
        return date('Y-m-d H:i:s');
    }
}

class CustomValidation
{
    public function youtubevideo($field, $value, $params)
    { 
 
        if (strpos($value,'youtube.com/watch?v=') !== false)
        {
            $ytparams = explode('?v=', $value);
            $ytid = explode('&', $ytparams[1]);
            
            if(strlen($ytid[0])<11)
            {
                return false;
            }   
            $context = stream_context_create(array(
                'http' => array('ignore_errors' => true),
            ));
                        
            $data = file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$ytid[0], false, $context);
            
            if($data=="Invalid id" || $data=="Video not found")
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }    
}

class YouTube
{
    public static function getThumbnail($link)
    {
            $ytparams = explode('?v=', $link);
            $ytid = explode('&', $ytparams[1]);
            
            if(strlen($ytid[0])<11)
            {
                return false;
            }               
            return 'https://img.youtube.com/vi/'.$ytid[0].'/sddefault.jpg';
    }
    
    public static function getID($link)
    {
            $ytparams = explode('?v=', $link);
            $ytid = explode('&', $ytparams[1]);
            
            if(strlen($ytid[0])<11)
            {
                return false;
            }               
            return $ytid[0];
    }
}



class JSON
{
        public static function prettyPrint($json, $html = false) 
        {
                $tabcount = 0; 
		$result = ''; 
		$inquote = false; 
		$ignorenext = false; 
                $help = 0;
                
		if ($html) { 
		    $tab = "&nbsp;&nbsp;&nbsp;"; 
		    $newline = "<br/>"; 
		} else { 
		    $tab = "\t"; 
		    $newline = "\n"; 
		} 
 
		for($i = 0; $i < strlen($json); $i++) { 
		    $char = $json[$i]; 
 
		    if ($ignorenext) { 
		        $result .= $char; 
		        $ignorenext = false; 
		    } else { 
		        switch($char) {
                            case ':':
                                $next = $json[$i+1];
                                $previous = $json[$i-1];
                                if($previous=='"')
                                {
                                    $result .= ' <b><span style="color: #339933">'.$char.'</span></b> ';
                                }
                                break;
		            case '{': 
		                $tabcount++; 
		                $result .= "<span style='color:red'>" . $char . "</span>" . $newline . str_repeat($tab, $tabcount); 
		                break; 
		            case '}': 
		                $tabcount--; 
		                $result = trim($result) . $newline . str_repeat($tab, $tabcount) . "<span style='color:red'>" . $char . "</span>"; 
		                break; 
                           case '[': 
		                $tabcount++; 
		                $result .= "<span style='color:darkred'>" . $char . "</span>" . $newline . str_repeat($tab, $tabcount); 
		                break; 
		            case ']': 
		                $tabcount--; 
		                $result = trim($result) . $newline . str_repeat($tab, $tabcount) . "<span style='color:darkred'>" . $char . "</span>"; 
		                break; 
		            case ',': 
		                $result .= $char . $newline . str_repeat($tab, $tabcount); 
		                break; 
		            case '"': 
		                $inquote = !$inquote; 
		                $result .= $char;
                                $next = $json[$i+1];
                                $previous = $json[$i-1];
                                if($next==":") {
                                    $result .= "</b>";
                                }
                                if($previous=="," || $previous=="{") {
                                    $result .= "<b>";
                                }
                                
		                break; 
		            case '\\': 
		                if ($inquote) $ignorenext = true; 
		                $result .= $char; 
		                break; 
		            default: 
		                $result .= $char; 
		        } 
		    } 
		} 
 
		return $result; 
	}    
}

class LeagueCDN 
{
    public static function getCurrentVersion()
    {
        $url = 'https://ddragon.leagueoflegends.com/realms/na.json';
        $json = file_get_contents($url);
        $data = json_decode($json);
        
        return $data->v;
    }
    
    public static function getIcon($version, $id)
    {
        return 'https://ddragon.leagueoflegends.com/cdn/'.$version.'/img/profileicon/'.$id.'.png';
    }
    
}
class League
{
    public static function getChampions()
    {
        $ch = array('Aatrox','Ahri','Akali','Alistar','Amumu','Anivia','Annie','Ashe','Blitzcrank','Brand','Caitlyn','Cassiopeia','Cho\'Gath','Corki','Darius','Diana','Dr. Mundo','Draven','Elise','Evelynn','Ezreal','Fiddlesticks','Fiora','Fizz','Galio','Gangplank','Garen','Gragas','Graves','Hecarim','Heimerdinger','Irelia','Janna','Jarvan IV','Jax','Jayce','Jinx','Karma','Karthus','Kassadin','Katarina','Kayle','Kennen','Kha\'Zix','Kog\'Maw','LeBlanc','Lee Sin','Leona','Lissandra','Lucian','Lulu','Lux','Malphite','Malzahar','Maokai','Master Yi','Miss Fortune','Mordekaiser','Morgana','Nami','Nasus','Nautilus','Nidalee','Nocturne','Nunu','Olaf','Orianna','Pantheon','Poppy','Quinn','Rammus','Renekton','Rengar','Riven','Rumble','Ryze','Sejuani','Shaco','Shen','Shyvana','Singed','Sion','Sivir','Skarner','Sona','Soraka','Swain','Syndra','Talon','Taric','Teemo','Thresh','Tristana','Trundle','Tryndamere','Twisted Fate','Twitch','Udyr','Urgot','Varus','Vayne','Veigar','Vi','Viktor','Vladimir','Volibear','Warwick','Wukong','Xerath','Xin Zhao','Yasuo','Yorick','Zac','Zed','Ziggs','Zilean','Zyra');
    
        return $ch;        
    }
}
class RiotAPI {
        const API_URL_1_1 = 'http://prod.api.pvp.net/api/lol/{region}/v1.1/';
        const API_URL_1_2 = 'http://prod.api.pvp.net/api/lol/{region}/v1.2/';
        const API_URL_2_1 = 'http://prod.api.pvp.net/api/lol/{region}/v2.2/';
        const API_KEY = 'ff8e559e-abcd-4a66-a38e-17a6aee2171d';
        const RATE_LIMIT_MINUTES = 500;
        const RATE_LIMIT_SECONDS = 10;
        const CACHE_LIFETIME_MINUTES = 60;
        const CACHE_ENABLED = false;
        private $REGION;
        
        public function __construct($region)
        {
                $this->REGION = $region;                
        }

        public function getChampion(){
                $call = 'champion';

                //add API URL to the call
                $call = self::API_URL_1_1 . $call;

                return $this->request($call);
        }

        public function getGame($id){
                $call = 'game/by-summoner/' . $id . '/recent';

                //add API URL to the call
                $call = self::API_URL_1_2 . $call;

                return $this->request($call);
        }

        public function getLeague($id){
                $call = 'league/by-summoner/' . $id;

                //add API URL to the call
                $call = self::API_URL_2_1 . $call;

                return $this->request($call);
        }

        public function getStats($id,$option='summary'){
                $call = 'stats/by-summoner/' . $id . '/' . $option;

                //add API URL to the call
                $call = self::API_URL_1_1 . $call;

                return $this->request2($call);
        }

        public function getSummoner($id,$option=null){
                $call = 'summoner/' . $id;
                switch ($option) {
                        case 'masteries':
                                $call .= '/masteries';
                                break;
                        case 'runes':
                                $call .= '/runes';
                                break;
                        case 'name':
                                $call .= '/name';
                                break;
                        
                        default:
                                //do nothing
                                break;
                }

                //add API URL to the call
                $call = self::API_URL_1_2 . $call;

                return $this->request($call);
        }


        public function getSummonerByName($name){


                //sanitize name a bit - this will break weird characters
                $name = preg_replace("/[^a-zA-Z0-9 ]+/", "", $name);
                $call = 'summoner/by-name/' . $name;

                //add API URL to the call
                $call = self::API_URL_1_2 . $call;

                return $this->request($call);
        }


        public function getTeam($id){
                $call = 'team/by-summoner/' . $id;

                //add API URL to the call
                $call = self::API_URL_2_1 . $call;

                return $this->request($call);
        }

        private function request($call){
                $url = $this->format_url($call);
                $result = file_get_contents($url);
                
                return $result;        

        }

        //creates a full URL you can query on the API
        private function format_url($call){
                return str_replace('{region}', $this->REGION, $call) . '?api_key=' . self::API_KEY;
        }
        
        private function request2($call){
                $url = $this->format_url2($call);
                $result = file_get_contents($url);
                
                return $result;        

        }

        //creates a full URL you can query on the API
        private function format_url2($call){
                return str_replace('{region}', $this->REGION, $call) . '&api_key=' . self::API_KEY;
        }
}