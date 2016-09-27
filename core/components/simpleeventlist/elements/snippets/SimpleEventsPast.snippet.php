<?php
/* PastEvents
*  Wayne Roddy ( wayne@modx.com )
*  Sept. 2016
*  I'm not a PHP developer. No laughing
*  Shows Children (Events) that are "Past" from this parent resource
*  Children (Events) of this parent should have the 4 Template Variables included with this Repo
*  event_cover,event_date,event_location,event_past
*/

$output = "";
$rows = "";

$children = $modx->resource->getMany('Children');
if(!$children){
    return "No Past Events";
}

foreach ($children as $child) {

    if($child->getTVValue('sel_event_past')){

        $url = $modx->makeUrl($child->get('id'));
        $title = $child->get('pagetitle');
        $tvdate = $child->getTVValue('sel_event_date');
        $location = $child->getTVValue('sel_event_location');

        $rows .= $modx->getChunk('SimpleEvents-upcoming-tpl',
            array(
                'url' => $url,
                'title' => $title,
                'date' => $tvdate,
                'location' => $location
            )
        );

    }
}

$output = $modx->getChunk('SimpleEvents-upcoming-outer', array('rows' => $rows));
return $output;