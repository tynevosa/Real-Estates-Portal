<?php
define('CONFIG', [
    'host' => '127.0.0.1',
    'dbname' => 'db',
    'user' => 'root',
    'password' => ''
]);

class DB
{
    private $connection;
    function __construct()
    {
        $this->connection = new PDO('mysql:host=' . CONFIG['host'] . ';dbname=' . CONFIG['dbname'], CONFIG['user'], CONFIG['password'], [
            PDO::FETCH_ASSOC
        ]);
    }

    /**
     * Executes raw SQL query
     *
     * @param string $stm
     * @return mixed
     */
    public function exec(string $stm)
    {
        return $this->connection->exec($stm);
    }

    /**
     * @param mixed $val
     * @return string
     */
    public function escape($val)
    {
        return $this->connection->quote($val);
    }

    /**
     * Retrieves all found records based on raw SQL query
     *
     * @param string $stm
     *
     * @return bool|array
     */
    public function fetch(string $stm)
    {
        return $this->connection->query($stm)->fetchAll();
    }

    /**
     * Retrieves first found records based on raw SQL query
     *
     * @param string $stm
     *
     * @return bool|array
     */
    public function first(string $stm)
    {
        return $this->connection->query($stm)->fetch();
    }

    /**
     * Retrieves all records from a table
     *
     * @param string $table
     *
     * @return bool|array
     */
    public function all(string $table)
    {
        return $this->fetch("SELECT * FROM $table");
    }

    /**
     * Creates new record in a table.
     * On success returns the newly created record id
     * Example:
     *      insert('users', ['username'=>'john.doe']]);
     *
     * @param string $table
     * @param string[][] $props
     *
     * @return bool|int
     */
    public function insert(string $table, $props)
    {
        $columns = array_keys($props);
        $values = array_values($props);

        $columns_string = implode(',', $columns);
        $values_string = implode(',', array_fill(0, count($columns), '?'));

        $sql = "INSERT INTO $table ($columns_string) VALUES ($values_string)";

        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute($values)) {
            return $this->connection->lastInsertId();
        }

        return false;
    }

    /**
     * Updates record in a given table, with new data $props 
     * based on given $cond (conditions)
     * Example:
     *      update('users', ['username'=>'jane.doe'], ['id'=>1]);
     *
     * @param string $table
     * @param array  $props
     * @param string[][] $cond
     *
     * @return bool
     */
    public function update(string $table, $props, $cond)
    {
        $sets = [];
        foreach ($props as $key => $val) {
            $sets[] = $key . "=" . $this->escape($val);
        }
        $sets = implode(', ', $sets);

        $conditions = [];
        foreach ($cond as $key => $val) {
            $conditions[] = $key . "=" . $val;
        }
        $conditions = implode(" AND ", $conditions);

        $sql = "UPDATE $table SET $sets WHERE $conditions";

        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Closes the connection / Cleanup;
     *
     * @return void
     */
    public function __destruct()
    {
        $this->connection = null;
    }
}
