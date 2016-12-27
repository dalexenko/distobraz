<?php

$dbh=MYSQL_CONNECT($dbhost, $dblogin, $dbpassw) OR DIE("Can not connected to database.");
@mysql_select_db($database) or die("Can not select database.");

function highlight ($text, $highlight_urls, $highlight_fragment, $fragment,
                            $b_select, $e_select, $target) {
  if ($highlight_urls) {
    $text = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])",
                          "<a href=\"\\1://\\2\\3\" $target>\\1://\\2\\3</a>",
                          $text);
    $text = eregi_replace("[[:alpha:]]+@[^<>[:space:]]+[[:alnum:]/]",
                          "<a href=\"mailto:\\0\">\\0</a>", $text);
  }
  if ($highlight_fragment) {
    if (strlen(trim($fragment)) > 0) {
      $text = eregi_replace(sql_regcase($fragment),$b_select."\\0".$e_select,$text);
    }
    if ($highlight_urls) {
      $text = eregi_replace("<a href=\"([^[\<]*)".$b_select."([^[\<]*)".$e_select."([^[\<]*)",
                            "<a href=\"\\1\\2\\3",
                            $text);
    }
  }
  return $text;
}

# PDB class
class pdb {
  var $dbh1;
  var $sql;
  var $template;
  var $recperpage;

  var $result;
  var $argsstring;
  var $stpage;
  var $recordcount;

  // Store a result to variable "$this->result"
  function prn($text) {
    $this->result .= $text;
  }

  // Main function. Activate SQL Query and process the result.
  function execute() {
    global $REQUEST_METHOD;
    global $HTTP_POST_VARS;
    global $HTTP_GET_VARS;

    $this->argsstring = '';
    $this->stpage = 1;

    if ($REQUEST_METHOD == 'POST') {
      while (list($var, $value) = each($HTTP_POST_VARS)) {
        $this->argsstring = $this->argsstring . "$var=$value&";
      }
      if (isset($_POST['stpage'])) { $this->stpage = $_POST['stpage']; }
    }
    else {
      while (list($var, $value) = each($HTTP_GET_VARS)) {
        $this->argsstring = $this->argsstring . "$var=$value&";
      }
      if (isset($_GET['stpage'])) { $this->stpage = $_GET['stpage']; }
    }
    if (strlen($this->argsstring) > 1) {
      $this->argsstring=substr($this->argsstring,0,strlen($this->argsstring)-1);
    }

    $query = MYSQL_QUERY($this->sql, $this->dbh);
    $this->recordcount = mysql_num_rows($query);

    if ($this->stpage < 1) { $this->stpage = 1; }
    $start_record = (($this->stpage -1) * $this->recperpage) + 1;
    $currecord = 1;

    if ($start_record > 1) {
      while(($row = mysql_fetch_object($query))&&($currecord < $start_record-1))
      {
        $currecord ++;
      }
    }
    $currecord = 1;
    while(($row=mysql_fetch_object($query))&&($currecord<=$this->recperpage)) {
      include($this->template);
      $currecord++;
    }
   }

  // Returns a "page navigation" links block.
  function paginal_links()
  {
    if ($this->recordcount < 1) {
      return '';
    }
    $i = 1;
    $result = '';
    $page_count = floor(($this->recordcount - .00001) / $this->recperpage) + 1;
    while ($i <= $page_count) {
      if ($i == $this->stpage) {
        $result .= ' | ' . sprintf("$i");
      }
      else {
        $result .= ' | ' . $this->make_links_package(sprintf("$i"), $i);
      }
      $i++;
    }
    if ($this->recordcount > 0) {
      $result .= ' | ';
    }
    return $result;
  }

  // Returns a "page navigation" links block (compact style).
  function paginal_links_compact($links_count)
  {
    if ($this->recordcount < 1) {
      return '';
    }
    $pages_count = floor(($this->recordcount - .00001) / $this->recperpage) + 1;
    $page = $this->stpage - floor($links_count / 2);
    if (floor($links_count / 2) == ($links_count / 2)) { $page++; }
    if ($page + $links_count > $pages_count) {
      $page = $pages_count - $links_count + 1;
    }
    $show_links = 0;
    $result = '';
    if ($page > 1) {
      $result .= $this->make_links_package(sprintf("<<"), $page-1);
    }
    while (($show_links < $links_count) && ($page <= $pages_count)) {
      if ($page > 0) {
        if ($page != $this->stpage) {
          $result .= ' | ' . $this->make_links_package(sprintf("$page"), $page);
        }
        else {
          $result .= ' | ' . sprintf("$page");
        }
        $show_links++;
      }
      $page++;
    }
    if ($this->recordcount > 0) {
      $result .= ' | ';
      if ($page <= $pages_count) {
        $result .= $this->make_links_package(sprintf(">>"), $page);
      }
    }
    return $result;
  }

  // Returns a "next page" link
  function next_page_link($link_text)
  {
    $pages_count = floor(($this->recordcount - .00001) / $this->recperpage) + 1;
    if ($this->stpage < $pages_count) {
      return  $this->make_links_package($link_text, $this->stpage+1);
    }
    else {
      return '';
    }
  }

  // Returns a "previous page" link
  function previous_page_link($link_text)
  {
    if ($this->stpage > 1) {
      return  $this->make_links_package($link_text, $this->stpage-1);
    }
    else {
      return '';
    }
  }

  // make_links_package
  function make_links_package($link_name, $stpage_n)
  {
    global $SERVER_NAME;
    global $PHP_SELF;
    $args = explode("&", $this->argsstring);
    $flag_psr = false;
    $link = "$PHP_SELF?";
    for ($i=0; $i < count($args); $i++) {
      if ($i > 0) {$link .= '&';}
      if (substr(strtoupper($args[$i]), 0, 6) == 'STPAGE') {
        $link .= 'stpage=' . sprintf("$stpage_n");
        $flag_psr = true;
      }
      else
        $link .= $args[$i];
    }
    if (! $flag_psr) {
      if ($this->argsstring == '') {
        $link .= 'stpage=' . sprintf("$stpage_n");
      }
      else {
        $link .= '&stpage=' . sprintf("$stpage_n");
      }
    }
    return  '<a href="' . $link . '">' . $link_name . '</a>';
  }
}
?>