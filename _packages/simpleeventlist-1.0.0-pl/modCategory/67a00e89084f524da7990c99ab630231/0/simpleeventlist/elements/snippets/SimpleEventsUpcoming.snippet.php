<?php
/* SimpleEventsUpcoming
*  Wayne Roddy ( wayne@modx.com )
*  Sept. 2016
*  I'm not a PHP developer. No laughing
*  Shows Children (Events) that are "Upcoming" from this parent resource
*  Children (Events) of this parent should have the 4 Template Variables included with this Repo
*  event_cover,event_date,event_location,event_past
*/

$output = "";
$rows = "";

$children = $modx->resource->getMany('Children');
if(!$children){
    return "No Upcoming Events";
}

$now = new DateTime();

foreach ($children as $child) {
    $upcoming = true;

    if($child->get('hidemenu') == 0){
        //qualifiers
        $past = $child->getTVValue('sel_event_past');
        $date = new DateTime($child->getTVValue('sel_event_date'));

        if($past){ $upcoming = false; }
        if($date < $now) { $upcoming = false; $child->setTVValue('sel_event_past', "true"); }

        if($upcoming){
            $url = $modx->makeUrl($child->get('id'));
            $title = $child->get('pagetitle');
            $desc = $child->get('description');
            $cover = $child->getTVValue('sel_event_cover');
            $tvdate = $child->getTVValue('sel_event_date');
            $location = $child->getTVValue('sel_event_location');

            $rows .= $modx->getChunk('SimpleEvents-upcoming-tpl',
                array(
                    'url' => $url,
                    'cover' => $cover,
                    'title' => $title,
                    'desc' => $desc,
                    'date' => $tvdate,
                    'location' => $location
                )
            );
        }
    }
}

$output = $modx->getChunk('SimpleEvents-upcoming-outer', array('rows' => $rows));
return $output;