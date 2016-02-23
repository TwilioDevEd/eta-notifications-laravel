<?php
Html::macro('renderStatus', function($status)
{
    $class = 'default';
    if ($status === 'Shipped') {
        $class = 'info';
    }
    else if($status === 'Delivered') {
        $class = 'success';
    }
    $label = '<span class="label label-' . $class . '">' . $status . '</span>';

    return $label;
});

Html::macro('renderNotificationStatus', function($status)
{
    $class = 'default';
    if ($status === 'queued') {
        $class = 'warning';
    }
    else if($status === 'sent') {
        $class = 'info';
    }
    else if($status === 'delivered') {
        $class = 'success';
    }
    $label = '<span class="label label-' . $class . '">' . $status . '</span>';

    return $label;
});
