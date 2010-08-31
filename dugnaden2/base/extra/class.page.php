<?php

class page
{
	public $title = array();
	public $head = '';
	public $css = '';
	public $js = '';
	public $js_domready = '';
	protected $js_files_loaded = array();
	public $body_start = '';
	public $body_end = '';
	public $keywords = array();
	public $description = '';
	
	public $theme = '';
	public $theme_file = 'default';
	
	public $content = '';
	
	public $messages = false;
	
	/**
	 * Ikke legge til javascript på siden
	 */
	public $js_disable;
	
	/** Constructor */
	public function __construct()
	{
		global $__page, $__server;
		
		// sørg for at session er startet
		sess_start();
		
		// standardverdier
		$this->title = array($__page['title']);
		$this->keywords = $__page['keywords_default'];
		$this->description = $__page['description_default'];
		$this->theme = $__page['theme'];
		
		// sørg for at sessions/page_settings/messages er satt opp
		if (!isset($_SESSION[$__server['session_prefix'].'page_settings']['messages']))
		{
			$_SESSION[$__server['session_prefix'].'page_settings']['messages'] = array();
		}
		
		$this->messages = &$_SESSION[$__server['session_prefix'].'page_settings']['messages'];
	}
	
	/** Last inn siden (kalles til slutten av scriptet for å hente themet */
	public function load()
	{
		ess::$b->dt("page_load_pre");
		
		// temafilen
		$theme_file = ROOT."/themes/".$this->theme."/".$this->theme_file.".php";
		
		// finnes ikke temafilen?
		if (!file_exists($theme_file))
		{
			throw new HSException("Fant ikke temafilen <b>$this->theme_file.php</b> for temaet <b>$this->theme</b>.");
		}
		
		// legg til innholdet
		$this->content .= ob_get_contents();
		@ob_clean();
		
		// sjekk om vi har en placeholder (der for standard meldinger skal plasseres)
		$placeholder = strpos($this->content, '<boxes />');
		
		// informasjonsmeldinger
		if (count($this->messages) > 0)
		{
			$msgs = '';
			$msgs_top = '';
			$msgs_bottom = '';
			
			// gå gjennom hver melding
			foreach ($this->messages as $row)
			{
				// sett opp html
				$msg = $this->message_format($row);
				
				// spesiell plassering?
				$force = isset($row['force']) ? $row['force'] : false;
				
				// på toppen
				if ($force == "top" && $placeholder !== false)
				{
					$msgs_top .= $msg;
				}
				
				// i bunnen
				elseif ($force == "bottom")
				{
					$msgs_bottom .= $msg;
				}
				
				// standard
				else
				{
					$msgs .= $msg;
				}
			}
			
			// plasser meldingene som skal i bunnen
			if ($msgs_bottom != "") $this->content .= $msgs_bottom;
			
			// plasser meldingene som skal i toppen
			if ($msgs_top != "") $this->content = $msgs_top . $this->content;
			
			// plasser standard meldinger
			if ($placeholder !== false)
			{
				// sørg for korrekt posisjon hvor den skal plasseres i tilfelle innholdet har blitt endret
				// sjekk om vi har en placeholder (der for standard meldinger skal plasseres)
				$placeholder = strpos($this->content, '<boxes />');
				
				$this->content = substr($this->content, 0, $placeholder) . $msgs . substr($this->content, $placeholder);
			}
			else
			{
				$this->content = $msgs . $this->content;
			}
			
			// tøm meldingene
			$this->messages = array();
		}
		
		// fjern placeholder tags
		if ($placeholder !== false)
		{
			$this->content = strtr($this->content, array('<boxes />' => ''));
		}
		
		// hent temafilen
		require $theme_file;
		
		// hent full html kode som ble generert
		$content = ob_get_contents();
		@ob_clean();
		
		// gå gjennom HTML og sjekk for brukerlinker (<user../>) osv. og vis innholdet
		echo parse_html($content);
		
		if (defined("SHOW_QUERIES_INFO"))
		{
			echo '
<a href="javascript:void(0)" onclick="this.nextSibling.style.display=\'block\'">Admin info..</a><div style="display: none"><br /><pre>GET<br />'.htmlspecialchars(print_r($_GET, true)).'<br />POST<br />'.htmlspecialchars(print_r($_POST, true)).'<br />'.htmlspecialchars(print_r(ess::$b->db->queries_text, true)).'</pre></div>';
		}
		
		// stop scriptet
		die;
	}
	
	/** Hent innhold til <head> */
	public function generate_head()
	{
		$head = $this->head;
		
		// legg til css
		if (!empty($this->css))
		{
			$head .= "<style type=\"text/css\">\r\n<!--\r\n" . $this->css . "-->\r\n</style>\r\n";
		}
		
		// legg til javascript
		if (!$this->js_disable && (!empty($this->js) || !empty($this->js_domready)))
		{
			$dr = !empty($this->js_domready) ? "window.addEvent(\"sm_domready\", function() {\r\n{$this->js_domready}});\r\n" : "";
			$head .= "<script type=\"text/javascript\">\r\n<!--\r\n" . $this->js . $dr . "// -->\r\n</script>\r\n";
		}
		
		// send resultatet
		return $head;
	}
	
	/** Generer tittel */
	public function generate_title()
	{
		global $__page;
		
		// sett sammen tittelen og send resultatet
		return implode($__page['title_split'], ($__page['title_direction'] == "right" ? $this->title : array_reverse($this->title)));
	}
	
	/** Generer nøkkelord */
	public function generate_keywords()
	{
		// sett sammen keywords og send resultatet
		return implode(", ", $this->keywords);
	}
	
	/** Legg til tittel */
	public function add_title()
	{
		foreach (func_get_args() as $value) {
			$this->title[] = htmlspecialchars($value);
		}
	}
	
	/** Legg til data i <head> */
	public function add_head($value)
	{
		$this->head .= $value."\r\n";
	}
	
	/** Legg til CSS */
	public function add_css($value)
	{
		$this->css .= $value."\r\n";
	}
	
	/** Legg til en hel CSS fil */
	public function add_css_file($path, $media = "all")
	{
		$this->add_head('<link rel="stylesheet" type="text/css" href="'.$path.'" media="'.$media.'" />');
	}
	
	/** Legg til javascript */
	public function add_js($value)
	{
		$this->js .= $value."\r\n";
	}
	
	/** Legg til javascript som kjøres i domready event */
	public function add_js_domready($value)
	{
		$this->js_domready .= $value."\r\n";
	}
	
	/** Legg til javascript fil */
	public function add_js_file($path)
	{
		// allerede lastet inn?
		if (in_array($path, $this->js_files_loaded)) return;
		$this->js_files_loaded[] = $path;
		$this->add_head('<script src="'.$path.'" type="text/javascript"></script>');
	}
	
	/** Legg til HTML rett etter <body> */
	public function add_body_pre($value)
	{
		$this->body_start .= $value."\r\n";
	}
	
	/** Legg til HTML rett før </body> */
	public function add_body_post($value)
	{
		$this->body_end .= $value."\r\n";
	}
	
	/** Legg til nøkkelord */
	public function add_keyword()
	{
		foreach (func_get_args() as $value) {
			$this->keywords[] = htmlspecialchars($value);
		}
	}
	
	/** Nullstill alle nøkkelordene (sletter dem) */
	public function reset_keywords()
	{	
		$this->keywords = array();
	}
	
	/** Endre beskrivelsen */
	public function set_description($value)
	{
		$this->description = htmlspecialchars($value);
	}
	
	/**
	 * Legg til informasjonsmelding (info, error, osv)
	 * 
	 * @param string $value
	 * @param string $type = NULL
	 * @param string $force = NULL
	 * @param string $name = NULL
	 */
	public function add_message($value, $type = NULL, $force = NULL, $name = NULL)
	{
		// standard type er info
		if ($type === NULL) $type = "info";
		
		// raden
		$row = array(
			"type" => $type,
			"message" => $value
		);
		
		// skal den plasseres et bestemt sted?
		if ($force !== NULL) $row['force'] = $force;
		
		// for å muliggjøre overskriving/sletting
		if ($name)
		{
			$this->messages[$name] = $row;
		}
		else
		{
			$this->messages[] = $row;
		}
	}
	
	/**
	 * Hent ut en bestemt informasjonsmelding
	 */
	public function message_get($name, $erase = true, $format = null)
	{
		// finnes ikke meldingen?
		if (!isset($this->messages[$name])) return null;
		$msg = &$this->messages[$name];
		
		// slette meldingen?
		if ($erase)
		{
			unset($this->messages[$name]);
		}
		
		if ($format) return $this->message_format($msg);
		return $msg;
	}
	
	/**
	 * Formater html for melding
	 */
	public function message_format($row)
	{
		// hva slags type melding?
		switch ($row['type'])
		{
			// feilmelding
			case "error":
				return '<div class="error_box">'.$row['message'].'</div>';
			break;
			
			// informasjon
			case "info":
				return '<div class="info_box">'.$row['message'].'</div>';
			break;
			
			// egendefinert
			case "custom":
				return $row['message'];
			break;
			
			// ukjent
			default:
				return '<div class="info_box">'.htmlspecialchars($row['type']).' (ukjent): '.$row['message'].'</div>';
		}
	}
}