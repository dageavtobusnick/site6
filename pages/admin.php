	<?php
		include './scripts/db.php';
		include './components/table_design.php';
		$query = "SELECT users.id,roles.name as role,users.login FROM users
				LEFT JOIN roles ON users.role_id=roles.id";
		$result=$link->query($query);
		$html="<table class='table'>";
		$html.="<tr>";
		$html.="<td>Пользователь</td>";
		$html.="<td>Забанен</td>";
		$html.="<td>Админ-статус</td>";
		$html.="<td>Бан-панель</td>";
		$html.='<td>Удаление</td>';
		$html.='<td>Редактирование</td>';
		$html.="</tr>";
		foreach($result as $row){
			if(is_null($row)||$row==''){
				continue;
			}
			$html.='<tr class="'.($row['role']=='admin'?'admin':'user').'">';
			$html.="<td>".$row["login"]."</td>";
			$query = "SELECT * FROM banlist WHERE user_id=".$row['id'];
			$user_result=$link->query($query);
			$user= $user_result->fetch_assoc();
			$html.= '<td>'.(empty($user)?'нет':'да').'</td>';
			$html.= '<td><a href="/'.ROOT_PATH.'/adminise/'.$row['id'].'">сделать '.($row['role']=='admin'?'пользователем':'админом').'</a></td>';
			$html.= '<td><a href="/'.ROOT_PATH.'/ban/'.$row['id'].'">'.(empty($user)?'забанить':'разбанить').'</a></td>';
			$html.= '<td><a href="/'.ROOT_PATH.'/deleteAccount/'.$row['id'].'">удалить</a></td>';
			$html.= '<td><a href="/'.ROOT_PATH.'/personalArea/'.$row['id'].'">редактировать</a></td>';
			$html.="</tr>";
		}
		$html.="</table>";
		echo $html;
		echo '<br/>';
	?>