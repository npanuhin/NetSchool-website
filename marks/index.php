<?php
require_once __DIR__ . '/../src/config.php'; if (!isset($_SESSION['user_id']) || !verifySession()) { logout(); redirect('/login/'); exit; } $default_mark = 1; $default_mark_rate = 10; ?> <!DOCTYPE html><html lang="ru" <?php if (isset($_SESSION['dark']) && $_SESSION['dark']) echo ' class="dark"'?>><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="build/marks.min.css"> <?php include_once __DIR__ . '/../src/favicon.php' ?> <title>NetSchool PTHS | Оценки</title></head><body> <?php require_once __DIR__ . '/../src/header.php' ?> <main> <?php
 include_once __DIR__ . '/../src/message_alerts.php'; require_once __DIR__ . '/../src/menu.php'; ?> <div class="marks"><h3>Оценки</h3> <?php
 $diary = json_decode($person['diary'], true); if (is_null($diary)) { ?> <p>Оценки не загружены</p> <?php
 } else { $all_days = []; $all_average_marks = []; $table = []; foreach ($diary as $day => $tasks) { foreach ($tasks as $task_data) { $lesson = handle_lesson_name(trim($task_data[0])); if (!isset($table[$lesson])) $table[$lesson] = []; if (!isset($table[$lesson][$day])) $table[$lesson][$day] = []; $table[$lesson][$day][] = [ $task_data[4], $task_data[3], trim($task_data[2]), trim($task_data[1]), $task_data[5], trim($task_data[6][0]), $task_data[6][1] ]; if (!in_array($day, $all_days)) $all_days[] = $day; } } $all_lessons = array_keys($table); sort($all_days); sort($all_lessons); $period_start = $person["diary_period_start"]; $period_end = $person["diary_period_end"]; if (is_null($period_start) || is_null($period_end)) { if (is_null($period_start)) $period_start = class_to_diary_period($db, $person['class'])[0]; if (is_null($period_end)) $period_end = class_to_diary_period($db, $person['class'])[1]; if (!($period_start instanceof DateTime)) $period_start = new DateTime($period_start); if (!($period_end instanceof DateTime)) $period_end = new DateTime($period_end); set_diary_period($db, $period_start->format('Y-m-d'), $period_end->format('Y-m-d')); } else { if (!($period_start instanceof DateTime)) $period_start = new DateTime($period_start); if (!($period_end instanceof DateTime)) $period_end = new DateTime($period_end); } ?> <label class="period_start_label">с <input min="<?php echo $TRUE_SCHOOL_YEAR_BEGIN->format('Y-m-d') ?>" max="<?php echo $TRUE_SCHOOL_YEAR_END->format('Y-m-d') ?>" id="period_start" type="date" value="<?php echo $period_start->format('Y-m-d') ?>" data-default="<?php echo class_to_diary_period($db, $person['class'])[0]->format('Y-m-d') ?>"></label><label class="period_end_label">по <input min="<?php echo $TRUE_SCHOOL_YEAR_BEGIN->format('Y-m-d') ?>" max="<?php echo $TRUE_SCHOOL_YEAR_END->format('Y-m-d') ?>" id="period_end" type="date" value="<?php echo $period_end->format('Y-m-d') ?>" data-default="<?php echo class_to_diary_period($db, $person['class'])[1]->format('Y-m-d') ?>"></label><div><ul><li></li><li id="scroll_left"><svg viewBox="0 0 40 70" xmlns="http://www.w3.org/2000/svg"><title>Листать назад</title><path d="M1.43565 31.2376L31.5346 1.1396C33 -0.297211 34.4999 -0.297251 35.5 0.702789C36.5 1.70283 36.5 3.20279 35 4.70292L5 34.7036L35 64.7029C36.5 66.2028 36.5 67.7025 35.5 68.7028C34.4999 69.7031 33 69.7028 31.5338 68.2669L1.43487 38.1685C0.47793 37.2111 0 35.9577 0 34.7036C0 33.4489 0.47886 32.1945 1.43565 31.2376Z"/></svg></li> <?php
 foreach ($all_lessons as $lesson) { ?> <li title="<?php echo $lesson ?>"><?php echo short_lesson_name($lesson) ?></li> <?php
 } ?> </ul><div><table><tr> <?php
 $cur_month = null; $width = 0; foreach ($all_days as $day) { $datetime = new DateTime($day); if (is_null($cur_month)) $cur_month = $datetime->format('m'); if ($datetime->format('m') != $cur_month) { ?> <td colspan="<?php echo $width ?>" title="<?php echo $months[(int)($cur_month - 1)] ?>"><span> <?php echo $months[(int)($cur_month - 1)] ?> </span></td> <?php
 $cur_month = $datetime->format('m'); $width = 0; } ++$width; } if ($width != 0) { ?> <td colspan="<?php echo $width ?>" title="<?php echo $months[(int)($cur_month - 1)] ?>"><span> <?php echo $months[(int)($cur_month - 1)] ?> </span></td> <?php
 } ?> </tr><tr> <?php
 foreach ($all_days as $day) { $datetime = new DateTime($day); ?> <td title="<?php echo $weekdays[$datetime->format('w') - 1] . ', ' . ltrim($datetime->format('d'), '0') . ' ' . $months_genetive[$datetime->format('m') - 1] ?>"> <?php echo $datetime->format('d') ?> <br> <?php echo $weekdays_short[$datetime->format('w') - 1] ?> </td> <?php
 } ?> </tr> <?php
 foreach ($all_lessons as $lesson) { $days = $table[$lesson]; ?> <tr> <?php
 $days_expired_key = []; $average_mark = 0; $rate_summ = 0; foreach ($days as $day => $marks) { foreach ($marks as $mark_data) { $mark = $mark_data[0]; $mark_rate = $mark_data[1]; $task_expired = $mark_data[4]; if (!is_null($mark) || $task_expired) { if (is_null($mark)) $mark = $default_mark; if (is_null($mark_rate)) $mark_rate = $default_mark_rate; $average_mark += $mark * $mark_rate; $rate_summ += $mark_rate; } $days_expired_key[$day] = isset($days_expired_key[$day]) ? $days_expired_key[$day] | $task_expired : $task_expired; } } $all_average_marks[$lesson] = $average_mark / $rate_summ; $empty_space = 0; foreach ($all_days as $day) { if (isset($days[$day]) && $days[$day]) { if ($empty_space) { ?> <td <?php if ($empty_space > 1) echo ' colspan="' . $empty_space . '"' ?>></td> <?php
 } $empty_space = 0; ?> <td class="<?php echo $day ?> filled<?php if ($days_expired_key[$day]) echo ' expired' ?>"><div> <?php
 $tasks = $days[$day]; $task_index = 0; for ($task_index = 0; $task_index < count($tasks); ++$task_index) { $task_data = $tasks[$task_index]; $mark = $task_data[0]; $mark_rate = $task_data[1]; $task = $task_data[2]; $task_type = $task_data[3]; $task_expired = $task_data[4]; $task_lesson_ext = $task_data[5]; $task_data_ext = $task_data[6]; if (!is_null($mark) || $task_expired) { if (is_null($mark)) $mark = $default_mark; if (is_null($mark_rate)) $mark_rate = $default_mark_rate; ?> <span <?php
 if ($task_expired) echo ' class="expired"'; if ($mark) echo ' data-mark="' . $mark . '"'; if ($mark_rate) echo ' data-rate="' . $mark_rate . '"'; ?> id="<?php echo $day . '-' . $lesson . '-' . $task_index ?>"> <?php echo $mark ?> <div> <?php
 if ($task) { ?> <h5><?php echo $task ?></h5> <?php
 } $task_data = []; if ($task_type) $task_data[] = 'Тип: ' . handle_task_type($task_type); if ($mark_rate) $task_data[] = 'Вес: ' . $mark_rate; $ext_task_data = ''; foreach ($task_data_ext as $key => $value) { if ($key && $value && !in_array($key, $disabled_task_data_keys)) { $ext_task_data .= $key . ':<p>' . nl2br($value) . '</p>'; } } if ($ext_task_data) $task_data[] = $ext_task_data; echo implode('<br>', $task_data); ?> </div></span> <?php
 } else { ?> <span id="<?php echo $day . '-' . $lesson . '-' . $task_index ?>">-<div> <?php
 if ($task) { ?> <h5><?php echo $task ?></h5> <?php
 } $task_data = []; if ($task_type) $task_data[] = 'Тип: ' . handle_task_type($task_type); if ($mark_rate) $task_data[] = 'Вес: ' . $mark_rate; $ext_task_data = ''; foreach ($task_data_ext as $key => $value) { if ($key && $value && !in_array($key, $disabled_task_data_keys)) { $ext_task_data .= $key . ':<p>' . nl2br($value) . '</p>'; } } if ($ext_task_data) $task_data[] = $ext_task_data; echo implode('<br>', $task_data); ?> </div></span> <?php
 } } ?> </div></td> <?php
 } else { ++$empty_space; } } if ($empty_space) { ?> <td <?php if ($empty_space > 1) echo ' colspan="' . $empty_space . '"' ?>></td> <?php
 } ?> </tr> <?php
 } ?> </table><div class="period_hidden_left"></div><div class="period_hidden_right"></div></div><ul><li></li><li id="scroll_right"><svg viewBox="0 0 40 70" xmlns="http://www.w3.org/2000/svg"><title>Листать вперёд</title><path d="M1.43565 31.2376L31.5346 1.1396C33 -0.297211 34.4999 -0.297251 35.5 0.702789C36.5 1.70283 36.5 3.20279 35 4.70292L5 34.7036L35 64.7029C36.5 66.2028 36.5 67.7025 35.5 68.7028C34.4999 69.7031 33 69.7028 31.5338 68.2669L1.43487 38.1685C0.47793 37.2111 0 35.9577 0 34.7036C0 33.4489 0.47886 32.1945 1.43565 31.2376Z"/></svg></li> <?php
 foreach ($all_average_marks as $lesson => $average_mark) { ?> <li>- <?php ?> </li> <?php
 } ?> </ul></div> <?php
 } ?> </div></main><div class="details"></div><script type="text/javascript" src="/src/event.js" defer="defer"></script><script type="text/javascript" src="/src/build/ajax.min.js" defer="defer"></script><script type="text/javascript" src="/src/build/common.min.js" defer="defer"></script><script type="text/javascript" src="marks.js" defer="defer"></script></body></html>