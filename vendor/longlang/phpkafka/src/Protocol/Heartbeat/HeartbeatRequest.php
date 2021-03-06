<?php

declare(strict_types=1);

namespace longlang\phpkafka\Protocol\Heartbeat;

use longlang\phpkafka\Protocol\AbstractRequest;
use longlang\phpkafka\Protocol\ProtocolField;

class HeartbeatRequest extends AbstractRequest
{
    /**
     * The group id.
     *
     * @var string
     */
    protected $groupId = '';

    /**
     * The generation of the group.
     *
     * @var int
     */
    protected $generationId = 0;

    /**
     * The member ID.
     *
     * @var string
     */
    protected $memberId = '';

    /**
     * The unique identifier of the consumer instance provided by end user.
     *
     * @var string|null
     */
    protected $groupInstanceId = null;

    public function __construct()
    {
        if (!isset(self::$maps[self::class])) {
            self::$maps[self::class] = [
                new ProtocolField('groupId', 'string', false, [0, 1, 2, 3, 4], [4], [], [], null),
                new ProtocolField('generationId', 'int32', false, [0, 1, 2, 3, 4], [4], [], [], null),
                new ProtocolField('memberId', 'string', false, [0, 1, 2, 3, 4], [4], [], [], null),
                new ProtocolField('groupInstanceId', 'string', false, [3, 4], [4], [3, 4], [], null),
            ];
            self::$taggedFieldses[self::class] = [
            ];
        }
    }

    public function getRequestApiKey(): ?int
    {
        return 12;
    }

    public function getMaxSupportedVersion(): int
    {
        return 4;
    }

    public function getFlexibleVersions(): array
    {
        return [4];
    }

    public function getGroupId(): string
    {
        return $this->groupId;
    }

    public function setGroupId(string $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getGenerationId(): int
    {
        return $this->generationId;
    }

    public function setGenerationId(int $generationId): self
    {
        $this->generationId = $generationId;

        return $this;
    }

    public function getMemberId(): string
    {
        return $this->memberId;
    }

    public function setMemberId(string $memberId): self
    {
        $this->memberId = $memberId;

        return $this;
    }

    public function getGroupInstanceId(): ?string
    {
        return $this->groupInstanceId;
    }

    public function setGroupInstanceId(?string $groupInstanceId): self
    {
        $this->groupInstanceId = $groupInstanceId;

        return $this;
    }
}
