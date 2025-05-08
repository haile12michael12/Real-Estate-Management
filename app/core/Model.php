<?php

namespace App\Core;

abstract class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        return $this->db->select($this->table)->fetchAll();
    }

    public function find($id) {
        return $this->db->select(
            $this->table,
            '*',
            "{$this->primaryKey} = :id",
            [':id' => $id]
        )->fetch();
    }

    public function create($data) {
        $filteredData = array_intersect_key($data, array_flip($this->fillable));
        return $this->db->insert($this->table, $filteredData);
    }

    public function update($id, $data) {
        $filteredData = array_intersect_key($data, array_flip($this->fillable));
        return $this->db->update(
            $this->table,
            $filteredData,
            "{$this->primaryKey} = :id",
            [':id' => $id]
        );
    }

    public function delete($id) {
        return $this->db->delete(
            $this->table,
            "{$this->primaryKey} = :id",
            [':id' => $id]
        );
    }

    public function where($column, $value) {
        return $this->db->select(
            $this->table,
            '*',
            "$column = :value",
            [':value' => $value]
        )->fetchAll();
    }

    public function orderBy($column, $direction = 'ASC') {
        return $this->db->select(
            $this->table,
            '*',
            '',
            [],
            "$column $direction"
        )->fetchAll();
    }

    public function paginate($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        return $this->db->select(
            $this->table,
            '*',
            '',
            [],
            '',
            "$offset, $perPage"
        )->fetchAll();
    }

    public function count() {
        return $this->db->select(
            $this->table,
            'COUNT(*) as count'
        )->fetch()->count;
    }

    public function exists($id) {
        return $this->find($id) !== false;
    }

    public function first() {
        return $this->db->select(
            $this->table,
            '*',
            '',
            [],
            '',
            '1'
        )->fetch();
    }

    public function last() {
        return $this->db->select(
            $this->table,
            '*',
            '',
            [],
            "{$this->primaryKey} DESC",
            '1'
        )->fetch();
    }
} 