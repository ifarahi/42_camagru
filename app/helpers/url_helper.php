<?php
    function redirects($page){
        header('location: ' . URLROOT . '/' . $page);
    }