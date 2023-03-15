<?php

namespace App\Core\Domain\Models\KTI\Member;

use App\Core\Domain\Models\KTI\KTIMemberType;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use Exception;

class KTIMember
{
    private KTIMemberId $id;
    private ?KTITeamId $team_id;
    private string $name;
    private string $no_telp;
    private KTIMemberType $member_type;

    /**
     * @param KTIMemberId $id
     * @param ?KTITeamId $team_id
     * @param string $name
     * @param string $no_telp
     * @param KTIMemberType $member_type
     */
    public function __construct(KTIMemberId $id, ?KTITeamId $team_id, string $name, string $no_telp, KTIMemberType $member_type)
    {
        $this->id = $id;
        $this->team_id = $team_id;
        $this->name = $name;
        $this->no_telp = $no_telp;
        $this->member_type = $member_type;
    }

    /**
     * @throws Exception
     */
    public static function create(?KTITeamId $team_id, string $name, string $no_telp, KTIMemberType $member_type)
    {
        return new self(
            KTIMemberId::generate(),
            $team_id,
            $name,
            $no_telp,
            $member_type
        );
    }

    /**
     * @return KTIMemberId
     */
    public function getId(): KTIMemberId
    {
        return $this->id;
    }

    /**
     * @return KTITeamId
     */
    public function getTeamId(): KTITeamId
    {
        return $this->team_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNoTelp(): string
    {
        return $this->no_telp;
    }

    /**
     * @return KTIMemberType
     */
    public function getMemberType(): KTIMemberType
    {
        return $this->member_type;
    }
}
