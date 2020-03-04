<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.0
 *
 * @package    Ykimportwoo
 * @subpackage Ykimportwoo/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
    <h3>Дополнительные метаполя: </h3>
    <table class="form-table">
        <tr>
            <th><label for="user_fb_txt">Адресс:</label></th>
            <td>
                <input type="text" name="adress" id="js-address" value="<?php echo $this->adress_field ?>"><br>
            </td>
        </tr>
        <tr>
            <th><label for="user_fb_txt">Телефон:</label></th>
            <td>
                <input type="text" name="phone" class="ielement"  id="js-phone"  value="<?php echo $this->phone_field ?>">
                <div class="error-box">Invalid phone</div>
            </td>
        </tr>
        <tr>
            <th><label for="user_fb_txt">Пол:<?php echo $this->gender_field?> </label></th>
            <td>
                <select name="gender" onchange="hidefam();" id="gensel" >
                    <option value="1" <?php echo ($this->gender_field < 2)?'selected="selected"':''?> disabled hidden>Пока не определился</option>
                    <option value="2" <?php echo ($this->gender_field == 2)?'selected="selected"':''?>>Женский</option>
                    <option value="3" <?php echo ($this->gender_field == 3)?'selected="selected"':''?>>Мужской</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="user_fb_txt">Семейное положение:</label></th>
            <td>
                <select name="family" id="family" >
                    <option value="0" <?php echo ($this->family_field < 1)?'selected="selected"':''?> disabled hidden>Чёрт не разберёт</option>
                    <option value="1" id="fa1" <?php echo ($this->family_field == 1)?'selected="selected"':''?>>Холост</option>
                    <option value="2" id="fa2" <?php echo ($this->family_field == 2)?'selected="selected"':''?>>Женат</option>
                    <option value="3" id="fa3" <?php echo ($this->family_field == 3)?'selected="selected"':''?>>Жена, Дети, ипотека</option>
                    <option value="4" id="fa4" <?php echo ($this->family_field == 4)?'selected="selected"':''?>>На рыбалке</option>
                    <option value="5" id="fa5" <?php echo ($this->family_field == 5)?'selected="selected"':''?>>Замужем</option>
                    <option value="6" id="fa6" <?php echo ($this->family_field == 6)?'selected="selected"':''?>>Не замужем</option>
                    <option value="7" id="fa7" <?php echo ($this->family_field == 7)?'selected="selected"':''?>>Хочу мороженку</option>
                </select>
            </td>
        </tr>
    </table>