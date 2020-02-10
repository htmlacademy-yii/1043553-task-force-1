<?php

namespace TaskForce\CsvExport;

use TaskForce\Exception\TaskException;

class CsvExport
{
    private $files = [
        "categories" => "categories",
        "cities" => "cities",
        "opinions" => "users_review",
        "profiles" => "users",
        "replies" => "users_review",
        "tasks" => "tasks",
        "users" => "users"
    ];

    /*$tables = [
        table_name => [
        fileName =>[table_key1, table_key2...]
        ]
    ]*/
    private $tables = [
        "categories" => [
            'categories' => ["name", "image"]
        ],
        "cities" => [
            'cities' => ["name", "lat", "lon"]
        ],
        "users_review" => [
            'opinions' => ["created_at", "vote", "review"],
            'replies' => ["created_at", "vote", "review"]
        ],
        "users" => [
            'users' => ["email", "name", "password_hash", "created_at"],
            'profiles' => ["address", "birthday", "description", "phone", "skype"]
        ],
        "tasks" => [
            'tasks' => ["created_at", "category_id", "description", "deadline", "title",
            "address", "budget", "lat", "lon"]
        ]
    ];

    private $usersEmails = [];

    private $emailKey = 0;

    public function csvToSql($path): string
    {
        $data = $this->getData($path);
        $sql = "";
        foreach ($data as $value) {
            $query = $this->formQuery($value);
            $sql .= $query . PHP_EOL;
        }

        foreach ($this->files as $file => $table) {
            if (stristr($path, $file)) {
                $fileName = $file . ".sql";
                $fp = fopen($fileName, "w");
                fwrite($fp, $sql);
                $lines = file($fileName);
                unset($lines[0]);
                file_put_contents($fileName, implode('', $lines));
                fclose($fp);
                return $fileName;
            }
        }
    }

    public function getData($path)
    {
        $csvFile = file($path);
        foreach ($csvFile as $line) {
            yield ["data" => str_getcsv($line), 'path' => $path];
        }
    }

    private function formQuery(array $values): string
    {
        $path = $values["path"] ?? null;
        $values = $values["data"] ?? null;

        foreach ($this->files as $file => $table) {
            if (stristr($path, $file) && $this->tables[$table][$file]) {
                $keys = $this->tables[$table][$file];
                return $this->buildRequest($table, $keys, $values);
            }
        }
    }

    private function buildRequest(string $table, array $keys, array $values): string
    {
        if (count($keys) != count($values)) {
            throw new TaskException("arrays must be equal");
        }

        if ($keys == $this->tables['users']['profiles']) {
            return $this->updateQuery($table, $keys, $values);
        }

        if ($keys == $this->tables['users']['users']) {
            $date = array_pop($values);
            $timestamp = strtotime($date);
            array_push($values, $timestamp);

            array_push($keys, 'city_id');
            array_push($values, rand(1, 1000));

            array_push($keys, 'current_role');
            array_push($values, rand(0, 1));

            array_push($keys, 'last_active');
            $lastActive = time() - rand(1000, 10000);
            array_push($values, $lastActive);
        }

        if (
            $keys == $this->tables['users_review']['opinions']
            or $keys == $this->tables['users_review']['replies']
        ) {
            $values[0] = strtotime($values[0]);
            array_push($keys, 'user_customer_id', 'user_employee_id');
            array_push($values, rand(1, 20), rand(1, 20));
        }

        if ($keys == $this->tables['tasks']['tasks']) {
            $values[0] = strtotime($values[0]);
            array_push($keys, 'city_id', 'user_customer_id', 'user_employee_id', 'current_status');
            array_push($values, rand(1, 1000), rand(1, 20), rand(1, 20), rand(0, 4));
        }

        $query = $this->insertQuery($table, $keys, $values);

        if ($table == "users") {
            array_push($this->usersEmails, $values[0]);
        }
        return $query;
    }

    private function insertQuery(string $table, array $keys, array $values): string
    {
        $query = "INSERT INTO " . "`" . $table . "` ";
        $query .= "(`" . implode("`, `", $keys) . "`) ";
        return $query .= "VALUES ('" . implode("', '", $values) . "'); ";
    }

    private function updateQuery(string $table, array $keys, array $values): string
    {
        $query = "UPDATE " . "`" . $table . "` SET ";

        foreach ($values as $key => $value) {
            $query .= " `$keys[$key]` = '$value' ,";
        }
        $query = substr($query, 0, -1);
        $query .= "WHERE `email` = " . "'" . $this->usersEmails[$this->emailKey] . "'" . "; ";
        $this->emailKey = $this->emailKey + 1;

        return $query;
    }
}

