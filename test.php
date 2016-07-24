<?php
class Singleton {
    function Singleton( $directCall = true ) {
        if ( $directCall ) {
            trigger_error("Нельзя использовать конструктор для создания класса Singleton. 
                           Используйте статический метод getInstance()",E_USER_ERROR);
        }
		echo "<script>
				//реализация сортировки
				function sort(el) {	
				var col_sort = el.innerHTML; 
				var tr = el.parentNode;
				var table = tr.parentNode;    
				var td, arrow, col_sort_num;
					for (var i=0; (td = tr.getElementsByTagName('td').item(i)); i++) {
						if (td.innerHTML == col_sort) {
							col_sort_num = i; 
								if (td.prevsort == 'y'){
									arrow = td.firstChild;
									el.up = Number(!el.up);
								}
							else{
							td.prevsort = 'y';
							arrow = td.insertBefore(document.createElement('span'),td.firstChild);
							el.up = 0;
							}
							arrow.innerHTML = el.up?'↑ ':'↓ ';
						}
						else{
							if (td.prevsort == 'y'){
							td.prevsort = 'n';
							if (td.firstChild) td.removeChild(td.firstChild);
							}
						}
					}	 
				var a = new Array();
				for(i=1; i < table.rows.length; i++) {
					a[i-1] = new Array();
					a[i-1][0]=table.rows[i].getElementsByTagName('td').item(col_sort_num).innerHTML;
					a[i-1][1]=table.rows[i];
				}
				a.sort();
				if(el.up) a.reverse();	 
				for(i=0; i < a.length; i++)
				table.appendChild(a[i][1]);
				}	
			</script>";
		function getFileList($dir){
			// массив, хранящий возвращаемое значение
			$retval = array();
			if(substr($dir, -1) != "/") $dir .= "/";
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
					} 
					elseif(is_readable("$dir$entry")) {
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
		$dirlist = getFileList('/home/u109591592/public_html/wp-content/themes/epixx/');
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
			/* отобразить - скрыть */
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
    }
    function &getInstance() {
        static $instance;
        if ( !is_object( $instance ) ) {
            $class = __CLASS__;
            $instance = new $class( false );
        }
        return $instance;
    }
	}

$test = &Singleton::getInstance();
?>
