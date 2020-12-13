<?php


namespace lingyin\common\components\snowflake;


use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Snowflake 是 Twitter 内部的一个 ID 生算法，可以通过一些简单的规则保证在大规模分布式情况下生成唯一的 ID 号码。其组成为：
 *
 * 第一个 bit 为未使用的符号位。
 * 第二部分由 41 位的时间戳（毫秒）构成，他的取值是当前时间相对于某一时间的偏移量。
 * 第三部分和第四部分的 5 个 bit 位表示数据中心和机器ID，其能表示的最大值为 2^10 -1 = 1023。
 * 最后部分由 12 个 bit 组成，其表示每个工作节点每毫秒生成的序列号 ID，同一毫秒内最多可生成 2^12 -1 即 4095 个 ID。
 *
 * Class Snowflake
 * @package lingyin\common\components
 */
class Snowflake extends Component
{
    const MAX_TIMESTAMP_LENGTH = 41;

    const MAX_WORK_ID_LENGTH = 10;

    const MAX_SEQUENCE_LENGTH = 12;

    const MAX_FIRST_LENGTH = 1;

    /**
     * @var int 机器Id,合法值 0~1023
     */
    protected $workerId;

    public $driver = 'cache';

    public $startTime;

    public function next($prefix = '')
    {
        $currentTime = $this->getCurrentMicroTime();
        while (($sequence = $this->sequence($currentTime, $prefix)) > (-1 ^ (-1 << self::MAX_SEQUENCE_LENGTH))) {
            usleep(1);
            $currentTime = $this->getCurrentMicroTime();
        }

        $workerLeftMoveLength = self::MAX_SEQUENCE_LENGTH;
        $timestampLeftMoveLength = self::MAX_WORK_ID_LENGTH + $workerLeftMoveLength;

        return (string)((($currentTime - $this->getStartTimeStamp()) << $timestampLeftMoveLength)
            | ($this->workerId << $workerLeftMoveLength)
            | ($sequence));
    }

    protected function sequence($current, $prefix = '')
    {
        $redis = app()->{$this->driver}->redis;

        $key = $current;
        $prefix && $key = $prefix . ':' . $key;
        $key = "snowflake:{$key}";
        $lua = "return redis.call('exists',KEYS[1])<1 and redis.call('psetex',KEYS[1],ARGV[2],ARGV[1])";

        if ($redis->eval($lua, 1, $key, 1000, 1)) {
            return 0;
        }

        return $redis->incrby($key, 1);
    }

    protected function getCurrentMicroTime()
    {
        return floor(microtime(true) * 1000) | 0;
    }

    public function getStartTimeStamp()
    {
        if ($this->startTime > 0) {
            return $this->startTime;
        }

        $defaultTime = '2020-10-10 08:08:08';

        return strtotime($defaultTime) * 1000;
    }

    /**
     * @param int $workerId
     * @throws InvalidConfigException
     */
    public function setWorkerId($workerId)
    {
        $maxWorkId = -1 ^ (-1 << self::MAX_WORK_ID_LENGTH);
        if ($workerId < 0 || $workerId > $maxWorkId) {
            throw new InvalidConfigException("workerId 值不合法，可选值范围【0-{$maxWorkId}】");
        }
        $this->workerId = $workerId;
    }
}