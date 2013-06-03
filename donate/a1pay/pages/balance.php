<?
if($_SESSION["OnUser"] == "yes") {
?>

  <form method="POST"  class="application"  accept-charset="UTF-8" action="https://partner.a1pay.ru/a1lite/input">
  <input type="hidden" name="key" value="<?=$form_key?>" />
  <input type="input" name="cost" /> руб.
  <input type="hidden" name="name" value="Оплата в Личном Кабинете" />
  <input type="hidden" name="comment" value="<? echo $_SESSION["account_id"]; ?>" />  
  <input type="hidden" name="order_id" value="0" />
  <input type="submit" style="border:1px;" src="https://partner.a1pay.ru/gui/images/a1lite_buttons/button_small.png" value="Оплатить" />
</form>
<br />
<a href="./support/" target="_blank">Поддержка системы оплаты</a><br />
<a href="http://www.a1agregator.ru/main/abonent" target="_blank">Информация о стоимости коротких номеров для абонентов</a>
<br />
<?
} else {

echo "Необходимо авторизироваться на сайте";

}
?>