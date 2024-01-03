<?php

namespace App\Repositories;

use App\Models\Contracts\UserContract;
use App\Models\Document;
use App\Repositories\Contracts\UserRepositoryContract;

abstract class UserRepository extends RepositoryBase implements UserRepositoryContract
{
    public function create(array $data): UserContract
    {
        $document = new Document();
        $document->document = $data['document'];
        $document->save();
        unset($data['document']);

        $data['document_id'] = $document->id;
        return $this->model::create($data);
    }
}
