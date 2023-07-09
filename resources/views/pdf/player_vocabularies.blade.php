<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>My Vocabularies: </th>
        </tr>
        <br>
        @foreach($vocabularies as $index=>$vocabulary)
        <tr>
            <td>
                {{++$index . ' - ' . $vocabulary['vocabulary']}}
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>