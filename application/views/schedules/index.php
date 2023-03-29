<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul>
<?php foreach($schedules as $schedule): $datetime = new DateTime($schedule->NextDelivery);?>
    <li data-id="schedule-<?=$schedule->ScheduleID?>">
        <input type="checkbox">
        <select name="frequency" class="frequency">
            <option value="">-- Frequency --</option>
            <?php foreach($frequencies as $frequency):?>
                <option value="<?=$frequency->FrequencyID?>"<?=$frequency->FrequencyID == $schedule->FrequencyID ? " selected": ""?> data-tag="<?=$frequency->FrequencyName?>"><?=$frequency->FrequencyName?></option>
            <?php endforeach;?>
        </select>
        <label>Start: </label>
        <input class="datetime" type="datetime-local" value="<?=$schedule->ScheduleDateTime?>">
        <input class="date" type="date" value="<?=$datetime->format("Y-m-d")?>" name="date">
        <input class="time" type="time" value="<?=$datetime->format('H:i')?>" name="time">
    </li>
<?php endforeach;?>
</ul>