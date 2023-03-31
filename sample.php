<?php

declare(strict_types=1);

/**
 * 日付の範囲を表す文字列からDatePeriodを生成する
 * 
 * @param string $data_range
 * @return \DatePeriod|null
 */
function getDatePeriodFromDateRangeString(
    string $data_range,
    string $separator = '〜',
    string $format = 'Y年m月d日'
): ?\DatePeriod {
    // 日付範囲の文字列を区切り文字で分割し、開始日と終了日の文字列に分けて配列で取得
    // 区切り文字が含まれていなければ、日付範囲の文字列を日付の文字列とみなし、開始日と終了日を同じにする
    $date_pair = (strpos($data_range, $separator) !== false)
        ? explode($separator, $data_range)
        : [$data_range, $data_range];

    // 開始日と終了日のDatetimeImmutableを取得
    $start = \DateTimeImmutable::createFromFormat($format, $date_pair[0]);
    $end = \DateTimeImmutable::createFromFormat($format, $date_pair[1]);

    // フォーマットに合致しなければDateTimeImmutableではなくfalseが返るので失敗。nullを返す
    if (!($start instanceof \DateTimeImmutable) || !($end instanceof \DateTimeImmutable)) {
        return null;
    }

    // 日付の差を取得
    $interval = $start->diff($end);

    // DateTimeImmutable::diffの結果がfalseになる場合があるようなので、DateIntervalでなければ失敗としてnullを返す
    if (!($interval instanceof \DateInterval)) {
        // 日付の期間を取得
        return null;
    }

    // 日付範囲オブジェクトを返す
    return new \DatePeriod($start, $interval, $end);
};

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
