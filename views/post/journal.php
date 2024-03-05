<h1>Журнал заявок</h1>
<table class="table">
    <tr><th>ID</th><th>Описание</th><th>Кабинет</th><th>Дата</th><th>Количество</th></tr>
<?php
foreach ($applications as $application){
    echo "<tr><td>{$application['id']}</td><td>{$application['text']}</td><td>{$application['room']}</td>
<td>{$application['date']}</td><td>{$application['number']}</td></tr>>";
}
?>
</table>
