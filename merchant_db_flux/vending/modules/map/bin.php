<?php

function dword(&$buf, $offset=0)
{
  return ord($buf{$offset++})+(ord($buf{$offset++})<<8)+(ord($buf{$offset++})<<16)+(ord($buf{$offset})<<24);
}

function byte(&$buf, $offset=0)
{
  return ord($buf{$offset});
}

?>