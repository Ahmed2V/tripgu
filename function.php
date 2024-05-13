<?php
function filterRequest($requestname){
   return htmlspecialchars(strip_tags($_POST[$requestname]));
}
// هحطها في الفايل بتاع الكونكشن للداتا بيز عشان استدعيها مره واحده AAH