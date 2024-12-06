<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function getAll($perPage = 15, $filters = []); // Index con paginación
    public function store(array $data); // Crear nuevo registro
    public function findById(int $id); // Obtener un registro por ID
    public function update(int $id, array $data); // Actualizar registro
    public function delete(int $id); // Eliminar registro
}
