<?php

class Paginator{
    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;
    var $mid_range;
    var $low;
    var $high;
    var $limit;
    var $return;
    var $default_ipp = 5;
	var $baseurl = '';

    function Paginator()
    {
        $this->current_page = 1;
        $this->mid_range = 5;
        $this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;
		$this->baseurl = explode("?",$_SERVER['REQUEST_URI']);
		$this->baseurl = $this->baseurl[0];
    }

    function paginate()
    {
        if(!empty($_GET['ipp']) && $_GET['ipp'] == 'All')
        {
            $this->num_pages = ceil($this->items_total/$this->default_ipp);
            $this->items_per_page = $this->default_ipp;
			
			
			if($_GET['ipp'] == 'All')
			{
				$this->num_pages = 1;
				$this->items_per_page = "All";
			}
        }
        else
        {
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
            $this->num_pages = ceil($this->items_total/$this->items_per_page);
        }
        $this->current_page = (int) (!empty($_GET['npage'])) ? $_GET['npage']:0; // must be numeric > 0
        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
        $prev_page = $this->current_page-1;
        $next_page = $this->current_page+1;
        if($this->num_pages > 0)
        {
            $this->return = ($this->current_page != 1 And $this->items_total >= 1) ? "<li><a class=\"paginate\" href=\"$this->baseurl?npage=$prev_page&ipp=$this->items_per_page\">«</a></li> ":"<li class=\"disabled\"><a href=\"#\">«</a></li> ";

            $this->start_range = $this->current_page - floor($this->mid_range/2);
            $this->end_range = $this->current_page + floor($this->mid_range/2);

            if($this->start_range <= 0)
            {
                $this->end_range += abs($this->start_range)+1;
                $this->start_range = 1;
            }
            if($this->end_range > $this->num_pages)
            {
                $this->start_range -= $this->end_range-$this->num_pages;
                $this->end_range = $this->num_pages;
            }
            $this->range = range($this->start_range,$this->end_range);

            for($i=1;$i<=$this->num_pages;$i++)
            {
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " <li class=\"disabled\"><a href=\"#\">...</a></li> ";
                // loop through Все pages. if first, last, or in range, display
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
                {
                    $this->return .= ($i == $this->current_page) ? "<li class=\"active\"><a title=\"На страницу $i из $this->num_pages\" class=\"active\" href=\"#\">$i</a></li> ":"<li><a class=\"paginate\" title=\"На страницу $i из $this->num_pages\" href=\"$this->baseurl?npage=$i&ipp=$this->items_per_page\">$i</a></li> ";
                }
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " <li class=\"disabled\"><a href=\"#\">...</a></li> ";
            }
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 1) And (@$_GET['npage'] != 'All')) ? "<li><a class=\"paginate\" href=\"$this->baseurl?npage=$next_page&ipp=$this->items_per_page\">»</a></li>\n":"<li class=\"disabled\"><a href=\"#\">»</a></li>\n";
          // $this->return .= ($_GET['ipp'] == 'All') ? "<li><a class=\"active\" style=\"margin-left:10px\" href=\"#\">Все</a></li> \n":"<li><a class=\"paginate\" style=\"margin-left:10px\" href=\"$this->baseurl?npage=1&ipp=All\">Все</a></li> \n";
        }
        else
        {
            for($i=1;$i<=$this->num_pages;$i++)
            {
                $this->return .= ($i == $this->current_page) ? "<li class=\"active\"><a href=\"#\">$i</a></li> ":"<li><a class=\"paginate\" href=\"$this->baseurl?npage=$i&ipp=$this->items_per_page\">$i</a></li> ";
            }
            //$this->return .= "<li><a class=\"paginate\" href=\"$this->baseurl?npage=1&ipp=All\">Все</a></li> \n";
        }
        $this->low = ($this->current_page > 0) ? ($this->current_page-1) * $this->items_per_page:0;
        $this->high = (!empty($_GET['ipp']) && $_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
        $this->limit = (!empty($_GET['ipp']) && $_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
    }

    function display_items_per_page()
    {
		if($this->num_pages > 0)
		{
        $items = '';
        $ipp_array = array(10,25,50,100,'All');
        foreach($ipp_array as $ipp_opt)
		{
			if($ipp_opt == "All") {$name="Все";} else {$name=$ipp_opt;}
			$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$name</option>\n":"<option value=\"$ipp_opt\">$name</option>\n";
		}
        return "<select name=\"ppi\" title=\"Записей на страницу\"  class=\"form-control\" onchange=\"window.location='$this->baseurl?npage=1&ipp='+this[this.selectedIndex].value;return false\">$items</select>\n";
		}
		else
		{
		return false;	
		}
    }

    function display_jump_menu()
    {
        for($i=1;$i<=$this->num_pages;$i++)
        {
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
        }
        return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='$this->baseurl?npage='+this[this.selectedIndex].value+'&ipp=$this->items_per_page';return false\">$option</select>\n";
    }

    function display_pages()
    {
        return "<ul class=\"pagination\">".$this->return."</ul>";
    }
}
?>
