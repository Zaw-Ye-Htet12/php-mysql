<?php 
$totalPages = 20; // Total number of pages  

$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

$range = 2; // Number of pages to display before and after the current page

$start = max($currentpage - $range, 1);  
$end = min($currentpage + $range, $totalPages);  

echo '<ul class="pagination">';  

// Display the "Previous" link
if ($currentpage > 1) {
    echo '<li><a href="'.url('paginator').'?page=' . ($currentpage - 1) . '">Previous</a></li>';
}

// Display the first page
if ($start > 1) {
    echo '<li><a href="'.url("paginator").'?page=1">1</a></li>';
    if ($start > 2) {
        echo '<li class="disabled"><span>...</span></li>';
    }
}

// Display page numbers within the range
for ($i = $start; $i <= $end; $i++) {
    $active = ($currentpage == $i) ? 'active' : '';
    echo '<li class="' . $active . '"><a href="'.url('paginator') .'?page=' . $i . '">' . $i . '</a></li>';
}

// Display the last page
if ($end < $totalPages) {
    if ($end < $totalPages - 1) {
        echo '<li class="disabled"><span>...</span></li>';
    }
    echo '<li><a href="'.url('paginator') .'?page=' . $totalPages . '">' . $totalPages . '</a></li>';
}

// Display the "Next" link
if ($currentpage < $totalPages) {
    echo '<li><a href="'.url('paginator') .'?page=' . ($currentpage + 1) . '">Next</a></li>';
}

echo '</ul>';