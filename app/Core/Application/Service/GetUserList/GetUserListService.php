<?php

namespace App\Core\Application\Service\GetUserList;

use App\Core\Application\Service\PaginationResponse;
use Exception;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\UserRepositoryInterface;

class GetUserListService
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(GetUserListRequest $request)
    {
        $users_pagination = $this->user_repository->getWithPagination($request->getPage(), $request->getPerPage());
        $max_page = $users_pagination['max_page'];

        $user_response = array_map(function (User $user){
            return new GetUserListResponse(
                $user
                //yang dibutuhin untuk ditampilkan apa aja
            );
        }, $users_pagination['data']);

        return new PaginationResponse($user_response, $request->getPage(), $max_page);
    }
}
