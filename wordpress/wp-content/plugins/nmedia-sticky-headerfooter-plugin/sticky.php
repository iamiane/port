<div id="nm-sticky-subscription" style="<?php echo $this->position?>">
<div id="bottom-contents" style="width:<?php echo $this->width?>px; background:<?php echo $this->bgcolor?>;border: <?php echo $this->bdcolor?>">

<span style="width:<?php echo $this->widthMessageDiv?>px; float:left; color:<?php echo $this->fontcolor?>;font-size:<?php echo $this->fontsize?>">
<?php echo html_entity_decode(stripcslashes($this -> message))?>
</span>

<span id="nm-sticky-delete" style="background: url(<?php echo plugins_url('images/close_16.png', __FILE__)?>) no-repeat center" onClick="closeBottom()"></span>

<div style="clear:both"></div>
</div>
</div>


