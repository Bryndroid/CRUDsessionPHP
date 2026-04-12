<?php
require_once __DIR__."/../models/service.class.php";

header('Content-Type: application/json');
echo json_encode(Service::allService());
