<?php

require_once('bin.php');

class gat {
  private $m;
  private $r;
  private $xs, $ys;

  public function __construct($b) {
    $this->xs = dword($b, 6);
    $this->ys = dword($b, 10);
    //printf("Loading map: %03d*%03d\n", $this->xs, $this->ys);

    $n = $this->xs * $this->ys;
    $i = 14;
    $x = 0;
    $y = 0;
    $this->m = array();
    for($xy = 0; $xy < $n; $xy++) {
      $this->m[$x++][$y] = (dword($b, $i + 16) == 0 ? true : false);
      if( $x == $this->xs ) {
        $x = 0;
        $y++;
      }
      $i += 20;
    }
  }
  
  public function c($x, $y) {
    if( $x < 0 || $x >= $this->xs || $y < 0 || $y >= $this->ys )
      return false;
    return $this->m[$x][$y];
  }
  
  public function near_free($x, $y, $mr=8) {
    static $s = array( array(1,0), array(0,-1), array(-1,0), array(0,1) );
    if( $this->c($x, $y) )
      return array($x, $y);
    for($r=1; $r<=$mr; $r++) {
      $ax = $x - $r;
      $ay = $y + $r;
      for($j=0;$j<4;$j++) {
        for($k=0;$k<2*$r;$k++) {
          if( $this->c($ax, $ay) )
            return array($ax, $ay);
          $ax+=$s[$j][0];
          $ay+=$s[$j][1];
        }
      }
    }
    return false;
  }
  
  public function init_room() {
    $this->r = array();
    $rooms = array();
    $id = 1;
    for($x=0;$x<$this->xs;$x++)
      $this->r[$x][0] = false;
    for($y=0;$y<$this->ys;$y++)
      $this->r[0][$y] = false;
    for($x=1; $x<$this->xs; $x++) {
      for($y=1; $y<$this->ys; $y++) {
        if( $this->c($x,$y) !== true ) {
          $this->r[$x][$y] = false;
          continue;
        }
        if( is_numeric($this->r[$x][$y-1]) ) {
          $rid = $this->r[$x][$y-1];
          $this->r[$x][$y] = $rid;
          $rooms[$rid][] = array($x,$y);
          if( is_numeric($this->r[$x-1][$y]) && ($o=$this->r[$x-1][$y])!=$rid ) {
            foreach($rooms[$o] as $e)
            {
              $this->r[$e[0]][$e[1]] = $rid;
              $rooms[$rid][] = array($e[0], $e[1]);
            }
            unset($rooms[$o]);
          }
        }
        else if( is_numeric($this->r[$x-1][$y]) ) {
          $rid = $this->r[$x-1][$y];
          $this->r[$x][$y] = $rid;
          $rooms[$rid][] = array($x,$y);
          if( is_numeric($this->r[$x][$y-1]) && ($o=$this->r[$x][$y-1])!=$rid ) {
            foreach($rooms[$o] as $e)
            {
              $this->r[$e[0]][$e[1]] = $rid;
              $rooms[$rid][] = array($e[0], $e[1]);
            }
            unset($rooms[$o]);
            printf("%d > %d\n", $rid, $o);
            die('waiting...');
          }
        }
        else {
          $rooms[$id] = array( array($x, $y) );
          $this->r[$x][$y] = $id++;
        }
      }
    }
  }
  
  public function r($x,$y) {
    if( $x < 0 || $x >= $this->xs || $y < 0 || $y >= $this->ys )
      return false;
    return $this->r[$x][$y];
  }
  
  public function draw_map($return=false,$scale=2, $xc, $yc) {
    $im = imagecreatetruecolor($this->xs*$scale,$this->ys*$scale);
	
    $c = imagecolorallocate($im, 255, 255, 255);
    for($x=0;$x<($this->xs-1);$x++) {
      for($y=0;$y<($this->ys-1);$y++) {
        if( !$this->c($x, $y) )
          continue;
        imagefilledrectangle($im, $x*$scale-$scale/2,$y*$scale-$scale/2,$x*$scale+$scale/2,$y*$scale+$scale/2, $c);
      }
    }
	
	$black = imagecolorallocate($im, 0, 0, 0);
	$white = imagecolorallocate($im, 0, 255, 0);
	imagefilledarc($im,  $xc*$scale-$scale/2,  ($this->ys*$scale)-($yc*$scale-$scale/2),  10,  10,  0, 360, $white, IMG_ARC_PIE);
	imagearc($im,  $xc*$scale-$scale/2,  ($this->ys*$scale)-($yc*$scale-$scale/2),  10,  10,  0, 360, $black);
	
    if( $return )
      return $im;
    imagepng($im, 'test2.png');
    return true;
  }
  
  public function draw_map_room($return=false,$scale=2) {
    $im = imagecreatetruecolor($this->xs*$scale,$this->ys*$scale);
	//echo $this->xs*$scale.' '.$this->ys*$scale;
    $w = imagecolorallocate($im, 255, 255, 255);
    $rooms = array();
    for($x=0;$x<($this->xs-1);$x++) {
      for($y=0;$y<($this->ys-1);$y++) {
        if( !$this->c($x, $y) )
          continue;
        if( !isset($this->r[$x][$y]) || !is_numeric($this->r[$x][$y]) ) {
          die('Something went wrong..');
        }
        if( isset($rooms[$this->r[$x][$y]]) )
          $c = $rooms[$this->r[$x][$y]];
        else
          $c=$rooms[$this->r[$x][$y]]=imagecolorallocate($im, rand(40,250), rand(40,250), rand(40,250));
        imagefilledrectangle($im, $x*$scale-$scale/2,$y*$scale-$scale/2,$x*$scale+$scale/2,$y*$scale+$scale/2, $c);
      }
    }
    if( $return )
      return $im;
    imagepng($im, 'test4.png');
    return true;
  }
}


?>