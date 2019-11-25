<?php


namespace App\Repositories;



use App\Models\Link;

class LinkRepository
{
    public function selectAll()
    {
        return Link::orderBy('serial_number', 'asc')->orderBy('id', 'asc')->paginate(10);
    }
}