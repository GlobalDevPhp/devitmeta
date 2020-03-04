<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.0
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/public/partials
 */
?>
<h3 class="entry-title">Профиль пользователя ID <?php echo (int)$_GET['user_info'];?>:</h3>

<div class="public"><b>Ник пользователя: </b><?php echo $userobj->user_nicename;?><br/>
<b>Почта: </b><?php echo $userobj->user_email;?><br/>
<b>Дата регистарации: </b><?php echo $userobj->user_registered;?><br/>
<b>Домашняя страница: </b><?php echo $userobj->user_url;?><br/></div>

<h3 class="entry-title">Шифрованные данные:</h3>
<div class="protected"><b>Адресс: </b><?php echo $userobj->meta_adress;?><br/>
<b>Телефон: </b><?php echo $userobj->meta_phone;?><br/>
<b>Пол: </b><?php echo $userobj->genderarr[$userobj->meta_gender];?><br/>
<b>Семейное положение: </b><?php echo $userobj->familyarr[$userobj->meta_family];?></div>

<div><a href="/test_devit_meta">Назад к списку пользователей</a></div>