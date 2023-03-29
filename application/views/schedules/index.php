<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul>
<?php foreach($schedules as $schedule): $datetime = new DateTime($schedule->ScheduleDateTime);?>
    <li data-id="schedule-<?=$schedule->ScheduleID?>">
        <div class="form-field">
            <input type="checkbox">
        </div>
        <div class="form-field">
            <select name="frequency" class="frequency">
                <option value="">-- Frequency --</option>
                <?php foreach($frequencies as $frequency):?>
                    <option value="<?=$frequency->FrequencyID?>"<?=$frequency->FrequencyID == $schedule->FrequencyID ? " selected": ""?> data-tag="<?=$frequency->FrequencyName?>"><?=$frequency->FrequencyName?></option>
                <?php endforeach;?>
            </select>
        </div>
        <label>Start: </label>
        <!-- <input class="datetime" type="datetime-local" value="<?=$schedule->ScheduleDateTime?>"> -->
        <div class="form-field">
            <input class="date" type="date" value="<?=$datetime->format("Y-m-d")?>" name="date">
        </div>
        <div class="form-field">
            <input class="time" type="time" value="<?=$datetime->format('H:i')?>" name="time">
        </div>
    </li>
<?php endforeach;?>
    <li data-id="schedule-new">
        <i class="fas fa-plus"></i> Add new schedule
    </li>
</ul>