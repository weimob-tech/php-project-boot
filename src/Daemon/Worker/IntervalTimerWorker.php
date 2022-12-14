<?php

namespace WeimobCloudBoot\Daemon\Worker;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Daemon\Registry\IntervalTimerRegistry;
use Workerman\Lib\Timer;

class IntervalTimerWorker extends BaseFramework
{
    public function onWorkerStart($worker)
    {
        /** @var IntervalTimerRegistry $intervalTimerRegistry */
        $intervalTimerRegistry = $this->getContainer()->get('intervalTimerRegistry');

        foreach ($intervalTimerRegistry->getBeanPool() as $name => $item) {

            if (is_array($item) && isset($item['timeInterval']) && isset($item['callback'])) {

                $timeInterval = floatval($item['timeInterval']);
                $callback = $item['callback'];
                $args = $item['args'];
                $persistent = boolval($item['persistent']);

                if ($persistent && $timeInterval < 60) {
                    //LogFacade::warn('IntervalTimerWorker.onWorkerStart.' . $name . ' the param `timeInterval` must be greater than 60');
                    continue;
                }

                if ($timeInterval > 172800) {
                    //LogFacade::warn('IntervalTimerWorker.onWorkerStart.' . $name . ' the param `timeInterval` must be smaller than 172800');
                    continue;
                }

                if (!is_callable($callback)) {
                    //LogFacade::warn('IntervalTimerWorker.onWorkerStart.' . $name . ' the param `callback` must be a callback');
                    continue;
                }

                Timer::add($timeInterval, $callback, $args, $persistent);
            }

        }
    }
}