<div class="message <?=$message_type?>">
    <span><?= $message ? $message : $this->session->flashdata($message_type);?></span>
    <button class="dismiss-msg">x</button>
</div>