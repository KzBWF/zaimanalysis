<?php echo $year."年"; ?></br>
<a href="weekly?prev=<?php echo $month; ?>&year=<?php echo $year; ?>">PREV</a>
<?php  echo $month."月度"; ?>
<a href="weekly?next=<?php echo $month; ?>&year=<?php echo $year; ?>">NEXT</a>
</br>
<a href="weekly?weekprev=<?php echo $week; ?>&year=<?php echo $year; ?>&mon=<?php echo $month; ?>">PREV</a>
<?php  $temp = $week + 1; echo $temp."週目"; ?>
<a href="weekly?weeknext=<?php echo $week; ?>&year=<?php echo $year; ?>&mon=<?php echo $month; ?>">NEXT</a>
</br>
<?php 
	echo $begin."日～".$last."日</br>";
	echo "支出：".$totalpay."円</br>";
	echo "<hr>";
 ?>
</br>
