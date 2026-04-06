<!DOCTYPE html>
<html>

<head>
    <title>Benchmark Result</title>
    <p>
        This benchmark evaluates the performance of database read operations in a Laravel-based application,
        comparing Eloquent ORM and Raw SQL approaches.

        Each test case represents a common query pattern in real-world applications, including simple selection,
        filtering (WHERE clause), relational queries (JOIN), aggregation (GROUP BY), and sorting (ORDER BY with LIMIT).

        The dataset consists of approximately <b>1000 records retrieved per query</b>. Each experiment was executed
        <b>30 iterations</b>, with the first <b>5 iterations discarded</b> to eliminate warm-up effects such as caching
        and query optimization by the database engine.

        The reported results include the <b>average execution time (in milliseconds)</b> and the
        <b>standard deviation</b>, providing insight into both performance and stability of each approach.
    </p>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 600px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h2><?= $type ?> Benchmark Result</h2>

    <table>
        <tr>
            <th>Test Case</th>
            <th>Avg Time (ms)</th>
            <th>Std Dev</th>
        </tr>

        <?php foreach ($results as $name => $data): ?>
            <tr>
                <td><?= $name ?></td>
                <td><?= $data['avg'] ?></td>
                <td><?= $data['std_dev'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>