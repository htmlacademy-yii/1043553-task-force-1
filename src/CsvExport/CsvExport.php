<?php

namespace TaskForce\CsvExport;

use TaskForce\Exception\TaskException;

class CsvExport
{
    private $files = [
        "categories" => "categories",
        "cities" => "cities",
        "opinions" => "users_review",
        "profiles",
        "replies" => "users_review",
        "tasks" => "tasks",
        "users" => "users"
    ];

    private $tables = [
        "categories" => ["name", "image"],
        "cities" => ["name", "lat", "lon"],
        "users_review" => ["created_at", "vote", "review"],
        "users" => ["email", "name", "password_hash", "created_at",
            "address", "birthday", "description", "phone", "skype"],
        "tasks" => ["created_at", "category_id", "description", "deadline", "title",
            "address", "budget", "task_lat", "task_lon"]
    ];

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
                fclose($fp);
                return $fileName;
            }
        }
    }

    public function getData($path)
    {

      /*  $file = new \SplFileObject($path);
        while (!$file->eof()) {
            yield ["data" => $file->fgetcsv(), 'path' => $path];
        }*/

        $csvFile = file($path);
        foreach ($csvFile as $line) {
            yield ["data" => str_getcsv($line), 'path' => $path];
        }
    }

    private function formQuery(array $values)
    {
        $path = $values["path"] ?? null;
        $values = $values["data"] ?? null;

        foreach ($this->files as $file => $table) {
            if (stristr($path, $file)) {
                $keys = $this->tables[$table];
                return $this->buildRequest($table, $keys, $values);
            }
        }
    }

    private function buildRequest(string $table, array $keys, array $values): string
    {
        if (count($keys) != count($values)) {
            throw new TaskException("arrays must be equal");
        }
        $query = "INSERT INTO " . "`" . $table . "` ";
        $query .= "(`" . implode("`, `", $keys) . "`) ";
        $query .= "VALUES ('" . implode("', '", $values) . "'); ";

        return $query;
    }
}
