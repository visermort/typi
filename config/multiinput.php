<?php

return [
    //configName
    'advantages' => [
        "single-row" => false,
        "columns" => [
            [
                "name" => "title",
                "title" => "Title",
                "type" => "Varchar"
            ],
            [
                "name" => "description",
                "title" => "Description",
                "type" => "Text"
            ],
            [
                "name" => "status",
                "title" => "Status",
                "type" => "Dropdown",
                "items" => [
                    "0" => "Waiting",
                    "1" => "Active",
                    "2" => "Disable"
                ]
            ],
            [
                "name" => "start_date",
                "title" => "Start date",
                "type" => "Date"
            ],
//            [
//                "name" => "start_datetime",
//                "title" => "Start time",
//                "type" => "DateTime"
//            ],
        ]
    ],
    //other configNames


];