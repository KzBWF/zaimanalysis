<?php echo $year."年"; ?></br>
<a href="monthly?prev=<?php echo $month; ?>&year=<?php echo $year; ?>">PREV</a>
<?php  echo $month."月度"; ?>
<a href="monthly?next=<?php echo $month; ?>&year=<?php echo $year; ?>">NEXT</a>
</br>
<?php 
	echo "収入：".$totalinc."円</br>";
	echo "支出：".$totalpay."円</br>";
	echo "<hr>";
	echo "収支：".$balance."円</br>";
	echo "<hr>";
	echo "収入一覧</br>";
	foreach($income as $val) {
		echo $val->日付.":".$val->カテゴリ.":".$val->ジャンル.":".$val->商品.":".$val->メモ.":".$val->収入."</br>";
	}
	echo "支出一覧</br>";
	foreach($payment as $val) {
		echo $val->日付.":".$val->カテゴリ.":".$val->ジャンル.":".$val->商品.":".$val->メモ.":".$val->支出."</br>";
	}
 ?>
</br>
