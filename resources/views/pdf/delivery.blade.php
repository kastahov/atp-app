<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        td, th {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <th colspan="2">Інформація про відправлення</th>
    </tr>
    <tr>
        <td>Відправник</td>
        <td>{{ $delivery['sender'] }}</td>
    </tr>
    <tr>
        <td>Отримувач</td>
        <td>{{ $delivery['receiver'] }}</td>
    </tr>
    <tr>
        <td>Місце завантаження</td>
        <td>{{ $delivery['loading_location'] }}</td>
    </tr>
    <tr>
        <td>Місце призначення</td>
        <td>{{ $delivery['destination'] }}</td>
    </tr>
    <tr>
        <td>Водій</td>
        <td>{{ $delivery['driver']['full_name'] ?? null }}</td>
    </tr>
    <tr>
        <th colspan="2">Опис вантажу</th>
    </tr>
    <tr>
        <td>Найменування вантажу</td>
        <td>{{ $delivery['cargo']['name'] }}</td>
    </tr>
    <tr>
        <td>Кількість</td>
        <td>{{ $delivery['cargo']['quantity'] }}</td>
    </tr>
    <tr>
        <td>Вага (кг)</td>
        <td>{{ $delivery['cargo']['weight'] }}</td>
    </tr>
    <tr>
        <td>Розміри</td>
        <td>{{ $delivery['cargo']['size'] }}</td>
    </tr>
    <tr>
        <th colspan="2">Данні про автомобіль</th>
    </tr>
    <tr>
        <td>Марка</td>
        <td>{{ $delivery['driver']['vehicle']['brand'] ?? null }}</td>
    </tr>
    <tr>
        <td>Модель</td>
        <td>{{ $delivery['driver']['vehicle']['model'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Реєстраційний номер</td>
        <td>{{ $delivery['driver']['vehicle']['reg_number'] ?? '-' }}</td>
    </tr>
    <tr>
        <th colspan="2">Додаткова інформація</th>
    </tr>
    <tr>
        <td colspan="2">{{ $delivery['comment'] ?? '-' }}</td>
    </tr>
    <tr>
        <th colspan="2">Підписи</th>
    </tr>
    <tr>
        <td>Підпис вантажовідправника</td>
        <td style="text-align: center; padding: 15px">X</td>
    </tr>
    <tr>
        <td>Підпис перевізника</td>
        <td style="text-align: center; padding: 15px">X</td>
    </tr>
</table>
</body>
</html>
