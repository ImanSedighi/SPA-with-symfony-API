<?php

namespace AppBundle\Transformer;

class InvitationTransformer
{
    public function transformErrors($errors): array
    {
        return [
            'errors' => (string) $errors
        ];
    }

    public function transformCreate($id): array
    {
        return [
            'id' => $id
        ];
    }
}