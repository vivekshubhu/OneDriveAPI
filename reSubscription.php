<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . './Subscription.php';

$dateAfterOneMonth = new DateTime('+29 day');
$formattedDate = $dateAfterOneMonth->format('Y-m-d H:i:s');

$dateTime = new DateTime($formattedDate);
$dateTime->setTimezone(new DateTimeZone('UTC'));
$expirationDate = $dateTime->format('Y-m-d\TH:i:s.u\Z');

$subcription = new Subscription();

$allSubscriptions = $subcription->get();

if ($allSubscriptions) {
    $subcription->update($expirationDate, $allSubscriptions[0]->id);
    return;
}

$subcription->create();
