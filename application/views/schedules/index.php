<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if($list):?>
    <form id="schedules-form">
        <div class="action-row">
            <div class="form-field">
                <input type="checkbox" id="select-all">
            </div>
            <div class="form-field">
                <select name="action">
                    <option value="">-- Perform Action --</option>
                    <option value="delete">Delete</option>
                    <option value="inactivate">Inactivate</option>
                </select>
            </div>
            <button type="submit" disabled>Go</button>
        </div>
        <hr>
        <ul>
        <?php foreach($schedules as $schedule): $datetime = new DateTime($schedule->ScheduleDateTime);?>
            <li data-id="schedule-<?=$schedule->ScheduleID?>">
                <div class="form-field">
                    <input type="checkbox" name="schedule-<?=$schedule->ScheduleID?>">
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
                <div class="form-field">
                    <input class="date" type="date" value="<?=$datetime->format("Y-m-d")?>" name="date">
                </div>
                <div class="form-field">
                    <input class="time" type="time" value="<?=$datetime->format('H:i')?>" name="time">
                </div>
            </li>
        <?php endforeach;?>
        </ul>
    </form>
    <a href="/schedules/add" class="btn">
        <i class="fas fa-calendar-plus"></i> 
        <span>Add Schedule</span>
    </a>
    <li class="template" id="template" data-id="schedule-new">
        <div class="form-field">
            <input type="checkbox">
        </div>
        <div class="form-field">
            <select name="frequency" class="frequency">
                <option value="">-- Frequency --</option>
                <?php foreach($frequencies as $frequency):?>
                    <option value="<?=$frequency->FrequencyID?>" data-tag="<?=$frequency->FrequencyName?>"><?=$frequency->FrequencyName?></option>
                <?php endforeach;?>
            </select>
        </div>
        <label>Start: </label>
        <div class="form-field">
            <input class="date" type="date" value="<?=date("Y-m-d")?>" name="date">
        </div>
        <div class="form-field">
            <input class="time" type="time" value="<?=date('H:i')?>" name="time">
        </div>
    </li>
<?php else: ?>
    <h3>Schedules</h3>
    <a href="/schedules/add" class="btn">
        <i class="fas fa-calendar-plus"></i> 
        <span>Add Schedule</span>
    </a>
    <table class="schedules">
        <thead>
            <tr class="grid">
                <th class="col-frequency">Frequency</th>
                <th class="col-date">Date</th>
                <th class="col-time">Time</th>
                <th class="col-actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($schedules as $schedule): 
                $datetime = new DateTime($schedule->ScheduleDateTime); 
                $datetime->setTimeZone(new DateTimeZone("America/Edmonton"));?>
                <tr class="grid" data-id="schedule-<?=$schedule->ScheduleID?>">
                    <td class="col-frequency"><?=$schedule->FrequencyName?></td>
                    <td class="col-date"><?=$datetime->format('Y-m-d')?></td>
                    <td class="col-time"><?=$datetime->format('g:ia')?></td>
                    <td class="col-actions">
                        <!-- TODO: These links all need to work/do their appropriate tasks -->
                        <a class="tooltip btn" title="edit schedule" aria-label="edit schedule" href="/schedules/edit/<?=$schedule->ScheduleID?>"><i class="fas fa-edit"></i></a>
                        <a class="tooltip btn" title="delete schedule" aria-label="delete schedule" href="/schedules/delete/<?=$schedule->ScheduleID?>"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php if($latest_delivery):?>
        <?php $last_delivery_date = new DateTime($latest_delivery->DeliveryLogDateTime); $last_delivery_date->setTimeZone(new DateTimeZone("America/Edmonton"));?>
        <!-- TODO: This needs to link to view the list of delivery events, maybe -->
        <a href="<?=current_url()?>">Last Delivered: <?=$last_delivery_date ? $last_delivery_date->format("M jS, Y @ g:ia") : "Not delivered yet"?></a>
    <?php else:?>
    <p>Latest delivery will appear here once a delivery has been made.</p>
    <?php endif;?>
    
<?php endif;?>