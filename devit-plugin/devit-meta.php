<?php
/*
Plugin Name: devitmeta
Plugin URI: http://www.itnotes.org.ua/
Description: This plugin add metafields to users profile, and create page test_devit_meta.
Author: Yevgen Khromykh <xevxevx@gmail.com>
Contributor: Yevgen Khromykh <xevxevx@gmail.com>
Author URI: http://www.itnotes.org.ua/
Version: 0.1
*/

define('RSA_PRIVATE', "-----BEGIN RSA PRIVATE KEY-----
MIIBOgIBAAJBAMTsduhnBT2aG8o4lZ+5J4am+jY6ArxqK3+L/WT0JJvb3EqsmOPM
6NDLBSN/kJapZGL7f+NXCd7z43YgJxqUyfECAwEAAQJALBhTC/k9mCyw+lgvUOOx
8Rnkv03AHRadBOOA6yEsLWXqT5loioh0UdcMDZ75ZL/DIgHTIx2DEue4OuSP37O7
LQIhAOkLPK8GjFP3nioOX1q+nMdKq5B1aSe9rRPR3wQA6qaXAiEA2FJelqv9G7Cy
gEENCdYBao/X90xI3wj2XxzwptHwbLcCIAPQxEiVUdzaFAPaQmNo9YYpyc9OrM8S
wu+tIvqczTq3AiEAypFHlhx0Jkvuu38u8HkAVoNgn2lGC+VeoG5/RBfv5j0CIHTx
aLUtQ3THbZ8lNj8q/mB3txCt+I9kVd9J1M/Vh3Jd
-----END RSA PRIVATE KEY-----"); 

define('RSA_PUBLIC', "-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAMTsduhnBT2aG8o4lZ+5J4am+jY6Arxq
K3+L/WT0JJvb3EqsmOPM6NDLBSN/kJapZGL7f+NXCd7z43YgJxqUyfECAwEAAQ==
-----END PUBLIC KEY-----");

// хук для страницы своего профиля, дополняем её
add_action('show_user_profile', 'devit_new_fields_add', 'show');
// хук для страницы редактирования чужого профиля, дополняем её
add_action('edit_user_profile', 'devit_new_fields_add', 'edit');
// хук для страницы добавления пользователя, дополняем её
add_action('user_new_form', 'devit_new_fields_add', 'new');

// Хуки сохранения данных
add_action('personal_options_update', 'devit_new_fields_update');
add_action('edit_user_profile_update', 'devit_new_fields_update');
add_action( 'user_register', 'devit_new_fields_update' );

// замена шорткода
add_shortcode('devit_users', 'devit_users');

// Регистрируем хук активации плагина
register_activation_hook( __FILE__, 'devit_activate' );

// Создаём пост test_devit_meta с шорткодом
function devit_activate(){
    global $user_ID;
    $new_page_title = 'test_devit_meta';
    $new_page_content = '[devit_users]';
    $new_page_template = ''; //указывается шаблон страницы (если надо)
 
    $page_check = get_page_by_title($new_page_title);
    $new_page = array(
        'post_type' => 'page',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_status' => 'publish',
        'post_author' => $user_ID,
    );
    if(!isset($page_check->ID)){
        $new_page_id = wp_insert_post($new_page);
    } 
}

// расширяем форму админки
function devit_new_fields_add($kwhere){
    if ($kwhere != "add-new-user")
    {
        /*$dvpkadress = get_user_meta( $kwhere->ID, "adress", 1 );
        $dvpkphone = get_user_meta( $kwhere->ID, "phone", 1 );
        $dvpkgender = get_user_meta( $kwhere->ID, "gender", 1 );
        $dvpkfamily = get_user_meta( $kwhere->ID, "family", 1 );
        $pk = openssl_get_privatekey(RSA_PRIVATE);
        if ( ! empty($dvpkadress))  openssl_private_decrypt(base64_decode($dvpkadress), $dvadress, $pk);
        if ( ! empty($dvpkphone)) openssl_private_decrypt(base64_decode($dvpkphone), $dvphone, $pk);
        if ( ! empty($dvpkgender)) openssl_private_decrypt(base64_decode($dvpkgender), $dvgender, $pk);
        if ( ! empty($dvpkfamily)) openssl_private_decrypt(base64_decode($dvpkfamily), $dvfamily, $pk);
        */
        list($dvadress,$dvphone,$dvgender,$dvfamily) = decode_metadata($kwhere->ID);
    }
    ?>
    <h3>Дополнительные метаполя: </h3>
    <table class="form-table">
        <tr>
            <th><label for="user_fb_txt">Адресс:</label></th>
            <td>
                <input type="text" name="adress" value="<?php echo $dvadress ?>"><br>
            </td>
        </tr>
        <tr>
            <th><label for="user_fb_txt">Телефон:</label></th>
            <td>
                <input type="text" name="phone" value="<?php echo $dvphone ?>"><br>
            </td>
        </tr>
        <tr>
            <th><label for="user_fb_txt">Пол:<?php echo $dvgender?> </label></th>
            <td>
                <select name="gender" onchange="hidefam();" id="gensel" >
                    <option value="1" <?php echo ($dvgender<2)?'selected="selected"':''?> disabled hidden>Пока не определился</option>
                    <option value="2" <?php echo ($dvgender==2)?'selected="selected"':''?>>Женский</option>
                    <option value="3" <?php echo ($dvgender==3)?'selected="selected"':''?>>Мужской</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="user_fb_txt">Семейное положение:</label></th>
            <td>
                <select name="family" >
                    <option value="0" <?php echo ($dvfamily<1)?'selected="selected"':''?> disabled hidden>Чёрт не разберёт</option>
                    <option value="1" id="fa1" <?php echo ($dvfamily==1)?'selected="selected"':''?>>Холост</option>
                    <option value="2" id="fa2" <?php echo ($dvfamily==2)?'selected="selected"':''?>>Женат</option>
                    <option value="3" id="fa3" <?php echo ($dvfamily==3)?'selected="selected"':''?>>Жена, Дети, ипотека</option>
                    <option value="4" id="fa4" <?php echo ($dvfamily==4)?'selected="selected"':''?>>На рыбалке</option>
                    <option value="5" id="fa5" <?php echo ($dvfamily==5)?'selected="selected"':''?>>Замужем</option>
                    <option value="6" id="fa6" <?php echo ($dvfamily==6)?'selected="selected"':''?>>Не замужем</option>
                    <option value="7" id="fa7" <?php echo ($dvfamily==7)?'selected="selected"':''?>>Хочу мороженку</option>
                </select>
            </td>
        </tr>
    </table>
<script>
function hidefam(){
    var e = document.getElementById("gensel");
    var genval = e.options[e.selectedIndex].value;
    if (genval == 2){
        document.getElementById("fa1").style.display = 'none';
        document.getElementById("fa2").style.display = 'none';
        document.getElementById("fa3").style.display = 'none';
        document.getElementById("fa4").style.display = 'none';

        document.getElementById("fa5").style.display = 'block';
        document.getElementById("fa6").style.display = 'block';
        document.getElementById("fa7").style.display = 'block';
    }
    else if (genval == 3) {
        document.getElementById("fa1").style.display = 'block';
        document.getElementById("fa2").style.display = 'block';
        document.getElementById("fa3").style.display = 'block';
        document.getElementById("fa4").style.display = 'block';

        document.getElementById("fa5").style.display = 'none';
        document.getElementById("fa6").style.display = 'none';
        document.getElementById("fa7").style.display = 'none';
    }
    else {
        document.getElementById("fa1").style.display = 'none';
        document.getElementById("fa2").style.display = 'none';
        document.getElementById("fa3").style.display = 'none';
        document.getElementById("fa4").style.display = 'none';
        document.getElementById("fa5").style.display = 'none';
        document.getElementById("fa6").style.display = 'none';
        document.getElementById("fa7").style.display = 'none';
    }

}
</script>
    <?php
}

// обновление данных в базе
function devit_new_fields_update($kwhere){
    $pk  = openssl_get_publickey(RSA_PUBLIC);
    openssl_public_encrypt($_POST['adress'], $pkadress, $pk);
    openssl_public_encrypt($_POST['phone'], $pkphone, $pk);
    openssl_public_encrypt($_POST['gender'], $pkgender, $pk);
    openssl_public_encrypt($_POST['family'] , $pkfamily, $pk);
    
    update_user_meta( $kwhere, "adress", base64_encode($pkadress));    
    update_user_meta( $kwhere, "phone", base64_encode($pkphone));
    update_user_meta( $kwhere, "gender", base64_encode($pkgender));
    update_user_meta( $kwhere, "family", base64_encode($pkfamily));
}

// Замена шорткода [devit_users]
function devit_users(){
    $users_list = "";
    // Если выбран пользователь, показываем псевдо профиль
    if ((int)$_GET['user_info'] > 0)
    {
        $genderarr = array('','Пока не определился','Женский','Мужской');
        $familyarr = array('Чёрт не разберёт','Холост','Женат','Жена, Дети, ипотека','На рыбалке','Замужем','Не замужем','Хочу мороженку');

        $userobj = get_userdata( (int)$_GET['user_info'] );

        list($dvadress,$dvphone,$dvgender,$dvfamily) = decode_metadata($userobj->ID);
        $users_list = "<h3 class=\"entry-title\">Профиль пользователя ID".(int)$_GET['user_info'].":</h3><div style=\"background-color: gainsboro;padding: 10px;margin-bottom: 20px; width:100%;\"><b>Ник пользователя: </b>".$userobj->user_nicename."<br/>";
        $users_list .= "<b>Почта: </b>".$userobj->user_email."<br/>";
        $users_list .= "<b>Дата регистарации: </b>".$userobj->user_registered."<br/>";
        $users_list .= "<b>Домашняя страница: </b>".$userobj->user_url."<br/></div>";
        $users_list .= "<h3 class=\"entry-title\">Шифрованные данные:</h3><div style=\"background-color: antiquewhite;padding: 10px;margin-bottom: 20px; width:100%;\"><b>Адресс: </b>".$dvadress."<br/>";
        $users_list .= "<b>Телефон: </b>".$dvphone."<br/>";
        $users_list .= "<b>Пол: </b>".$genderarr[$dvgender]."<br/>";
        $users_list .= "<b>Семейное положение: </b>".$familyarr[$dvfamily]."</div>";
        $users_list .= "<div><a href=\"?user_info=0\">Назад к списку пользователей</a></div>";
    }
    else // иначе показываем список пользовалей
    {
        $users_list = "<h3 class=\"entry-title\">Список пользователей:</h3><ul>";
        $user_num_by_page = 10;
        $offset = 0;
        global $paged;
        if ($paged > 0)
            $offset = ($paged - 1)*$user_num_by_page;
        $userscnt = get_users();
        $pagesnum = ceil (count($userscnt)/$user_num_by_page);
    
        $args = array(
            'number'  =>  $user_num_by_page,
            'offset'   => $offset
        );
        $users = get_users($args);
        foreach( $users as $user ){
            // обрабатываем
            $users_list .= "<li><a href='?user_info=".$user->ID."'>".$user->user_login."</li>";
        }
        $users_list.="</ul>".paginate_users($pagesnum);
    }
    return $users_list;
}
// в функцию вынесен код расшифровки
function decode_metadata($uid){
    $dvpkadress = get_user_meta( $uid, "adress", 1 );
    $dvpkphone = get_user_meta( $uid, "phone", 1 );
    $dvpkgender = get_user_meta( $uid, "gender", 1 );
    $dvpkfamily = get_user_meta( $uid, "family", 1 );
    $pk = openssl_get_privatekey(RSA_PRIVATE);
    if ( ! empty($dvpkadress))  openssl_private_decrypt(base64_decode($dvpkadress), $dvadress, $pk);
    if ( ! empty($dvpkphone)) openssl_private_decrypt(base64_decode($dvpkphone), $dvphone, $pk);
    if ( ! empty($dvpkgender)) openssl_private_decrypt(base64_decode($dvpkgender), $dvgender, $pk);
    if ( ! empty($dvpkfamily)) openssl_private_decrypt(base64_decode($dvpkfamily), $dvfamily, $pk);
    return array($dvadress,$dvphone,$dvgender,$dvfamily);
}

// генерируем код паджинации
function paginate_users($numuser){
    $total = isset( $numuser ) ? $numuser : 1;
    $a['total'] = $total;
    $a['mid_size'] = 3; // сколько ссылок показывать слева и справа от текущей
    $a['end_size'] = 1; // сколько ссылок показывать в начале и в конце
    $a['prev_text'] = '&laquo;'; // текст ссылки "Предыдущая страница"
    $a['next_text'] = '&raquo;'; // текст ссылки "Следующая страница"
    $result = "";
    if ( $total > 1 ) $result .= '<nav class="pagination">';
    $result .= paginate_links( $a );
    if ( $total > 1 ) $result .= '</nav>';
    return $result;
}

/*
register_deactivation_hook( __FILE__, 'devit_deactivate' );

function devit_deactivate(){
} */

?>