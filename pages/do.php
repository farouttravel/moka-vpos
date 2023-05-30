<?php



var_dump($result); die();

if ($result->Data->IsSuccessful) {
    header('Location: ');
    exit;
}

throw new Exception($result->Data->ResultCode . ': ' . $result->Data->ResultMessage);