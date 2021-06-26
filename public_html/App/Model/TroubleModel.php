<?php

namespace App\Model;

class TroubleModel 
{
    public function show404()
    {
        echo "
        <section id=\"page_404\" class=\"cases-links\">
        <h2 class=\"error-404\"> 404 Сторінка не знайдена!</h2>
        <p class=\"error-404-p\">Сторінка яку ви шукали не існує!
        Натисніть 
        <a href=\"https://greenbro.net\"> тут </a>щоб повернутися на головну сторінку.<br>
        Якщо ви потрапили на цю сторінку через натискання посилання, повідомте нас щоб
        ми могли виправити цю помилку:)</p>
        </section>
        ";
    }
}