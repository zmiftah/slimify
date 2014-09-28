<?php

namespace App\Lib;

/*
 * Paginator Widget
 * Base on http://doditsuprianto.com
 * 
 * @project     : JendelaKarir
 * @package     : library\widget
 * @author      : Zein Miftah
 * @copyright   : 2014
 * 
 * @last-update : 2014-08-16
 */

class Paginator 
{
    private $totalrows;
    private $rowsperpage;
    private $website;
    private $page;
    private $suffix = '';

    public function __construct($rowstotal, $rowsperpage, $website) 
    {
        $this->totalrows = $rowstotal;
        $this->website = $website;
        $this->rowsperpage = $rowsperpage;
    }

    public function setPage($page)
    {
        $this->page = $page;
        if (!$page) $this->page=1;
    }

    public function getLimit() 
    {
        return ($this->page - 1) * $this->rowsperpage;
    }

    private function getTotalRows() 
    {
        return $this->totalrows;
    }

    private function getLastPage() 
    {
        return ceil($this->totalrows / $this->rowsperpage);
    }

    public function showPager() 
    {
        $this->getTotalRows();

        $pagination = "";
        $lastpage   = $this->getLastPage();
        $lpm1 = $lastpage - 1;
        $page = $this->page;
        $prev = $this->page - 1;
        $next = $this->page + 1;
        $link = $this->website . $this->suffix;

        $pagination .= '<ul class="pagination pagination-small pagination-right">';

        if ( $lastpage > 1 ) {
            if ( $page > 1 ) {
                $pagination .= '<li><a href="' . $link . '1">&laquo;</a></li>';
            } else {
                $pagination .= '<li class="disabled"><span>&laquo;</span></li>';
            }

            if ( $lastpage < 9 ) {
                for ( $counter = 1; $counter <= $lastpage; $counter++ ) {
                    if ( $counter == $page ) {
                        $pagination .= '<li class="active"><span>' . $counter . '</span></li>';
                    } else {
                        $pagination .= '<li><a href="' . $link . $counter . '">' . $counter . '</a></li>';
                    }
                }
            } elseif ( $lastpage >= 9 ) {
                if ( $page < 4 ) {
                    for ( $counter = 1; $counter < 6; $counter++ ) {
                        if ( $counter == $page ) {
                            $pagination .= '<li class="active"><span>' . $counter . '</span></li>';
                        } else {
                            $pagination .= '<li><a href="' . $link . $counter . '">' . $counter . '</a></li>';
                        }
                    }
                    $pagination .= '<li><span>...</span></li>';
                    $pagination .= '<li><a href="' . $link . $lpm1 . '">' . $lpm1 . '</a></li>';
                    $pagination .= '<li><a href="' . $link . $lastpage . '">' . $lastpage . '</a></li>';

                } elseif ( $lastpage - 3 > $page && $page > 1 ) {
                    $pagination .= '<li><a href="' . $link . '1">1</a></li>';
                    $pagination .= '<li><a href="' . $link . '2">2</a></li>';
                    $pagination .= '<li><span>...</span></li>';
                    for ( $counter = $page - 1; $counter <= $page + 5; $counter++ ) {
                        if ( $counter == $page ) {
                            $pagination .= '<li class="active"><span>' . $counter . '</span></li>';
                        } else {
                            $pagination .= '<li><a href="' . $link . $counter . '">' . $counter . '</a></li>';
                        }
                    }
                    $pagination .= '<li><span>...</span></li>';
                    $pagination .= '<li><a href="' . $link . $lpm1 . '">' . $lpm1 . '</a></li>';
                    $pagination .= '<li><a href="' . $link . $lastpage . '">' . $lastpage . '</a></li>';

                } else {
                    $pagination .= '<li><a href="' . $link . '1">1</a></li>';
                    $pagination .= '<li><a href="' . $link . '2">2</a></li>';
                    $pagination .= '<li><span>...</span></li>';
                    for ( $counter = $lastpage - 4; $counter <= $lastpage; $counter++ ) {
                        if ( $counter == $page ) {
                            $pagination .= '<li class="active"><span>' . $counter . '</span></li>';
                        } else {
                            $pagination .= '<li><a href="' . $link . $counter . '">' . $counter . '</a></li>';
                        }
                    }
                }
            }

            if ( $page < $counter - 1 ) {
                $pagination .= '<li><a href="' . $link . $lastpage . '">&raquo;</a></li>';
            } else {
                $pagination .= '<li class="disabled"><span>&raquo;</span></li>';
            }
        }

        $pagination .= "</ul>\n";

        return $pagination;
    }
}
