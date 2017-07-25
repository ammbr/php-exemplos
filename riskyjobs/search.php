<?php 
require_once('conecta.php');
include_once('header.php');
echo "<h2>Resultado da pesquisa</h2>";

function build_query($user_search, $sort) {

	$search_query = "SELECT * FROM jobs";
	$clean_search = str_replace(',', ' ', $user_search);
	$search_words = explode(' ', $clean_search);
	$final_search_words = array();
	if (count($search_words) > 0) {
		foreach ($search_words as $word) {
			if (!empty($word)) {
				$final_search_words[] = $word;
			} 
		}
	} 
	if (count($final_search_words) > 0) {
		foreach($final_search_words as $word) {
			$where_list[] = "description LIKE '%$word%'"; 
		} 
	}
	$where_clause = implode(' OR ', $where_list); 
	if (!empty($where_clause)) { 
		$search_query .= " WHERE $where_clause"; 
	} 
	switch ($sort) {
		case 1:
			$search_query .= " ORDER BY title";
		break;
		case 2:
			$search_query .= " ORDER BY title DESC";
		break;
		case 3:
			$search_query .= " ORDER BY state";
		break;
		case 4:
			$search_query .= " ORDER BY state DESC";
		break;
		case 5:
			$search_query .= " ORDER BY date_posted";
		break;
		case 6:
			$search_query .= " ORDER BY date_posted DESC";
		break;
	}
	return $search_query; 
}

function generate_sort_links($user_search, $sort) {
	$sort_links = '';

	switch ($sort) {
		case 1:
			$sort_links .= '<tr><th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=2">Título</a><th>Description</th>';
			$sort_links .= '<th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=3">Estado</a></th>';
			$sort_links .= '<th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=5">Data</a></th></tr>';
		break;
		case 3:
			$sort_links .= '<tr><th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=1">Título</a><th>Description</th>';
			$sort_links .= '<th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=4">Estado</a></th>';
			$sort_links .= '<th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=5">Data</a></th></tr>';
		break;
		case 5:
			$sort_links .= '<tr><th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=1">Título</a><th>Description</th>';
			$sort_links .= '<th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=3">Estado</a></th>';
			$sort_links .= '<th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=6">Data</a></th></tr>';
		break;
		default:
			$sort_links .= '<tr><th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=1">Título</a><th>Description</th>';
			$sort_links .= '<th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=3">Estado</a></th>';
			$sort_links .= '<th><a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort=5">Data</a></th></tr>';
	}
	return $sort_links;
}

function generate_page_links($user_search, $sort, $cur_page, $num_pages) {
	$page_links = '';
	if ($cur_page > 1) {
		$page_links .= '<a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort='.$sort.'&page='.($cur_page - 1).'"><- </a>';
	} else {
		$page_links .= '<- ';
	}
	for ($i = 1; $i <= $num_pages; $i++) {
		if ($cur_page == $i) {
			$page_links .= ' '.$i;
		} else {
			$page_links .= ' <a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort='.$sort.'&page='.$i.'"> '.$i.'</a>';
		}
	}
	if ($cur_page < $num_pages) {
		$page_links .= '<a href="'.$_SERVER['PHP_SELF'].'?usersearch='.$user_search.'&sort='.$sort.'&page='.($cur_page + 1).'"> -></a>';
	} else {
		$page_links .= ' ->';
	}
	return $page_links;
}

$sort = $_GET['sort'];
$user_search = $_GET['usersearch'];
if (!empty($user_search )) {

	$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
	$results_per_page = 5;
	$skip = (($cur_page - 1) * $results_per_page);


	$query = build_query($user_search, $sort); 
	$result = mysqli_query($dbc, $query)
		or die("erro ao acessar banco de dados.");  
	$num_row = mysqli_num_rows($result); 
	$num_pages = ceil($num_row / $results_per_page); 

	$query .= " LIMIT $skip, $results_per_page";
	$final_result = mysqli_query($dbc, $query)
		or die("erro ao acessar banco de dados.");
	
	if ($num_row > 0) {
		echo '<table>';
		echo generate_sort_links($user_search, $sort);

		while ($row = mysqli_fetch_array($final_result)) {
			echo '<tr><td>'.$row['title'].'</td>';
			if (strlen($row['description']) > 100) {
				echo '<td>'. substr($row['description'], 0, 100). ' ...</td>';	
			} else {
				echo '<td>'. $row['description'] . '</td>';
			}
			echo '<td>'.$row['state'].'</td>';
			echo '<td>'.substr($row['date_posted'], 0, 10).'</td></tr>';
		}
		echo '</table>';
		if ($num_pages > 1) {
			echo generate_page_links($user_search, $sort, $cur_page, $num_pages);
		}
		mysqli_close($dbc);
	} else {
		echo 'Não foi encontrado nenhum resultado.';
	}	
} else {
	echo 'O campo de busca está vazio.';
}

include_once('footer.php');
