<?php

class mosaic {
    /**
     *
     * @var int 
     */
    private $increment = 0;
    /**
     *
     * @var string 
     */
    private $class = 'class';
    /**
     *
     * @var string 
     */
    private $altText = '';
    /**
     *
     * @var int
     */
    private $sharpness = 5;
    /**
     *
     * @var height 
     */
    private $h;
    /**
     *
     * @var width
     */
    private $w;
    /**
     * not used
     * @var string
     */
    private $type;
    /**
     *
     * @var string
     */
    private $imageURL;
    /**
     *
     * @var string
     */
    private $outLookConditionalComment = 'mso';
    /**
     * Set the image url
     * @param string $imageURL 
     */
    function setImageURL($imageURL) {
        $this->imageURL = $imageURL;
        list($this->w, $this->h, $this->type) = getimagesize($imageURL);
    }
    /**
     * Set some alt text
     * @param string $altText 
     */
    function setAltText($altText) {
        $this->altText = $altText;
    }
    /**
     * Set the sharpness
     * @param string $sharpness 
     */
    function setSharpness($sharpness) {
        $this->sharpness = $sharpness;
    }
    /**
     * Generate the whole thing
     * @return string 
     */
    function generate() {
        $return = $this->getCSS().PHP_EOL;
        $return .= $this->getMSOHackStart().PHP_EOL;
        $return .= $this->getImageReplacement().PHP_EOL;
        $return .= $this->getMosaic().PHP_EOL;
        $return .= $this->getEndWrapper().PHP_EOL;
        $return .= $this->getMSOHackEnd().PHP_EOL;
        $this->incrementClass();
        return $return;
    }
    /**
     * End of the wrapper
     * @return string 
     */
    function getEndWrapper() {
        $wrapper = '</div>';
        $wrapper .= '</td>';
        $wrapper .= '</tr>';
        $wrapper .= '</tbody>';
        $wrapper .= '</table>';
        return $wrapper;
    }
    /**
     * Get the mosaic table
     * @return string 
     */
    function getMosaic() {
        $resource = imagecreatefromstring(file_get_contents($this->imageURL));
        $class = $this->getClass();
        $mosaic = '<table width="' . $this->w . '" height="' . $this->h . '" cellspacing="0" cellpadding="0" border="0" bgcolor="#fefefe" class="' . $class . '">';
        $mosaic .= '<tbody>';
        for ($y = 0; $y < $this->h; $y+=$this->sharpness) {
            $mosaic .= '<tr>';
            for ($x = 0; $x < $this->w; $x+=$this->sharpness) {
                $color = imagecolorat($resource, $x, $y);
                //get an rgba colour
                $rgba = imagecolorsforindex($resource, $color);
                $rgba['alpha'] = $rgba['alpha'];
                $colour_string = $this->rgb2hex($rgba);
                $mosaic .= '<td width="' . $this->sharpness . '" bgcolor="' . $colour_string . '"><b></b></td>' . PHP_EOL;
            }
            $mosaic .= '</tr>' . PHP_EOL;
        }
        $mosaic .= '</tbody>';
        $mosaic .= '</table>';

        return $mosaic;
    }

    /**
     * Convert an rgb array to a hex string
     * @param array $rgba Format array('red'=>N1, 'green'=>N2, 'blue'=>N3, 'alpha'=>N4);
     * @return string
     */
    private function rgb2hex(array $rgb) {
        if (isset($rgb['alpha'])) {
            unset($rgb['alpha']);
        }
        $out = "";
        foreach ($rgb as $c) {
            $hex = base_convert($c, 10, 16);
            $out .= ($c < 16) ? ("0" . $hex) : $hex;
        }
        return '#' . strtoupper($out);
    }
    /**
     * The class for this mosaic
     * @return type 
     */
    private function getClass() {
        return $this->class . $this->increment;
    }
    /**
     * Add one to the increment id 
     */
    private function incrementClass() {
        $this->increment++;
    }
    /**
     * Start the mso hack
     * @return string 
     */
    private function getMSOHackStart(){
        $class = $this->getClass();
        $msoHack = '<!--[if '.$this->outLookConditionalComment.']><style>.' . $class . '{display:none !important}</style><table cellpadding="0" cellspacing="0" style="display:block;float:none;" align=""><tr><td>';
        $msoHack .= '<img src="' . $this->imageURL . '" alt="'.$this->altText.'" style="display:block;" moz="3" valid="true" height="' . $this->h . '" width="' . $this->w . '"></td></tr></table><style type="text/css">/*<![endif]-->';
        return $msoHack;
    }
    /**
     * End of the mso hack
     */
    private function getMSOHackEnd(){
        $msoHack = '<!--[if '.$this->outLookConditionalComment.']>*/</style><![endif]-->';
        return $msoHack;
    }
    /**
     * Generate the image replacement string
     * @return string 
     */
    function getImageReplacement() {
        $class = $this->getClass();
        $replacement = '<table width="' . $this->w . '" cellspacing="0" cellpadding="0" border="0" align="" moz="3" style="display:block;float:none" class="' . $class . '">';
        $replacement .= '<tbody>';
        $replacement .= '<tr>';
        $replacement .= '<td style="padding:0px 0px 0px 0px;" class="' . $class . '">';
        $replacement .= '<div class="' . $class . '" style="width:0px;height:0px;overflow:visible;float:left;position:absolute">';
        $replacement .= '<table cellspacing="0" cellpadding="0" class="' . $class . '">';
        $replacement .= '<tbody>';
        $replacement .= '<tr>';
        $replacement .= '<td background="' . $this->imageURL . '"><div class="' . $class . '" style="width:' . $this->w . 'px;height:' . $this->h . 'px"></div></td>';
        $replacement .= '</tr>';
        $replacement .= '</tbody>';
        $replacement .= '</table>';
        $replacement .= '</div>';
        return $replacement;
    }
    /**
     * Get the css for the top
     * @return string 
     */
    function getCSS() {
        $class = $this->getClass();
        $css = '<style type="text/css">';
        $css .= '.ExternalClass .ecxhm1_3{width:' . $this->w . 'px !important;height:' . $this->h . 'px !important; float:none !important}.ExternalClass .ecxhm2_3{display:none !important}';
        $css .= '.' . $class . ' td b{width:1px;height:1px;font-size:1px}.' . $class . '{-webkit-text-size-adjust: none}';
        $css .= '</style>';
        return $css;
    }

}