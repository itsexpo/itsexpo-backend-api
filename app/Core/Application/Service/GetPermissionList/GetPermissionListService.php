<?php

namespace App\Core\Application\Service\GetPermissionList;

use App\Core\Application\Service\PaginationResponse;
use Exception;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

class GetPermissionListService
{
    private PermissionRepositoryInterface $permission_repository;

    /**
     * @param PermissionRepositoryInterface $permission_repository
     */
    public function __construct(PermissionRepositoryInterface $permission_repository)
    {
        $this->permission_repository = $permission_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(GetPermissionListRequest $request)
    {
        $permissions_pagination = $this->permission_repository->getWithPagination($request->getPage(), $request->getPerPage());
        $max_page = $permissions_pagination['max_page'];

        $permission_response = array_map(function (Permission $permission){
            return new GetPermissionListResponse(
                $permission
                //yang dibutuhin untuk ditampilkan apa aja
            );
        }, $permissions_pagination['data']);

        return new PaginationResponse($permission_response, $request->getPage(), $max_page);
    }
}
