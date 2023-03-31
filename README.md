# getDatePeriodFromDateRangeString

```PHP
$date_period1 = getDatePeriodFromDateRangeString('2023年1月1日〜2023年12月31日');

if ($date_period1 instanceof \DatePeriod) {
    echo $date_period1->getStartDate()->setTime(0, 0, 0)->format('Y-m-d H:i:s') . PHP_EOL;
    echo $date_period1->getEndDate()->setTime(23, 59, 59)->format('Y-m-d H:i:s') . PHP_EOL;
    // 2023-01-01 00:00:00
    // 2023-12-31 23:59:59
}

$date_period2 = getDatePeriodFromDateRangeString('2023年1月1日');

if ($date_period2 instanceof \DatePeriod) {
    echo $date_period2->getStartDate()->setTime(0, 0, 0)->format('Y-m-d H:i:s') . PHP_EOL;
    echo $date_period2->getEndDate()->setTime(23, 59, 59)->format('Y-m-d H:i:s') . PHP_EOL;
    // 2023-01-01 00:00:00
    // 2023-01-01 23:59:59
}
```
