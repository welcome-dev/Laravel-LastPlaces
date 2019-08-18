<style>
.pagination {
  display: inline-block;
  padding-left: 0;
  margin: 20px 0;
  border-radius: 4px;
}
.pagination > li {
  display: inline;
}
.pagination > li > a,
.pagination > li > span {
  position: relative;
  float: left;
  padding: 6px 12px;
  line-height: 1.42857143;
  text-decoration: none;
  color: #337ab7;
  background-color: #ffffff;
  border: 1px solid #dddddd;
  margin-left: -1px;
}
.pagination > li:first-child > a,
.pagination > li:first-child > span {
  margin-left: 0;
  border-bottom-left-radius: 4px;
  border-top-left-radius: 4px;
}
.pagination > li:last-child > a,
.pagination > li:last-child > span {
  border-bottom-right-radius: 4px;
  border-top-right-radius: 4px;
}
.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
  color: #23527c;
  background-color: #eeeeee;
  border-color: #dddddd;
}
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus {
  z-index: 2;
  color: #ffffff;
  background-color: #337ab7;
  border-color: #337ab7;
  cursor: default;
}
.pagination > .disabled > span,
.pagination > .disabled > span:hover,
.pagination > .disabled > span:focus,
.pagination > .disabled > a,
.pagination > .disabled > a:hover,
.pagination > .disabled > a:focus {
  color: #777777;
  background-color: #ffffff;
  border-color: #dddddd;
  cursor: not-allowed;
}
.pagination-lg > li > a,
.pagination-lg > li > span {
  padding: 10px 16px;
  font-size: 18px;
}
.pagination-lg > li:first-child > a,
.pagination-lg > li:first-child > span {
  border-bottom-left-radius: 6px;
  border-top-left-radius: 6px;
}
.pagination-lg > li:last-child > a,
.pagination-lg > li:last-child > span {
  border-bottom-right-radius: 6px;
  border-top-right-radius: 6px;
}
.pagination-sm > li > a,
.pagination-sm > li > span {
  padding: 5px 10px;
  font-size: 12px;
}
.pagination-sm > li:first-child > a,
.pagination-sm > li:first-child > span {
  border-bottom-left-radius: 3px;
  border-top-left-radius: 3px;
}
.pagination-sm > li:last-child > a,
.pagination-sm > li:last-child > span {
  border-bottom-right-radius: 3px;
  border-top-right-radius: 3px;
}
</style>

<?php

$link_limit = 6; 

?>

@if ($memberLists->lastPage() > 1)
<div class="text-right">
<ul class="pagination">
    <li class="{{ ($memberLists->currentPage() == 1) ? ' disabled' : '' }}">
        <a href="{{ ($memberLists->currentPage() == 1) ? 'javascript:void(0)' : $memberLists->url($memberLists->currentPage()-1) }}">Previous</a>
    </li>
    @for ($i = 1; $i <= $memberLists->lastPage(); $i++)
          <?php
            $half_total_links = floor($link_limit / 2);
            $from = $memberLists->currentPage() - $half_total_links;
            $to = $memberLists->currentPage() + $half_total_links;
            if ($memberLists->currentPage() < $half_total_links) {
               $to += $half_total_links - $memberLists->currentPage();
            }
            if ($memberLists->lastPage() - $memberLists->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($memberLists->lastPage() - $memberLists->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <li class="{{ ($memberLists->currentPage() == $i) ? ' active' : '' }}">
                    <a href='{{ $memberLists->url("$i") }}'>{{ $i }}</a>
                </li>
            @endif
     @endfor
    <li class="{{ ($memberLists->currentPage() == $memberLists->lastPage()) ? ' disabled' : '' }}">
        <a href="{{ ($memberLists->currentPage() == $memberLists->lastPage()) ? 'javascript:void(0)' : $memberLists->url($memberLists->currentPage()+1) }}" >Next</a>
    </li>
</ul>
</div>
@endif
