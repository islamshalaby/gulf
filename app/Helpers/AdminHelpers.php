<?php
    namespace App\Helpers;
    class AdminHelpers {
        public static function GetOptionSelected($array, $id, $option_id){
            for ($i = 0; $i < count($array); $i ++) {
                if ($array[$i]->id == $id && $array[$i]->option_id == $option_id) {
                    return "selected";
                }
            }
            return null;
        }
    }