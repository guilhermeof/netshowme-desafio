<?php
namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 *
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * @param integer $id
     * @return Model|null
     */
    public function find($id);

    /**
     * @return Collection
     */
    public function all();

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data = []);

    /**
     * @param string|integer $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data = []);

    /**
     * @param string|integer $id
     * @return bool
     */
    public function delete($id = null);
}
