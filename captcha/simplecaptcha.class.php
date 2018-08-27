<?php
class SimpleCaptcha {
	/** Fonts location */
	var $lokasifont = "";
	
    var $tulisan  = "";
	
    /** Width of the image */
    var $width  = 80;

    /** Height of the image */
    var $height = 30;

    /** Dictionary word file (empty for randnom text) */
    var $wordsFile = "";

    /** Min word length (for non-dictionary random text generation) */
    var $minWordLength = 4;

    /**
     * Max word length (for non-dictionary random text generation)
     * 
     * Used for dictionary words indicating the word-length
     * for font-size modification purposes
     */
    var $maxWordLength = 4;

    /** Sessionname to store the original text */
    var $session_var = 'zonaariemendaediindonesia';

    /** Background color in RGB-array */
    var $backgroundColor = array(255, 255, 255);

    /** Foreground colors in RGB-array */
    var $colors = array(//array(27,78,181),
        //array(22,163,35),
        array(0,149,67)
		//array(214,36,7), 
		//array(47,141,228), 
		//array(122,26,211), 
		//array(172,35,64), 
		//array(255,204,0)
		);

    /** Shadow color in RGB-array or false */
    var $shadowColor = false; //array(0, 0, 0);

    /**
     * Font configuration
     *
     * - font: TTF file
     * - spacing: relative pixel space between character
     * - minSize: min font size
     * - maxSize: max font size
     */
    var $fonts = array(
        //'Antykwa'  => array('spacing' => -2, 'minSize' => 15, 'maxSize' => 16, 'font' => 'AntykwaBold.ttf')
        //'Candice'  => array('spacing' =>-1,'minSize' => 16, 'maxSize' => 19, 'font' => 'Candice.ttf')
        //'DingDong' => array('spacing' => 0, 'minSize' => 12, 'maxSize' => 14, 'font' => 'Ding-DongDaddyO.ttf')
        //'Duality'  => array('spacing' => -1, 'minSize' => 14, 'maxSize' => 16, 'font' => 'Duality.ttf')
        //'Heineken' => array('spacing' => -2, 'minSize' => 17, 'maxSize' => 22, 'font' => 'Heineken.ttf'),
        //'Jura'     => array('spacing' => -1, 'minSize' => 16, 'maxSize' => 20, 'font' => 'Jura.ttf'),
        //'StayPuft' => array('spacing' =>-1,'minSize' => 16, 'maxSize' => 20, 'font' => 'StayPuft.ttf'),
        'Times'    => array('spacing' => -1, 'minSize' => 14, 'maxSize' => 15, 'font' => 'TimesNewRomanBold.ttf')
        //'VeraSans' => array('spacing' => -0.5, 'minSize' => 8, 'maxSize' => 16, 'font' => 'VeraSansBold.ttf')
    );

    /** Wave configuracion in X and Y axes */
    var $Yperiod    = 10;
    var $Yamplitude = 0;
    var $Xperiod    = 10;
    var $Xamplitude = 3;

    /** letter rotation clockwise */
    var $maxRotation = 2;

    /**
     * Internal image size factor (for better image quality)
     * 1: low, 2: medium, 3: high
     */
    var $scale = 2;

    /** 
     * Blur effect for better image quality (but slower image processing).
     * Better image results with scale=3
     */
    var $blur = false;

    /** Debug? */
    var $debug = false;
    
    /** Image format: jpeg or png */
    var $imageFormat = 'png';


    /** GD image */
    var $im;

    function __construct($config = array()) {
    }

    function CreateImage() {
        $ini = microtime(true);

        /** Initialization */
        $this->ImageAllocate();
		
        /** Text insertion */
        $text = $this->GetCaptchaText();
        $fontcfg  = $this->fonts[array_rand($this->fonts)];
        $this->WriteText($text, $fontcfg);

        $_SESSION[$this->session_var] = $text;

        /** Transformations */
     //   $this->WaveImage();
        if ($this->blur) {
            //imagefilter($this->im, IMG_FILTER_GAUSSIAN_BLUR);
        }
       // $this->ReduceImage();


        if ($this->debug) {
            imagestring($this->im, 1, 1, $this->height-8,
                "$text {$fontcfg['font']} ".round((microtime(true)-$ini)*1000)."ms",
                $this->GdFgColor
            );
        }


        /** Output */
        $this->WriteImage();
        $this->Cleanup();
    }

    /**
     * Creates the image resources
     */
    function ImageAllocate() {
        // Cleanup
        if (!empty($this->im)) {
            imagedestroy($this->im);
        }

        $this->im = imagecreatetruecolor($this->width*$this->scale, $this->height*$this->scale);

        // Background color
        $this->GdBgColor = imagecolorallocate($this->im,
            $this->backgroundColor[0],
            $this->backgroundColor[1],
            $this->backgroundColor[2]
        );
		imagecolortransparent( $this->im, $this->GdBgColor );
        imagefilledrectangle($this->im, 0, 0, $this->width*$this->scale, $this->height*$this->scale, $this->GdBgColor);

        // Foreground color
        $color           = $this->colors[mt_rand(0, sizeof($this->colors)-1)];
        $this->GdFgColor = imagecolorallocate($this->im, $color[0], $color[1], $color[2]);

        // Shadow color
        if (!empty($this->shadowColor)) {
            $this->GdShadowColor = imagecolorallocate($this->im,
                $this->shadowColor[0],
                $this->shadowColor[1],
                $this->shadowColor[2]
            );
        }
    }

    /**
     * Text generation
     *
     * @return string Text
     */
    function GetCaptchaText() {
		if ($this->tulisan=="") {
			$text = $this->GetDictionaryCaptchaText();
			if (!$text) {
				$text = $this->GetRandomCaptchaText();
			}
			return $text;
		} else {
			return $this->tulisan;
		}
    }

    /**
     * Random text generation
     *
     * @return string Text
     */
    function GetRandomCaptchaText($length = null) {
        if (empty($length)) {
            $length = rand($this->minWordLength, $this->maxWordLength);
        }

        $words  = "abcdefghijlmnopqrstvwyz";
        $vocals = "aeiou";
		$words  = "0123456789";
		$vocals = "13579";

        $text  = "";
        $vocal = rand(0, 1);
        for ($i=0; $i<$length; $i++) {
            if ($vocal) {
                $text .= substr($vocals, mt_rand(0, 4), 1);
            } else {
                $text .= substr($words, mt_rand(0, 9), 1);
            }
            $vocal = !$vocal;
        }
        return $text;
    }

  /**
     * Random dictionary word generation
     *
     * @param boolean $extended Add extended "fake" words
     * @return string Word
     */
    function GetDictionaryCaptchaText($extended = false) {
        if (empty($this->wordsFile)) {
            return false;
        }

        $fp     = fopen($this->wordsFile, "r");
        $length = strlen(fgets($fp));
        if (!$length) {
            return false;
        }
        $line   = rand(0, (filesize($this->wordsFile)/$length)-1);
        if (fseek($fp, $length*$line) == -1) {
            return false;
        }
        $text = trim(fgets($fp));
        fclose($fp);


        /** Change ramdom volcals */
        if ($extended) {
            $text   = str_split($text, 1);
            $vocals = array('a', 'e', 'i', 'o', 'u');
            foreach ($text as $i => $char) {
                if (mt_rand(0, 1) && in_array($char, $vocals)) {
                    $text[$i] = $vocals[mt_rand(0, 4)];
                }
            }
            $text = implode('', $text);
        }

        return $text;
    }

    /**
     * Text insertion
     */
    function WriteText($text, $fontcfg = array()) {
        if (empty($fontcfg)) {
            // Select the font configuration
            $fontcfg  = $this->fonts[array_rand($this->fonts)];
        }
        $fontfile = $this->lokasifont.$fontcfg['font'];

        /** Increase font-size for shortest words: 9% for each glyp missing */
        $lettersMissing = $this->maxWordLength-strlen($text);
        $fontSizefactor = 1+($lettersMissing*0.09);

        // Text generation (char by char)
        $x      = 20*$this->scale;
        $y      = round(($this->height*27/40)*$this->scale);
        $length = strlen($text);
        for ($i=0; $i<$length; $i++) {
            $degree   = rand($this->maxRotation*-1, $this->maxRotation);
            $fontsize = rand($fontcfg['minSize'], $fontcfg['maxSize'])*$this->scale*$fontSizefactor;
            $letter   = substr($text, $i, 1);

            if ($this->shadowColor) {
                $coords = imagettftext($this->im, $fontsize, $degree,
                    $x+$this->scale, $y+$this->scale,
                    $this->GdShadowColor, $fontfile, $letter);
            }
            $coords = imagettftext($this->im, $fontsize, $degree,
                $x, $y,
                $this->GdFgColor, $fontfile, $letter);
            $x += ($coords[2]-$x) + ($fontcfg['spacing']*$this->scale);
        }
    }



    /**
     * Wave filter
     */
    function WaveImage() {
        // X-axis wave generation
        $xp = $this->scale*$this->Xperiod*rand(1,3);
        $k = rand(0, 100);
        for ($i = 0; $i < ($this->width*$this->scale); $i++) {
            imagecopy($this->im, $this->im,
                $i-1, sin($k+$i/$xp) * ($this->scale*$this->Xamplitude),
                $i, 0, 1, $this->height*$this->scale);
        }

        // Y-axis wave generation
        $k = rand(0, 100);
        $yp = $this->scale*$this->Yperiod*rand(1,2);
        for ($i = 0; $i < ($this->height*$this->scale); $i++) {
            imagecopy($this->im, $this->im,
                sin($k+$i/$yp) * ($this->scale*$this->Yamplitude), $i-1,
                0, $i, $this->width*$this->scale, 1);
        }
    }




    /**
     * Reduce the image to the final size
     */
    function ReduceImage() {
        // Reduzco el tamaño de la imagen
        $imResampled = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled($imResampled, $this->im,
            0, 0, 0, 0,
            $this->width, $this->height,
            $this->width*$this->scale, $this->height*$this->scale
        );
        imagedestroy($this->im);
        $this->im = $imResampled;
    }








    /**
     * File generation
     */
    function WriteImage() {
        if ($this->imageFormat == 'png') {
            header("Content-type: image/png");
            imagepng($this->im);
			
        } else {
            header("Content-type: image/jpeg");
            imagejpeg($this->im, null, 80);
        }
    }







    /**
     * Cleanup
     */
    function Cleanup() {
        imagedestroy($this->im);
    }
}
?>