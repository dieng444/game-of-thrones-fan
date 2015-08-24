<?php
$events = $data;
?>
<div id="block-event">
    <?php
    foreach ($events->events->event as $event) {
    ?>
        
            <div class="event">
                <h2 class="h2-detail"><?php echo $event->title; ?></h2>
                <h4><?php echo $event->venue->name; ?> (<i><?php echo $event->venue->location->city ?>) </i></h4>
                <figure><img src="<?php echo $event->image[3]; ?>" alt=""/></figure>
            </div>
    <?php
    }
    ?>
 </div>
