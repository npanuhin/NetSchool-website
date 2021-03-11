<?php
require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/session.php';

if (!$AUTHORIZED) {
	logout();
	redirect('/login/');
	exit;
}
get_person();
?>

<!DOCTYPE html>
<html lang="ru"<?php if (isset($_COOKIE['dark']) && $_COOKIE['dark']) echo ' class="dark"'?>>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="build/help.min.css">
	<?php include_once __DIR__ . '/../src/favicon.html' ?>
	<title>NetSchool PTHS | Помощь</title>
</head>
<body>

	<?php require_once __DIR__ . '/../src/header.php' ?>

	<main>

		<?php
		include_once __DIR__ . '/../src/message_alerts.php';
		require_once __DIR__ . '/../src/menu.html';
		?>

		<div class="help">

			<h1 title="Ответы на часто задаваемые вопросы">F.A.Q.</h1>
			<p class="desc">
				Это сайт-зеркало с открытым исходным кодом для удобного просмотра информации из Netschool. Сайт разработан для учеников и их родителей (просьба не приглашать учителей, так как это уронит сайт) и призван сделать повседневную жизнь более комфортной.
			</p>

			<h4>Общее</h4>

			<div class="question" id="question-conn">— Я нашел баги, придумал интересную фичу. Как мне донести свою мысль в поддержку?</div>
			— Просто напишите в поддержку по одной из ссылок ниже. Но для начала крайне рекомендуется ознакомится со всем этим разделом (с неочевидными фичами и тем, что сейчас находится в разработке).
			
			<div class="question" id="question-safety">— Насколько это безопасно? Храните ли Вы мои пароли?</div>
			— Мы получаем данные через <a href="https://ru.wikipedia.org/wiki/Веб-скрейпинг" target="_blank">парсинг</a> обычного нетскула, и нам нужны «чистые» логин и пароль для того, чтобы получать доступ. Но мы их не используем (и никому не передаем), кроме случаев, когда нам нужно срочно что-то починить.
			
			<div class="question" id="question-better">— Чем этот Netschool лучше стандартного?</div>
			— Во-первых, не требуется авторизация каждый раз, когда Вы заходите на сайт. Во-вторых — более удобные отображения расписания, оценок, домашних заданий и так далее (а еще куча прикольных плюшек, которые мы еще делаем). В-третьих — если обычный нетскул не работает, оценки и файлы ДЗ на нашем нетскуле по-прежнему будут доступны. Наконец — темная тема!
			
			<div class="question" id="question-help">— Я хочу чем-нибудь помочь в разработке!</div>
			— На текущий момент помочь достаточно сложно, потому что код сейчас вообще не документирован (так как полностью переписывается каждую неделю), и разобраться в нем достаточно сложно. Но пишите, может, придумаем что-нибудь…
			
			<div class="question" id="question-delete">— Мне не понравилось, я не буду этим пользоваться / я не хочу доверять Вам мой пароль. </div>
			— Вы можете всегда удалить свой аккаунт. С этого момента мы не будет обновлять ваши данные. Также это удалит ваши логин и пароль из базы данных (здесь Вам придется поверить в нашу честность). Если Вы захотите вернуться, Вам придется заново пройти регистрацию, что займет длительное время. Удалить страницу можно по <a href="/delete/" target="_blank">ссылке</a>.  

			<h4>Известные <span class="del" title="&#34;Не баг, а фича&#34;">баги</span> фичи и планы на будущее</h4>

			<p title="А вот и подсказка :)">
				Общий совет — наведите на неочевидное место, и там выплывет подсказка (да, этот же совет появлялся и при первом заходе на сайт, но мало ли что, кто их читает). Баги могут время от времени появляться из-за тестирования на сервере, проблем синхронизации, чей-то неосторожности, захода учителей на сайт… Так что поломки время от времени — нормально, но они, как правило, не долгие (если у Вас длительные проблемы, то рекомендуется сообщить в поддержку).
			</p>

			<div class="question" id="question-clock">— Часы в правом верхнем углу отстают!</div>
			— Это время последнего обновления Ваших данных из нетскула. Оно всегда будет отставать от реального времени, и крайне не рекомендуется на них ориентироваться.)
			
			<div class="question" id="question-bug-switch">— При переключениями между секциями возникает «мелькание», экран на короткое время вспыхивает белым.</div>
			— Это известный баг, который мы хотим почнить. Вполне может быть, что в скором времени починим, но ничего не гарантируем.
			
			<div class="question" id="question-mobile">— Я хочу мобильную версию сайта!</div>
			— Да, мы знаем, что текущая версия выглядит жутко, и сейчас работаем над нормальной мобильной версией (а потом еще, может, вообще мобильное приложение сделаем, но это будет нескоро…).
			
			<div class="question" id="question-zoom">— А Вы можете выкладывать ссылки на Zoom-конференции на уроки и спецкурсы прямо сюда?</div>
			— Оно уже почти готово. Еще чуть-чуть — и появится.
			
			<div class="question" id="question-safety">— «Расписание» практически бесполезно. Можете туда, например, добавить спецкурсы?</div>
			— Там (также в скором времени) появится гораздо больше полезной информации, и оно перестанет быть просто бесполезным пунктом в меню.
			
			<div class="question" id="question-faces">— Почему в объявлениях лицо отображается только у Анны Анатольевны?</div>
			— Это совпадает с функционалом обычного нетскула (но у нас также каждый учитель имеет свой индивидуальный цвет), и смысла добавлять других учителей достаточно мало. Если это кому-нибудь действительно нужно — пишите, добавим. 
			<div>
			
			<div class="question" id="question-marks">— Почему некоторые оценки подсвечиваются?</div>
			— Подсвечиваются оценки, которые выше среднего балла на текущий момент. Иными словами — то, что светится, его поднимает. 
			<div>

			<a class="github_link" href="https://github.com/npanuhin/NetSchool-PTHS" target="_blank" title="Репозиторий вебсайта на GitHub">
				<?php include_once __DIR__ . '/../files/icons/github.svg' ?>
			</a>

			<a class="vk_link" href="https://vk.com/netschool_pths" target="_blank" title="Группа ВКонтакте">
				<?php include_once __DIR__ . '/../files/icons/vk.svg' ?>
			</a>
			<!-- © Никита Панюхин, Ева Пальчикова, Андрей Ситников, Марк Ипатов, 2021 -->
		</div>
	</div>  
		
	</main>
	<script type="text/javascript" src="/src/event.js" defer></script>
	<script type="text/javascript" src="/src/build/ajax.min.js" defer></script>
	<script type="text/javascript" src="/src/build/common.min.js" defer></script>
	<!-- <script type="text/javascript" src="build/help.min.js" defer></script> -->
</body>

</html>