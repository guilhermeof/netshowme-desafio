<?php
namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Find method
     *
     * @param int $id
     * @return Model|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * All method
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Create method
     *
     * @param array $data
     * @return Model|mixed
     */
    public function create(array $data = [])
    {
        $object = new $this->model($data);
        $object->save();
        return $object;
    }

    /**
     * Update method
     *
     * @param int|string $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data = [])
    {
        if ($object = $this->find($id)) {
            $object->fill($data);
            return $object->save();
        }

        return false;
    }


    /**
     * Delete method
     *
     * @param null $id
     * @return bool
     */
    public function delete($id = null)
    {
        return $this->model->destroy([$id]);
    }
}
