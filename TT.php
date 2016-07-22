<?php 
/*
Template Name: File-Manager
*/
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Brutal food</title>
        <meta name="description" content="Простые рецепты для мужчин">
        <link rel="stylesheet" href="<?php bloginfo ("template_directory"); ?>/main.css">
        <link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>
<body>
	<div id="logo">
            <a href="index.html"><img src="<?php bloginfo ("template_directory"); ?>/images/logo.png" alt="logo" height="90 px" width="600 px" /></a>
        </div>
        <div class=navigator>
         	<?php
	$args = array(
	'menu_id'=>'topmenu',
	'menu_class'      => 'menu-left',
	'theme_location'=>'menu_top',
	'container'=>''
	);
	wp_nav_menu($args);
	?>             
            <form class="form-search" method="get" action="<?php echo home_url( '/' ) ?>" >
                <input type="text" name="s" id="s" placeholder="поиск" value="<?php echo get_search_query() ?>">
                <button type="submit" id="searchsubmit"></button>
            </form>

            
        </div>

    <div class="page">
            <div class=menu_nav>
                	<?php
	$args = array(
	'menu_id'=>'leftmenu',
	'menu_class'      => 'menu-left',
	'theme_location'=>'menu_left',
	'container'=>''
	);
	wp_nav_menu($args);
	?>    
            </div>
            <div id=title><h1><?php the_title();?></h1>
                <div id=content>
			<form method="post" enctype="multipart/form-data">
			<input type=file name=uploadfile>
			<input type=submit name="button" value=Загрузить></form>
		<?php
			if (isset($_POST["button"])){
			// Каталог, в который мы будем принимать файл:
			$uploaddir = '/home/u109591592/public_html/wp-content/themes/epixx/';
			$uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
			// Копируем файл из каталога для временного хранения файлов:
			if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
				{
					echo "<h3>Файл успешно загружен на сервер</h3>";
				}
			else { echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>"; exit; }
			// Выводим информацию о загруженном файле:
			echo "<h3>Информация о загруженном на сервер файле: </h3>";
			echo "<p><b>Оригинальное имя загруженного файла: ".$_FILES['uploadfile']['name']."</b></p>";
			echo "<p><b>Mime-тип загруженного файла: ".$_FILES['uploadfile']['type']."</b></p>";
			echo "<p><b>Размер загруженного файла в байтах: ".$_FILES['uploadfile']['size']."</b></p>";
			echo "<p><b>Временное имя файла: ".$_FILES['uploadfile']['tmp_name']."</b></p>";
				}
		?>

<script>
function sort(el) {	
   var col_sort = el.innerHTML; 
   var tr = el.parentNode;
   var table = tr.parentNode;    
   var td, arrow, col_sort_num;
   
	for (var i=0; (td = tr.getElementsByTagName("td").item(i)); i++) {
   	if (td.innerHTML == col_sort) {
            col_sort_num = i; 
            if (td.prevsort == "y"){
                arrow = td.firstChild;
                el.up = Number(!el.up);
            }else{
                td.prevsort = "y";
                arrow = td.insertBefore(document.createElement("span"),td.firstChild);
                el.up = 0;
            }
            arrow.innerHTML = el.up?"↑ ":"↓ ";
        }else{
            if (td.prevsort == "y"){
                td.prevsort = "n";
                if (td.firstChild) td.removeChild(td.firstChild);
            }
        }
    }
	 
	 var a = new Array();
	 
    for(i=1; i < table.rows.length; i++) {
	 	a[i-1] = new Array();
	 	a[i-1][0]=table.rows[i].getElementsByTagName("td").item(col_sort_num).innerHTML;
		a[i-1][1]=table.rows[i];
	 }
	 
	 a.sort();
	 if(el.up) a.reverse();	 
	 
	 for(i=0; i < a.length; i++)
	 table.appendChild(a[i][1]);
}
</script>
<?php
function getFileList($dir)
  {
    // массив, хранящий возвращаемое значение
    $retval = array();
	

    // добавляет конечный слеш, если была возвращена пустота
    if(substr($dir, -1) != "/") $dir .= "/";

    // указать путь до директории и прочитать список вложенных файлов
    $d = @dir($dir) or die("getFileList: Не удалось открыть каталог $dir для чтения");
    while(false !== ($entry = $d->read())) {

      // пропустить скрытые файлы
      if($entry[0] == ".") continue;
      if(is_dir("$dir$entry")) {
        $retval[] = array(
          "name" => "$dir$entry/",
          "size" => 0,
          "lastmod" => filemtime("$dir$entry")
        );
      } elseif(is_readable("$dir$entry")) {
	
        $retval[] = array(
          "name" => basename("$dir$entry"),
          "size" => filesize("$dir$entry"),
	  "type" => substr(strrchr("$dir$entry", '.'), 1)
        );
      }
    }
    $d->close();

    return $retval;
  }
$dirlist = getFileList("/home/u109591592/public_html/wp-content/themes/epixx/");
// вывод результатов листинга в качестве HTML-таблицы
  echo "<table class='spc'>\n";
  echo "<input type='checkbox' id='raz' class='del' checked='checked'/><label for='raz' class='del'>Отобразить содержимое файловой системы</label>";	
  echo "<style>
	.thd {
	cursor: pointer;
	background-color: silver;
	font-size: 3ex;
	}
	table, th, td, tr {
	width: auto;
	border: 2px groove #a6b8bc;
	border-collapse: collapse;
	margin: 10px;
	padding: 3px;
	color: #1B3D6A;
	}
	del { visibility: hidden; }
	.del:not(:checked) + label + * { visibility: hidden; }
	.del:not(:checked) + label,
	.del:checked + label {
 	visibility: visible;
  	padding: 2px 10px;
  	border-radius: 2px;
  	color: #fff;
  	background: #4e6473;
  	cursor: pointer;
	}
	.del:checked + label {
  	background: #e36443;
	}
	</style>";	
  echo "<tr><td class='thd' onclick='sort(this)' title='Нажмите на заголовок, чтобы отсортировать колонку'>Name</td><td class='thd' onclick='sort(this)' title='Нажмите на заголовок, чтобы отсортировать колонку'>Type</td><td class='thd' onclick='sort(this)' title='Нажмите на заголовок, чтобы отсортировать колонку'>Size</td></tr>\n";
  foreach($dirlist as $file) {
    echo "<tr>\n";
    echo "<td>{$file['name']}</td>\n";
    echo "<td>{$file['type']}</td>\n";
    echo "<td>{$file['size']}</td>\n";
    echo "</tr>\n";
	
  }
	
  echo "</table>\n\n";
?>
    	</div>
	
	</div>
            <div id=aut>
                <?php get_sidebar(); ?>
            </div>    
    </div>  
    <?php get_footer(); ?>   
    </body>
</html>