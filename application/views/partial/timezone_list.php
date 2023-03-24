<select name="timezone" id="timezone">
    <?php foreach($timezones as $timezone):
        $tz = new DateTimeZone($timezone);
        $offset = $tz->getOffset(new DateTime());
        $hours = $offset / 3600;
        $minutes = $offset / 60 % 60;?>
        <option value="<?=$timezone?>" <?=set_select("timezone", $timezone, $timezone == $default)?>>
            <?=$timezone?>&nbsp;&nbsp;
            GMT <?=$hours >= 0 ? "+" : "&nbsp;-"?><?=str_pad(abs(floor($hours)), 2, "0", STR_PAD_LEFT)?>:<?=str_pad(abs($minutes), 2, "0", STR_PAD_LEFT)?> 
        </option>
    <?php endforeach;?>
</select>